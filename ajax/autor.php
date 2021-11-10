<?php 
require_once "../modelos/Autor.php";

$autor=new Autor();

$idautor=isset($_POST["idautor"])? limpiarCadena($_POST["idautor"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";
$imagen=isset($_POST["imagen"])? limpiarCadena($_POST["imagen"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':

		if (!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name']))
		{
			$imagen=$_POST["imagenactual"];
		}
		else 
		{
			$ext = explode(".", $_FILES["imagen"]["name"]);
			if ($_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/png")
			{
				$imagen = round(microtime(true)) . '.' . end($ext);
				move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/autores/" . $imagen);
			}
		}
		if (empty($idautor)){
			$rspta=$autor->insertar($nombre,$descripcion,$imagen);
			echo $rspta ? "Autor registrado" : "Autor no se pudo registrar";
		}
		else {
			$rspta=$autor->editar($idautor,$nombre,$descripcion,$imagen);
			echo $rspta ? "Autor actualizado" : "Autor no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$autor->desactivar($idautor);
 		echo $rspta ? "Autor Desactivado" : "Autor no se puede desactivar";
	break;

	case 'activar':
		$rspta=$autor->activar($idautor);
 		echo $rspta ? "Autor activado" : "Autor no se puede activar";
	break;

	case 'mostrar':
		$rspta=$autor->mostrar($idautor);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$autor->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->condicion)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idautor.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idautor.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idautor.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idautor.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->nombre,
 				"2"=>$reg->descripcion,
 				"3"=>"<img src='../files/autores/".$reg->imagen."' height='50px' width='50px' >",
 				"4"=>($reg->condicion)?'<span class="label bg-green">Activado</span>':
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
 // require 'noacceso.php';
//}
//}
//ob_end_flush();
?>