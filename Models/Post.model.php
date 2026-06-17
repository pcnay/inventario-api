<?php
  require_once "Connection.php";

  class PostModel
  {
    // Grabando los datos de forma dinamica
    static public function postData($table,$data)
    {
      //echo '<pre>';print_r($table);echo'</pre>';
      //echo '<pre>';print_r($data);echo'</pre>';
      //return;


      // Obtiene las columnas de cualquier tabla.
      $columns = "";
      $params = "";
      // $key = Nombre de propiedad de las columnas (Son las columnas de la tabla)

      foreach ($data as $key => $value)
      {
        $columns .= $key.","; // Almacena los nombres de columnas de la tabla
        $params .= ":".$key.","; // Es el valor de la columna de la tabla
      }

      // Eliminando la ultima coma de la cadena de "$columns"
      // 0 = Que no tome encuenta el inicio
      // -1 = Elimine el ultimo caracter de la cadena.
      $columns = substr($columns,0,-1);
      $params = substr($params,0,-1);

      //echo "<pre>";print_r($columns);echo"</pre>";
      //echo "<pre>";print_r($params);echo"</pre>";
      //return;

      // Creando la sentencia INSERT de forma dinamica.
      $sql = "INSERT INTO $table ($columns) VALUES ($params)";
      //echo "<pre>";print_r($sql);echo"</pre>";
      //return;
      

      $link = Connection::connect(); // Establece la conexion.
      $stmt = $link->prepare($sql);
                        
      //echo"<pre>";print_r($data);echo "</pre>";
      //return;
          
      //foreach($data as $key => &$value) // Funciona tambien
      foreach($data as $key => $value)
      {
        // Enlazando los parametros en Bind de forma dinamica
        //echo"<pre>";print_r($key);echo"</pre>";
        //echo"<pre>";print_r($value);echo"</pre>";
        // $stmt->bindParam(":".$key, $value, PDO::PARAM_STR); // Funciona tambien
        $stmt->bindParam(":".$key, $data[$key], PDO::PARAM_STR);
        

        //echo"<pre>";print_r($stmt);echo"</pre>";
      }
      
      //$stmt->debugDumpParams();
      //return;

      //echo "<pre>";print_r($stmt);echo"</pre>";
      //return;

      if ($stmt->execute()) 
      {
 				$stmt->closeCursor();
				$stmt=null;

        $response = array(
          "lastId" => $link->lastInsertId(),
          "comment" => "The process was successful "
        );
        return $response;
      }
      else
      {
 				$stmt->closeCursor();
				$stmt=null;

        return Connection::connect()->errorInfo();

      }

    } // static public function postData($table,$data)

  }
?>
