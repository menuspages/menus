<?php


namespace App\Constants;


class Roles
{
    const ADMIN_ROLE = 'admin';
    const RESTAURANT_MANAGER_ROLE = 'restaurant_manager';

    public static function roles (){
        return [
          self::ADMIN_ROLE => 'الادمن',
          self::RESTAURANT_MANAGER_ROLE => 'مدير المتجر',
        ];
    }
}
