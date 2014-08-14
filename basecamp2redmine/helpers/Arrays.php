<?php


namespace basecamp2redmine\helpers;


class Arrays {

    public static function indexby($arr, $field = 'id') {
        $newarr = array();
        foreach($arr as $item) {
            $newarr[$item->$field] = $item;
        }
        return $newarr;
    }

} 