<?php

namespace cubes\ecommerce\order;

class OrderStatus
{
    const NEW = 0;
    const PROCESS = 1;
    const COMPLETED = 2;
    const CANCELED = 99;

    public static $map = [
        self::NEW => 'Новый',
        self::PROCESS => 'В процессе',
        self::COMPLETED => 'Выполнен',
        self::CANCELED => 'Отменен',
    ];
}
