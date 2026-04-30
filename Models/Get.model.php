<?php
  require_once "Connection.php";
  class GetModel
  {
    // static= El valor se asigna a una variable para que posteriormente sea utilizada
    // Se esta obteniendo los datos de la tabla.
    static public function getData($table,$select)
    {
      $sql = "SELECT $select FROM $table";
      // Preparacion de la sentencia SQL
      // Ejecuta el metodo de conexion a la base de datos y ejecuta el metodo para preparar la ejecucion
      $stmt = Connection::connect()->prepare($sql);
      $stmt->execute();

      // PDO::FETCH_CLASS = Para mostrar los nombres de columna
      return $stmt->fetchAll(PDO::FETCH_CLASS);
      
    } // static public function getData($table)


    // static= El valor se asigna a una variable para que posteriormente sea utilizada
    // Peticiones Get CON filtros
    static public function getDataFilter($table,$select,$linkTo,$equalTo)
    {
      // Para filtrar con varios valores 
      // Tomando de referencia estos valores.
      //$linkTo = "title_course,id_instructor_course";
      //$equalTo = "Desarrollo Web_2";

      // Separando la cadenas por comas como elementos en el arreglo.
      $linkToArray = explode(",",$linkTo); // Contiene los campos a filtrar en la consulta
      $equalToArray = explode("_",$equalTo);
      $linkToText = "";
      //echo '<pre>';print_r($linkToArray); echo'</pre>';
      //echo '<pre>';print_r($equalToArray); echo'</pre>';
      //return;


      // Construyendo la sentencia de forma dinamica 
      // $sql = "SELECT $select FROM $table WHERE $linkTo = :$linkTo";

      if (count($linkToArray)>1)
      {
        foreach ($linkToArray as $key => $value)
        {
          if ($key >0) // Es el indice del arreglo, cuando es > 0 tiene mas de un parametro
          {
            $linkToText .= "AND ".$value." = :".$value." "; // Despues del WHERE y continua con el AND.
          }

        }  

      }
      
      // $linkToArray[0] = contiene el primer elemento del arreglo.
      // Es para el caso de que solo sea un elemento.

      $sql = "SELECT $select FROM $table WHERE $linkToArray[0] = :$linkToArray[0] $linkToText";
      //echo '<pre>';print_r($sql);echo'</pre>';
      //return;

      //:$linkTo = Para pasar el valor de la variable "$linkto"

      // Preparacion de la sentencia SQL
      // Ejecuta el metodo de conexion a la base de datos y ejecuta el metodo para preparar la ejecucion

      // Pasando los valores al "bindParam" para "n" condiciones en la clausula WHERE
      $stmt = Connection::connect()->prepare($sql);
      foreach ($linkToArray as $key => $value)
        {
          $stmt->bindParam(":".$value, $equalToArray[$key], PDO::PARAM_STR); // Para enlazar el parametro "$equalTo"      
        }

      $stmt->execute();

      // PDO::FETCH_CLASS = Para mostrar los nombres de columna
      return $stmt->fetchAll(PDO::FETCH_CLASS);

    } // static public function getDataFilter($table)
                                                                                          

  } // class GetModel

?>
