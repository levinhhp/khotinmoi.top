<?php
function get_time($ptime){
    $etime = time() - $ptime;    
    if( $etime < 1 ){
        return 'less than 1 second ago';
    }    
    $a = array( 12 * 30 * 24 * 60 * 60  =>  'year',
                30 * 24 * 60 * 60       =>  'month',
                24 * 60 * 60            =>  'day',
                60 * 60             =>  'hour',
                60                  =>  'minute',
                1                   =>  'second'
    );
    foreach( $a as $secs => $str ){
        $d = $etime / $secs;
        if( $d >= 1 ){
            $r = round( $d );
            if($str=='year'){
                $str_ago = 'năm';
            }elseif($str=='month'){
                $str_ago = 'tháng';
            }elseif($str=='day'){
                $str_ago = 'ngày';
            }elseif($str=='hour'){
                $str_ago = 'giờ';
            }elseif($str=='minute'){
                $str_ago = 'phút';
            }elseif($str=='second'){
                $str_ago = 'giây';
            }
            return $r . ' ' . $str_ago . ' trước';
        }
    }
}