<?php

namespace modules\admin\classes;

class AdminCast
{

    public static function date($value)
    {
        return $value ? \date('Y-m-d', \strtotime($value)) : '';
    }
}
