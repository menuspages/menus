<?php


namespace App\Constants;


class Order
{
    const PICKUP_TYPE_DELIVERY = 1;
    const PICKUP_TYPE_TAKE_AWAY = 2;
    const PICKUP_TYPE_SWEETEND = 3;
    
    const PICKUP_TYPES = [
        self::PICKUP_TYPE_DELIVERY => 'توصيل',
        self::PICKUP_TYPE_TAKE_AWAY => 'استلام',
        self::PICKUP_TYPE_SWEETEND => 'محلي',
        
    ];
}
