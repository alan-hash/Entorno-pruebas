<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Estudiante
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($codigo,$dni,$nombre,$carrera,$direccion,$telefono,$email)
	{
		$sql="INSERT INTO estudiante (codigo,dni,nombre,carrera,direccion,telefono,email,condicion)
		VALUES ('$codigo','$dni','$nombre','$carrera','$direccion','$telefono','$email','1')";
		return ejecutarConsulta($sql);
	}


	//Implementamos un método para editar registros
	public function editar($idestudiante,$codigo,$dni,$nombre,$carrera,$direccion,$telefono,$email)
	{
		$sql="UPDATE estudiante SET codigo='$codigo',dni='$dni',nombre='$nombre',carrera='$carrera',direccion='$direccion',telefono='$telefono',email='$email' WHERE idestudiante='$idestudiante'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($idestudiante)
	{
		$sql="UPDATE estudiante SET condicion='0' WHERE idestudiante='$idestudiante'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idestudiante)
	{
		$sql="UPDATE estudiante SET condicion='1' WHERE idestudiante='$idestudiante'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idestudiante)
	{
		$sql="SELECT * FROM estudiante WHERE idestudiante='$idestudiante'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM estudiante";
		return ejecutarConsulta($sql);		
	}

	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{
		$sql="SELECT * FROM estudiante where condicion=1";
		return ejecutarConsulta($sql);		
	}
}

?>