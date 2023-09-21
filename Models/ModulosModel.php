<?php
class ModulosModel extends Mysql
{
    private $id;
    private $orden;
    private $modulo;
    private $padre_id;
    private $vista;
    private $icon_menu;
    private $fecha_creacion;
    private $activo;

    public function __construct()
    {
        parent::__construct();
    }

    #########################################
    ### MODELO: MOSTRAR TODOS LOS MODULOS ###
    #########################################
    public function selectModulos()
    {
        #Sentencia
        //$sql = "SELECT * FROM modulos WHERE activo != 0";
        $sql = "SELECT * FROM modulos";

        #Mando a llamar la función(select_all)
        $request = $this->select_all($sql);
        return $request;
    }

    ####################################### 
    ### MODELO: GUARDAR UN NUEVO MODULO ###
    #######################################
    public function insertModulo(string $module, string $view, string $icon)
    {
        $return = "";

        //$orden_default = 0;
        $this->modulo = $module;
        $this->vista = $view;
        $this->icon_menu = $icon;
        $this->fecha_creacion = gmdate('Y-m-d H');

        $sql = "SELECT MAX(orden) AS max_orden FROM modulos";

        $request = $this->select($sql);

        if (isset($request['max_orden'])) {
            // Si hay un valor válido en $request[0]['max_orden'], obtén el valor máximo de la columna "orden".
            $nuevoOrden = $request['max_orden'] + 1;
        } else {
            // Si $request[0]['max_orden'] no existe o es NULL, establece el nuevo valor en 0.
            $nuevoOrden = 0;
        }

        #Valor del orden
        $this->orden = $nuevoOrden;

        #########
        #########       

        $sql = "SELECT * FROM modulos WHERE modulo = '{$this->modulo}' ";

        #Mando a llamar la función(select_all)
        $request = $this->select_all($sql);

        if (empty($request)) {

            // Continúa con la inserción del nuevo registro en la tabla "modulos".
            $sql = "INSERT INTO modulos(orden, modulo, vista, icon_menu, fecha_creacion) VALUES (?, ?, ?, ?, ?)";

            $arrData = array($this->orden, $this->modulo,  $this->vista,  $this->icon_menu, $this->fecha_creacion);

            $requestInsert = $this->insert($sql, $arrData);

            return $requestInsert;
        } else {
            $return = "existe";
        }
        return $return;
    }

    ### MODELO: MOSTRAR TODOS LOS MODULOS ###
    public function mostrarJstree()
    {
        $sql = "select id as id,
        (case when (padre_id is null or padre_id = 0)then '#' else padre_id end) as parent,
        modulo as text,
        vista from modulos m
        order by m.orden";

        #Mando a llamar la función(select_all)
        $request = $this->select_all($sql);
        return $request;

        /*$sql = "SELECT '' as opciones, id, orden, modulo, (select modulo FROM modulos mp where mp.id = m.padre_id) as modulo_padre,
                vista, icon_menu, date(fecha_creacion) as fecha_creacion, date(fecha_actualizacion) as fecha_actualizacion
        FROM modulos m
        ORDER BY m.orden";*/
    }

    /*==============================================================
    FNC PARA REORGANIZAR LOS MODULOS DEL SISTEMA
    ==============================================================*/
    public function ReorganizarJstree($modulos_ordenados)
    {

        $total_registros = 0;

        $this->id;
        $this->orden;
        $this->padre_id;

        foreach ($modulos_ordenados as $modulo) {

            $array_item_modulo = explode(";", $modulo);

            $this->id = $array_item_modulo[0];
            $this->padre_id = $array_item_modulo[1];
            $this->orden = $array_item_modulo[2];

            $sql = "UPDATE modulos SET padre_id = ?, orden = ?  WHERE id  = $this->id";

            $arrData = array(str_replace($this->padre_id, '#', 0), $this->orden);
            $request = $this->update($sql, $arrData);


            if ($request) {
                $total_registros = $total_registros + 1;
            } else {
                $total_registros = 0;
            }
        }

        return $total_registros;
    }

    public function ObtenerModuloPorPerfil(int $intIdPerfil)
    {
        $this->id = $intIdPerfil;

        $sql = "SELECT id, modulo,
                IFNULL(case when (m.vista is null or m.vista = '') then '0' else (
                (SELECT '1' FROM perfil_modulo pm WHERE pm.id_modulo = m.id AND pm.id_perfil = $this->id)) end,0) as sel
                 FROM modulos m
                 ORDER BY m.orden";

        $request = $this->select_all($sql);

        return $request;
    }
}
