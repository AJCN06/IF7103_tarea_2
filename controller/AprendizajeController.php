<?php

class AprendizajeController
{

    private $view;

    public function __construct()
    {
        $this->view = new View();
    }

    public function aprendizajeView()
    {
        $this->view->show('aprendizajeView.php');
    }

    public function disc()
    {
        $consulta['Sexo'] = $_POST['sexoi'];
        $consulta['Promedio'] = $_POST['promedioi'];
        $consulta['Recinto'] = $_POST['recintoi'];

       
        require_once 'Bayes.php';
        $bayes = new Bayes();

        $resultado['Estilo'] = $bayes->Adivinar($consulta, 'estilo_aprendizaje');
        $this->view->show('resultadoView.php', $resultado['Estilo']);
    }
}
