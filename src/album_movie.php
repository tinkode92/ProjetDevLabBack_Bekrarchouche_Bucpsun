<?php

class Movie
{
    public function __construct(
        public int $id_api,
        public int $album_id

    )
    {
    }
    public function verify(): bool
    {
        $isValid = true;

        if ($this->id_api === "") {
            $isValid = false;
        }

        return $isValid;
    }
}
