<?php
  require_once "Models/Post.model.php";

  class PostController
  {
    // Metodo para crear datos.
    static public function postData($table,$data)
    {
      // Se hace llamado al modelo.
      $response = PostModel::postData($table,$data);
      //echo'<pre>';print_r($response);echo '</pre>';
      //return;
      $return = new PostController;
      $return->fncResponse($response);

    }

    // Se creara un metodo para obtener las respuestas del Controlador en formato JSon.
    // Es lo que mostrara cuando realize la consulta a la base de datos.
    public function fncResponse($response)
    {
      if (!empty($response)) // Si no viene vacia la respuesta "response"
      {
        $json = array(
        'status' => 200,        
        'results' => $response
        );
      } // if (!empty($response))
      else
      {
        $json = array(
        'status' => 400,        
        'results' => "Not Found",
        'method' => 'POST'
        );
      }

      // Modifica las cabeceras de la peticion (En el programa Postman se muestra)
      echo json_encode($json,http_response_code($json["status"])); 
    }



  }

?>
