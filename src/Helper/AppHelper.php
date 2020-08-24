<?php

namespace App\Helper;

use DateTime;
use DateTimeZone;

class AppHelper
{
    public static function parseToJSON($arr) {

        $arr = isset($arr) ? $arr : [];

        return json_encode($arr);
    }

    public static function getDatetime() {

        $datetime = new DateTime('now');
        $datetime->setTimeZone(new DateTimeZone('America/Sao_Paulo')); // Change to london time.

        return $datetime->format('Y-m-d\TH:i:s\ZP');
    }

    public static function getUUID() {

        try {

            $datetime = new DateTime('now');
            $datetime = $datetime->format('ymzHisu');

            $uuid = uniqid() . '-' . hash("fnv132", $datetime);

        } catch (\Exception $e) {

            $uuid = substr(md5(rand()), 0, 15);
        }

        return $uuid;
    }
}