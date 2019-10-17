<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 08.10.2019
 * Time: 1:24
 */

class ServerInfo
{
    private $phone_array;
    private $agent;

    public function __construct()
    {
        $this->phone_array = array('iphone', 'android', 'pocket', 'palm', 'windows ce', 'windowsce', 'cellphone', 'opera mobi', 'ipod', 'small', 'sharp',
            'sonyericsson', 'symbian', 'opera mini', 'nokia', 'htc_', 'samsung', 'motorola', 'smartphone', 'blackberry', 'playstation portable', 'tablet browser');
        $this->agent = $_SERVER['HTTP_USER_AGENT'];
    }

    public function IsMobile()
    {
        foreach ($this->phone_array as $value) {
            if ( strpos($this->agent, $value) !== false ) return true;
        }

        return false;
    }
}