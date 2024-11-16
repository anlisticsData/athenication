<?php

namespace Interfaces;

use Commoms\TokenEntity;



interface ITokenRepository{
    function store(TokenEntity $token);
    function by($token);
    function update(TokenEntity $token);
    function remove($token);
    
    
    
}