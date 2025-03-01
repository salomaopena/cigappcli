<?php

function format_currency($value){
    return 'R$ '. number_format($value,2,'.');
}