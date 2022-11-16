<header>

    <h1>
        <?php

        echo $this->getName();

        if (isset($_SESSION['userName'])) {

            echo " | " . $_SESSION['userName'];
        }
        ?>
    </h1>

    <hr>

    <nav>
        <ul>

            <?php

            if (isset($_SESSION['userName'])) {

                $arguments = explode('/', trim($_GET['url'], '/'));

                if ($arguments[1]) {
                    echo '<li><a href="/agenda">Inicio</a></li>';
                } else {
                    echo '<li>Inicio</li>';
                }

                if ($arguments[1] !== 'insert') {
                    echo '<li><a href="/agenda/insert">Insert</a></li>';
                } else {
                    echo '<li>Insert</li>';
                }

                if ($arguments[1] !== 'delete') {
                    echo '<li><a href="/agenda/delete">Delete</a></li>';
                } else {
                    echo '<li>Delete</li>';
                }

                if ($arguments[1] !== 'search') {
                    echo '<li><a href="/agenda/search">Search</a></li>';
                } else {
                    echo '<li>Search</li>';
                }

                if ($arguments[1] !== 'update') {
                    echo '<li><a href="/agenda/update">Update</a></li>';
                } else {
                    echo '<li>Update</li>';
                }

                // Añado el enlace para salir
                echo '<li><a href="/login/logout">Salir</a></li>';
            }

            ?>
        </ul>
    </nav>
</header>