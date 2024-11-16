<?php

use Middlewares\Cors;
use Commoms\TokenEntity;
use Interfaces\IConnect;
use Middlewares\Authentication;
use Interfaces\ITokenRepository;

error_reporting(E_ALL);
ini_set('display_errors', 1);



require_once "vendor/autoload.php";


interface IConnectDataBase extends IConnect{
    function connect();
}


class TextAdapter implements IConnectDataBase{
    function connect(){
        return fopen("demo.dat",'a+');
    }
}

class TokenRepository implements ITokenRepository{
    private $iConnect=null;
    function __construct(IConnectDataBase $iConnect)
    {
        $this->iConnect=$iConnect;
    }


    function store(TokenEntity $token){}
    function by($token){}
    function update(TokenEntity $token){}
    function remove($token){}
}


$t = new TokenRepository(new TextAdapter());



try {
    Cors::init();
    //Authentication::init(null, ['view_dashboard'], ['view_dashboard']);
    Authentication::init("eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyLCJ1c2VyIjoxLCJsZXZlbCI6MSwiZXhwIjoxNzMxNzUxODg4fQ.-3VmsZlKD7x1qcCXvfJ1XRgncYb9HcDJSDQf7AIU1OA", ['view_dashboard'], ['view_dashboard']);
    //eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyLCJ1c2VyIjoxLCJsZXZlbCI6MSwiZXhwIjoxNzMxMzIzNTEwfQ.ynf2NKZlsy7pR8epXEvP9gil51a3f3-uFmVc0dpOTtE
    echo "Ola acesso permitido.!";
} catch (Exception   $e) {
    print_r(["<pre>", $e->getMessage()]);
}
