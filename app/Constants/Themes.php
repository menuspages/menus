<?php


namespace App\Constants;


class Themes
{
    const LOGIN_PAGE_BACKGROUND_IMAGE_PATH_ADMIN = '"https://wallpaperaccess.com/full/1803337.jpg"';
    const LOGIN_PAGE_BACKGROUND_IMAGE_PATH = '"https://wallpaperaccess.com/full/1155017.jpg"';

    const THEME_1 = '1';
    const THEME_2 = '2';
    const THEME_3 = '3';
    const THEME_4 = '4';
    const THEME_5 = '5';
    const THEME_6 = '6';
    const THEME_7 = '7';
    const THEME_8 = '8';
    const THEME_9 = '9';
    const THEME_101 = '101';
    const THEME_10 = '10';
    
    
    
    const AVAILABLE_THEMES = [
        self::THEME_1,
        self::THEME_2,
        self::THEME_3,
        self::THEME_4,
        self::THEME_5,
        self::THEME_6,
        self::THEME_7,
    	self::THEME_8,
        self::THEME_9,
        self::THEME_101,
        self::THEME_10,
        

    ];
    const AVAILABLE_THEMES_LABELS = [
        self::THEME_1 => 'الشكل الاول',
        self::THEME_2 => 'الشكل الثاني',
        self::THEME_3 => 'الشكل الثالث',
        self::THEME_4 => 'الشكل الرابع',
        self::THEME_5 => 'الشكل الخامس',
        self::THEME_6 => 'New Theme',
        self::THEME_7 => 'New Theme 7',
	    self::THEME_8 => 'New Theme 8',
        self::THEME_9 => 'New Theme 9',
        self::THEME_101 => 'Test Theme 101',
        self::THEME_10 => 'New Theme 10',
        
    ];

    const THEMES_NEEDS_ALL_ITEMS = [
        self::THEME_5
    ];
}
