<?php

add_action('wp_head', 'vue_faw_js');
function vue_faw_js(){
    ?>
    <script src="https://kit.fontawesome.com/728a3885a4.js" crossorigin="anonymous"></script>
    <script src="<?php echo plugins_url( '/AirportFlights/assets/js/vue.js') ?>"></script>
    <?php
}

add_shortcode('flight_menu', 'flight_menu');

function flight_menu(){
	ob_start();
	?>
	<div id="flight_menu" >
        <div class="menu-flight" v-if="show_menu">
            <div v-for="flight in flights" v-if="selected == null">
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
            <div v-for="type in types" v-if="selected != null">
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
        <div class="flight-list" v-if="selected != null && type_selected != null">
            <div style="display: flex; justify-content: space-around">
                <div class="list-title">
                    <div class="icon-type" v-on:click="toggle_menu" style="cursor: pointer; background-color: var(--wp-primary)">
                        <i v-bind:class="'fa-solid ' +  (show_menu ? 'fa-eye-slash' : 'fa-eye') + ' fa-2xl'"></i>
                    </div>
                    <div class="icon-type" >
                        <i v-bind:class="selected.icon + ' fa-2xl'"></i>
                    </div>
                    <div style="display: inline-block;">
                        <strong>{{selected.label}} {{type_selected.label}}</strong>
                        <div>{{type_selected.name}} {{selected.name}} </div>
                    </div>

                </div>
                <div style="padding-top: 15px">
                    <h3><strong>{{current_time}}</strong></h3>
                </div>
            </div>

            <div style="padding-top: 25px">
                <table>
                    <tr>
                        <th>
                            <h4>Aerolínea</h4>
                            <p>Airline</p>
                        </th>
                        <th>
                            <h4>Vuelo</h4>
                            <p>Flight</p>
                        </th>
                        <th v-if="selected.name == 'arrival'">
                            <h4>Origen</h4>
                            <p>Origin</p>
                        </th>
                        <th v-if="selected.name == 'departure'">
                            <h4>Destino</h4>
                            <p>Destination</p>
                        </th>
                        <th>
                            <h4>Hora de {{selected.label}}</h4>
                            <p>Time of {{selected.name}}</p>
                        </th>
                        <th>
                            <h4>Estado</h4>
                            <p>Status</p>
                        </th>
                    </tr>
                    <tr v-for="flight in flight_list">
                        <th>
                            <img
                                    v-bind:src="flight.terms.airline[0].values.airline_image[0]"
                                    v-if="flight.terms.airline != false && flight.terms.airline[0].values.airline_image != false"
                                    alt=""
                                    width="200px">
                        </th>
                        <th>
                            <p>
                                {{flight.meta_values['_wp_flight-code_meta_key'][0]}}
                            </p>
                        </th>
                        <th>
                            <p>

                            </p>
                        </th>
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