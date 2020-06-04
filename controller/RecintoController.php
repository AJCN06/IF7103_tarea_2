<?php

class RecintoController
{

    private $view;

    public function __construct()
    {
        $this->view = new View();
    }

    public function recintoView()
    {
        $this->view->show('recintoView.php');
    }

    public function disc()
    {
        $consulta['Sexo'] = $_POST['sexoi'];
        $consulta['Promedio'] = $_POST['promedioi'];
        $consulta['Estilo'] = $_POST['estiloi'];

               
        require_once 'Bayes.php';
        $bayes = new Bayes();

        $resultado['Estilo'] = $bayes->Adivinar($consulta, 'recinto_origen');
        $this->view->show('resultadoView.php', $resultado['Estilo']);
    }
}
