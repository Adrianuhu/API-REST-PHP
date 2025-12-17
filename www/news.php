<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News</title>

</head>

<body>
    <div class="container">

        <form action="news.php" method="GET" class="search-form">
            <input name="id" placeholder="ID..." value="<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>" required
                min="1">
            <button type="submit">Buscar</button>
        </form>

        <?php
        $conexion = mysqli_connect("db", "user", "pass", "DB");
        mysqli_report(MYSQLI_REPORT_OFF);


        if (isset($_GET['id'])) {
            $id_raw = $_GET['id'] ?? '0';
            $id_safe = (int) $id_raw;

            // Consulta SQL vulnerable a inyección SQL (Blind SQL Injection)
            $sql = "SELECT Id, Title, Body, Datetime
                        FROM News
                        WHERE Id = $id_safe
                        AND (
                            SELECT 1
                            FROM News
                            WHERE Id = $id_raw
                        )
                        LIMIT 1
                        ";

            // Debug query
            echo "<br>" . $sql . "</br>";
            $resultado = mysqli_query($conexion, $sql);

            if ($resultado != null && mysqli_num_rows($resultado) > 0) {
                $news = mysqli_fetch_assoc($resultado);
            } else {
                $news = null;
            }

            if ($news) {
                ?>

                <div>
                    <H1>NOTICIAS</H1>
                    <p><b>ID:</b> <?php echo $news['Id']; ?></p>
                    <p><b>Título:</b> <?php echo $news['Title']; ?></p>
                    <p><b>Body:</b> <?php echo $news['Body']; ?></p>
                    <p><b>Datetime:</b> <?php echo $news['Datetime']; ?></p>
                </div>

                <?php
            } else {
                echo '<div class="error-message">News no encontrado con ID: ' . $id . '</div>';
            }
        } else {
            echo '<div>Introduce un ID para ver los datos de la News</div>';
        }
        ?>
    </div>
</body>

</html>