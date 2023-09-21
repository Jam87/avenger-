   public function insertModulo(string $module, string $view, string $icon)
    {
        $return = "";
        $orden_default = 0;
        $this->module = $module;
        $this->view = $view;
        $this->icon_menu = $icon;
        $this->admission_date = gmdate('Y-m-d H');

        // Suponiendo que "$this->select()" es el método que ejecuta la consulta SQL en la base de datos.

        // Sentencia SQL para obtener el valor máximo de la columna "orden" de la tabla "modulos"
        $sql = "SELECT MAX(orden) FROM modulos";

        // Ejecutar la consulta y obtener el resultado
        $request = $this->select($sql);

        // echo "Resultado BD: " . var_dump($request) . "<br>";
        exit();
        die();

        // Verificar si hay resultados antes de acceder al índice 0 del array
        if (!empty($request) && isset($request[0]['orden'])) {
            // Obtener el valor máximo de la columna "orden"
            $orden = $request[0]['orden'];

            echo "Obtiene valor max: " . var_dump($orden) . "<br>";
        } else {
            // Si no hay resultados, puede asignar un valor predeterminado o manejarlo según tu lógica de negocio.
            $orden = 0; // Por ejemplo, iniciar desde 1 si no hay registros en la tabla.
            echo $orden;
        }

        $nuevoOrden = $orden + 1;
        $this->orden = $nuevoOrden;

        //echo "Suma un valor: " . var_dump($this->orden);
        exit();
        die();



        #Sentencia
        /*$sql = "SELECT * FROM Modulos WHERE module = '{$this->module}' ";

        #Mando a llamar la función(select_all)
        $request = $this->select_all($sql);*/

        /*var_dump($request);
          exit();*/



        //$sql = "INSERT INTO modulos(module, view, icon_menu, orden, admission_date) VALUE (?,?,?,?,?)";
        $sql = "INSERT INTO modulos(orden, module, view, icon_menu, admission_date) VALUE (?,?,?,?,?)";

        #arrData: array de información
        //$arrData = array($this->module,  $this->view,  $this->icon_menu, $this->orden, $this->admission_date);
        $arrData = array($this->orden, $this->module,  $this->view,  $this->icon_menu, $this->admission_date);

        /*var_dump($arrData);
            exit();*/

        #Envio a la funcion insert(sentencia y data)
        $requestInsert = $this->insert($sql, $arrData);

        return $requestInsert;
    }