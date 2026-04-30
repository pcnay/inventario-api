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

  // Esta tabla se tiene que enviar al "Controllers"
  // Se va a instanciar para ejecutar un metodo.

  // $response = GetController::getData($table);
  $response = new GetController();

  // Se comenzara a seleccionar los controladores dependiendo si se va usar filtros (Where) en la peticion de la API
  // Verificando si viene la variable Global "linkTo" y "equalTo"
  // Peticions "Get" con Filtro
  if (isset($_GET["linkTo"]) && isset($_GET["equalTo"]))
  {
     $response->getDataFilter($table,$select,$_GET["linkTo"],$_GET["equalTo"]);
  }
  // Peticion Get sin Filtro
  else 
    {
      $response->getData($table,$select);
    }
  
  ?>

