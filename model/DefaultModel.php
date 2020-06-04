<?php

class DefaultModel
{
    public function __construct()
    {
        require_once 'libs/SPDO.php';
        $this->db = SPDO::singleton();
    }

    // datos de la base, varia segun la tabla 
    public function get_data($sp)
    {
        $consulta = $this->db->prepare('CALL sp_' . $sp . '');
        $consulta->execute();
        $resultados = $consulta->fetchAll();
        $consulta->CloseCursor();
        return $resultados;
    }
}
