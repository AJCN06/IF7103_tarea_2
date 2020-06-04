<?php

class SexoController
{

    private $view;

    public function __construct()
    {
        $this->view = new View();
    }

    public function sexoView()
    {
        $this->view->show('sexoView.php');
    }

    public function disc()
    {
        $consulta['Recinto'] = $_POST['recintoi'];
        $consulta['Promedio'] = $_POST['promedioi'];
        $consulta['Estilo'] = $_POST['estiloi'];

        require_once 'Bayes.php';
        $bayes = new Bayes();

        $resultado['Sexo'] = $bayes->Adivinar($consulta, 'sexo_estudiante');
        if ($resultado['Sexo'] == 'F')
            $this->view->show('resultadoView.php', 'Femenino');
        else
            $this->view->show('resultadoView.php', 'Masculino');
    }
}
