<?php
require_once('./dao/abstractDAO.php');


class WebsiteUser extends abstractDAO {

    private $username;
    private $password;
    private $authenticated = false;

    function __construct() {
        try{
            parent::__construct();
        } catch(mysqli_sql_exception $e){
            throw $e;
        }
    }

    public function authenticate($username, $password){
        $loginQuery = "SELECT * FROM adminusers WHERE Username = ? AND Password = ?";
        $stmt = $this->mysqli->prepare($loginQuery);
        $stmt->bind_param('ss', $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows == 1){
            $this->username = $username;
            $this->password = $password;
            $this->authenticated = true;
            $this->getUserData($username);
        }
        $stmt->free_result();
    }

    public function getUserData($username){
        $result = $this->mysqli->query("SELECT AdminID, lastlogin from adminUsers WHERE username='$username'");
        $user_data = mysqli_fetch_array($result);
        $count_row = $result->num_rows;
        if ($count_row == 1) {
            mysqli_query("UPDATE adminUsers set lastlogin = CURRENT_DATE WHERE username='$username'");

            $_SESSION['AdminID'] = $user_data['AdminID'];
            $_SESSION['lastlogin'] = $user_data['lastlogin'];

        }

    }

    public function isAuthenticated(){
        return $this->authenticated;
    }



}
?>
