<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <h1>LOGIN</h1>

    <form action="login_SOLUCION.php" method="GET">
        <div>
            <label for="username">Usuario</label>
            <input type="text" id="username" name="username" placeholder="Usuario" required>
        </div>

        <div>
            <label for="password">Contraseña</label>
            <input type="text" id="password" name="password" placeholder="Contraseña" required>
        </div>

        <button type="submit">Entrar</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $manager = new MongoDB\Driver\Manager("mongodb://app:app_password@mongo:27017/appdb");

        $username = $_GET['username'];
        $password = $_GET['password'];

        // SOLUCION A LA VULNERABILIDAD NOSQL INYECTION
        $lista_bloqueos = ['{', '}', '[', ']', '$'];

        foreach ($lista_bloqueos as $char) {
            if (strpos($username, $char) !== false || strpos($password, $char) !== false) {
                echo '<div>Usuario o contraseña incorrectos.</div>';
                die();
            }
        }

        // VULNERABILIDAD NOSQL INYECTION
        // ESCRIBIENDO {"$ne": null} en el campo de contraseña se accede a cualquier usuario


        // Forzar que se pueda hacer una inyección NoSQL
        $decoded = json_decode($password, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            $password = $decoded;
        }

        // Filtro utulizado para MongoDB
        $filter = [
            'username' => $username,
            'password' => $password
        ];

        $query = new MongoDB\Driver\Query($filter);
        $cursor = $manager->executeQuery('appdb.users', $query);
        $result = $cursor->toArray();

        if (!empty($result)) {
            $user = $result[0];
            ?>
            <div>
                <H1>BIENVENIDO</H1>
                <p>Usuario: <?php echo $user->username; ?></p>
                <button onclick="window.location.href='login_SOLUCION.php'">Salir</button>
            </div>
    <?php
        } else {
            echo 'Usuario o contraseña incorrectos.';
        }
    }
    ?>
</body>

</html>