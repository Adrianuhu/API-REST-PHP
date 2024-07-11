<?php

require_once 'config.php';
require_once './src/utils/setHttpResponseCode.php';

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header('Content-Type: application/json');
header('Access-Control-Allow-Credentials: true');

/** Verifica si existe una inst via petición GET */
if (isset($_GET['inst'])) {
    /// Asigna el valor de la inst de la petición
    $inst = $_GET['inst'];
    $response = '';

    /** Se lee el metodo solicitado [GET, POST, PUT, DELETE] */
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET': {
            echo(' GET: ');
            echo($inst);

            switch ($inst){

                /** INSTRUCTION 1: Check password */
                case 'checkPassword': {
                    echo( ' checking password...');
                    break;
                }




                default: {
                    break;
                }

            }

            /// Obtiene el valor de id en la inst api.example.com/METODO/ID
            $id = intval(preg_replace('/[^0-9]+/', '', $inst), 10);
            
            $response = $inst;

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
            $data = json_decode(file_get_contents("php://input"), true);
            /// Convierte lo obtenido en DATA a un JSON y verifica que no tenga errores, si tiene errores responde 400
            echo(' POST: ');
            echo($data);

            switch ($inst) {
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
            switch ($inst) {
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
     /// No hace nada

     setHttpResponseCode($response['status']);

}

/*if($response == null){
    http_response_code(404);
}else{
    echo json_encode($response);
}*/

echo json_encode($response);

?>