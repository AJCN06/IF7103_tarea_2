<?php

class View {

    public function __construct() {
        ;
    }

    public function show($nombreVista, $vars = array()) {
        $config = Config::singleton();
        $path = $config->get('viewFolder') . ucwords($nombreVista);

        if (is_file($path) == FALSE) {
            trigger_error('Pagina ' . $path . ' no existe', E_USER_NOTICE);
            return FALSE;
        }

        if (is_array($vars)) {
            foreach ($vars as $key => $value) {
                $key = $value;
            }
        }
        include $path;
    }

}
