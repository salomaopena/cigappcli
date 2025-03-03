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


function get_order_total_items(){
    
    $order = session()->get('order');

    if(empty($order['items'])) return 0;

    $total = 0;

    foreach ($order['items'] as $item){
        $total += $item['quantity'];
    }

    return $total;
}

function get_quantity_in_order($id){
    $order = get_order();

    if(empty($order['items'])) return 0;

    if(key_exists($id, $order['items'])){
        return $order['items'][$id]['quantity'];
    }

    return 0;
}

function delete_order(){
    //clear order from session
    session()->remove('order');
}

function get_order(){
    //get order from session
    return session()->get('order');
}

function update_order($id_product, $quantity, $price){
    
    $order = get_order();

    //check if product exists
    //if(empty($order['items'])) return;

    if(key_exists($id_product, $order['items'])){
        if($quantity==0){
            //remove product from order
            unset($order['items'][$id_product]);
        }else{
            //update product quantity and total
            $order['items'][$id_product]['quantity'] = $quantity;
        }
    }else{

        //check if quantity is zero

        if($quantity==0) return;

        //add product to order
        $order['items'][$id_product] = [
            'quantity' => $quantity,
            'price'     => $price,
        ];
    }

    //update order in session
    session()->set('order', $order);
}

function get_order_total_price(){
    $order = get_order();

    if(empty($order['items'])) return 0;

    $total = 0;

    foreach ($order['items'] as $item){
        $total += $item['quantity'] * $item['price'];
    }

    return $total;
}