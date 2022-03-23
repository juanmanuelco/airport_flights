<?php

add_shortcode('flight_menu', 'flight_menu');

function flight_menu(){
	ob_start();
	?>
	<script src="https://kit.fontawesome.com/728a3885a4.js" crossorigin="anonymous"></script>
    <script src="<?php echo plugins_url( '/AirportFlights/assets/js/vue.js') ?>"></script>
	<div id="flight_menu" style="display: flex; justify-content: space-between ">
        <div v-for="flight in flights" v-if="selected == null">
            <div style="text-align: center" class="button-flight" v-on:click="setFlight(flight)">
                <h4><strong>{{flight.label}}</strong></h4>
                <i v-bind:class="flight.icon + ' fa-2xl'"></i>
            </div>
        </div>

        <div v-for="type in types" v-if="selected != null">
            <div style="text-align: center" class="button-flight" v-on:click="changeRoute(type)">
                <h4><strong>{{type.label}}</strong></h4>
                <i v-bind:class="type.icon + ' fa-2xl'"></i>
            </div>
        </div>

	</div>
    <style>
        .button-flight{
            border-radius: 15px;
            border: 3px solid var(--wp--preset--color--primary);
            padding-bottom: 25px;
            margin:15px;
            width: 240px;
        }
        #flight_menu a{
            text-decoration: none;
        }
        .button-flight:hover{
            cursor: pointer;
            background-color: var(--wp--preset--color--primary);
            color: var(--wp--preset--color--white);
        }

    </style>
	<script>
        let flight_menu = new Vue({
            el: '#flight_menu',
            data: {
				flights : [
                    { name : 'arrival', label : '<?php echo __('Arrival') ?>', icon : 'fa-solid fa-plane-arrival' },
                    { name : 'departure', label : '<?php echo __('Departure') ?>', icon : 'fa-solid fa-plane-departure' }
				],
                types : [
                    { name : 'back', label : '<?php echo __('Back') ?>', icon : 'fa-solid fa-rotate-left' , link : 'back'},
                    { name : 'national', label : '<?php echo __('National') ?>', icon : 'fa-solid fa-flag' , link : ''},
                    { name : 'international', label : '<?php echo __('International') ?>', icon : 'fa-solid fa-globe' , link : ''},
                ],
                selected: null
            },
            computed : {

            },
            methods :{
                setFlight :(flight)=>{
                    flight_menu.selected = flight;
                },
                changeRoute : (type)=>{
                    if(type.link === 'back')   flight_menu.selected = null;
                }
            }
        });
	</script>
	<?php
	return ob_get_clean();
}