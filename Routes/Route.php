<?php

    // Para obtener el nombre del dominio 
    //$routeArray = $_SERVER['HTTP_HOST'];
    //echo '<pre>'; print_r($routeArray); echo'</pre>';

    // Para obtener el nombre despues del dominio 
    //$routeArray = $_SERVER['REQUEST_URI'];
    //echo '<pre>'; print_r($routeArray); echo'</pre>';

    // Separando la cadena que obtiene
    $routeArray = explode ('/',$_SERVER['REQUEST_URI']);
    // Quitando los arreglos vacios.
    // echo '<pre>'; print_r(array_filter($routeArray)); echo'</pre>';

    $parametros_url = count(array_filter($routeArray));

    // =======================================
    // Cuando no se hace ninguna peticion a la API
    // =========================================
    if ($parametros_url === 0)
    {
      $json = array (
      'status' => 400,
      'result' => "Not Found"
        );
       // El arreglo lo convierte a forma JSon.
       // Que son los valores que se utilizan en las APIs.
      echo json_encode($json,http_response_code("404"));  
      return;
    }

    // echo '<pre>';print_r($_SERVER['REQUEST_METHOD']);echo'</pre>';

    // Cuando se hacen peticiones a la API
    if (($parametros_url == 1) && ($_SERVER['REQUEST_METHOD']))
      {
        // Se empieza a usar las protocolos HTTP.
 
        // Obteniendo la "tabla"
        $table = explode("/",$routeArray[1])[0];
        //echo'</pre>';print_r($tabla);echo'</pre>';
        //return;


        // ===> Peticiones GET
        if ($_SERVER['REQUEST_METHOD'] == "GET" )
          {
            // Es como se vincula El servicio de GET con el de "Routes"
            include "Services/Get.php";

          } // if ($_SERVER['REQUEST_METHOD'] == "GET" )
          
        // ===> Peticiones POST
        if ($_SERVER['REQUEST_METHOD'] == "POST" )
          {
            include "Services/Post.php";

            /*
            $json = array (
              'status' => 200,
              'result' => "Solicitud POST"
                );
              // El arreglo lo convierte a forma JSon.
              // Que son los valores que se utilizan en las APIs.
              echo json_encode($json,http_response_code("200"));          
            */

          } // if ($_SERVER['REQUEST_METHOD'] == "POST" )

        // ===> Peticiones PUT
        if ($_SERVER['REQUEST_METHOD'] == "PUT" )          
          {
            $json = array (
              'status' => 200,
              'result' => "Solicitud PUT"
                );
              // El arreglo lo convierte a forma JSon.
              // Que son los valores que se utilizan en las APIs.
              echo json_encode($json,http_response_code("200"));          
          } // if ($_SERVER['REQUEST_METHOD'] == "PUT" )

        // ===> Peticiones DELETE
        if ($_SERVER['REQUEST_METHOD'] == "DELETE" )          
          {
            $json = array (
              'status' => 200,
              'result' => "Solicitud DELETE"
                );
              // El arreglo lo convierte a forma JSon.
              // Que son los valores que se utilizan en las APIs.
              echo json_encode($json,http_response_code("200"));          
          } // if ($_SERVER['REQUEST_METHOD'] == "DELETE" )


      } // if (($parametros_url == 1) && ($_SERVER['REQUEST_METHOD']))
    
?>
