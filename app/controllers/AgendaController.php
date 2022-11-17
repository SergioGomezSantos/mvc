<?php

namespace App\Controllers;

require "../app/models/AgendaModel.php";
use App\Models\AgendaModel;

class AgendaController {

    const ERROR_INFO = "Todos los campos son necesarios";
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

            if ($type && $name && $surnames && $address && $phone) {

                $agendaModel = new AgendaModel();
                $agendaModel->checkInsertBBDD($type, $name, $surnames, $address, $phone);

            } else {

                $_SESSION['error'] = $this::ERROR_INFO;
            }
        }

        header("Location: /agenda/insert");
        die();
    }

    public function delete()
    {
        $exist = $this->agendaModel->checkBBDD();
        $exist ? require "../app/views/delete.php" : header('Location: /');
    }

    public function search()
    {
        $exist = $this->agendaModel->checkBBDD();
        $exist ? require "../app/views/search.php" : header('Location: /');
    }

    public function update()
    {
        $exist = $this->agendaModel->checkBBDD();
        $exist ? require "../app/views/update.php" : header('Location: /');
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