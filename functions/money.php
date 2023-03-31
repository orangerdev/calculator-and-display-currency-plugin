<?php

function hlm_formatted_currency( $number, $currency_pos, $currency_symbol )
{

    $currency_value = number_format( $number, 0, ",", "." );

    switch ($currency_pos) :
        case 'left' :
            $formatted_currency = $currency_symbol . $currency_value;
            break;
        case 'right' :
            $formatted_currency = $currency_value . $currency_symbol;
            break;
        case 'left_space' :
            $formatted_currency = $currency_symbol .' '. $currency_value;
            break;
        case 'right_space' :
            $formatted_currency = $currency_value .' '. $currency_symbol;
            break;
    endswitch;

    return $formatted_currency;

}

function hlm_get_currency_rate( $from = 'USD', $to = 'IDR' )
{

    $rate = 1;

    $date = current_time('timestamp', true);
    $yql_query_url = 'https://query1.finance.yahoo.com/v8/finance/chart/' . $from . $to . '=X?symbol=' . $from . $to . '%3DX&period1=' . ( $date - 60 * 86400 ) . '&period2=' . $date . '&interval=1d&includePrePost=false&events=div%7Csplit%7Cearn&lang=en-US&region=US&corsDomain=finance.yahoo.com';
    $res = file_get_contents($yql_query_url);

    //$yql_query_url="http://query.yahooapis.com/v1/public/yql?q=select+%2A+from+yahoo.finance.xchange+where+pair+in+EURGBP&format=json&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys";
    $data = json_decode($res, true);
    // echo '<pre>'.print_r($data,1).'</pre>';

    $result = isset($data['chart']['result'][0]['indicators']['quote'][0]['close']) ? $data['chart']['result'][0]['indicators']['quote'][0]['close'] : ( isset($data['chart']['result'][0]['meta']['previousClose']) ? array($data['chart']['result'][0]['meta']['previousClose']) : array() );

    if (count($result) && is_array($result)) :
        $rate = end($result);
    endif;

    return $rate;

}

function hlm_get_currencies()
{
    $all_currencies = array(
        'USD' =>
        array(
            'symbol' => '$',
            'description' => 'US Dollar',
            'symbol_native' => '$',
            'decimals' => 2,
            'rate' => 1,
            'name' => 'USD',
            'flag' => 'us',
            'rate_plus' => '',
            'is_etalon' => 0,
            'position' => 'left',
            'hide_cents' => 0,
        ),
        'IDR' =>
        array(
            'symbol' => 'Rp',
            'description' => 'Indonesian Rupiah',
            'symbol_native' => 'Rp',
            'decimals' => 0,
            'rate' => 1,
            'name' => 'IDR',
            'flag' => 'id',
            'rate_plus' => '',
            'is_etalon' => 0,
            'position' => 'left',
            'hide_cents' => 0,
        ),
        'SGD' =>
        array(
            'symbol' => 'S$',
            'description' => 'Singapore Dollar',
            'symbol_native' => '$',
            'decimals' => 2,
            'rate' => 1,
            'name' => 'SGD',
            'flag' => 'sg',
            'rate_plus' => '',
            'is_etalon' => 0,
            'position' => 'left',
            'hide_cents' => 0,
        ),
        'AUD' =>
        array(
            'symbol' => 'AU$',
            'description' => 'Australian Dollar',
            'symbol_native' => '$',
            'decimals' => 2,
            'rate' => 1,
            'name' => 'AUD',
            'flag' => 'au',
            'rate_plus' => '',
            'is_etalon' => 0,
            'position' => 'left',
            'hide_cents' => 0,
        )
    );

    return $all_currencies;
}