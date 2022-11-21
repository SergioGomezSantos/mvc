<?php

namespace App\Controllers;

require "../app/models/AgendaModel.php";
use App\Models\AgendaModel;

class AgendaController {

    // Definir constantes a utlizar. Los 2 tipos de contacto y todos los errores.
    const TYPES_ARRAY = array('persona', 'empresa');
    const ERROR_FORM_INFO = "Tipo, nombre, dirección y teléfono son campos necesarios";
    const ERROR_PERSONA_INFO = "Persona no puede tener email";
    const ERROR_PERSONA_SURNAMES = "Persona no puede tener apellidos vacío";
    const ERROR_EMPRESA_INFO = "Empresa no puede tener apellidos";
    const ERROR_EMPRESA_EMAIL = "Empresa no puede tener email vacío";
    const ERROR_LIST_INFO = "Elige un contacto de la lista";


    // Definir nombre y agendaModel porque se usa éste último en todas las funciones. Privados para que no se pueda acceder desde fuera.
    private $name;
    private $agendaModel;

    // Inicializo ambas variables.
    function __construct()
    {
        $this->name = "Agenda";
        $this->agendaModel = new AgendaModel();
    }

    // Compruebo si existe la tabla desde el modelo y llamo a la vista. Dentro de la vista se utilizará $exist para mostrar un texto-botón u otro.
    public function index()
    {
        $exist = $this->agendaModel->checkBBDD();
        require "../app/views/home.php";
    }

    // Llamo al modelo para inicializar la tabla en Base de Datos. Después, redirección al index. (Se mira si la tabla existe dentro del modelo).
    public function initialize() {

        $this->agendaModel->initializeBBDD();
        header('Location: /');
        die();
    }

    // Llamo al modelo para resetear los datos la tabla en Base de Datos. Después, redirección al index. (Se mira si la tabla existe dentro del modelo).
    public function reset() {

        $this->agendaModel->resetBBDD();
        header('Location: /');
        die();
    }

    // Compruebo si existe la tabla desde el modelo. Si existe, llamo a la vista. 
    //                                               Si no existe, redirección a index.
    public function insert()
    {
        $exist = $this->agendaModel->checkBBDD();

        if ($exist) {
            
            require "../app/views/insert.php";

        } else {

            header('Location: /');
            die();
        }
    }

    // Compruebo si llega por POST. Si llega por POST, recojo todos los parámetros del formulario y si son válidos, inserto el contacto desde el modelo.
    // Tanto si llega o no por POST, redirección a /agenda/insert para ver el resultado.
    public function checkInsert()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST" && (isset($_POST['send']) && !empty($_POST['send']))) {

            $params = $this->getAllParamsAndCheck();

