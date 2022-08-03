<?php

namespace App\Http\Controllers;

use DateTimeInterface;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use JsonSerializable;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    protected ?Authenticatable $user;

    public function __construct(){
        $this->user = Auth::user();
    }

    protected function mapArray(JsonSerializable $object): array
    {
        $new = [];
        $serialized = $object->jsonSerialize();
        foreach ($serialized as $key => $data){
            $new[$this->camelCaseToUnderscore($key)] = $data;
        }
        return $new;
    }

    private function camelCaseToUnderscore($string): string
    {
        $str = lcfirst($string);
        $str = preg_replace("/[A-Z]/", "_"."$0", $str);
        return strtolower($str);
    }
}
