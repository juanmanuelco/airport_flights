<?php ?>
<style>
    :root {
        --wp-primary: #1a4548;
        --wp-secundary: #005a87;
        --wp-light: #ffffff;
    }

    .icon-type {
        background-color: var(--wp-secundary);
        padding: 15px;
        font-size: 25px;
        border-radius: 15px;
        text-align: center;
        color: var(--wp-light);
        float:left;
        margin-right: 25px;
        margin-top:10px
    }

    .list-title {
        padding-left: 15px;
        text-transform: capitalize;
    }

    .list-title div {
        font-size: 15px;
    }

    .list-title div strong {
        font-size: 25px;
    }

    .menu-flight {
        display: flex;
        justify-content: center;
    }

    .menu-flight .button-flight {
        border-radius: 15px;
        border: 3px solid var(--wp-primary);
        padding-bottom: 25px;
        margin: 5px;
    }

    #flight_menu{
        max-width: 100% !important;
    }

    #flight_menu .menu-flight a {
        text-decoration: none;
    }

    .menu-flight .button-flight:hover,
    .button-flight-active {
        cursor: pointer;
        background-color: var(--wp-primary);
        color: var(--wp-light);
    }
    .flights_list_table td{
        vertical-align: middle;
        text-align: center;
    }
    .flights_list_table tr td p{
        font-size: 1.4em;
    }
    .flights_list_table {
        width: 100%;
    }

    .flights_list_table thead{
        overflow-y: auto;
    }


    .flights_list_table thead th { position: sticky; top: 140px; z-index: 1; }

    #list_header_top{
        position: sticky; top: 30px; z-index: 1;
        background-color: white;
    }


    .flights_list_table tr th {
        background-color: var(--wp-secundary) !important;
        color: var(--wp-light) !important;
    }
    .loader {
        border: 16px solid #f3f3f3; /* Light grey */
        border-top: 16px solid #3498db; /* Blue */
        border-radius: 50%;
        width: 120px;
        height: 120px;
        animation: spin 2s linear infinite;
        margin : 0 auto;
        margin-top: 50px;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .p-title{
        font-size: 25px;
    }

</style>