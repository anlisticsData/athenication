<?php

namespace Commoms;

use Interfaces\IToArray;

class TokenEntity implements IToArray
{
    public $fillable = ["id", "token", "user_id", "level_id", "expired", "created"];
    public $id;
    public $token;
    public $user_id;
    public $level_id;
    public $expired;
    public $created;


    public function __construct($parameters = null)
    {
        $this->created=date("Y-m-d H:m:i");
        $this->expired=strtotime(date("Y-m-d H:m:i"));
        if (!is_null($parameters)) {
            foreach ($this->fillable as $index => $value) {
                if (isset($parameters[$value])) {
                    $this->$value = $parameters[$value];
                }
            }
        }
    }

    function toArray(){
        $list=[];
        foreach ($this->fillable as $index => $value) {
            $list[$value]=$this->$value;
        }
        return $list;
    }
}
