<?php

error_reporting(-1);

require_once ('application/Application.php');

function router($params) {
    $method = $params ['method'];
    if ($method) {
        $app = new Application();
        switch ($method) {
            // user
            case 'getNameByLetter' : return $app->getNameByLetter($params);
            case 'getAlldata' : return $app->getAlldata($params);
            case 'inactiveUsers' :return $app->inactiveUsers();
            case 'passport' : return $app->passport($params);
            case 'citizens' : return $app->citizens();
            case 'messageLength' : return $app->messageLength();
            case 'oddeven': return $app->oddeven();
            case 'order' : return $app->order();
            case 'average' : return $app->average();
            case 'getId' : return $app->getId();
            case 'login' : return $app->login($params);
            case 'logout' : return $app->logout($params);
            case 'registration' : return $app->registration($params);
            // chat
            case 'sendMessage' : return $app->sendMessage($params);
            case 'getMessages' : return $app->getMessages($params);
            // game
            case 'join' : return $app->join($params);
            case 'leave' : return $app->leave($params);
            case 'action' : return $app->action($params);
            case 'getScene' : return $app->getScene($params);
        }
    }
    return false;
}

function answer($data) {
    if ($data){
        return array(
            'result' =>'ok',
            'data' => $data
        );
    }
    return array ('result' => 'error');
}

echo json_encode(answer(router($_GET)));