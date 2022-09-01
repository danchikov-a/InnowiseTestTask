<?php

namespace src;

use InvalidArgumentException;

class Task8
{
    public function main(string $json): string
    {
        $jsonObject = json_decode($json);

        if ($jsonObject != null) {
            return sprintf(
                "Title : %s\nAuthor : %s\nPublisher :%s",
                $jsonObject->Title,
                $jsonObject->Author,
                $jsonObject->Detail->Publisher
            );
        } else {
            throw new InvalidArgumentException();
        }
    }
}
