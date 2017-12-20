<?php

namespace modules\admin\classes;

class AdminCast
{

    /**
     * @param $value
     *
     * @return false|string
     */
    public static function date($value)
    {
        return $value ? \date('Y-m-d', \strtotime($value)) : '';
    }

    /**
     * @param $value
     *
     * @return false|string
     */
    public static function dateTime($value)
    {
        return $value ? \date('Y-m-d H:i:s', \strtotime($value)) : '';
    }
}
