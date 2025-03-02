<?php

function init_order(){
    //clear order, if exists
    delete_order();

    //set new empty order
    session()->set('order', [
        'items' => [],
        'status' => 'new',
    ]);
}

function add_product_temp(){
    $order = get_order();

    $order['items'][1] =[
        'quantity' => 1,
        'price_per_unit' => 10.00,
    ];

    //update order in sesscion

    session()->set('order', $order);

    return true;
}

function delete_order(){
    //clear order from session
    session()->remove('order');
}

function get_order(){
    //get order from session
    return session()->get('order');
}