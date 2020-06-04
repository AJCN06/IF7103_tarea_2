<?php

class RedesController
{

    private $view;

    public function __construct()
    {
        $this->view = new View();
    }

    public function RedesView()
    {
        $this->view->show('RedesView.php');
    }

    public function disc()
    {
        $consulta['Reliability (R)'] = $_POST['Rei'];
        $consulta['Number of links (L)'] = $_POST['Lii'];
        $consulta['Capacity (Ca)'] = $_POST['Cai'];
        $consulta['Costo (Co)'] = $_POST['Coi'];

        require_once 'Bayes.php';
        $bayes = new Bayes();

        $resultado['Class'] = $bayes->Adivinar($consulta, 'clasificacion_redes');
        $this->view->show('resultadoView.php', $resultado['Class']);
    }
}
