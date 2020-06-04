<?php

class ProfesorController
{

    private $view;

    public function __construct()
    {
        $this->view = new View();
    }

    public function ProfesorView()
    {
        $this->view->show('ProfesorView.php');
    }

    public function disc()
    {
        $consulta['A'] = $_POST['ai'];
        $consulta['B'] = $_POST['bi'];
        $consulta['C'] = $_POST['ci'];
        $consulta['D'] = $_POST['di'];
        $consulta['E'] = $_POST['ei'];
        $consulta['F'] = $_POST['fi'];
        $consulta['G'] = $_POST['gi'];
        $consulta['H'] = $_POST['hi'];

        require_once 'Bayes.php';
        $bayes = new Bayes();

        $resultado['CLASS'] = $bayes->Adivinar($consulta, 'tipo_profesor');
        $this->view->show('resultadoView.php', $resultado['CLASS']);
    }
}