            if ($params["valid"]) {

                $this->agendaModel->checkInsertBBDD($params["type"], $params["name"], $params["surnames"], $params["address"], $params["phone"], $params["email"]);
            }
        }

        header("Location: /agenda/insert");
        die();
    }

    // Función privada para recoger todos los parámetros del formulario y validarlos
    private function getAllParamsAndCheck()
    {

        // Para cada campo, si viene de POST estando setteado y lleno, lo recojo y lo almaceno en la sesión para poder volver a rellenar el formulario.

        // En el tipo, también compruebo que sea uno de los escritos en la constante TYPES_ARRAY
        if (isset($_POST['type']) && !empty($_POST['type']) && in_array($_POST['type'], $this::TYPES_ARRAY)) {
            $type = htmlspecialchars($_POST['type']);
            $_SESSION['prevForm']['prevType'] = $type;
        }

        if (isset($_POST['name']) && !empty($_POST['name'])) {
            $name = htmlspecialchars($_POST['name']);
            $_SESSION['prevForm']['prevName'] = $name;
        }

        if (isset($_POST['surnames']) && !empty($_POST['surnames'])) {
            $surnames = htmlspecialchars($_POST['surnames']);
            $_SESSION['prevForm']['prevSurnames'] = $surnames;
        }

        if (isset($_POST['address']) && !empty($_POST['address'])) {
            $address = htmlspecialchars($_POST['address']);
            $_SESSION['prevForm']['prevAddress'] = $address;
        }

        if (isset($_POST['phone']) && !empty($_POST['phone'])) {
            $phone = htmlspecialchars($_POST['phone']);
            $_SESSION['prevForm']['prevPhone'] = $phone;
        }

        if (isset($_POST['email']) && !empty($_POST['email'])) {
            $email = htmlspecialchars($_POST['email']);
            $_SESSION['prevForm']['prevEmail'] = $email;
        }

        if (isset($_POST['id']) && !empty($_POST['id'])) {
            $id = htmlspecialchars($_POST['id']);
            $_SESSION['prevForm']['id'] = $id;
        }


        // Declaro valid como true.
        $valid = true;

        // Si los campos que no pueden ser nulos están llenos, voy comprobando las demás restricciones para ajustar el error y la validación.
        // .= y . " " para verlo mejor si necesita 2 errores

        if ($type && $name && $address && $phone) {

            // Persona
            if ($type === $this::TYPES_ARRAY[0]) {

                // Con Email
                if ($email) {

                    $_SESSION['error'] .= $this::ERROR_PERSONA_INFO . " ";
                    $valid = false;
                }

                // Sin Apellidos
                if (!$surnames) {

                    $_SESSION['error'] .= $this::ERROR_PERSONA_SURNAMES;
                    $valid = false;
                }
            }

            // Empresa
            if ($type === $this::TYPES_ARRAY[1]) {

                // Con Apellidos
                if ($surnames) {

                    $_SESSION['error'] .= $this::ERROR_EMPRESA_INFO  . " ";
                    $valid = false;
                }

                // Sin Email
                if (!$email) {

                    $_SESSION['error'] .= $this::ERROR_EMPRESA_EMAIL;
                    $valid = false;
                }
            }

        } else {

            // Si los campos que no pueden ser nulos están vacíos, ajusto el error y la validación.

            $valid = false;
            $_SESSION['error'] = $this::ERROR_FORM_INFO;
        }

        // Devuelvo todos los parámetros y la validación.

        return [
            "valid" => $valid, 
            "type" => $type, 
            "name" => $name, 
            "surnames" => $surnames, 
            "address" => $address, 
            "phone" => $phone, 
            "email" => $email,
            "id" => $id
        ];
    }

    // Compruebo si existe la tabla desde el modelo. Si existe, busco la lista de contactos (id, nombre) desde el modelo y llamo a la vista. 
    //                                               Si no existe, redirección a index.
    public function delete()
    {
        $exist = $this->agendaModel->checkBBDD();

        if ($exist) {

            $contacts = $this->agendaModel->getContactsList();
            require "../app/views/delete.php";

        } else {

            header('Location: /');
            die();
        }
    }

    // Compruebo si llega por POST. Si llega por POST, compruebo si tiene removeContatc (id). Si lo tiene, lo recojo y lo elimino desde el modelo.
    //                                                                                        Si no lo tiene, ajusto el error.
    // Tanto si llega o no por POST, redirección a /agenda/delete para ver el resultado.
    public function checkDelete()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST" && (isset($_POST['deleteSend']) && !empty($_POST['deleteSend']))) {

            if (isset($_POST['removeContatc']) && !empty($_POST['removeContatc'])) {

                $removeContact = htmlspecialchars($_POST['removeContatc']);
                $this->agendaModel->deleteBBDD($removeContact);

            } else {
                
                $_SESSION['error'] = $this::ERROR_LIST_INFO;
            }
        }

        header('Location: /agenda/delete');
        die();
    }

    // Compruebo si existe la tabla desde el modelo. Si existe, compruebo si va a buscar un contacto en específico o no.                  
    //                                               Si no existe, redirección a index.
    public function search()
    {
        $exist = $this->agendaModel->checkBBDD();

        if ($exist) {

            // Si busca un contacto, recojo la id y busco el contacto desde el modelo. Declaro 2 variables para usar en la vista y la llamo.
            // Si no busca un contacto en concreto, busco la lista de contactos (id, nombre) desde el modelo y llamo a la vista.

            if (isset($_GET['contact']) && !empty($_GET['contact'])) {
                
                $contactId = htmlspecialchars($_GET['contact']);
                $this->agendaModel->searchBBDD($contactId);
                $readonly = "readonly";
                $goBack = "search";
                require "../app/views/seeContact.php";

            } else {

                $contacts = $this->agendaModel->getContactsList();
                require "../app/views/search.php";
            }

        } else {

            header('Location: /');
            die();
        }
    }

    // Compruebo si existe la tabla desde el modelo. Si existe, compruebo si va a actualizar un contacto en específico o no.                  
    //                                               Si no existe, redirección a index.
    public function update()
    {

        $exist = $this->agendaModel->checkBBDD();

        if ($exist) {


            // Si va a actualizar un contacto, recojo la id y busco el contacto desde el modelo. Declaro una variable para usar en la vista y la llamo.
            // Si no va a actualizar un contacto, busco la lista de contactos (id, nombre) desde el modelo y llamo a la vista.

            if (isset($_GET['contact']) && !empty($_GET['contact'])) {
                
                $contact = htmlspecialchars($_GET['contact']);
                $this->agendaModel->searchBBDD($contact, true);
                $goBack = "update";
                require "../app/views/updateSelected.php";

            } else {

                $contacts = $this->agendaModel->getContactsList();
                require "../app/views/update.php";
            }
            

        } else {

            header('Location: /');
            die();
        }
    }

    // Compruebo si llega por POST. Si llega por POST, recojo todos los parámetros del formulario y si es válido, lo actualizo desde el modelo
    // Si se actualiza, redirección a /agenda/update para ver el resultado
    // Si no llega por POST y no se ha actualizo (redirección si actualiza), redirección a /agenda/update?contacto para ver el resultado pudiendo reintentar.
    public function updateSelected()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST" && (isset($_POST['updateSend']) && !empty($_POST['updateSend']))) {

            $params = $this->getAllParamsAndCheck();
            
            if ($params["valid"]) {

                $updated = $this->agendaModel->updateBBDD($params["type"], $params["name"], $params["surnames"], $params["address"], 
                                                $params["phone"], $params["email"], $params["id"]);

                if ($updated) {

                    header('Location: /agenda/update');
                    die();

                }
            }

            header('Location: /agenda/update?contact=' . $params["id"]);
            die();
        }

        header('Location: /agenda/update');
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
     * Setter para name
     * Set the value of name
     */
    public function setName($name): self
    {
        $this->name = $name;

        return $this;
    }
}