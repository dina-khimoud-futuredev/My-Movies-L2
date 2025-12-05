<?php
namespace mdb ;

use \pdo_wrapper\PdoWrapper ;

include __DIR__ . "../../../DB_CREDENTIALS.php" ;

class MoviesDB extends PdoWrapper
{


    public function __construct(){
        // appel au constructeur de la classe mère
        parent::__construct(
            $GLOBALS['db_name'],
            $GLOBALS['db_host'],
            $GLOBALS['db_port'],
            $GLOBALS['db_user'],
            $GLOBALS['db_pwd']) ;
    }


    //login and signup
    public function signup($username, $password){
        $query = 'INSERT INTO users(username, password) VALUES (:username, :password)' ;
        $params = [
            'username' => $username,
            'password' => $password
        ] ;
        return $this->exec($query, $params) ;
    }
    public function checkUser($username){
        $query = 'SELECT * FROM users WHERE username = :username';
        $params = ['username' => $username];
    
        $result = $this->exec($query, $params);
        
        if (!empty($result)) {
            return $result[0]; 
        }
        return null;
    }
   

}