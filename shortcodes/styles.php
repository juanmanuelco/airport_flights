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

    .flight-list {
        padding-top: 25px;
    }

    .menu-flight .button-flight {
        border-radius: 15px;
        border: 3px solid var(--wp-primary);
        padding-bottom: 25px;
        margin: 5px;
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
        font-size: 1.8em;
    }
    .flights_list_table {
        overflow-x: scroll;
        display: block;
    }
    .flights_list_table tbody{
        width: 100%;
        display: inline-table;
    }
    .flights_list_table tr th {
        background-color: var(--wp-secundary) !important;
        color: var(--wp-light) !important;
    }

</style>