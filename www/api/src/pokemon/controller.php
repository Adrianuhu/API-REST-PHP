<?php

require_once './src/pokemon/model.php';

class pokemonController
{
    private $model;

    public function __construct()
    {
        $this->model = new Pokemon();
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
