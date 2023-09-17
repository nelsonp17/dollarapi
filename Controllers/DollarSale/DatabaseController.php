<?php

namespace Controllers\DollarSale;
use Config\Database;
use Controllers\Utils\Utils;

class DatabaseController extends Database {
    public $utils = new Utils();
    public function __construct(){
        parent::__construct(); // Llama al constructor de la clase padre para establecer la conexión a la base de datos
    }
    
    // Agrega un registro
    public function create(...$data){
        $fecha = $this->utils->currentDate();
        $mysqli = $this->obtenerConexion();
        $query = "INSERT INTO dollar (nombre, precio, updated_at, created_at) VALUES (?, ?, ?, ?)";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("sss", $data[0], $data[1], $fecha, $fecha);
        $stmt->execute();
        $stmt->close();
    }
    
    // Buscar un registro
    public function find($id){
        $mysqli = $this->obtenerConexion();
        $query = "SELECT * FROM dollar WHERE id = ?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        if ($resultado->num_rows === 0) {
            // No se encontró ningún registro con el ID especificado
            return null;
        }
        
        $row = $resultado->fetch_assoc();
        // Accede a los valores del registro encontrado
        $id = $row['id'];
        $name = $row['name'];
        $sale = $row['sale'];
        $updatedAt = $row['updatedAt'];
        $createAt = $row['createAt'];
        
        $stmt->close();
        
        // Realiza las acciones necesarias con los valores encontrados
        // Puedes devolverlos como un arreglo, un objeto, etc.
        return [
            'createAt' => $createAt,
            'updatedAt' => $updatedAt,
            'sale' => $sale,
            'name' => $name,
            'id' => $id,
        ];
    }

    // Leer todos los registros
    public function all(){
        $mysqli = $this->obtenerConexion();
        $query = "SELECT * FROM dollar";
        $resultado = $mysqli->query($query);

        $all = [];
        while ($row = $resultado->fetch_assoc()) {
            // Accede a los valores de cada fila
            $id = $row['id'];
            $name = $row['name'];
            $sale = $row['sale'];
            $updatedAt = $row['updatedAt'];
            $createAt = $row['createAt'];
            // Realiza las acciones necesarias con los valores
            array_push($all, [
                'createAt' => $createAt,
                'updatedAt' => $updatedAt,
                'sale' => $sale,
                'name' => $name,
                'id' => $id,
            ]);
        }
        $resultado->close();
        return $all;
    }
    
    // Actualizar un registro
    public function update($id, $data){
        $mysqli = $this->obtenerConexion();
        $query = "UPDATE dollar SET campo1 = ?, campo2 = ?, campo3 = ? WHERE id = ?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("sssi", $data['campo1'], $data['campo2'], $data['campo3'], $id);
        $stmt->execute();
        $stmt->close();
    }
    
    // Eliminar un registro
    public function delete($id){
        $mysqli = $this->obtenerConexion();
        $query = "DELETE FROM dollar WHERE id = ?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }


    // Cerrar la conexion
    public function __destruct()
    {
        $this->cerrarConexion();
    }
}