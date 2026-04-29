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
      $linkTo = "title_course,id_instructor_course";
      $equalTo = "Desarrollo Web_2";

      // Separando la cadenas por comas como elementos en el arreglo.
      $linkToArray = explode(",",$linkTo);
      $equalToArray = explode("_",$equalTo);
      

      $sql = "SELECT $select FROM $table WHERE $linkTo = :$linkTo";

      //:$linkTo = Para pasar el valor de la variable "$linkto"

      // Preparacion de la sentencia SQL
      // Ejecuta el metodo de conexion a la base de datos y ejecuta el metodo para preparar la ejecucion

      $stmt = Connection::connect()->prepare($sql);
        $stmt->bindParam(":".$linkTo, $equalTo, PDO::PARAM_STR); // Para enlazar el parametro "$equalTo"      
        $stmt->execute();

        // PDO::FETCH_CLASS = Para mostrar los nombres de columna
        return $stmt->fetchAll(PDO::FETCH_CLASS);

    } // static public function getDataFilter($table)
                                                                                          

  } // class GetModel

?>
