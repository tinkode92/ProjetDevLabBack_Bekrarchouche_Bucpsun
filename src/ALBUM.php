<?php

 class Album
 {
     public function __construct(
         public string $name,
         public string $status,
     )
     {
     }

     public function verify(): bool
     {
         $isValid = true;

         if ($this->name === "" || $this->status === "") {
             $isValid = false;
         }

         return $isValid;
     }
 }
