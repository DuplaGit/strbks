<?php

/**
 * Class login
 * handles the user's login and logout process
 */
class Login
{
    /**
     * @var object The database connection
     */
    private $db_connection = null;
    /**
     * @var array Collection of error messages
     */
    public $errors = array();
    /**
     * @var array Collection of success / neutral messages
     */
    public $messages = array();

    /**
     * the function "__construct()" automatically starts whenever an object of this class is created,
     * you know, when you do "$login = new Login();"
     */
    public function __construct()
    {
        // create/read session, absolutely necessary
        session_start();

        // check the possible login actions:
        // if user tried to log out (happen when user clicks logout button)
        if (isset($_GET["logout"])) {
            $this->doLogout();
        }
        // login via post data (if user just submitted a login form)
        elseif (isset($_GET["adminlogin"]) || isset($_GET['dashboard']) || isset($_GET['admin'])) {
            $this->doAdminLoginWithPostData();
        }
        elseif (isset($_POST["login"])) {
            $this->dologinWithPostData();
        }
    }
     /**
     * log in with post data
     */
    private function dologinWithPostData()
    {
        // check login form contents
        if (empty($_POST['user_name'])) {
            $this->errors[] = "Username field was empty.";
        } elseif (empty($_POST['user_password'])) {
            $this->errors[] = "Password field was empty.";
        // } elseif (empty($_POST['user_email'])) {
        //     $this->errors[] = "Email field was empty.";
        } elseif (!empty($_POST['user_name']) && !empty($_POST['user_password'])) {

            // create a database connection, using the constants from config/db.php (which we loaded in index.php)
            $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            // change character set to utf8 and check it
            if (!$this->db_connection->set_charset("utf8")) {
                $this->errors[] = $this->db_connection->error;
            }

            // if no connection errors (= working database connection)
            if (!$this->db_connection->connect_errno) {

                // escape the POST stuff
                $user_name = $this->db_connection->real_escape_string($_POST['user_name']);
                $user_password = $this->db_connection->real_escape_string($_POST['user_password']);
                // $user_email = $this->db_connection->real_escape_string($_POST['user_email']);

                // database query, getting all the info of the selected user (allows login via email address in the
                // username field)
                $sql = "SELECT *
                        FROM stores
                        WHERE 
                        code = '$user_password' 
                        AND 
                        email LIKE '%$user_name%'
                        ";
                $result_of_login_check = $this->db_connection->query($sql);

                // if this user exists
                if ($result_of_login_check->num_rows == 1) {
                       // if (strcasecmp($_POST['user_name'],$result_row->name) == 0){ 
                    // get result row (as an object)
                        $result_row = $result_of_login_check->fetch_object();
                       // write user data into PHP SESSION (a file on your server)

                        $_SESSION['user_id'] = $result_row->code;
                        $_SESSION['user_name'] = $result_row->name;
                       
                        
                        $_SESSION['user_login_status'] = 0;

                        // }
                } else {
                    $this->errors[] = "No existe esta tienda.$user_name.$user_password";
                }
            } else {
                $this->errors[] = "Database connection problem.";
            }
        }
    }
    /**
     * log in with post data
     */
    private function doEmployeeLoginWithPostData()
    {
        // check login form contents
        if (empty($_POST['user_name'])) {
            $this->errors[] = "Username field was empty.";
        } elseif (empty($_POST['user_password'])) {
            $this->errors[] = "Password field was empty.";
        // } elseif (empty($_POST['user_email'])) {
        //     $this->errors[] = "Email field was empty.";
        } elseif (!empty($_POST['user_name']) && !empty($_POST['user_password'])) {

            // create a database connection, using the constants from config/db.php (which we loaded in index.php)
            $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            // change character set to utf8 and check it
            if (!$this->db_connection->set_charset("utf8")) {
                $this->errors[] = $this->db_connection->error;
            }

            // if no connection errors (= working database connection)
            if (!$this->db_connection->connect_errno) {

                // escape the POST stuff
                $user_name = $this->db_connection->real_escape_string($_POST['user_name']);
                $user_password = $this->db_connection->real_escape_string($_POST['user_password']);
                // $user_email = $this->db_connection->real_escape_string($_POST['user_email']);

                // database query, getting all the info of the selected user (allows login via email address in the
                // username field)
                $sql = "SELECT *
                        FROM employees
                        WHERE email = '" . $user_name . "';";
                $result_of_login_check = $this->db_connection->query($sql);

                // if this user exists
                if ($result_of_login_check->num_rows == 1) {
                       // if (strcasecmp($_POST['user_name'],$result_row->name) == 0){ 
                    // get result row (as an object)
                         $result_row = $result_of_login_check->fetch_object();
                       // write user data into PHP SESSION (a file on your server)

                        $_SESSION['user_id'] = $result_row->code;
                        $_SESSION['user_name'] = $result_row->name;
                       
                        
                        $_SESSION['user_login_status'] = 0;

                        // }
                } else {
                    $this->errors[] = "No existe esta tienda.";
                }
            } else {
                $this->errors[] = "Database connection problem.";
            }
        }
    }
    /**
     * log in with post data
     */
    private function doAdminLoginWithPostData()
    {
        // check login form contents
        if (empty($_POST['user_name'])) {
            $this->errors[] = "Username field was empty.";
        } elseif (empty($_POST['user_password'])) {
            $this->errors[] = "Password field was empty.";
        // } elseif (empty($_POST['user_email'])) {
        //     $this->errors[] = "Email field was empty.";
        } elseif (!empty($_POST['user_name']) && !empty($_POST['user_password'])) {

            // create a database connection, using the constants from config/db.php (which we loaded in index.php)
            $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            // change character set to utf8 and check it
            if (!$this->db_connection->set_charset("utf8")) {
                $this->errors[] = $this->db_connection->error;
            }

            // if no connection errors (= working database connection)
            if (!$this->db_connection->connect_errno) {

                // escape the POST stuff
                $user_name = $this->db_connection->real_escape_string($_POST['user_name']);
                // $user_email = $this->db_connection->real_escape_string($_POST['user_email']);

                // database query, getting all the info of the selected user (allows login via email address in the
                // username field)
                $sql = "SELECT *
                        FROM users
                        WHERE user_name = '" . $user_name . "' OR id = '" . $user_name . "';";
                $result_of_login_check = $this->db_connection->query($sql);

                // if this user exists
                if ($result_of_login_check->num_rows == 1) {

                    // get result row (as an object)
                    $result_row = $result_of_login_check->fetch_object();

                    // using PHP 5.5's password_verify() function to check if the provided password fits
                    // the hash of that user's password
                    // print_r( password_get_info($result_row->user_password_hash) );
                    if (password_verify($_POST['user_password'], $result_row->user_password_hash)) {

                        // write user data into PHP SESSION (a file on your server)

                        $_SESSION['id'] = $result_row->id;
                        $_SESSION['user_id'] = $result_row->user_id;
                        $_SESSION['user_name'] = $result_row->user_name;
                        // $_SESSION['user_email'] = $result_row->user_email;
                        
                        $_SESSION['user_login_status'] = 1;
                        if(isset($_GET['dashboard'])) {
                            header("Location:dashboard");
                        }

                        if(isset($_GET['admin'])) {
                            header("Location:admin");
                        }

                    } else {
                        $this->errors[] = "Wrong password. Try again.";
                    }
                } else {
                    $this->errors[] = "This user does not exist.";
                }
            } else {
                $this->errors[] = "Database connection problem.";
            }
        }
    }

