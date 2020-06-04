<?php

class EstiloController
{

    private $view;

    public function __construct()
    {
        $this->view = new View();
    }

    public function EstiloView()
    {
        $this->view->show('EstiloView.php');
    }

    public function disc()
    {
        $consulta['EC'] = $_POST['c5'] + $_POST['c9'] + $_POST['c13'] + $_POST['c17'] + $_POST['c25'] + $_POST['c29'];
        $consulta['OR'] = $_POST['c2'] + $_POST['c10'] + $_POST['c22'] + $_POST['c26'] + $_POST['c30'] + $_POST['c34'];
        $consulta['CA'] = $_POST['c7'] + $_POST['c11'] + $_POST['c15'] + $_POST['c19'] + $_POST['c31'] + $_POST['c35'];
        $consulta['EA'] = $_POST['c4'] + $_POST['c12'] + $_POST['c24'] + $_POST['c28'] + $_POST['c32'] + $_POST['c36'];

        require_once 'Bayes.php';
        $bayes = new Bayes();

        $resultado['Estilo'] = $bayes->Adivinar($consulta, 'estilo_tabla');

        $this->view->show('resultadoView.php', $resultado['Estilo']);
    }
}
