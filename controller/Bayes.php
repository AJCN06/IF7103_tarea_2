<?php
class Bayes
{
    public function Calcular($nombre)
    {
        $meta = $this->meta_info($nombre); // obtiene info necesaria (metodo mas abajo)
        $columnas = $meta['columnas'];
        $opciones = $meta['opciones'];
        $objetivo = $meta['objetivo'];
        $nombre_tabla = $meta['tabla'];

        require_once 'model/DefaultModel.php';
        $Default = new DefaultModel();
        $tabla = $Default->get_data($nombre_tabla); // obtiene la tabla

        /* variable par guardar la cantidad de veces que sale un target en el set
        de datos, nombre poco explicito por formula */
        $n = [];

        /* se guardaran la probabilidad de que salga la del usuario entre todas
        las que hay  */
        $p = [];

        /* Se guardara el contador de cada posible opcion por columna de cada 
        posible target, en resumen genera la tabla con los contadores, luego
        la tabla con las probabilidades*/
        $nc = []; // nc -> tipo -> atributo -> contador con opciones

        /*NOTA: n, m, p, nc son nombres de la formula */

        /* variable para guardar las posibles opciones de target, ejemplo,
        quiere saber el tipo de profe, se guardara los posibles resultados*/
        $objetivos = array();

        /*Cantidad de columans a evaluar, para formula*/
        $m = count($columnas);


        /*Ciclo que recorre la tabla para contar la cantidad de veces que sale 
        cada target, ejemplo cuantas veces sale divergente, etc. guarda dodo en 
        n dividiendo por la clave ej n[divergente] += 1*/


        foreach ($tabla as $tupla) {
            if (isset($n[$tupla[$objetivo]])) { // valida que cada opcion este creada sino la crea
                $n[$tupla[$objetivo]] += 1;
            } else {
                $n[$tupla[$objetivo]] = 1;
                array_push($objetivos, $tupla[$objetivo]); /* y agrega el target a 
                        los obetivos para guardar los posibles resultados que como 
                        varia dependiendo la tabla y formulario, son desconocidos 
                        hasta ahora */
            }
        }


        for ($i = 0; $i < count($columnas); $i++) { //calcula la probabilidad de cada 
            $p[$columnas[$i]] = 1 / $opciones[$i]; // atributo de la tabla y los guarda
            /*en p['1'] ya que A seria una columna con 3 opciones que esta 
                        opciones['1'] que reprecenta la columna A */
        }

        foreach ($tabla as $tupla) {
            if (!isset($nc[$tupla[$objetivo]])) { // valida uqe el target exista, sino lo crea
                $nc[$tupla[$objetivo]] = [];
            }

            $tipo = $nc[$tupla[$objetivo]]; // lo saca en una variable, solo por orden 

            for ($i = 0; $i < count($columnas); $i++) { // recorre las columnas a evaluar
                if (!isset($tipo[$columnas[$i]])) { // genera cada columna para cada target si no existe aun
                    $tipo[$columnas[$i]] = [];
                }

                $atributo = $tipo[$columnas[$i]]; //igual, la saca por orden 

                if (!isset($atributo[$tupla[$columnas[$i]]])) { // valida que cada atributo/columna tenga la 
                    $atributo[$tupla[$columnas[$i]]] = 0; //posible opcion, sino la crea en 0
                }

                $atributo[$tupla[$columnas[$i]]] += 1; // suma uno a la opcion de la columna
                $tipo[$columnas[$i]] = $atributo; // lo devuelve al tipo
            }
            $nc[$tupla[$objetivo]] = $tipo; // y el tipo vuelve al nc
        }
        /*Este ciclo solo va contar y cada opcion existente en la tabla en cada 
        columna para cada target, los que no esten en la tabla no son generados, 
        los gnero en este metodo en 0 */
        $nc = $this->llenar_vacios($nc); // (metodo mas abajo)


        /* Recorre toda la matriz generada, en este punto nc es la tabla con el contador
        por atributo para cada posible objetivo, se vuelve a recorrer ya con los 0 que 
        no se contaron en la tabla y en cada poscion se se cambia el contador por el resultado 
        de la formula. */
        $aux = 0;
        foreach ($objetivos as $tipo) {
            foreach ($columnas as $col) {
                foreach ($nc[$tipo][$col] as &$val) {
                    $val =  ($val + $m * $p[$col]) / ($n[$tipo] + $m);
                }
            }
            $nc[$tipo]['veces_en_tabla'] = $n[$tipo]; //guarda la cantidad de veces de cada target
            $aux += $n[$tipo];
        }
        $nc['total_en_tabla'] = $aux; // variable auxiliar para contar la cantidad total de targets

        $file = 'probabilidades/' . $nombre . '.json';
        file_put_contents($file, json_encode($nc)); // en la carpeta datos esta un json por formulario con las probabilidades/
    }




