<?php

namespace Config;
use mysqli;

class Database {
    private $host = db_host;
    private $usuario = db_user;
    private $contrasena = db_password;
    private $nombreBaseDatos = db_name;

    protected $conexion;

    public function __construct() {
        $this->conexion = new mysqli($this->host, $this->usuario, $this->contrasena, $this->nombreBaseDatos);

        if ($this->conexion->connect_error) {
            die("Error al conectar a la base de datos: " . $this->conexion->connect_error);
        }
    }

    public function obtenerConexion() {
        return $this->conexion;
    }

    public function cerrarConexion() {
        $this->conexion->close();
    }
}
/**
* Uso de la conexión
*$conexion = new Conexion();
*$mysqli = $conexion->obtenerConexion();

* Ejemplo de consulta
*$query = "SELECT * FROM tabla_ejemplo";
*$resultado = $mysqli->query($query);

*if ($resultado->num_rows > 0) {
*    while ($fila = $resultado->fetch_assoc()) {
*        echo "ID: " . $fila["id"] . ", Nombre: " . $fila["nombre"] . "<br>";
*    }
*} else {
*    echo "No se encontraron resultados.";
*}
*
*Cerrar la conexión
*$conexion->cerrarConexion();**/
