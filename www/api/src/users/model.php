<?php

require_once './src/database/database.php';

class Users
{
    private $conn;
    public $respuesta = array(
        "status" => '',
        "body" => '',
    );

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function create($data)
    {
        try {
            $descripcion = $data['descripcion'];
            $estatus = $data['estatus'];

            $query = 'INSERT INTO `bas_categoria` (
                        `descripcion`,
                        `estatus`)
                    VALUES (
                        :descripcion,
                        :estatus)';
            $statement = $this->conn->prepare($query);
            $statement->bindParam(":descripcion", $descripcion, PDO::PARAM_STR);
            $statement->bindParam(":estatus", $estatus, PDO::PARAM_STR);
            $statement->execute();

            $this->respuesta['status'] = 'ok';
            $this->respuesta['body'] = 'Categoria registrada';

        } catch (PDOException $e) {
            $this->respuesta['status'] = 'err';
            $this->respuesta['body'] = 'error: ' . $e->getMessage();
        }
        return $this->respuesta;
    }

    public function update()
    {
    }

    public function delete($id)
    {
        try {
            $query = 'DELETE FROM`bas_categoria` WHERE id_categoria = :id';
            $statement = $this->conn->prepare($query);
            $statement->bindParam(":id", $id, PDO::PARAM_STR);
            $statement->execute();

            $this->respuesta['status'] = 'ok';
            $this->respuesta['body'] = 'Categoria eliminada';

        } catch (PDOException $e) {
            $this->respuesta['status'] = 'err';
            $this->respuesta['body'] = 'error: ' . $e->getMessage();
        }
        return $this->respuesta;
    }

    /*  
     *          CHECK PASSWORD FUNCTION
     *          -----------------------
     *          Input $data (JSON) {'name': input1, 'password': input2}
     *          Output respuesta(JSON) {'FOUND': output1}
     */

    public function checkPassword($data)
    {
        try {
            $userName = $data['name'];
            $passWord = $data['password'];               

            $query = 'SELECT
                        COUNT(
                            name) as FOUND
                    FROM
                        DB.users
                    WHERE
                        name = :nm 
                        AND
                        password = :pw';
                        // :pw;

            $statement = $this->conn->prepare($query);
            $statement->bindParam(":nm", $userName, PDO::PARAM_STR);
            $statement->bindParam(":pw", $passWord, PDO::PARAM_STR);
            $statement->execute();

            $this->respuesta['status'] = 'ok';
            
            //
             if ($statement->rowCount() > 0) {
                $this->respuesta['body'] = $statement->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $this->respuesta['body'] = 'la tabla esta vacia';
            } 

        } catch (PDOException $e) {
            $this->respuesta['status'] = 'err';
            $this->respuesta['body'] = 'error: ' . $e->getMessage();
        }
        return $this->respuesta;
    }

    public function readOne($id)
    {
        try {
            $query = 'SELECT
                        username
                    FROM
                        DB.users
                    WHERE
                        userId = :id';
            $statement = $this->conn->prepare($query);
            $statement->bindParam(":id", $id, PDO::PARAM_STR);
            $statement->execute();

            if ($statement->rowCount() > 0) {
                $this->respuesta['status'] = 'ok';
                $this->respuesta['body'] = $statement->fetch(PDO::FETCH_ASSOC);
                } else {
                $this->respuesta['status'] = 'error';
                $this->respuesta['body'] = 'No existe registro.';
            }

        } catch (PDOException $e) {
            $this->respuesta['status'] = 'err';
            $this->respuesta['body'] = 'error: ' . $e->getMessage();
        }
        return $this->respuesta;
    }

    public function getparamstoUpdate($input)
    {
        $filterParams = [];
        foreach ($input as $param => $value) {
            $filterParams[] = "$param=:$param";
        }
        return implode(", ", $filterParams);
    }

    //Asociar todos los parametros a un sql
    public function bindAllValues($statement, $params)
    {
        foreach ($params as $param => $value) {
            $statement->bindValue(':' . $param, $value);
        }
        return $statement;
    }
}
