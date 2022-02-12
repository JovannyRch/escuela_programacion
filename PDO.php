<?php


class CustomPDO
{
    function __construct()
    {

        $server = 'localhost';
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

    function registrarAlumno($id, $nombre, $pass)
    {
        return $this->insert("INSERT INTO usuarios(id_usuario, nombre_usuario, contrasenia, tipo_usuario) values('$id', '$nombre', '$pass', 'E')");
    }

    function getUser($id, $pass)
    {
        return $this->row("SELECT * from usuarios where id_usuario = '$id' and contrasenia = '$pass'");
    }
}
