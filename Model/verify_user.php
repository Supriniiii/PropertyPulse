<?php
    session_start();
  class UserAuthenticator {
    protected $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getUser($username){
        $sql = "SELECT * FROM users WHERE username = ?";
      $stmt = $this->pdo->prepare($sql);
      $stmt->bind_param('s', $username);
      $stmt->execute();
      $result = $stmt->get_result();
      $user = $result->fetch_assoc(); 

      return $user;
    }
    
    
    public function verifyCredentials($username, $password) {
      
        $user= $this->getUser($username);
  
      if ($user) {
          
        if(password_verify($password, $user['password'])){
            unset($_SESSION["error_message"]);
            return 0;
        }

        return 1;
      } else {
          return -1;
      }
  
  }
  

    public function initUserSession($username) {
      
        $user= $this->getUser($username);
        
        $_SESSION['user_id'] = $user['UserID'];
        $_SESSION['user_type'] = $user['userType'];
        $_SESSION['user_username'] = $user['username'];
        $_SESSION['application_update']="";
        unset($_SESSION['show']);
       	unset($_SESSION['Approved']);

        switch ($user['userType']) {
            case 'tenant':
                header('Location: ../View/tenant_dashboard.php');
                break;
            case 'service_worker':
                header('Location: ../View/serviceprovider_dashboard.php');
                break;
            case 'property_owner':
                header('Location: ../View/propertyowner_dashboard.php');
                break;
        }
        exit;
    }

   
    public function availUsername($username){
        $sql ="SELECT * FROM users WHERE username = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bind_param('s', $username);
        $num_rows=$stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc(); 

        if($user == null ){
            return true;
        }else {return false;}
    }
}
?>