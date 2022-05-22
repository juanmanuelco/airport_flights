<?php ?>
<script type="text/javascript">
    let flight_menu = new Vue({
        el: '#flight_menu',
        data: {
            titles : {
                airline:        ['Airline', 'Aerolínea'],
                flight:         ['Flight', 'Vuelo'],
                gate:           ['Gate', 'Puerta' ],
                origin :        ['Origin', 'Origen'],
                destination :   ['Destination', 'Destino'],
                estimate :      ['Time of departure', 'Hora de salida'],
                status :        ['Status', 'Estado']
            },
            flights : [
                { name : 'arrival', label : '<?php echo __('Arrival', 'airport_flights') ?>', icon : 'fa-solid fa-plane-arrival' },
                { name : 'departure', label : '<?php echo __('Departure', 'airport_flights') ?>', icon : 'fa-solid fa-plane-departure' }
            ],
            routes : [
                { name : 'back', label : '<?php echo __('Back', 'airport_flights') ?>', icon : 'fa-solid fa-rotate-left' , link : 'back', active : false},
                { name : 'national', label : '<?php echo __('National', 'airport_flights') ?>', icon : 'fa-solid fa-flag' , link : '', active : false},
                { name : 'international', label : '<?php echo __('International', 'airport_flights') ?>', icon : 'fa-solid fa-globe' , link : '', active : false},
            ],
            flight_selected: null,
            route_selected : null,
            show_menu : true,
            current_time : '',
            loading : false,
            flight_list : [],
            width : window.innerWidth < 1250 ?  (window.innerWidth * 2) : window.innerWidth,
            urlInterval : null,
            scrollingInterval : null,
            dateToShow : true,
            show_all : <?php echo $attr['menu'] ?>,
            index_title : 0,
            index_subtitle : 1,
            interval_f : <?php echo $attr['interval_f'] ?>,
            interval_b : <?php echo $attr['interval_b'] ?>
        },
        mounted (){
            this.getCurrentTime();
            this.getCurrentSize();
            this.setCurrentFlights();
        },
        methods :{
            setCurrentFlights : ()=>{
                jQuery( document ).ready(()=>{
                    if(flight_menu.show_all === 0){
                        let type = '<?php echo $attr['type'] ?>';
                        let route = '<?php echo $attr['route'] ?>';
                        flight_menu.flight_selected = type === 'd' ? flight_menu.flights[1] : flight_menu.flights[0];
                        flight_menu.route_selected = route === 'i' ? flight_menu.routes[2] : flight_menu.routes[1];
                        flight_menu.getListData();
                    }
                })
            },
            setFlight :(flight)=>{
                flight_menu.flight_selected = flight;
            },
            todayList : ()=>{
                flight_menu.dateToShow = !flight_menu.dateToShow;
                flight_menu.getListData();
            },
            changeRoute : (type)=>{
                flight_menu.flight_list = [];
                clearInterval(flight_menu.urlInterval);
                flight_menu.urlInterval = null;
                flight_menu.routes.forEach((t)=>{
                    t.active = false;
                });
                if(type.link === 'back') {
                    flight_menu.flight_selected = null;
                    flight_menu.route_selected = null;
                    return;
                }
                type.active = true;
                flight_menu.route_selected = type;
                flight_menu.getListData();
            },
            getCurrentTime : ()=>{
                setInterval( ()=> {
                    let currentTimeDate = new Date();
                    let hours   =  currentTimeDate.getHours();
                    let minutes =  currentTimeDate.getMinutes();
                    let AMPM = hours >= 12 ? 'PM' : 'AM';
                    minutes = minutes < 10 ? '0'+minutes : minutes;
                    flight_menu.current_time = `${hours}:${minutes}${AMPM}`;
                }, 3000);
            },
            getCurrentSize : ()=>{
                jQuery(window).resize(() => {
                    flight_menu.width = window.innerWidth < 1250 ?  (window.innerWidth * 2) : window.innerWidth;
                });
            },
            toggle_menu : ()=>{
                flight_menu.show_menu = !flight_menu.show_menu;
            },
            getListData : ()=>{
                flight_menu.loading = true;
                let url = `<?php echo get_home_url() ?>/wp-json/v1/list/flights?route=${flight_menu.route_selected.name}&type=${flight_menu.flight_selected.name}`;
                flight_menu.urlListData(url);
                clearInterval(flight_menu.urlInterval);
                flight_menu.urlInterval = setInterval( (uri)=> {
                    flight_menu.urlListData(uri);
                    flight_menu.index_title = flight_menu.index_title === 0 ? 1: 0;
                    flight_menu.index_subtitle = flight_menu.index_subtitle === 0 ? 1: 0;
                }, 30000, url);
            },
            urlListData : (url)=>{
                url= new URL(url);
                url.searchParams.append('current', flight_menu.getDateString());
                url.searchParams.append('interval_f', flight_menu.interval_f);
                url.searchParams.append('interval_b', flight_menu.interval_b);

                fetch(url).then(response => response.json()).then((list)=>{
                    list.sort((a, b)=>{
                        let _a = new Date(a.meta_values['_wp_flight-estimate_meta_key'][0]);
                        let _b = new Date(b.meta_values['_wp_flight-estimate_meta_key'][0]);
                        return _b - _a;
                    });
                    flight_menu.flight_list = list;
                }).finally(()=>{
                    flight_menu.loading = false;

                    let interval_time = 100;
                    clearInterval(flight_menu.scrollingInterval);
                    flight_menu.scrollingInterval =  setInterval(()=>{
                        window.scrollBy(0,interval_time);
                        if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight ||  window.scrollY == 0) {
                            interval_time = (interval_time *-1);
                        }
                    }, 1000)
                });
            },
            getHour : (fl)=>{
                let currentTimeDate = new Date(fl.meta_values['_wp_flight-estimate_meta_key'][0]);
                let hours   =  currentTimeDate.getHours();
                let minutes =  currentTimeDate.getMinutes();

                let AMPM = hours >= 12 ? 'PM' : 'AM';
                minutes = minutes < 10 ? '0'+minutes : minutes;

                let month = currentTimeDate.getMonth() + 1;
                month = month < 10 ? `0${month}` : month;

                let day = currentTimeDate.getDate();
                day = day < 10 ? `0${day}` : day;

                return `${day}/${month}  - ${hours}:${minutes}${AMPM}`;
            },
            getStringValue : (fl, attribute)=>{
                return fl.meta_values[attribute][0]
            },
            getDateString : ()=>{
                let currentTime = new Date();
                let month = currentTime.getMonth() + 1;
                month = month < 10 ? `0${month}` : month;

                let day = currentTime.getDate();
                day = day < 10 ? `0${day}` : day;

                let hour = currentTime.getHours();
                hour = hour < 10 ? `0${hour}` : hour;

                let minutes = currentTime.getMinutes();
                minutes = minutes < 10 ? `0${minutes}` : minutes;
                return `${currentTime.getFullYear()}-${month}-${day} ${hour}:${minutes}`;
            }
        }
    });
</script>
