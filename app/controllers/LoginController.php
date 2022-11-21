<?php

namespace App\Controllers;

require "../app/models/LoginModel.php";
use App\Models\LoginModel;

session_start();

class LoginController
{
    // Definir constante a utlizar
    const FORM_ERROR = "Ambos campos son necesarios";

    // Definir nombre y loginModel porque se usa éste último en todas las funciones. Privados para que no se pueda acceder desde fuera.
    private $name;
    private $loginModel;

    // Inicializo ambas variables.
    function __construct()
    {
        $this->name = "Login";
        $this->loginModel = new LoginModel();
    }

    // Compruebo si existe la tabla desde el modelo y llamo a la vista. Dentro de la vista se utilizará $exist para mostrar un texto-botón u otro.
    public function index()
    {
        $exist = $this->loginModel->checkBBDD();
        require "../app/views/login.php";
    }

    // Llamo al modelo para inicializar la tabla en Base de Datos. Después, redirección al index. (Se mira si la tabla existe dentro del modelo).
    // En este initialize se usa el .sql, por lo que se crea la tabla y se insertan las filas conjuntamente
    public function initialize() 
    {

        $this->loginModel->initializeBBDD();
        header('Location: /');
        die();
    }

    // Compruebo si llega por POST. Si llega por POST, recojo el nombre y la contraseña. Si ambas variables están llenas, compruebo los credenciales desde el modelo.
    // Tanto si llega o no por POST, redirección a / para ver el resultado. Si el login es correcto, / accederá a al agenda. Si no es correcto, volverá al login.
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

                $this->loginModel->checkLogin($userName, $password);

            } else {
                
                $_SESSION['error'] = $this::FORM_ERROR;
            }
        }

        header("Location: /");
        die();
    }

    // Función para borrar el contenido de la sesión y redirigir a /, que será el login.
    public function logout()
    {

        $_SESSION = array();
        session_destroy();
        setCookie(session_name(), '', time() - 60, '/');
        header("Location: /");
        die();
    }

    /**
     * Getter para Name
     * Get the value of name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Setter para Name
     * Set the value of name
     */
    public function setName($name): self
    {
        $this->name = $name;

        return $this;
    }
}
