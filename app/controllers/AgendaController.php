<?php

class AgendaController {

    const ERROR_INFO = "Todos los campos son necesarios";
    const TYPES_ARRAY = array('persona', 'empresa');
    private $name;

    function __construct()
    {
        $this->name = "Agenda";
    }

    public function index()
    {
        require "../app/views/home.php";
    }

    public function insert()
    {
        require "../app/views/insert.php";
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

                require "../app/models/AgendaModel.php";
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
        require "../app/views/delete.php";
    }

    public function search()
    {
        require "../app/views/search.php";
    }

    public function update()
    {
        require "../app/views/update.php";
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