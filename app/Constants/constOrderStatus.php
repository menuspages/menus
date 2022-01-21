<?php
namespace App\Constants;
class constOrderStatus
{
    const NEW = 1;
    const NOTICED = 2;
    const FINISHED = 3;
    const CANCELLED = 0;
    
    const STATUSES = [
        self::NEW => 'جديد',
        self::NOTICED => 'تمت ملاحظته',
        self::FINISHED => 'انتهي',
        self::CANCELLED => 'ألغيت',

    ];
    
    public static function getUpdatedStatusByIndex($index)
    {
            if($index == 0)
            {
            return 'ألغيت';
            } 
           if($index == 1)
           {
              return 'تم الاستلام';
           } 
           if($index == 2)
           {
            return 'تمت ملاحظته ';
           } 
           if($index == 3)
           {
            return 'انتهي ';
           }            
    }
    public static function getStatusByIndex($index,$iscancelled=null)
    {
           if($iscancelled == true)
           {
                return "ألغيت";
           }
           if($index == 1)
           {
              return 'جديد';
           } 
           if($index == 2)
           {
            return 'قبول ';
           } 
           if($index == 3)
           {
            return 'انتهي ';
           } 
            return 'انتهي '; 
           
    }
}
