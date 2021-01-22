<?php

class DB {
    function __construct() {
        $host = "127.0.0.1:3306";
        $user = "root";
        $pass = "root";
        $name = "pi21";
        try {
            $this->conn = new PDO("mysql:host=$host;dbname=$name", $user, $pass);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            die();
        }
    }

    function __destruct() {
        $this->conn = null;
    }

    public function getUserByLogin($login) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE login='$login'");
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getUserByLoginPass($login, $password) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE login='$login' AND password='$password'");
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getUserByToken($token) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE token='$token'");
        $stmt->execute();
        return $stmt->fetch();
    }

    public function updateToken($id, $token) {
        $stmt = $this->conn->prepare("UPDATE users SET token='$token' WHERE id=$id");
        $stmt->execute();
        return true;
    }

    public function addNewUser($name, $login, $password) {
        print_r($name);
        $stmt = $this->conn->prepare("INSERT INTO users (`name`, `login`, `password`) VALUES ('$name', '$login', '$password')");
        $stmt->execute();
        return true;
    }
	
	public function addMessage($name, $message) {
		$stmt = $this->conn->prepare("INSERT INTO chat (name, message) VALUES ('$name', '$message')");
        $stmt->execute();		
	}
	
	public function updateChatHash() {
		$hash = md5(rand());
        $stmt = $this->conn->prepare("UPDATE game SET chat_hash='$hash'");
        $stmt->execute();		
	}
	
	public function getChatHash() {
		$stmt = $this->conn->prepare("SELECT * FROM game");
        $stmt->execute();
        return $stmt->fetch();		
	}
	
	public function getAllMessages() {
		$stmt = $this->conn->prepare("SELECT * FROM chat");
        $stmt->execute();
        return $stmt->fetchAll();		
    }
    
    public function getId() {
		$stmt = $this->conn->prepare("SELECT id FROM users WHERE id=1");
        $stmt->execute();
        return $stmt->fetchAll();		
	}

    public function average() {
        $stmt = $this->conn->prepare("SELECT `name` FROM  `users`");
        $stmt->execute();
        $arrayUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $countUsers = count($arrayUsers);
        $totalCountSymbols = 0;
        for ($i = 0; $i < $countUsers; $i++) {
            $totalCountSymbols += strlen($arrayUsers[$i]['name']);
        }
        return round($totalCountSymbols / $countUsers);
    }


    public function order() {
        $stmt = $this->conn->prepare("SELECT * FROM `chat` ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function oddeven() {
        $stmt = $this->conn->prepare("SELECT * FROM `chat` WHERE MOD(id,2) = 0 ORDER BY id ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function messageLength() {
        $stmt = $this->conn->prepare("SELECT `message` FROM `chat`");
        $stmt->execute();
        $arrayMessage = $stmt->fetchAll(PDO::FETCH_ASSOC);
        print_r($arrayMessage);
        $countMessage = count($arrayMessage);
        $maxMessageSymbols = 0;
        for ($i = 0; $i < $countMessage; $i++) {
            if ($maxMessageSymbols  < strlen($arrayMessage[$i]['message'])) {
                $maxMessageSymbols =  strlen($arrayMessage[$i]['message']);
            }
        }
        return $maxMessageSymbols;

    }

   public function citizens()  {
    $stmt = $this->conn->prepare("SELECT `login` FROM `users`");
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $amoutUsers = count($users);
    $stmt = $this->conn->prepare("SELECT `name` FROM `citizen`");
    $stmt->execute();
    $citizens = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $amounCitizens = count($citizens);
    $total = $amounCitizens + $amoutUsers;
    return $total;
   }

   public function passport($id) {
    $stmt = $this->conn->prepare("SELECT * FROM `passport` WHERE `id` = $id");
    $stmt->execute();
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    print_r($data);
    $res = abs($data['serie'] - $data['number']);
    return $res;
   }

   public function inactiveUsers() {
    $stmt = $this->conn->prepare("SELECT `token` FROM `users`");
    $stmt->execute();
    $usersData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $countArray = count($usersData);
    $count = 0;
    for($i = 0; $i < $countArray; $i++) {
        if ($usersData[$i]['token'] == NULL) {
            $count += 1;
        }
    }
    print_r($usersData);
    return $count;
   }

   public function getAlldata($table) {
    $stmt = $this->conn->prepare("SELECT * FROM `$table`");
    $stmt->execute();
    $elems = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return count($elems);
   }

   public function getNameByLetter($letter) {
    $stmt = $this->conn->prepare("SELECT login FROM users");
    $stmt->execute();
    $usersArr = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $firstLetter = 'a';
    $arrNames = [];
    print_r($usersArr);
    for($i = 0; $i < count($usersArr); $i++){
        $firstLetter = $usersArr[$i]['login'];
        if($letter == $firstLetter[0]) {
            array_push($arrNames, $firstLetter);
        }
    }
    return $arrNames;
   }
} 