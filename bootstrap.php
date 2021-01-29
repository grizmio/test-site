<?php
namespace Libs;


use Libs\RouteNotFoundException;
use Libs\MethodNotFoundException;
use Libs\Request;

define("TEMPLATES_PATH", __DIR__.DIRECTORY_SEPARATOR.'Templates');
define("MAX_BODY_SIZE", 65535);
define('PASSWORD_MIN_LENGTH', 8);

spl_autoload_register(function ($class) {
        $classPathFileName = str_replace('\\', DIRECTORY_SEPARATOR, $class).'.php';
        if(file_exists($classPathFileName)){
            include_once $classPathFileName;
            return;
        }
        debug('File not found: '.$classPathFileName);
    }
);

include('debug.php');
include_once('config/routes_config.php');


$requestUri = $_SERVER["REQUEST_URI"];
$requestMethod = $_SERVER['REQUEST_METHOD'];

$request = new Request();
$request->setHeaders(getallheaders());

try{
    $route = Router::getRoute($requestMethod, $requestUri, $request);
}catch(RouteNotFoundException $e){
    http_response_code(404);
    echo $e->getMessage();
    return 1;
}catch(MethodNotFoundException $e){
    http_response_code(404);
    echo $e->getMessage();
    return 1;
}


$controllerName = $route->getControllerName();

$databaseDSN = getenv('DATABASE_DSN');
if($databaseDSN !== FALSE) {
    $databaseUser = getenv('DATABASE_USER');
    $databasePassword = getenv('DATABASE_PASSWORD');
    Database::setDsn($databaseDSN);
    Database::setUser($databaseUser);
    Database::setPassword($databasePassword);
    Database::setOptions([
        \PDO::ATTR_EMULATE_PREPARES => false,
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
    ]);
    try{
        Database::connect();
    }catch( \PDOException $e ) {
        debug($e->getMessage());
    }
}

// intentamos obtener el cuerpo del request, segun manual php://input usar php
// MAX_BODY_SIZE esta definido en constants.php
$requestBody = file_get_contents('php://input', false, null, 0, MAX_BODY_SIZE);
$request->setBody($requestBody);
$controller = new $controllerName();
$controller->setRoute($route);
$controller->setRequest($request);
$controller();
