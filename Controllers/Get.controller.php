<?php
  require_once("Models/Get.model.php");
  class GetController
  {
    // Metodo para retornar informacion que devuelva el modelo.
    // Static = Se asigna a una variable para posteriormente se reutilizada
    // Peticiones "Get" SIN Filtro
    static public function getData($table,$select,$orderBy,$orderMode,$startAt,$endAt)
    {
      // Instanciando la clase "GetModel", para llamar al metodo "getData"
      $response = GetModel::getData($table,$select,$orderBy,$orderMode,$startAt,$endAt);

      //return $response;
      $return = new GetController();
      $return->fncResponse($response);

      
    } // function getData($table,$select)

    // Peticiones "Get" CON Filtro
    static public function getDataFilter($table,$select,$linkTo,$equalTo,$orderBy,$orderMode,$startAt,$endAt)
    {
      // Instanciando la clase "GetModel", para llamar al metodo "getData"
      $response = GetModel::getDataFilter($table,$select,$linkTo,$equalTo,$orderBy,$orderMode,$startAt,$endAt);
      //echo '<pre>';print_r($response); echo'</pre>';
      //return;


      //return $response;
      $return = new GetController();
      $return->fncResponse($response);

      
    } // function getData($table,$select)

    
    // Se creara un metodo para obtener las respuestas del Controlador en formato JSon.
    // Es lo que mostrara cuando realize la consulta a la base de datos.
    public function fncResponse($response)
    {
      if (!empty($response)) // Si no viene vacia la respuesta "response"
      {
        $json = array(
        'status' => 200,
        'total' => count($response),
        'results' => $response
        );
      } // if (!empty($response))
      else
      {
        $json = array(
        'status' => 400,        
        'results' => "Not Found"
        );
      }

      echo json_encode($json,http_response_code($json["status"])); 
    }

  } // Class GetController 


?>