    /**
     * perform the logout
     */
    public function doLogout()
    {
        // delete the session of the user
        $_SESSION = array();
        session_destroy();
        // return a little feeedback message
        if(isset($_GET["dashboard"])) {
            header("Location:./?dashboard");

        } elseif(isset($_GET["dashboard"])) {
            header("Location:./?admin");

        }else {
            header("Location:./");
        }
        // $this->messages[] = "You have been logged out.";

    }

    /**
     * simply return the current state of the user's login
     * @return boolean user's login status
     */
    public function isUserLoggedIn()
    {
        if (isset($_SESSION['user_login_status'])) {
            return true;
        }
        // default return
        return false;
    }


    /**
     * simply return the current state of the user's login
     * @return boolean user's login status
     */
    public function userInfo()
    {
        if (isset($_SESSION['user_login_status'])) {
           // create a database connection, using the constants from config/db.php (which we loaded in index.php)
              $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            // change character set to utf8 and check it
            // if (!$this->db_connection->set_charset("utf8")) {
            //     $this->errors[] = $this->db_connection->error;
            // }
              $sql = "SELECT * FROM users WHERE id = '" . $_SESSION['id']."'";
                $user_info = $this->db_connection->query($sql)  or die('Query failed: ' . mysqli_error());;

                // if this user exists
                if ($user_info->num_rows == 1) {

                    // get result row (as an object)
                    return $result_row = $user_info->fetch_object();

                }
        }
        // default return
        return false;
    }
}
