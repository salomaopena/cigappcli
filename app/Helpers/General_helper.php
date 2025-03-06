<?php

function format_currency($value){
    return 'R$ '. number_format($value,2,'.');
}

function define_order_number_from_id($id_order){
    //implement logic to generate order number from id

    if ($id_order < 100) {
        $order_number = $id_order;
        $order_series = 0;
    } else{
        $order_number = $id_order % 100;
        $order_series = floor($id_order / 100);
    }
    return [
        'order_number' => $order_number,
        'order_series' => $order_series,
        'order_code' => $order_series . '-' . $order_number,
    ];
}