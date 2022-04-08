<?php ?>
<script type="text/javascript">
    let flight_menu = new Vue({
        el: '#flight_menu',
        data: {
            titles : {
                airline:        ['Airline', 'Aerolínea'],
                flight:         ['Flight', 'Vuelo'],
                door:           ['Door', 'Puerta' ],
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
            dateToShow : true,
            show_all : <?php echo $attr['menu'] ?>,
            index_title : 0,
            index_subtitle : 1,
            interval : <?php echo $attr['interval'] ?> * 3600000
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
                fetch(url).then(response => response.json()).then((list)=>{
                    list.sort((a, b)=>{
                        let _a = new Date(a.meta_values['_wp_flight-estimate_meta_key'][0]);
                        let _b = new Date(b.meta_values['_wp_flight-estimate_meta_key'][0]);
                        return _b - _a;
                    });
                    if(flight_menu.dateToShow){
                        list = list.filter((fl)=>{
                            let currentTime = new Date().getTime();
                            let flightTimeDate = new Date(fl.meta_values['_wp_flight-estimate_meta_key'][0]).getTime();
<<<<<<< HEAD
                            if( !(flightTimeDate <= (currentTime + flight_menu.interval))) return false;
                            if( !( flightTimeDate >=  (currentTime - flight_menu.interval)) ) return false;
                            return  true;
=======
                            let hh = (flightTimeDate <= (currentTime + flight_menu.interval)) === (flightTimeDate >=  (currentTime - flight_menu.interval));
                            return  hh;
>>>>>>> 46b958dfd37c7867d35339d17ccf770f871a69fa
                        });
                    }
                    flight_menu.flight_list = list;
                }).finally(()=>{
                    flight_menu.loading = false;
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
            }
        }
    });
</script>
