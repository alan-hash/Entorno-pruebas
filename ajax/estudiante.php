<?php 
require_once "../modelos/Estudiante.php";

$estudiante=new Estudiante();

$idestudiante=isset($_POST["idestudiante"])? limpiarCadena($_POST["idestudiante"]):"";
$codigo=isset($_POST["codigo"])? limpiarCadena($_POST["codigo"]):"";
$dni=isset($_POST["dni"])? limpiarCadena($_POST["dni"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$carrera=isset($_POST["carrera"])? limpiarCadena($_POST["carrera"]):"";
$direccion=isset($_POST["direccion"])? limpiarCadena($_POST["direccion"]):"";
$telefono=isset($_POST["telefono"])? limpiarCadena($_POST["telefono"]):"";
$email=isset($_POST["email"])? limpiarCadena($_POST["email"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idestudiante)){
			$rspta=$estudiante->insertar($codigo,$dni,$nombre,$carrera,$direccion,$telefono,$email);
			echo $rspta ? "Estudiante registrado" : "Estudiante no se pudo registrar";
		}
		else {
			$rspta=$estudiante->editar($idestudiante,$codigo,$dni,$nombre,$carrera,$direccion,$telefono,$email);
			echo $rspta ? "Estudiante actualizado" : "Estudiante no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$estudiante->desactivar($idestudiante);
 		echo $rspta ? "Estudiante Desactivado" : "Estudiante no se puede desactivar";
	break;

	case 'activar':
		$rspta=$estudiante->activar($idestudiante);
 		echo $rspta ? "Estudiante activado" : "Estudiante no se puede activar";
	break;

	case 'mostrar':
		$rspta=$estudiante->mostrar($idestudiante);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$estudiante->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->condicion)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idestudiante.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idestudiante.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idestudiante.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idestudiante.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->codigo,
 				"2"=>$reg->dni,
 				"3"=>$reg->nombre,
 				"4"=>$reg->carrera,
 				"5"=>$reg->direccion,
 				"6"=>$reg->telefono,
 				"7"=>$reg->email,
 				"8"=>($reg->condicion)?'<span class="label bg-green">Activado</span>':
 				'<span class="label bg-red">Desactivado</span>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;
///}
//Fin de las validaciones de acceso
//}
//else
//{
 // require 'noacceso.php';
//}
}
//ob_end_flush();
?>