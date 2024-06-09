<?php

require_once './src/pokemon/model.php';

class bas_categoriaController
{
    private $model;

    public function __construct()
    {
        $this->model = new BasCategoria();
    }

    public function readAll()
    {
        return $this->model->read();
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
