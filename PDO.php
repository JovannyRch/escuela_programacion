<?php


class CustomPDO
{
    function __construct()
    {

        $server = 'localhost';
        //$username = 'u610741374_test';
        //$database = 'u610741374_test';
        //$password = 'test1Qasd';
        $username = 'root';
        $database = 'escuela_programacion_db';
        $password = '';

        try {
            $this->db = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
        } catch (Exception $e) {
            die('Connection Failed: ' . $e->getMessage());
        }
    }


    function row($sql)
    {
        $resultado = $this->db->prepare($sql);
        if ($resultado->execute()) {
            $arreglo =  $this->utf8_converter($resultado->fetchAll(PDO::FETCH_ASSOC));
            if (sizeof($arreglo) > 0) {
                return $arreglo[0];
            }
            return null;
        };

        return null;
    }



    function utf8_converter($array)
    {
        array_walk_recursive($array, function (&$item, $key) {
            if (!mb_detect_encoding($item, 'utf-8', true)) {
                $item = utf8_encode($item);
            }
        });

        return $array;
    }


    function array($sql)
    {
        try {
            $items = $this->db->prepare($sql);
            if ($items->execute()) {
                return $this->utf8_converter($items->fetchAll(PDO::FETCH_ASSOC));
            } else return array();
        } catch (\Throwable $th) {
            return array();
        }
    }

    function query($sql)
    {
        $stmt = $this->db->prepare($sql);
        return $stmt->execute();
    }


    function insert($sql)
    {
        $this->query($sql);
        return $this->db->lastInsertId();
    }


    function getUserById($id)
    {
        return $this->row("SELECT * from usuarios where id_usuario = '$id'");
    }

    function registrarAlumno($id, $nombre_usuario, $pass, $nombre, $paterno, $materno)
    {
        return $this->insert("INSERT INTO usuarios(id_usuario, nombre_usuario, contrasenia, tipo_usuario, nombre, paterno, materno) values('$id', '$nombre_usuario', '$pass', 'E', '$nombre', '$paterno', '$materno')");
    }

    function getUser($id, $pass)
    {
        return $this->row("SELECT * from usuarios where id_usuario = '$id' and contrasenia = '$pass'");
    }

    function getMaterias(){
        return $this->array("SELECT * from materias");
    }

    function getEstudiantes($id_estudiante = null){
        if(is_null($id_estudiante)){
            return $this->array("SELECT * from usuarios where tipo_usuario = 'E'");
        }
        return $this->array("SELECT * from usuarios where tipo_usuario = 'E' and id_usuario = $id_estudiante");
    }

    function consultarCalificacionAlumno($id_usuario, $id_materia){
        return $this->row("SELECT * from calificaciones where id_usuario = '$id_usuario' and id_materia = $id_materia");
    }

    function registrarCalificacion($id_usuario, $id_materia, $calificacion){
        
        $consulta = $this->consultarCalificacionAlumno($id_usuario, $id_materia);
        if(is_null($consulta)){ //Insert
            return $this->insert("INSERT INTO calificaciones(id_usuario, id_materia, calificacion) values('$id_usuario', $id_materia, $calificacion)");
        }else{   //Update
            $id_calificacion = $consulta['id_calificacion'];
            $this->query("UPDATE calificaciones set calificacion = $calificacion where id_calificacion = $id_calificacion");
            return $id_calificacion;
        }
    }


    function registrosCalificaciones($id_estudiante = null){
        $estudiantes = $this->getEstudiantes($id_estudiante);
        
        $materias = $this->getMaterias();

        $calificaciones = array();
        foreach ($estudiantes as $estudiante) {
            $id_estudiante = $estudiante['id_usuario'];
            
            $registrosCalificacionesAlumno = array(); 
            foreach ($materias as $materia) {
                $id_materia = $materia['id_materia'];
                $registroCalificacion = $this->consultarCalificacionAlumno($id_estudiante, $id_materia);
                if(is_null($registroCalificacion)){
                    $registrosCalificacionesAlumno[$id_materia] = "--";
                }else{
                    $registrosCalificacionesAlumno[$id_materia] = $registroCalificacion["calificacion"];
                }
            }
            $estudiante['calificaciones'] = $registrosCalificacionesAlumno;
            $calificaciones[] = $estudiante;
        }

        return array("consulta" => $calificaciones, 'materias' => $materias);
    }

    function getDatosUsuario($id_usuario){
        return $this->row("SELECT * from usuarios where id_usuario = '$id_usuario'");
    }
}
