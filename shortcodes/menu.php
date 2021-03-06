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
        'interval_f' => 12,
		'interval_b' => 12,
        'menu' => 1,
        'scroll' => 10
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
            <div style="display: flex; justify-content: space-around; padding-bottom:25px" id="list_header_top">
                <div class="list-title">
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


            <div v-if="!loading">
                <table class="flights_list_table" style="border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th>
                                <p class="p-title">{{titles.airline[index_title]}}</p>
                                <p>{{ titles.airline[index_subtitle] }}</p>
                            </th>
                            <th>
                                <p class="p-title">{{titles.flight[index_title]}}</p>
                                <p>{{ titles.flight[index_subtitle] }}</p>
                            </th>
                            <th>
                                <p class="p-title">{{ titles.gate[index_title] }}</p>
                                <p>{{ titles.gate[index_subtitle] }}</p>
                            </th>
                            <th v-if="flight_selected.name == 'arrival'">
                                <p class="p-title">{{ titles.origin[index_title] }}</p>
                                <p>{{ titles.origin[index_subtitle] }}</p>
                            </th>
                            <th v-if="flight_selected.name == 'departure'">
                                <p class="p-title">{{ titles.destination[index_title] }}</p>
                                <p>{{ titles.destination[index_subtitle] }}</p>
                            </th>
                            <th>
                                <p class="p-title">{{ titles.estimate[index_title] }}</p>
                                <p>{{ titles.estimate[index_subtitle] }}</p>
                            </th>
                            <th>
                                <p class="p-title">{{ titles.status[index_title] }}</p>
                                <p>{{ titles.status[index_subtitle] }}</p>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="flights_scroll_content" >
                        <tr v-for="flight in flight_list" style="border: 1px solid rgba(0,0,0,0.1)">
                            <td>
                                <img
                                        v-bind:src="flight.terms.airline[0].values.airline_image[0]"
                                        v-if="flight.terms.airline != false && flight.terms.airline[0].values.airline_image != false"
                                        style="width: 150px;">
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
                                    {{flight.terms.gate[0].name}}
                                </p>
                            </td>
                            <td>
                                <p>
                                    <strong v-if="flight.meta_values[`_wp_flight-origin_meta_key`].meta_data[`code_txt`] != undefined">
                                        {{flight.meta_values[`_wp_flight-origin_meta_key`].meta_data[`code_txt`][0] }}
                                    </strong>
                                    <strong v-if="flight.meta_values['_wp_flight-destination_meta_key'] != undefined">
                                        {{flight.meta_values[`_wp_flight-destination_meta_key`].name}}
                                    </strong>
                                    <br>
                                    <strong v-if="flight.meta_values['_wp_flight-origin_meta_key'] != undefined">
                                        {{flight.meta_values[`_wp_flight-origin_meta_key`].name}}
                                    </strong>
                                    <br>
                                    <strong v-if="flight.meta_values[`_wp_flight-origin_meta_key`].meta_data[`english_name_txt`] != undefined">
                                        {{flight.meta_values[`_wp_flight-origin_meta_key`].meta_data[`english_name_txt`][0] }}
                                    </strong>
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
                                    <br>
                                    <strong>{{ flight.terms.status[0].values[`english_name_txt`][0] }}</strong>
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
	</div>
    <?php
    include_once ('styles.php');
    include_once ('code.php');
    return ob_get_clean();
}