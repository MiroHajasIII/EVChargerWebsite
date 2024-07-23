<?php

require_once ('Models/Database.php');
require_once ('Models/UserData.php');
class UsersDataSet
{
    protected $_dbHandle, $_dbInstance;

    public function __construct()
    {
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getdbConnection();
    }

    /**
     * @return array returns the results of all users within the database
     */
    public function fetchAllUsers()
    {
        $sqlQuery = 'SELECT * FROM users';
        //echo $sqlQuery;       //commented out, only used for testing
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();

        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new UserData($row);
        }
        return $dataSet;
    }

    /**
     * login the user based on their input on the login form
     */
    public function login()
    {
        //clear search query of exploits before use
        $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
        $password = strip_tags($_POST['password']);
        $loginQuery = "SELECT * FROM users WHERE username='$username'";

        $statement = $this->_dbHandle->prepare($loginQuery);
        $statement->execute();
        $row = $statement->rowCount();

        if ($row > 0) {
            //local variable and new query initialisation
            $hashedPassword = $statement->fetchColumn(3);
            if (password_verify($password, $hashedPassword)) {
                $_SESSION['username'] = true;
                header("location:homepage.php");
            } else {
                //disband login due to wrong password
                echo '<br><br><div class="mx-auto alert alert-danger alert-dismissible fade show" role="alert">
                ACCESS DENIED: Invalid Email or Password - Please Try Again
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                $_SESSION['username'] = false;
                session_unset();
            }
        }
    }

    /**
     * Register a user with the website if they are not already a member
     *
     * @param String $usernameInput username passed from the users register form
     * @param String $fullnameInput fullname passed from the users register form
     * @param String $password password which will be hashed from the register form
     * @param String $photo photo link to the users preferred photo
     * @param int $phoneNumberInput phoneNumber of the user obtained from register form
     */
    public function register($usernameInput, $fullnameInput, $password, $photo, $phoneNumberInput)
    {
        //clear search query of exploits before use
        $username = filter_var($usernameInput, FILTER_SANITIZE_STRING);
        $fullname = filter_var($fullnameInput, FILTER_SANITIZE_STRING);
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $phoneNumber = filter_var($phoneNumberInput, FILTER_SANITIZE_NUMBER_INT);

        $checkQuery = "SELECT * FROM users WHERE username = '$username'";

        //prepare statements for checking existing user entry
        $checkStatement = $this->_dbHandle->prepare($checkQuery);
        $checkStatement->execute();
        $row = $checkStatement->rowCount();

        if ($row == 0) {
            //create a new user entry in the database with the following statements
            $insertQuery = "INSERT INTO users (username, fullname, password, photo, phoneNumber) VALUES ('$username', '$fullname', '$hashedPassword', '$photo', '$phoneNumber')";
            $statement = $this->_dbHandle->prepare($insertQuery);
            $statement->execute();
            header("location:index.php");
        } else {
            //report username already existing
            echo "<br><br><br><br>Error";
            echo "<br><br>'$username' already exists!";
        }
    }
}