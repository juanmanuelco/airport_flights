<?php ?>
<style>
    #flight_app input[type="text"] , #flight_app input[type="datetime-local"], #flight_app select{
        width: 100%;
    }
</style>
 <script>
        let flight_app = new Vue({
            el: '#flight_app',
            data: {
                flight_type : '<?php echo $flight_type ?>',
                flight_route : '<?php echo $flight_route ?>',
                flight_code : '<?php echo $flight_code ?>',
                flight_estimate : '<?php echo $flight_estimate ?>',
                flight_origin : '<?php echo $flight_origin ?>',
                flight_destination : '<?php echo $flight_destination ?>',
                flight_types : [
                    {'value' : 'arrival', 'label' : '<?php echo __('Arrivals', 'airport_flights') ?>' },
                    {'value' : 'departure', 'label' : '<?php echo __('Departures', 'airport_flights') ?>' },
                ],
                flight_routes : [
                    {'value' : 'national', 'label' : '<?php echo __('National', 'airport_flights') ?>' },
                    {'value' : 'international', 'label' : '<?php echo __('International', 'airport_flights') ?>' },
                ],
                places : <?php echo json_encode($places); ?>,
                search : ''
            },
	        computed : {
                currentType : ()=>{
                    let response = "";
                    switch (flight_app.flight_type){
                        case 'arrival':
                            response =  '<?php echo __('Arrival', 'airport_flights') ?>';
                            break
	                    case 'departure':
                            response =  '<?php echo __('Departure', 'airport_flights') ?>';
                            break
                    }
                    return response;
                }
	        },
            methods :{
                filter : ()=>{
                    flight_app.places = flight_app.places.map((place)=>{
                        if(flight_app.search.trim().length === 0){
                            place.visible = true;
                        }else{
                            place.visible = place.name.toLowerCase().includes(flight_app.search.toLowerCase());
                        }
                        return place;
                    });
                }
            }
        });
    </script>