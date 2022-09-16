<?php

namespace src;

use InvalidArgumentException;

class Task8
{
    public function main(string $json): string
    {
        $jsonObject = json_decode($json);

        if ($jsonObject != null && is_array(json_decode($json, true))) {
            return sprintf(
                "Title: %s\r\nAuthor: %s\r\nPublisher: %s",
                $jsonObject->Title,
                $jsonObject->Author,
                $jsonObject->Detail->Publisher
            );
        } else {
            throw new InvalidArgumentException();
        }
    }
}
