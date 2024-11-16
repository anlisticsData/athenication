# athenication
Pacote para validacao e acessos de usuario para usr em paginas php ou em apis 


<?php

use Commoms\Jwt;
use Middlewares\Cors;
use Commoms\TokenEntity;
use Interfaces\IConnect;
use Middlewares\Authentication;
use Interfaces\ITokenRepository;

error_reporting(E_ALL);
ini_set('display_errors', 1);



require_once "vendor/autoload.php";





interface IConnectDataBase extends IConnect
{
    function connect();
}


class TextAdapter implements IConnectDataBase
{
    function connect()
    {
        return fopen("demo.dat", 'w+');
    }
}

class TokenRepository implements ITokenRepository
{
    private $iConnect = null;
    function __construct(IConnectDataBase $iConnect)
    {
        $this->iConnect = $iConnect;
    }


    function store(TokenEntity $token)
    {
        $handler = $this->iConnect->connect();
        fwrite($handler, json_encode($token->toArray()));
        fclose($handler);
    }
    function by($token) {}
    function update(TokenEntity $token) {}
    function remove($token) {}
}






try {

    $json = file_get_contents('php://input');
    $obj = json_decode($json, true);

    $TokenRepository = new TokenRepository(new TextAdapter());
    $parsed = parse_ini_file('authentication.env');
    $secret = $parsed["auth"];


    if (isset($_GET['token']) && $_GET['token'] == 1) {
        $playload = [

            "email" => $obj['email'],
            "name" =>  $obj['email'],
            "user" => 1,
            "level" => 1,
            "permisions" => [
                'view_dashboard'
            ],
            "created_at" => date("Y-m-d H:m:i"),
            "exp" => strtotime(date("Y-m-d H:m:i"))

        ];
      
        $newToken = Jwt::encode($playload, $secret);
        $tokenEntity = new TokenEntity(["token" => $newToken, "user_id" => '1', "level_id" => "2"]);
        $TokenRepository->store($tokenEntity);
        echo $newToken;
    } else {
        Cors::init();
        if (isset($_GET["jwt"])) {
            $decode = Jwt::decode($_GET["jwt"],$secret);
            Authentication::init($_GET["jwt"], ['view_dashboard'],$decode['permisions']);
            //Authentication::init(null, ['view_dashboard'], ['view_dashboard']);
            //eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyLCJ1c2VyIjoxLCJsZXZlbCI6MSwiZXhwIjoxNzMxMzIzNTEwfQ.ynf2NKZlsy7pR8epXEvP9gil51a3f3-uFmVc0dpOTtE
            echo "Ola acesso permitido.!";
        }else{
            Authentication::init(null, ['view_dashboard'], ['view_dashboard']);
            echo "Ola Post no  acesso. :(";
        }
    }
} catch (Exception   $e) {
    print_r(["<pre>", $e->getMessage()]);
}

