<?php

  require_once "Models/Connection.php";
  require_once "Controllers/Post.controller.php";

  if (isset($_POST))
  {

    // $table = Viene desde "Route.php" es paso atraves de paso de funcion a funcion.
    // $columns = Se obtendra desde las propiedades del formulario

    $columns = array(); // Se crea el arreglo para los nombres de las columnas
    foreach (array_keys($_POST) as $key => $value)
    {
      array_push($columns,$value); // Para agregar elementos al arreglo.      
    }

    //echo '<pre>';print_r($columns);echo'</pre>';
    //return;


    // Validar si existe la tabla y las columnas. 
    //Connection::getColumnsData($table,$columns);
    //echo '<pre>';print_r(Connection::getColumnsData($table,$columns));echo'</pre>';
    if (empty(Connection::getColumnsData($table,$columns)))
    {
      $json = array(
        'status' => 400,
        'result' => "Error Fields in the form do not match the database"
      );
      echo json_encode($json,http_response_code($json["status"]));
      return;
    }

    // Solicitamos respuesta del controlador para crear datos para cualquier tabla.

    $response = new PostController();
    $response->postData($table,$_POST);


  } // if (isset($_POST))

?>
