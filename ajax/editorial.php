<?php 

require_once "../modelos/Editorial.php";

$editorial=new editorial();

$ideditorial=isset($_POST["ideditorial"])? limpiarCadena($_POST["ideditorial"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($ideditorial)){
			$rspta=$editorial->insertar($nombre,$descripcion);
			echo $rspta ? "Editorial registrada" : "Editorial no se pudo registrar";
		}
		else {
			$rspta=$editorial->editar($ideditorial,$nombre,$descripcion);
			echo $rspta ? "Editorial actualizada" : "Editorial no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$editorial->desactivar($ideditorial);
 		echo $rspta ? "Editorial Desactivada" : "Editorial no se puede desactivar";
	break;

	case 'activar':
		$rspta=$editorial->activar($ideditorial);
 		echo $rspta ? "Editorial activada" : "Editorial no se puede activar";
	break;

	case 'mostrar':
		$rspta=$editorial->mostrar($ideditorial);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$editorial->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->condicion)?'<button class="btn btn-warning" onclick="mostrar('.$reg->ideditorial.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->ideditorial.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->ideditorial.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->ideditorial.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->nombre,
 				"2"=>$reg->descripcion,
 				"3"=>($reg->condicion)?'<span class="label bg-green">Activado</span>':
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
}
//Fin de las validaciones de acceso
//}
//else
//{
//  require 'noacceso.php';
//}
//}
//ob_end_flush();
?>