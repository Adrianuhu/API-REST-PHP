<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>News</title>

</head>

<body>

    <form action="news_SOLUCION_2.php" method="GET">
        <input name="id" placeholder="ID..." value="<?php echo $_GET['id']?>" required min="1">
        <button type="submit">Buscar</button>
    </form>

    <?php
    $conexion = mysqli_connect("db", "user", "pass", "DB");
    mysqli_report(MYSQLI_REPORT_OFF);


    if (isset($_GET['id'])) {

        if (!ctype_digit($_GET['id'])) {
            echo '<div>News no encontrado con ID: ' . $_GET['id'] . '</div>';
            die();
        }

        $id_raw = $_GET['id'];
        $id_safe = (int) $id_raw;

        
        // Consulta SQL vulnerable a inyección SQL (Blind SQL Injection)
        // ESCRIBIENDO 3 AND 1=1 OK  2 AND 1=2 ERROR
        // 3 AND SUBSTRING(database(),1,1)='d' OK porque nuestra DDBB se llama "DB"
        // 3 AND SUBSTRING(database(),1,1)='a' ERROR porque nuestra DDBB se llama "DB"
    
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
            echo '<div>Noticia no encontrada con ID: ' . $id . '</div>';
        }
    } else {
        echo '<div>Introduce un ID para ver los datos de la noticia</div>';
    }
    ?>
</body>

</html>