<?php

add_action('wp_head', 'vue_faw_js');
function vue_faw_js(){
    ?>
    <script src="https://kit.fontawesome.com/728a3885a4.js" crossorigin="anonymous"></script>
    <script src="<?php echo plugins_url( '/AirportFlights/assets/js/vue.js') ?>"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" ></script>
    <?php
}

add_shortcode('flight_menu', 'flight_menu');

function flight_menu($attr){
	$attr = shortcode_atts( array(
		'type' => 'a',
        'route' => 'n',
        'interval' => 30000,
        'menu' => 1
	), $attr );
	ob_start();
	?>
	<div id="flight_menu" >
        <div class="menu-flight" v-if="show_menu && show_all == 1">
            <div v-for="flight in flights" v-if="flight_selected == null">
                <div
                        style="text-align: center"
                        class="button-flight"
                        v-on:click="setFlight(flight)"
                        v-bind:style="{width: (width / 8 ) + 'px' }"
                >
                    <h4><strong>{{flight.label}}</strong></h4>
                    <i v-bind:class="flight.icon + ' fa-2xl'"></i>
                </div>
            </div>
            <div v-for="type in routes" v-if="flight_selected != null">
                <div
                        style="text-align: center"
                        v-bind:class="'button-flight ' + (type.active ? 'button-flight-active' : '')"
                        v-on:click="changeRoute(type)"
                        v-bind:style="{width: (width / (type.link == 'back' ? 12 : 5.4) ) + 'px' }"
                >
                    <h4><strong>{{type.label}}</strong></h4>
                    <i v-bind:class="type.icon + ' fa-2xl'"></i>
                </div>
            </div>

        </div>
        <div class="flight-list" v-if="flight_selected != null && route_selected != null">
            <div style="display: flex; justify-content: space-around">
                <div class="list-title">
                    <div class="icon-type" v-on:click="todayList" style="cursor: pointer; background-color: var(--wp-primary)" v-if="show_all == 1">
                        <i v-bind:class="'fa-solid ' +  (today ? 'fa-circle-plus' : 'fa-circle-minus') + ' fa-2xl'"></i>
                    </div>
                    <div class="icon-type" v-on:click="toggle_menu" style="cursor: pointer; background-color: var(--wp-primary)" v-if="show_all == 1">
                        <i v-bind:class="'fa-solid ' +  (show_menu ? 'fa-eye-slash' : 'fa-eye') + ' fa-2xl'"></i>
                    </div>
                    <div class="icon-type" >
                        <i v-bind:class="flight_selected.icon + ' fa-2xl'"></i>
                    </div>
                    <div style="display: inline-block;">
                        <strong>{{flight_selected.label}} {{route_selected.label}}</strong>
                        <div>{{route_selected.name}} {{flight_selected.name}} </div>
                    </div>

                </div>
                <div style="padding-top: 15px">
                    <p class="p-title"><strong>{{current_time}}</strong></p>
                </div>
            </div>

            <div v-if="loading" style="text-align: center">
                <div class="loader" ></div>
            </div>


            <div style="padding-top: 25px" v-if="!loading">
                <table class="flights_list_table">
                    <tr>
                        <th>
                            <p class="p-title">Aerolínea</p>
                            <p>Airline</p>
                        </th>
                        <th>
                            <p class="p-title">Vuelo</p>
                            <p>Flight</p>
                        </th>
                        <th>
                            <p class="p-title">Puerta</p>
                            <p>Door</p>
                        </th>
                        <th v-if="flight_selected.name == 'arrival'">
                            <p class="p-title">Origen</p>
                            <p>Origin</p>
                        </th>
                        <th v-if="flight_selected.name == 'departure'">
                            <p class="p-title">Destino</p>
                            <p>Destination</p>
                        </th>
                        <th>
                            <p class="p-title">Hora de {{flight_selected.label}}</p>
                            <p>Time of {{flight_selected.name}}</p>
                        </th>
                        <th>
                            <p class="p-title">Estado</p>
                            <p>Status</p>
                        </th>
                    </tr>
                    <tr v-for="flight in flight_list" v-if="flight.terms.status[0].values['status_hidden'][0] == 'off' ">
                        <td>
                            <img
                                    v-bind:src="flight.terms.airline[0].values.airline_image[0]"
                                    v-if="flight.terms.airline != false && flight.terms.airline[0].values.airline_image != false"
                                    style="height: 100px;">
                            <span v-if="flight.terms.airline == false || flight.terms.airline[0].values.airline_image == false">
                                {{ flight.terms.airline[0].name }}

                            </span>
                        </td>
                        <td>
                            <p>
                                {{getStringValue(flight, `_wp_flight-code_meta_key`)}}
                            </p>
                        </td>
                        <td>
                            <p>
                                {{flight.terms.door[0].name}}
                            </p>
                        </td>
                        <td>
                            <p v-if="flight.meta_values['_wp_flight-destination_meta_key'] != undefined">
                                {{flight.meta_values[`_wp_flight-destination_meta_key`].name}}
                            </p>
                            <p v-if="flight.meta_values['_wp_flight-origin_meta_key'] != undefined">
                                {{flight.meta_values[`_wp_flight-origin_meta_key`].name}}
                            </p>
                        </td>
                        <td>
                            <p>
                                {{  getHour(flight) }}
                            </p>
                        </td>
                        <td v-bind:style="{ backgroundColor : `${flight.terms.status[0].values['status_bk_color'][0]}` }">
                            <p v-bind:style="{color: flight.terms.status[0].values['status_txt_color'][0] }">
                                <strong>{{ flight.terms.status[0].name }}</strong>
                            </p>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
	</div>
    <?php
    include_once ('styles.php');
    include_once ('code.php');
    return ob_get_clean();
}