<?php

use Middlewares\Authentication;
use Middlewares\Cors;

error_reporting(E_ALL);
ini_set('display_errors', 1);



require_once "vendor/autoload.php";







try {
    Cors::init();
    Authentication::init(null, ['view_dashboard'], ['view_dashboard']);
    //Authentication::init("eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyLCJ1c2VyIjoxLCJsZXZlbCI6MSwiZXhwIjoxNzMxMzIzNTEwfQ.ynf2NKZlsy7pR8epXEvP9gil51a3f3-uFmVc0dpOTtE", ['view_dashboard'], ['view_dashboard']);
    //eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyLCJ1c2VyIjoxLCJsZXZlbCI6MSwiZXhwIjoxNzMxMzIzNTEwfQ.ynf2NKZlsy7pR8epXEvP9gil51a3f3-uFmVc0dpOTtE
    echo "Ola acesso permitido.!";
} catch (Exception   $e) {
    print_r(["<pre>", $e]);
}
