<?php
/**
 * Creator: Bryan Mayor
 * Company: Blue Nest Digital, LLC
 * License: (Blue Nest Digital LLC, All rights reserved)
 * Copyright: Copyright 2018 Blue Nest Digital LLC
 */

namespace Roost\Testing\Laravel;

class JsonHelper
{
    public static function getJsonResponse(\Illuminate\Http\JsonResponse $response)
    {
        $content = $response->getContent();

        if($content === null) {
            throw new \RuntimeException("Unexpected json response: " . print_r($content, true));
        }

        $contentArray = json_decode($content, true);

        if($contentArray === null) {
            throw new \RuntimeException("Could not json_decode() json: " . print_r([
                    "content" => $content,
                    "json_last_error_msg" => json_last_error_msg()
                ]));
        }

        return $contentArray;
    }
}