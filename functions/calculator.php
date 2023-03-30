<?php

function hlm_get_calculator_title()
{

    $pre_data_calc = carbon_get_theme_option('hlm_pre_data_calc');

    foreach ( $pre_data_calc as $key => $value ) :

        $k = trim($value['title']);
        $weight = trim($value['weight']);
        $pt = trim($value['pt']);
        $pd = trim($value['pd']);
        $ph = trim($value['ph']);
        
        $new_title_arr[$k] = [
            'title' => $k,
            'weight' => $weight,
            'pt' => $pt,
            'pd' => $pd,
            'ph' => $ph,
        ];

    endforeach;

    return $new_title_arr;

}