    public function Adivinar($consulta, $target)
    {
        $json = file_get_contents('probabilidades/' . $target . '.json'); // se obtiene los datos del json respectivo
        $tabla = json_decode($json, true);

        $datos = [];/*variable que se utilizara para guardar los datos de la 
                        tabla que se necesitan con base a la consulta enviada*/

        $total_en_tabla = $tabla['total_en_tabla']; // cantidad de elementos objetvo en la tabla (para formula)
        unset($tabla['total_en_tabla']); // se elimina para que no afecte a la hora de recorrer la tabla y sacar datos


        /*ciclo principal que se encarga de sacar los datos por categoria, ejemplo,
        si se queire saber si es beginner, advanced, etc, el saca todos los datos
        de la tabla para cada categoria, seleccionando el dato de la categoria 
        de la columna correspondiente, luego en la columna saca solo el dato de 
        la tabla con base a la eleccion de la consulta del usuario, luego datos 
        por categoria se guarda en datos con la key de la categoria para que esten
        clasificados por categorias. */
        foreach ($tabla as $id_categoria => $categoria) {
            $datos_categoria = [];
            foreach ($categoria as $id_columna => $columna) {
                if ($id_columna != 'veces_en_tabla') { // excluye la columna, era necesaria para formula
                    if (isset($columna[$consulta[$id_columna]])) { //***
                        $datos_categoria[$id_columna] = $columna[$consulta[$id_columna]];
                    } else {
                        $datos_categoria[$id_columna] = $columna[intval($consulta[$id_columna])];
                    }
                }
            }
            /* *** Ese if valida que el promedio estuviera dentro de la tabla, 
            si el usuario ingresa un promedio que no estuviera guardado en la tabla
            es porque le contador estaba en 0 en ese promedio, entonces tendria 
            que guardar 501 posibles promedios de 5.00 a 10.00 con dos decimales,
            preferi guardar solo su numero exacto para ahorrar espacio ya que si 
            7.3 que ingresa en el usuario y no esta en el json va tener la misma 
            probabilidad que 7 que tampoco estaba en la tabla, y fue guardado para 
            calcular la probabilidad de todos los numero de 7.00 a 7.99, creo que 
            por faltar esos numero la probabilidad guardada en le json puede variar
            un poco */


            /*Ciclo que realiza la multiplicacion de cada categoria para saber 
            la probabilidad de cada posible respuesta */
            $result = 1;
            foreach ($datos_categoria as $val) {
                $result = $result * $val;
            }

            // se aplica la formula y guarda en ese lugar p() Total
            $datos_categoria['p() Total'] = $result * ($categoria['veces_en_tabla'] / $total_en_tabla);
            $datos[$id_categoria] = $datos_categoria;
        }


        /* Luego del Ciclo principal solo se recorre los datos generados escogiendo
        siempre el valor mas grande de todos y la categoria correspondinente
        seria la ganadora */
        $mayor = 0;
        $categoria_ganadora = '';
        foreach ($datos as $id_categoria => $resultado_categoria) {
            if ($resultado_categoria['p() Total'] > $mayor) {
                $mayor = $resultado_categoria['p() Total'];
                $categoria_ganadora = $id_categoria;
            }
        }
        return $categoria_ganadora;
    }



    /* El algoritmo tiene un error, ya que al ser dinamoco genera una nueva opcion 
    en cada columna cuando la encuentra, pero tambien se deben contantar las opciones
    que existan pero que no esten en la tabla, ya que el usuario podria ingresar ese 
    posible dato. 
    
    llenar_vacios genera todos las posibles opciones de todas las columnas que se 
    utilizen, con = 0, ya que nunca encontro una y asi se pueden calcular las aprox
    con esos datos*/
    private function llenar_vacios($nc)
    {
        $posibles_opciones = $this->opciones_quemadas();
        foreach ($nc as &$tipo) { //recorre cada target
            foreach ($tipo as $id_col => &$col) { //de cada target saca las columnas
                $opciones = $posibles_opciones[$id_col]; // saca las  opciones posibles para esa columna
                foreach ($opciones as $opcion) { // recorre esas opciones 
                    if (!isset($col[$opcion])) { // si esa opcion no existe (nunca fue contada)
                        $col[$opcion] = 0; // la setea a 0
                    }
                }
            }
        }
        /* Luego retorna el $nc con todos los datos contados mas los que nunca 
        encontro = 0*/
        return $nc;
    }

