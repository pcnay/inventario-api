<?php
  require_once "Connection.php";
  class GetModel
  {
    // static= El valor se asigna a una variable para que posteriormente sea utilizada
    // Se esta obteniendo los datos de la tabla.
    static public function getData($table,$select,$orderBy,$orderMode,$startAt,$endAt)
    {
      
      // Sin Ordenar, Limitar datos
      $sql = "SELECT $select FROM $table";


      // Solo para Ordenar.
      //if (($orderBy != null) && ($orderMode != null))

      //Ordenar, pero sin Limitar datos
      if (($orderBy != null) && ($orderMode != null) && ($startAt == null) && ($endAt == null))
      {
        //$sql = "SELECT $select FROM $table ORDER BY $column ASC";
        $sql = "SELECT $select FROM $table ORDER BY $orderBy $orderMode";
      }
      
      // Ordenando y Limitando datos
      if (($orderBy != null) && ($orderMode != null) && ($startAt != null) && ($endAt != null))
      {
        //$sql = "SELECT $select FROM $table ORDER BY $column ASC";
        $sql = "SELECT $select FROM $table ORDER BY $orderBy $orderMode LIMIT $startAt, $endAt";
      }

      // NO se esta Ordenando, pero si se esta Limitando datos .
      if (($orderBy == null) && ($orderMode == null) && ($startAt != null) && ($endAt != null))
      {        
        $sql = "SELECT $select FROM $table LIMIT $startAt, $endAt";
      }


      // Preparacion de la sentencia SQL
      // Ejecuta el metodo de conexion a la base de datos y ejecuta el metodo para preparar la ejecucion
      $stmt = Connection::connect()->prepare($sql);
      $stmt->execute();

      // PDO::FETCH_CLASS = Para mostrar los nombres de columna
      return $stmt->fetchAll(PDO::FETCH_CLASS);
      
    } // static public function getData($table)


    // static= El valor se asigna a una variable para que posteriormente sea utilizada
    // Peticiones Get CON filtros
    static public function getDataFilter($table,$select,$linkTo,$equalTo,$orderBy,$orderMode,$startAt,$endAt)
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
      
      // Sin Ordernar y sin Limitar datos.
      $sql = "SELECT $select FROM $table WHERE $linkToArray[0] = :$linkToArray[0] $linkToText";

      // $linkToArray[0] = contiene el primer elemento del arreglo.
      // Es para el caso de que solo sea un elemento.

      // Ordernar datos, sin Limitar

      if (($orderBy != null) && ($orderMode != null) && ($startAt == null) && ($endAt == null))
      {
        //$sql = "SELECT $select FROM $table WHERE $linkToArray[0] = :$linkToArray[0] $linkToText ORDER BY $column ASC";
        $sql = "SELECT $select FROM $table WHERE $linkToArray[0] = :$linkToArray[0] $linkToText ORDER BY $orderBy $orderMode";
      }

      // Ordernar y Limitar datos
      if (($orderBy != null) && ($orderMode != null) && ($startAt != null) && ($endAt != null))
      {
        $sql = "SELECT $select FROM $table WHERE $linkToArray[0] = :$linkToArray[0] $linkToText ORDER BY $orderBy $orderMode LIMIT $startAt, $endAt";
      }

      // Sin Ordernar y Limitar datos
      if (($orderBy == null) && ($orderMode == null) && ($startAt != null) && ($endAt != null))
      {
        $sql = "SELECT $select FROM $table WHERE $linkToArray[0] = :$linkToArray[0] $linkToText LIMIT $startAt, $endAt";
      }

      
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
                                                                                          
    // static= El valor se asigna a una variable para que posteriormente sea utilizada
    // Se esta obteniendo los datos de la tabla.
    // Sin Filtro Entre Tablas Relacionadas.

    // $response = GetModel::getRelData($rel,$type,$select,$orderBy,$orderMode,$startAt,$endAt); 

    static public function getRelData($rel,$type,$select,$orderBy,$orderMode,$startAt,$endAt)
    {
      $relArray = explode(",",$rel); // Obtiene los campos de la tabla por el cual se relacionan
     //echo '<pre>';print_r($relArray);echo '</pre>';
     // $relArray[0] = Contiene la primer tabla (principal) que se relacionara con la tabla secundario.
     // $relArray[1] = Contiene la segunda tabla (secundaria) que se relacionara con la tabla principal.
      $typeArray = explode(",",$type);
      //echo '<pre>';print_r($typeArray);echo '</pre>';
      //echo '<pre>';print_r(count($relArray));echo'</pre>';

      //return;
      //$typeArray[0] = Es el campo de la tabla principal.
      //$typeArray[1] = Es el campo de la tabla secundaria


      // Construyendo de forma dinamica las relaciones de las tablas.
      $innerJoinText = "";
      if (count($relArray)>1) // Si viene mas tablas que se van a relacionar.
      {
        foreach ($relArray as $key => $value)
        {
          if ($key >0) // Es el indice del arreglo, cuando es > 0 tiene mas de un parametro
          {
            // "$value" = Es el nombre de la tabla que se va a relacionar.
            $innerJoinText .= "INNER JOIN ".$value." ON ".$relArray[0].".id_".$typeArray[$key]."_".$typeArray[0]." = ".$value.".id_".$typeArray[$key]." ";
          }

        }  

      //}


        // Contruyendo la sentencia SQL para empezar a relacionar tablas.
        // Es para una sola relacion.

        // Sin Ordenar, y sin limitar datos Limitar datos.
       $sql = "SELECT $select FROM $relArray[0] $innerJoinText";

       //echo '<pre>';print_r($sql);echo'</pre>'; // Para que muestre el contenido de la consulta en el "endpoint" Postman.
       //return;

        // Solo para Ordenar.
        //if (($orderBy != null) && ($orderMode != null))

        
        //Ordenar, pero sin Limitar datos
        if (($orderBy != null) && ($orderMode != null) && ($startAt == null) && ($endAt == null))
        {
          //$sql = "SELECT $select FROM $table ORDER BY $column ASC";
          $sql = "SELECT $select FROM $relArray[0] $innerJoinText ORDER BY $orderBy $orderMode";
        }
        
        // Ordenando y Limitando datos
        if (($orderBy != null) && ($orderMode != null) && ($startAt != null) && ($endAt != null))
        {
          //$sql = "SELECT $select FROM $table ORDER BY $column ASC";
          $sql = "SELECT $select FROM $relArray[0] $innerJoinText ORDER BY $orderBy $orderMode LIMIT $startAt, $endAt";
        }

        // NO se esta Ordenando, pero si se esta Limitando datos .
        if (($orderBy == null) && ($orderMode == null) && ($startAt != null) && ($endAt != null))
        {        
          $sql = "SELECT $select FROM $relArray[0] $innerJoinText LIMIT $startAt, $endAt";
        }

      

        // Preparacion de la sentencia SQL
        // Ejecuta el metodo de conexion a la base de datos y ejecuta el metodo para preparar la ejecucion
        $stmt = Connection::connect()->prepare($sql);
        $stmt->execute();

        // PDO::FETCH_CLASS = Para mostrar los nombres de columna
        return $stmt->fetchAll(PDO::FETCH_CLASS);
      }else
      {
        return null;

      }
      
    } // static public function getData($table)


  } // class GetModel

?>
