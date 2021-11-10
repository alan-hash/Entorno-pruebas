<?php 

require_once "../modelos/Libro.php";

$libro=new Libro();

$idlibro=isset($_POST["idlibro"])? limpiarCadena($_POST["idlibro"]):"";
$titulo=isset($_POST["titulo"])? limpiarCadena($_POST["titulo"]):"";
$cantidad_disponible=isset($_POST["cantidad_disponible"])? limpiarCadena($_POST["cantidad_disponible"]):"";
$idautor=isset($_POST["idautor"])? limpiarCadena($_POST["idautor"]):"";
$ideditorial=isset($_POST["ideditorial"])? limpiarCadena($_POST["ideditorial"]):"";
$year_edicion=isset($_POST["year_edicion"])? limpiarCadena($_POST["year_edicion"]):"";
$idmateria=isset($_POST["idmateria"])? limpiarCadena($_POST["idmateria"]):"";
$numero_paginas=isset($_POST["numero_paginas"])? limpiarCadena($_POST["numero_paginas"]):"";
$formato=isset($_POST["formato"])? limpiarCadena($_POST["formato"]):"";
$peso=isset($_POST["peso"])? limpiarCadena($_POST["peso"]):"";
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
				move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/libros/" . $imagen);
			}
		}
		if (empty($idlibro)){
			$rspta=$libro->insertar($titulo,$cantidad_disponible,$idautor,$ideditorial,$year_edicion,$idmateria,$numero_paginas,$formato,$peso,$descripcion,$imagen);
			echo $rspta ? "Libro registrado" : "Libro no se pudo registrar";
		}
		else {
			$rspta=$libro->editar($idlibro,$titulo,$cantidad_disponible,$idautor,$ideditorial,$year_edicion,$idmateria,$numero_paginas,$formato,$peso,$descripcion,$imagen);
			echo $rspta ? "Libro actualizado" : "Libro no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$libro->desactivar($idlibro);
 		echo $rspta ? "Libro Desactivado" : "Libro no se puede desactivar";
	break;

	case 'activar':
		$rspta=$libro->activar($idlibro);
 		echo $rspta ? "Libro activado" : "Libro no se puede activar";
	break;

	case 'mostrar':
		$rspta=$libro->mostrar($idlibro);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$libro->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->condicion)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idlibro.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idlibro.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idlibro.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idlibro.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->titulo,
 				"2"=>$reg->cantidad_disponible,
 				"3"=>$reg->autor,
 				"4"=>$reg->editorial,
 				"5"=>$reg->year_edicion,
 				"6"=>$reg->materia,
 				"7"=>$reg->numero_paginas,
 				"8"=>$reg->formato,
 				"9"=>$reg->peso,
 				"10"=>$reg->descripcion,
 				"11"=>"<img src='../files/libros/".$reg->imagen."' height='50px' width='50px' >",
 				"12"=>($reg->condicion)?'<span class="label bg-green">Activado</span>':
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

 case "SelectAutor":
        require_once "../modelos/Autor.php";

            $autor = new Autor();
        $rspta = $autor->select();
        while ($reg = $rspta->fetch_object())
        {
                echo '<option value=' . $reg->idautor . '>' . $reg->nombre . '</option>';
            }   
    break;

case "SelectEditorial":
        require_once "../modelos/Editorial.php";
        $editorial = new Editorial();
        $rspta = $editorial->select();
        while ($reg = $rspta->fetch_object())
        {
                echo '<option value=' . $reg->ideditorial . '>' . $reg->nombre . '</option>';
            }   
    break;

 case "SelectMateria":
        require_once "../modelos/Materia.php";
        $materia = new Materia();
        $rspta = $materia->select();
        while ($reg = $rspta->fetch_object())
        {
                echo '<option value=' . $reg->idmateria . '>' . $reg->nombre . '</option>';
            }   
    break;
  }
?>