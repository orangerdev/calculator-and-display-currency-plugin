<?php

function hlm_convert_value_usd_to( $number, $currency = 'USD' )
{

    $currency_label = '$';
    $currency_space = '';
    $currency_value = hlm_fomatted_currency( $number );
    $currency_full = $currency_label . $currency_space . $currency_value;

    return $currency_full;

}

function hlm_fomatted_currency( $number )
{

    return number_format( $number, 0, ",", "." );

}