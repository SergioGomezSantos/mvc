<?php
session_start();

class LoginController
{
    const FORM_ERROR = "Ambos campos son necesarios";
    private $name;

    function __construct()
    {
        $this->name = "Login";
    }

    public function index()
    {
        require "../app/views/login.php";
    }

    public function check()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST" && (isset($_POST['send']) && !empty($_POST['send']))) {

            if (isset($_POST['userName']) && !empty($_POST['userName'])) {
                $userName = htmlspecialchars($_POST['userName']);
            }

            if (isset($_POST['password']) && !empty($_POST['password'])) {
                $password = htmlspecialchars($_POST['password']);
            }

            if ($userName && $password) {

                require "../app/models/LoginModel.php";
                $loginModel = new LoginModel();
                $loginModel->checkBBDD($userName, $password);

            } else {
                
                $_SESSION['error'] = $this::FORM_ERROR;
            }
        }

        header("Location: /");
        die();
    }

    public function logout()
    {

        $_SESSION = array();
        session_destroy();
        setCookie(session_name(), '', time() - 60, '/');
        header("Location: /");
        die();
    }

    /**
     * Get the value of name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     */
    public function setName($name): self
    {
        $this->name = $name;

        return $this;
    }
}
