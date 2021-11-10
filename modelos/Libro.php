<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Libro
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($titulo,$cantidad_disponible,$idautor,$ideditorial,$year_edicion,$idmateria,$numero_paginas,$formato,$peso,$descripcion,$imagen)
	{
		$sql="INSERT INTO libro (titulo,cantidad_disponible,idautor,ideditorial,year_edicion,idmateria,numero_paginas,formato,peso,descripcion,imagen,condicion)
		VALUES ('$titulo','$cantidad_disponible','$idautor','$ideditorial','$year_edicion','$idmateria','$numero_paginas','$formato','$peso','$descripcion','$imagen','1')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idlibro,$titulo,$cantidad_disponible,$idautor,$ideditorial,$year_edicion,$idmateria,$numero_paginas,$formato,$peso,$descripcion,$imagen)
	{
		$sql="UPDATE libro SET titulo='$titulo',cantidad_disponible='$cantidad_disponible',idautor='$idautor',ideditorial='$ideditorial',year_edicion='$year_edicion',idmateria='$idmateria',numero_paginas='$numero_paginas',formato='$formato',peso='$peso',descripcion='$descripcion',imagen='$imagen' WHERE idlibro='$idlibro'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar registros
	public function desactivar($idlibro)
	{
		$sql="UPDATE libro SET condicion='0' WHERE idlibro='$idlibro'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar registros
	public function activar($idlibro)
	{
		$sql="UPDATE libro SET condicion='1' WHERE idlibro='$idlibro'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idlibro)
	{
		$sql="SELECT * FROM libro WHERE idlibro='$idlibro'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT l.idlibro,l.titulo,l.cantidad_disponible,l.idautor,a.nombre as autor,l.ideditorial,e.nombre as editorial,l.year_edicion,l.idmateria,m.nombre as materia,l.numero_paginas,l.formato,l.peso,l.descripcion,l.imagen,l.condicion FROM libro l INNER JOIN autor a on l.idautor=a.idautor INNER JOIN editorial e ON l.ideditorial=e.ideditorial INNER JOIN materia m ON l.idmateria=m.idmateria";
		return ejecutarConsulta($sql);		
	}

	public function select()
        {
         $sql="SELECT * FROM libro WHERE condicion='1'";
         return ejecutarConsulta($sql);
        }

}

?>