<?php

require_once 'config.php';
require_once './src/utils/setHttpResponseCode.php';

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header('Content-Type: application/json');
header('Access-Control-Allow-Credentials: true');

/** Verifica si existe una pokemonId via petición GET */
if (isset($_GET['pokemonId'])) {
    /// Asigna el valor de la pokemonId de la petición
    $pokemonId = $_GET['pokemonId'];
    $response = '';

    /** Se lee el metodo solicitado [GET, POST, PUT, DELETE] */
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET': {
            /// Obtiene el valor de id en la pokemonId api.example.com/METODO/ID
            $id = intval(preg_replace('/[^0-9]+/', '', $pokemonId), 10);
            
            $response = $pokemonId;

            /// Obtiene el valor del metodo al que se dirige la petición
            // CREAR PARA QUE TE DEN TODO
            
            /// Solicita el controlador correspondiente y el metodo
            require_once BASE_PATH . '/api/src/pokemon/controller.php';
            $controller = new pokemonController();
            $response = $controller->readOne($id);

            /// Responde con un codigo 200 en caso de que la peticion sea correcta
            
            setHttpResponseCode($response['status']);
            break;

        }
        case 'POST': {
            /// Obtiene el valor de DATA, en donde estan los campos y valores a usar
            $data = $_POST['data'];
            //$data = json_decode(file_get_contents("php://input"), true);
            /// Convierte lo obtenido en DATA a un JSON y verifica que no tenga errores, si tiene errores responde 400
            switch ($pokemonId) {
            case 'categoria': {
                /// Solicita el controlador correspondiente y el metodo
                require_once 'controllers/bas_categoria_controller.php';
                $controller = new pokemonController();
                $response = $controller->create($data);
                /// Responde con un codigo 200 en caso de que la peticion sea correcta
                // http_response_code(200);
                break;
                }
            default: {
                break;
                }
            }
            break;
        }

        case 'DELETE': {
            switch ($pokemonId) {
            case "categoria/$id": {
                /// Solicita el controlador correspondiente y el metodo
                require_once 'controllers/bas_categoria_controller.php';
                $controller = new pokemonController();
                $response = $controller->delete($id);
                /// Responde con un codigo 200 en caso de que la peticion sea correcta
                // http_response_code(200);
                break;
                }
            default: {
                break;
                }
            }
            break;
        }

        default: {
            break;
        }
    }
} else {
     /// Solicita el controlador correspondiente y el metodo
     require_once BASE_PATH . '/api/src/pokemon/controller.php';
     $controller = new pokemonController();
     $response = $controller->readAll();

     /// Responde con un codigo 200 en caso de que la peticion sea correcta
     
     setHttpResponseCode($response['status']);
}

echo json_encode($response);

?>