    /*Posibles valores que existe ordenadas por columna y por tabla, al utilizar
    la clave del arreglo no hay problema en que todas esten en el mismo arreglo 
    ya que el algoritmo utiliza solo las que necesita de la informacion de la tabla
    y del atributo que tenga como target */
    private function opciones_quemadas()
    {
        /*Devolvera un array donde en cada key se guarda el nombre de la columan
        de la tabla, y cada key guarda un array con todas las posibles opciones de 
        esa columna, para su utlizacion sea opciones_por_columna = array[columna]  */
        return [
            // Tabla t1_profesores
            'A' => [1, 2, 3],
            'B' => ['F', 'NA', 'M'],
            'C' => ['I', 'B', 'A'],
            'D' => [1, 2, 3],
            'E' => ['O', 'ND', 'DM'],
            'F' => ['H', 'L', 'A'],
            'G' => ['S', 'N', 'O'],
            'H' => ['O', 'S', 'N'],


            // Tabla t1_redes
            'Reliability (R)' => range(2, 5),
            'Number of links (L)' => range(7, 20),
            'Capacity (Ca)' => ['High', 'Medium', 'Low'],
            'Costo (Co)' => ['High', 'Medium', 'Low'],

            // Tabla t1_recintoEstilo
            'EC' => range(6, 24),
            'OR' => range(6, 24),
            'CA' => range(6, 24),
            'EA' => range(6, 24),

            // Tabla t1_estilosexopromediorecinto
            'Sexo' => ['M', 'F'],
            'Estilo' => ['ASIMILADOR', 'ACOMODADOR', 'CONVERGENTE', 'DIVERGENTE'],
            'Promedio' => range(5, 10, 0.01),
            'Recinto' => ['Turrialba', 'Paraiso'],
        ];
    }

    /*Metodo que retorna la informacion de la tabla y datos que se utilizan para 
    el calculo de las probabilidades, dependiendo la probabilidad que vaya a sacar
    el devuelve la informacion necesaria.
    
        Ejemplo que quiera el recinto de origen, en meta se guardaria las columnas 
        ingresadas por el usuario para solo utilizar esas a la hora de calcular las
        probabilidades, como el usuario solo ingresara 3 datos, solo se generara
        el set de probabilidades con esos 3 datos de la tabla por cada posible dato
    */
    private function meta_info($nombre)
    {
        $meta = [];
        switch ($nombre) {

            case "estilo_tabla": // formulario al que accede, solo palabra clave 
                $meta['columnas'] = ['EC', 'OR', 'CA', 'EA']; //columnas a calcular
                $meta['opciones'] = [24, 24, 24, 24]; // opciones por columna en respectivo orden
                $meta['objetivo'] = 'Estilo'; // target a adivinar por decirlo asi
                $meta['tabla'] = 't1_recintoestilo'; //tabla donde esta esa info
                break;

            case "recinto_origen":
                $meta['columnas'] = ['Sexo', 'Estilo', 'Promedio'];
                $meta['opciones'] = [2, 4, count(range(5, 10, 0.01))];
                $meta['objetivo'] = 'Recinto';
                $meta['tabla'] = 't1_estilosexopromediorecinto';
                break;

            case "sexo_estudiante":
                $meta['columnas'] = ['Recinto', 'Estilo', 'Promedio'];
                $meta['opciones'] = [2, 4, count(range(5, 10, 0.01))];
                $meta['objetivo'] = 'Sexo';
                $meta['tabla'] = 't1_estilosexopromediorecinto';
                break;

            case "estilo_aprendizaje":
                $meta['columnas'] = ['Sexo', 'Recinto', 'Promedio'];
                $meta['opciones'] = [2, 2, count(range(5, 10, 0.01))];
                $meta['objetivo'] = 'Estilo';
                $meta['tabla'] = 't1_estilosexopromediorecinto';
                break;

            case 'tipo_profesor':
                $meta['columnas'] = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];
                $meta['opciones'] = [3, 3, 3, 3, 3, 3, 3, 3];
                $meta['objetivo'] = 'CLASS';
                $meta['tabla'] = 't1_profesores';
                break;

            case "clasificacion_redes":
                $meta['columnas'] = ['Reliability (R)', 'Number of links (L)', 'Capacity (Ca)', 'Costo (Co)'];
                $meta['opciones'] = [4, 14, 3, 3];
                $meta['objetivo'] = 'Class';
                $meta['tabla'] = 't1_redes';
                break;
        }
        return $meta;
    }
}
