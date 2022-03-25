<?php ?>
<script>
    let flight_menu = new Vue({
        el: '#flight_menu',
        data: {
            flights : [
                { name : 'arrival', label : '<?php echo __('Arrival') ?>', icon : 'fa-solid fa-plane-arrival' },
                { name : 'departure', label : '<?php echo __('Departure') ?>', icon : 'fa-solid fa-plane-departure' }
            ],
            types : [
                { name : 'back', label : '<?php echo __('Back') ?>', icon : 'fa-solid fa-rotate-left' , link : 'back', active : false},
                { name : 'national', label : '<?php echo __('National') ?>', icon : 'fa-solid fa-flag' , link : '', active : false},
                { name : 'international', label : '<?php echo __('International') ?>', icon : 'fa-solid fa-globe' , link : '', active : false},
            ],
            selected: null,
            type_selected : null,
            show_menu : true,
            current_time : '',
            loading : false,
            flight_list : [],
            width : window.innerWidth < 1250 ?  (window.innerWidth * 2) : window.innerWidth
        },
        mounted (){
            this.getCurrentTime();
            this.getCurrentSize();
        },
        computed : {

        },
        methods :{
            setFlight :(flight)=>{
                flight_menu.selected = flight;
            },
            changeRoute : (type)=>{
                flight_menu.types.forEach((t)=>{
                    t.active = false;
                });
                if(type.link === 'back') {
                    flight_menu.selected = null;
                    flight_menu.type_selected = null;
                    return;
                }
                type.active = true;
                flight_menu.type_selected = type;
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
                let url = `<?php echo get_home_url() ?>/wp-json/v1/list/flights?route=${flight_menu.type_selected.name}&type=${flight_menu.selected.name}`;
                console.log(url);
                fetch(url)
                    .then(response => response.json())
                    .then((list)=>{
                        flight_menu.flight_list = list;
                        console.log(list);
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                    });
            }
        }
    });
</script>
