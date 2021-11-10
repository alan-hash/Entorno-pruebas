<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Editorial
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($nombre,$descripcion)
	{
		$sql="INSERT INTO editorial (nombre,descripcion,condicion)
		VALUES ('$nombre','$descripcion','1')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($ideditorial,$nombre,$descripcion)
	{
		$sql="UPDATE editorial SET nombre='$nombre',descripcion='$descripcion' WHERE ideditorial='$ideditorial'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($ideditorial)
	{
		$sql="UPDATE editorial SET condicion='0' WHERE ideditorial='$ideditorial'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($ideditorial)
	{
		$sql="UPDATE editorial SET condicion='1' WHERE ideditorial='$ideditorial'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($ideditorial)
	{
		$sql="SELECT * FROM editorial WHERE ideditorial='$ideditorial'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM editorial";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{
		$sql="SELECT * FROM editorial where condicion=1";
		return ejecutarConsulta($sql);		
	}
}

?>