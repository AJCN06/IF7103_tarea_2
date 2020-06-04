<?php

class DefaultController
{

    private $view;

    public function __construct()
    {
        $this->view = new View();
    }

    public function accionDefault()
    {
        require_once 'Bayes.php';
        $test = new Bayes();

        $test->Calcular('estilo_tabla');
        $test->Calcular('recinto_origen');
        $test->Calcular('sexo_estudiante');
        $test->Calcular('estilo_aprendizaje');
        $test->Calcular('tipo_profesor');
        $test->Calcular('clasificacion_redes');

        $this->view->show('indexView.php');
    }
}
