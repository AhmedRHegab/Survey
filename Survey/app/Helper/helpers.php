<?php


if(!function_exists('str_limit')) {
    function str_limit($value , $limit = 20) {
        return  \Str::limit($value,$limit);
    }
}

