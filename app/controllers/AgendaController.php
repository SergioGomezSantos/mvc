<?php

namespace App\Controllers;

require "../app/models/AgendaModel.php";
use App\Models\AgendaModel;

class AgendaController {

    const ERROR_FORM_INFO = "Tipo, nombre, dirección y teléfono son campos necesarios";
    const ERROR_PERSONA_INFO = "Persona no puede tener email";
    const ERROR_EMPRESA_INFO = "Empresa no puede tener apellidos";
    const ERROR_LIST_INFO = "Elige un contacto de la lista";
    const TYPES_ARRAY = array('persona', 'empresa');

    private $name;
    private $agendaModel;

    function __construct()
    {
        $this->name = "Agenda";
        $this->agendaModel = new AgendaModel();
    }

    public function index()
    {
        $exist = $this->agendaModel->checkBBDD();
        require "../app/views/home.php";
    }

    public function initialize() {

        $this->agendaModel->initializeBBDD();
        header('Location: /');
        die();
    }

    public function reset() {

        $this->agendaModel->resetBBDD();
        header('Location: /');
        die();
    }

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

    private function getAllParamsAndCheck()
    {
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

        if (isset($_POST['prevName']) && !empty($_POST['prevName'])) {
            $prevName = htmlspecialchars($_POST['prevName']);
            $_SESSION['prevForm']['prevName'] = $email;
        }

        if ($type && $name && $address && $phone) {

            $valid = true;

            if ($type === $this::TYPES_ARRAY[0] && $email) {

                $_SESSION['error'] = $this::ERROR_PERSONA_INFO;
                $valid = false;
            }

            if ($type === $this::TYPES_ARRAY[1] && $surnames) {

                $_SESSION['error'] = $this::ERROR_EMPRESA_INFO;
                $valid = false;
            }

        } else {

            $_SESSION['error'] = $this::ERROR_FORM_INFO;
        }

        return [
            "valid" => $valid, 
            "type" => $type, 
            "name" => $name, 
            "surnames" => $surnames, 
            "address" => $address, 
            "phone" => $phone, 
            "email" => $email,
            "prevName" => $prevName
        ];
    }

    public function delete()
    {
        $exist = $this->agendaModel->checkBBDD();

        if ($exist) {

            $contactsName = $this->agendaModel->getContactsNamesList();
            require "../app/views/delete.php";

        } else {

            header('Location: /');
            die();
        }
    }

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

    public function search()
    {
        $exist = $this->agendaModel->checkBBDD();

        if ($exist) {

            if (isset($_GET['contact']) && !empty($_GET['contact'])) {
                
                $contactName = htmlspecialchars($_GET['contact']);
                $this->agendaModel->searchBBDD($contactName);
                $readonly = "readonly";
                require "../app/views/seeContact.php";

            } else {

                $contactsName = $this->agendaModel->getContactsNamesList();
                require "../app/views/search.php";
            }

        } else {

            header('Location: /');
            die();
        }
    }

    public function update()
    {

        $exist = $this->agendaModel->checkBBDD();

        if ($exist) {

            if (isset($_GET['contact']) && !empty($_GET['contact'])) {
                
                $contactName = htmlspecialchars($_GET['contact']);
                $this->agendaModel->searchBBDD($contactName, true);
                require "../app/views/updateSelected.php";

            } else {

                $contactsName = $this->agendaModel->getContactsNamesList();
                require "../app/views/update.php";
            }
            

        } else {

            header('Location: /');
            die();
        }
    }

    public function checkUpdate()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST" && (isset($_POST['updateSend']) && !empty($_POST['updateSend']))) {

            if (isset($_POST['updateContatc']) && !empty($_POST['updateContatc'])) {

                $updateContatc = htmlspecialchars($_POST['updateContatc']);

                header('Location: /agenda/update?contact=' . $updateContatc);
                die();

            } else {
                
                $_SESSION['error'] = $this::ERROR_LIST_INFO;
            }
        }

        header('Location: /agenda/update');
        die();
    }

    public function updateSelected()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST" && (isset($_POST['updateSend']) && !empty($_POST['updateSend']))) {

            $params = $this->getAllParamsAndCheck();
            
            if ($params["valid"]) {

                $updated = $this->agendaModel->updateBBDD($params["type"], $params["name"], $params["surnames"], $params["address"], 
                                                $params["phone"], $params["email"], $params["prevName"]);

                if ($updated) {

                    header('Location: /agenda/update');
                    die();

                }
            }

            header('Location: /agenda/update?contact=' . $params["name"]);
            die();
        }

        header('Location: /agenda/update');
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

// TODO quitar checkUpdate por GET | Footer volver para search/x y update/X | restringir doble null en base de datos + unique en nombre