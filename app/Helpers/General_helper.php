<?php

function format_currency($value){
    return 'R$ '. number_format($value,2,'.');
}

function define_order_number_from_last_order_number($new_order_number){
    //implement logic to generate order number from id

    if ($new_order_number < 100) {
        $order_number = $new_order_number;
        $order_series = 0;
    } else{
        $order_number = $new_order_number % 100;
        $order_series = floor($new_order_number / 100);
    }
    return [
        'order_number' => $order_number,
        'order_series' => $order_series,
        'order_code' => $order_series . '-' . $order_number,
    ];
}