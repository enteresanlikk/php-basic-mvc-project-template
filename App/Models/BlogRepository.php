<?php

namespace App\Models;

class BlogRepository
{
    public static function GetAll()
    {
        return array(
            array(
                "id" => 1,
                "url" => "yazi-1",
                "title" => "title 1",
                "content" => "content 1"
            ),
            array(
                "id" => 2,
                "url" => "yazi-2",
                "title" => "title 2",
                "content" => "content 2"
            ),
            array(
                "id" => 3,
                "url" => "yazi-3",
                "title" => "title 3",
                "content" => "content 3"
            ),
            array(
                "id" => 4,
                "url" => "yazi-4",
                "title" => "title 4",
                "content" => "content 4"
            )
        );
    }

    public static function Get($url)
    {
        $entry =  new \stdClass();
        $items = self::GetAll();
        foreach ($items as $item) {
            if($url == $item["url"]) {
                $entry = $item;
            }
        }

        return $entry;
    }
}