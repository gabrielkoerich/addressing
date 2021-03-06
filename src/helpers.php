<?php

if (! function_exists('int_to_postalcode')) {
    function int_to_postalcode($int)
    {
        $start = substr($int, 0, 5);
        $end = substr($int, 5, 3);

        return $start . '-' . $end;
    }
}

if (! function_exists('postalcode_to_int')) {
    function postalcode_to_int($string)
    {
        return preg_replace('/[^0-9]/', '', $string);
    }
}
