<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>

<body>
    <div class="login-container">
        <h1>LOGIN</h1>

        <form action="login.php" method="GET">
            <div class="form-group">
                <label for="username">Usuario</label>
                <input type="text" id="username" name="username" placeholder="Usuario" required>
            </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="text" id="password" name="password" placeholder="Contraseña" required>
            </div>

            <button type="submit">Entrar</button>
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            try {
                $manager = new MongoDB\Driver\Manager("mongodb://app:app_password@mongo:27017/appdb");

                $username = $_GET['username'] ?? '';
                $password = $_GET['password'] ?? '';

                // VULNERABILIDAD NOSQL INYECTION
                // ESCRIBIENDO {"$ne": null} en el campo de contraseña se accede a cualquier usuario
                $decoded = json_decode($password, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    $password = $decoded;
                }

                // Filtro directo
                $filter = [
                    'username' => $username,
                    'password' => $password
                ];

                // Debug: Mostrar el filtro para ver la inyección
                echo "<br>Filter: " . json_encode($filter) . "<br>";

                $query = new MongoDB\Driver\Query($filter);
                $cursor = $manager->executeQuery('appdb.users', $query);
                $result = $cursor->toArray();

                if (!empty($result)) {
                    $user = $result[0];
                    ?>
                    <div>
                        <H1>BIENVENIDO</H1>
                        <p><b>Usuario:</b> <?php echo $user->username; ?></p>
                        <button onclick="window.location.href='login.php'">Salir</button>
                    </div>
                    <?php
                } else {
                    echo '<div class="error-message">Usuario o contraseña incorrectos.</div>';
                }
            } catch (Throwable $e) {
                echo "Connection Error: " . $e->getMessage();
            }
        }
        ?>
    </div>
</body>

</html>