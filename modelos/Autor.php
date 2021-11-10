<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Autor
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($nombre,$descripcion,$imagen)
	{
		$sql="INSERT INTO autor (nombre,descripcion,imagen,condicion)
		VALUES ('$nombre','$descripcion','$imagen','1')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idautor,$nombre,$descripcion,$imagen)
	{
		$sql="UPDATE autor SET nombre='$nombre',descripcion='$descripcion',imagen='$imagen' WHERE idautor='$idautor'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($idautor)
	{
		$sql="UPDATE autor SET condicion='0' WHERE idautor='$idautor'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idautor)
	{
		$sql="UPDATE autor SET condicion='1' WHERE idautor='$idautor'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idautor)
	{
		$sql="SELECT * FROM autor WHERE idautor='$idautor'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM autor";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{
		$sql="SELECT * FROM autor where condicion=1";
		return ejecutarConsulta($sql);		
	}
}

?>