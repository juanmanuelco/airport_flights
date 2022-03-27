<?php
    function flightManagementLayout(){
        ?>
       <div class="main-general">
           <h1 class="title-white">AEROPUERTO GENERAL ELOY ALFARO</h1>
            <div class="center-div">
                <div class="button-container">
                    <div>
                        <a href="<?php echo get_home_url() ?>/wp-admin/edit.php?post_type=flight">Vuelos</a>
                    </div>
                    <div>
                        <a href="<?php echo get_home_url() ?>/wp-admin/edit-tags.php?taxonomy=airline&post_type=flight">Aerolineas</a>
                    </div>

                    <div>
                        <a href="<?php echo get_home_url() ?>/wp-admin/edit-tags.php?taxonomy=place&post_type=flight">Origenes/destinos</a>
                    </div>
                    <div>
                        <a href="<?php echo get_home_url() ?>/wp-admin/edit-tags.php?taxonomy=door&post_type=flight">Puertas</a>
                    </div>
                    <div>
                        <a href="<?php echo get_home_url() ?>/wp-admin/edit-tags.php?taxonomy=status&post_type=flight">Statuses</a>
                    </div>
                </div>
            </div>
       </div>
        <style>
            .main-general{
                margin: auto;
                text-align: center;
                padding-top: 20px !important;
                height: 100vh;
                position: relative;
                width: 100%;
                background-image: url("<?php echo plugins_url().'/AirportFlights/assets/images/airport.png' ?>");
                background-repeat: no-repeat;
                background-size: cover;
            }
            #wpcontent{
                padding-left: 0px !important;
            }
            .center-div{
                margin: 0;
                width: 450px;
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
            }
            .button-container{
                background-color: white;
                border-radius: 5%;
                width: 50%;
                margin: 0 auto;
                padding: 40px;
            }
            .button-container div a{
                color: white;
                font-weight: bold;
                font-size: 20px;
                text-decoration: none;
                background-color: #4092a0;
                padding: 10px;
                margin-bottom:20px;
                margin-top:20px;
                display: block;
            }
            .title-white{
                color:white;
                font-size: 60px;
                font-weight: bold;
                margin-top: 100px;
                text-shadow: 4px 2px #000000;
            }

        </style>
        <?php
    }

