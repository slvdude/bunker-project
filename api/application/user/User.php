<?php
class User {

    function __construct($db) {
        $this->db = $db;
    }

    public function login($login, $password) {
        $user = $this->db->getUserByLoginPass($login, $password);
        if ($user) {
            $token = md5(rand());
            $this->db->updateToken($user['id'], $token);
            return array(
                'name' => $user['name'],
                'login' => $user['login'],
                'token' => $token
            );
        }
    }

    public function registration($name, $login, $password) {
        print_r($name);
        $user = $this->db->getUserByLogin($login);
        if (!$user) {
            $this->db->addNewUser($name, $login, $password);
            return $this->login($login, $password);
        }
    }

    public function logout($token) {
        $user = $this->db->getUserByToken($token);
        if($user){
            $this->db->updateToken($user['id'], null);
            return true;
        }
    }
	
	public function getUser($token){
		return $this->db->getUserByToken($token);
    }
    
    public function getId(){
		return $this->db->getId();
	}

    public function average() {
        return $this->db->average();
    }

    public function order() {
        return $this->db->order();
    }

   public function oddeven() {
        return $this->db->oddeven();
    } 

   public function messageLength() {
    return $this->db->messageLength();
   }

   public function citizens() {
        return $this->db->citizens();
   }

   public function passport($id) {
    return $this->db->passport($id);
   }

   public function inactiveUsers() {
    return $this->db->inactiveUsers();
   }

   public function getAlldata($table) {
    return $this->db->getAlldata($table);
   }

   public function getNameByLetter($letter) {
    return $this->db->getNameByLetter($letter);
   }
}
