<?php 
/** 
 * Plugin Name : Infos Recipe
 * Description: Plugin fournissant des shortcodes
 * Author: Elliott
 * Version: 1.0.0
 */

function shortcode_infos($atts){
    extract(shortcode_atts(
        array(
            'time' => 10,
            'difficulty' => 3,
            'price' => 2
    ), $atts));

    switch ($atts->difficulty) {
        case 0:
            $difficulty = 'Très Facile';
            break;
        case 1:
            $difficulty = 'Moyennement dur';
            break;
        case 2:
            $difficulty = 'Très dur';
            break;
    }

    switch ($atts->price) {
        case 0:
            $price = 'Pas cher';
            break;
        case 1:
            $price = 'Bon marché';
            break;
        case 2:
            $price = 'Cher';
            break;
    }

    

    return '<div style="display: flex; width: 100%; justify-content: center;" class="container" >
                <div class="block">' + $atts->time + ' min</div>
                <div style="margin-left: 20px;" class="dot">.</div>
                <div style="margin-left: 20px;" class="block">' + $difficulty + '</div>
                <div style="margin-left: 20px;" class="dot">.</div>
                <div style="margin-left: 40px;" class="block">' + $price + '</div>
            </div>';
}
add_shortcode('infos', 'shortcode_infos');