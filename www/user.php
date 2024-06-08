<?php
header('Content-Type: application/json');
if (isset($_GET['username'])) {
    $username = htmlspecialchars($_GET['username']);

    http_response_code(200);

    $response = array(
        "status" => "success",
        "message" => "Usuario encontrado",
        "data" => array(
            "username" => $username,
            // Otros datos del usuario
        )
    );


} else {
    // echo "No se proporcionó un nombre de usuario.";
    http_response_code(400);
    $response = array(
        "status" => "error",
        "message" => "No se proporcionó un nombre de usuario.",
    );

}

echo json_encode($response);
?>