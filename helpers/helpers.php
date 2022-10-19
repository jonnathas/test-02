<?php

if(!function_exists('dateTimeFormate')){
    
    function dateTimeFormate($datatime){

        return \Carbon\Carbon::parse($datatime)->format('h:m d/m/Y');
    }
}