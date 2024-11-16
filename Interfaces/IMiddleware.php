<?php

namespace Interfaces;


interface IMiddleware{
    static function init($tokenDb=null,$permissionsSystem=null,$permissionsUsers=null,$exp=10);
}