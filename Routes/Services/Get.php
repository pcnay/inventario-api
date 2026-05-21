<?php
  require_once("Controllers/Get.controller.php");
  //echo '<pre>';print_r($routeArray[1]);echo '</pre>';
  $table = explode("?",$routeArray[1])[0];
    // Se realiza esta modificacion en la variable "$table"
  //Ya que $table viene todo despues del "/" en en este caso es "Tproducts?select=id_product,name_product", por lo que se tiene que separar para obtener la "tabla" y el "select"

  //echo '<pre>';print_r($table);echo '</pre>';
  //return;


  // $_GET["seelct"] ?? "*"; = Si no se envia la super variable global "GET", el valor por defecto es "*"
  $select = $_GET["select"] ?? "*";

  // Determinando si tiene la instruccion "orderBy" y "orderMode"
  $orderBy = $_GET["orderBy"] ?? null;
  $orderMode = $_GET["orderMode"] ?? null;

  // Se agregan esta lineas para el caso de que se quiera limitar las consultas
  $startAt = $_GET["startAt"] ?? null;
  $endAt = $_GET["endAt"] ?? null;


  // Esta tabla se tiene que enviar al "Controllers"
  // Se va a instanciar para ejecutar un metodo.

  // $response = GetController::getData($table);
  $response = new GetController();

  // Se comenzara a seleccionar los controladores dependiendo si se va usar filtros (Where) en la peticion de la API
  // Verificando si viene la variable Global "linkTo" y "equalTo"
  // Peticions "Get" con Filtro
  // Se agrega el codigo && (!isset($_GET["rel"])) && (!isset($_GET["type"])) para el caso de que se este manejando tablas relacionadas con filtros.
  if (isset($_GET["linkTo"]) && isset($_GET["equalTo"]) && (!isset($_GET["rel"])) && (!isset($_GET["type"])))
  {
     $response->getDataFilter($table,$select,$_GET["linkTo"],$_GET["equalTo"],$orderBy,$orderMode,$startAt,$endAt);     
  }
    // Peticiones "GET" SIN Filtro entre tablas relacionadas.
    // "type" = Es el subfijo para las tablas, para hacerlo dinamico las relaciones.
  else if ( ($table == "relations") && (isset($_GET["rel"])) && (isset($_GET["type"])) && (!isset($_GET["linkTo"])) && (!isset($_GET["equalTo"])) )
  {
    $response->getRelData($_GET["rel"],$_GET["type"],$select,$orderBy,$orderMode,$startAt,$endAt);

  }
   // Peticiones "GET" CON Filtro entre tablas relacionadas.
   // "type" = Es el subfijo para las tablas, para hacerlo dinamico las relaciones.
  else if ( ($table == "relations") && (isset($_GET["rel"])) && (isset($_GET["type"])) && (isset($_GET["linkTo"])) && (isset($_GET["equalTo"])) )
  { 
    $response->getRelDataFilter($_GET["rel"],$_GET["type"],$select,$_GET["linkTo"],$_GET["equalTo"],$orderBy,$orderMode,$startAt,$endAt);
  }

  // Peticiones Get para el buscador SIN relaciones 
  else if((!isset($_GET["rel"])) && (!isset($_GET["type"])) &&(isset($_GET["linkTo"])) && (isset($_GET["search"])))
  {
    $response->getDataSearch($table,$select,$_GET["linkTo"],$_GET["search"],$orderBy,$orderMode,$startAt,$endAt);
  }
  // Peticiones Get para el Buscador CON relaciones 
  else if(($table == "relations") && (isset($_GET["rel"])) && (isset($_GET["type"])) && (isset($_GET["linkTo"])) && (isset($_GET["search"])))
  {
    $response->getRelDataSearch($_GET["rel"],$_GET["type"],$select,$_GET["linkTo"],$_GET["search"],$orderBy,$orderMode,$startAt,$endAt);
  }


  // Peticion Get sin Filtro
  else 
    {
      $response->getData($table,$select,$orderBy,$orderMode,$startAt,$endAt);
    }
  
  ?>

