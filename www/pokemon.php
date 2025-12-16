<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokémon Stats</title>
    <link rel="stylesheet" href="index.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <form action="pokemon.php" method="GET" class="search-form">
                    <input name="id" placeholder="ID..." value="<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>" required min="1">
                    <button type="submit">Buscar</button>
                </form>
            </div>

            <?php
            $conexion = mysqli_connect("db", "user", "pass", "DB");

            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $sql = "SELECT * FROM Pokemon WHERE ID_Pokemon = '$id'";
                echo $sql;
                $resultado = mysqli_query($conexion, $sql);
                $pokemon = mysqli_fetch_assoc($resultado);

                if ($pokemon) {
            ?>
                <div class="card-header">
                    <h1><?php echo htmlspecialchars($pokemon['Pokemon']); ?></h1>
                    <div class="pokemon-id">#<?php echo str_pad($pokemon['ID_Pokemon'], 3, '0', STR_PAD_LEFT); ?></div>
                </div>

                <div class="stats-grid">
                    <div class="stat-row">
                        <span class="stat-label">HP</span>
                        <span class="stat-value"><?php echo $pokemon['HP']; ?></span>
                    </div>
                    <div class="stat-row">
                        <span class="stat-label">Ataque</span>
                        <span class="stat-value"><?php echo $pokemon['Attack']; ?></span>
                    </div>
                    <div class="stat-row">
                        <span class="stat-label">Defensa</span>
                        <span class="stat-value"><?php echo $pokemon['Defense']; ?></span>
                    </div>
                    <div class="stat-row">
                        <span class="stat-label">Ataque Especial</span>
                        <span class="stat-value"><?php echo $pokemon['Special_Attack']; ?></span>
                    </div>
                    <div class="stat-row">
                        <span class="stat-label">Defensa Especial</span>
                        <span class="stat-value"><?php echo $pokemon['Special_Defense']; ?></span>
                    </div>
                    <div class="stat-row">
                        <span class="stat-label">Velocidad</span>
                        <span class="stat-value"><?php echo $pokemon['Speed']; ?></span>
                    </div>
                </div>
            <?php
                } else {
                    echo '<div class="error-message">Pokémon no encontrado con ID: ' . htmlspecialchars($id) . '</div>';
                }
            } else {
                echo '<div style="text-align: center; color: var(--text-muted);">Introduce un ID para ver los datos del Pokémon</div>';
            }
            ?>
        </div>
    </div>
</body>
</html>
