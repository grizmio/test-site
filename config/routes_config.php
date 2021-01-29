<?php

namespace Libs;

use Libs\Router;
use Controller\Home;
use Controller\ApiUsersList;
use Controller\ApiUserShow;
use Controller\ApiUserDelete;
use Controller\ApiUserPOST;
use Controller\ApiUserPUT;
use Controller\ApiLoginPOST;
use Controller\LoginPOST;
use Controller\LoginGET;
use Controller\Logout;
use Libs\Route;

Router::addGETRoute(new Route('/', Home::class));
Router::addGETRoute(new Route('/Home', Home::class));

Router::addGETRoute(new Route('/login', LoginGET::class));
Router::addPOSTRoute(new Route('/login', LoginPOST::class));

Router::addPOSTRoute(new Route('/logout', Logout::class));
Router::addGETRoute(new Route('/logout', Logout::class));

// Endpoints de la API
Router::addGETRoute(new Route('/api/users', ApiUsersList::class));
Router::addGETRoute(new Route('/api/users/:userid', ApiUserShow::class));
Router::addDELETERoute(new Route('/api/users/:userid/', ApiUserDelete::class));
Router::addPOSTRoute(new Route('/api/users/', ApiUserPOST::class));
Router::addPUTRoute(new Route('/api/users/:userid/', ApiUserPUT::class));
Router::addPOSTRoute(new Route('/api/login/', ApiLoginPOST::class));

