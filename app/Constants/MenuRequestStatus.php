<?php


namespace App\Constants;


class MenuRequestStatus
{
    const NEW = 1;
    const SEEN = 2;

    const STATUSES = [
        self::NEW => 'جديد',
        self::SEEN => 'تمت ملاحظته',
    ];
}
