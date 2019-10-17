<?php

if (! function_exists('int_to_postalcode')) {
    function int_to_postalcode($int)
    {
        if ($int = preg_replace('/[^0-9]/', '', $int)) {            
            $start = substr($int, 0, 5);
            $end = substr($int, -3);

            return $start . '-' . $end;
        }
    }
}

if (! function_exists('postalcode_to_int')) {
    function postalcode_to_int($string)
    {
        return preg_replace('/[^0-9]/', '', $string);
    }
}
