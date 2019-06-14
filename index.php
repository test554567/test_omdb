<?php

require_once "bootstrap.php";

$omdbKey = '';

//TODO add routing

$controller = new TestController($omdbKey);
switch ($controller->getRequestParam('action')) {
    case 'add':
        $controller->addToFavourites();
        break;
    case 'remove':
        $controller->removeFromFavourites();
        break;
    case 'list':
        $controller->viewFavourites();
        break;
    case 'search':
    default:
        $controller->view();
}

?>
