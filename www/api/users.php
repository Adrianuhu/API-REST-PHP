<?php

require_once 'config.php';
require_once './src/utils/setHttpResponseCode.php';

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header('Content-Type: application/json');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

$response = [
    'status' => 400,
    'message' => 'Bad Request'
];

if (isset($_GET['inst'])) {
    $inst = $_GET['inst'];

    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            echo(' GET: ');
            //echo($inst);

            //$id = intval(preg_replace('/[^0-9]+/', '', $inst), 10);

            switch ($inst){

                /*  **********************************************************************          */
                case 'checkPassword':
                    echo( ' checking password...');
                    require_once BASE_PATH . '/api/src/users/controller.php';
                    $controller = new usersController();
                    $response = $controller->readOne($id);
                    break;
                default:
                    break;
            }

            

            setHttpResponseCode($response['status']);
            break;

        case 'POST':
            $data = json_decode(file_get_contents("php://input"), true);

            if (json_last_error() === JSON_ERROR_NONE) {
                echo(' POST: ');
                //echo(json_encode($data));

                switch ($inst) {
                    case 'checkPassword':
                        $userName = $_GET['name'];
                        $password = $_GET['password'];
                        require_once BASE_PATH . '/api/src/users/controller.php';
                        $controller = new usersController();
                        $response = $controller->checkPassword($data);
                        break;


                    default:
                        $response = [
                            'status' => 404,
                            'message' => 'Not Found'
                        ];
                        break;
                }



            } else {
                $response = [
                    'status' => 400,
                    'message' => 'Invalid JSON'
                ];
            }

            setHttpResponseCode($response['status']);
            break;

        case 'DELETE':
            $id = intval(preg_replace('/[^0-9]+/', '', $inst), 10);

            switch ($inst) {

            }

            setHttpResponseCode($response['status']);
            break;

        default:
            $response = [
                'status' => 405,
                'message' => 'Method Not Allowed'
            ];
            setHttpResponseCode($response['status']);
            break;
    }
} else {
    $response = [
        'status' => 400,
        'message' => 'Bad Request'
    ];
    setHttpResponseCode($response['status']);
}

echo json_encode($response);

?>
