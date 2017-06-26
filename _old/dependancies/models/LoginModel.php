<?php
class LoginModel{
    
    protected $db;
    
    public function __construct(PDO $db){
        $this->db = $db;
    }
	
    /**
	*	Authenticate user against database
	*/
    public function verifyCredentials($username, $password){
        //convert submitted password to sha1 format
        $sha = sha1($password);
        
        //prepare sql statement using supplied login and converted password
        $stmt = $this->db->prepare("
		SELECT user_id, user_login, user_password 
		FROM users 
		WHERE user_login = '$username' AND user_password='$sha' LIMIT 1
		
		");
        
        //Execute statement
        $stmt->execute();
        
        
        //if exactly one row is returned, return true and allow login
        if($stmt->rowCount() === 1){
            
           $_SESSION['user_id'] = $stmt->fetchColumn(0);
            return true;
        }
        
        //If any other result is returned, reject login attempt
        return true;
    }
}
	
	?>