<?php

namespace App;

class Propiedad
{
    //BD
    protected static $db;
    //Para poder iterarlos y sanitizar automáticamente
    protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'estacionamiento', 'crado', 'vendedorId'];

    //forma anterior a php8
    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitaciones;
    public $wc;
    public $estacionamiento;
    public $creado;
    public $vendedorId;


    //Definir conexión a la BD
    public static function setDB($database)
    {
        //referencia a atributos estáticos
        self::$db = $database;
    }

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? '';
        $this->titulo = $args['titulo'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? 'imagen.jpg';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->creado = date('Y/m/d');
        $this->vendedorId = $args['vendedorId'] ?? '';
    }

    public function guardar()
    {
        //Sanitizar entrada de datos
        $atributos = $this->sanitizarDatos();

        //Insertar en la BD
        $query = "INSERT INTO propiedades (titulo, precio, imagen, descripcion, habitaciones, wc, estacionamiento, creado, vendedorId) 
               VALUES('$this->titulo', $this->precio, '$this->imagen', '$this->descripcion', $this->habitaciones, $this->wc, $this->estacionamiento, '$this->creado', $this->vendedorId)";

        $resultado = self::$db->query($query);
        debuguear($resultado);
    }

    //Identifica y une los atributos de la BD
    public function atributos()
    {
        //itera sobre columnasDB
        $atributos = [];
        foreach (self::$columnasDB as $columna) {
            if ($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    public function sanitizarDatos()
    {
        //Sanitiza los datos
        $atributos = $this->atributos();
        $sanitizado = [];

        foreach ($atributos as $key => $value) {
            $sanitizado[$key] = self::$db->escape_string($value);
        }
        return $sanitizado;
    }
}
