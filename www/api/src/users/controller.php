<?php

require_once './src/users/model.php';

class usersController
{
    private $model;

    public function __construct()
    {
        $this->model = new Users();
    }

    /*
     *
     */
    public function checkPassword($data)
    {
        return $this->model->checkPassword($data);
    }

    public function readOne($id)
    {
        return $this->model->readOne($id);
    }

    public function create($data)
    {
        return $this->model->create($data);
    }

    public function delete($id)
    {
        return $this->model->delete($id);
    }
}
