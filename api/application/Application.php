<?php
require_once ('db/DB.php');
require_once ('user/User.php');
require_once ('chat/Chat.php');
require_once ('game/Game.php');

class Application {
    function __construct(){
        $db = new DB();
        $this->user = new User($db);
		$this->chat = new Chat($db);
    }

    public function login($params){
        if($params['login'] && $params ['password']) {
            return $this->user->login($params['login'], $params['password']);
        }
    }

    public function registration($params) {
		print_r($params);
        if($params['name'] && $params['login'] && $params ['password']) {
            return $this->user->registration($params['name'], $params['login'], $params ['password']);
        }
    }

    public function logout($params){
        if($params['token']) {
            return $this->user->logout($params['token']);
        }	
	}
	
	public function sendMessage($params) {
		if($params['token'] && $params['message']) {
			$user = $this->user->getUser($params['token']);
			if ($user) {
				$this->chat->sendMessage($user['name'], $params['message']);
				return true;
			}
		}
		return false;
	}
	
	public function getMessages($params){
		if($params['token'] && $params['hash']) {
			$user = $this->user->getUser($params['token']);
			if ($user) {
				return $this->chat->getMessages($params['hash']);
			}
		}
		return false;
		
	}

	public function getId(){
		return $this->user->getId();
	}

	public function average() {
		return $this->user->average();
	}
    
    public function order() {
    	return $this->user->order();
    }

    public function oddeven() {
    	return $this->user->oddeven();
    }

    public function messageLength() {
    	return $this->user->messageLength();
    }

    public function citizens() {
    	return $this->user->citizens();
    }

    public function passport($params) {
    	if($params['id']){
    		return $this->user->passport($params['id']);
    	}
    }

    public function inactiveUsers() {
    return $this->user->inactiveUsers();
   }

   public function getAlldata($params) {
   	if($params['table']){
   		return $this->user->getAlldata($params['table']);
   	}   
   	return false;	
   }

   public function getNameByLetter($params) {
   	if($params['letter']){
   		return $this->user->getNameByLetter($params['letter']);
   	}
   }
}