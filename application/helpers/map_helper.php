<?php 
function get_infor_from_address($address = null) {
    $prepAddr = str_replace(' ', '+', LocDau($address));
    $geocode = file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');
    $output = json_decode($geocode);
    return $output;
}
?>