<?php

namespace App\Controllers;

require "../app/models/AgendaModel.php";
use App\Models\AgendaModel;

class AgendaController {

    const ERROR_INSERT_INFO = "Tipo, nombre, dirección y teléfono son campos necesarios";
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
        $exist ? require "../app/views/insert.php" : header('Location: /');
    }

    public function checkInsert()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST" && (isset($_POST['send']) && !empty($_POST['send']))) {

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

                if ($valid) {

                    $agendaModel = new AgendaModel();
                    $agendaModel->checkInsertBBDD($type, $name, $surnames, $address, $phone, $email);
                }


            } else {

                $_SESSION['error'] = $this::ERROR_INSERT_INFO;
            }
        }

        header("Location: /agenda/insert");
        die();
    }

    public function delete()
    {
        $exist = $this->agendaModel->checkBBDD();
        $contactsName = $this->agendaModel->getContactsNamesList();
        $exist ? require "../app/views/delete.php" : header('Location: /');
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
        $exist ? require "../app/views/search.php" : header('Location: /');
    }

    public function update()
    {

        $exist = $this->agendaModel->checkBBDD();

        if ($exist) {

            if (isset($_GET['contact']) && !empty($_GET['contact'])) {
                
                // $contactInfo = $this->agendaModelSearch();
                require "../app/views/updateSelected";

            } else {

                $contactsName = $this->agendaModel->getContactsNamesList();
                require "../app/views/update.php";
            }
            

        } else {

            header('Location: /');
            die();
        }
    }

    public function checkUpdateSelected()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST" && (isset($_POST['updateSend']) && !empty($_POST['updateSend']))) {

            if (isset($_POST['updateContatc']) && !empty($_POST['updateContatc'])) {

                $updateContatc = htmlspecialchars($_POST['updateContatc']);
                // $this->agendaModel->updateBBDD($updateContatc);
                header('Location: /agenda/update?contact=' . $updateContatc);
                die();

            } else {
                
                $_SESSION['error'] = $this::ERROR_LIST_INFO;
            }
        }

        header('Location: /agenda/delete');
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