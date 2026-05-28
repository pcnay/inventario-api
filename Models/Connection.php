<?php
  class Connection 
  {
    // Informacion de la Base De Datos
    // "static" = Para que retorne la informacion y se almacena en una variable.
    // Cuando no se escribe la palabra "static" cuando no requiere que almacene, cuando se ejecuta ella funcion y tiene la instruccion "echo" o "include" 
    static public function infoDatabase()
    {
      $infoDB = array (
        "database" => "bd_BaseDatos2",
        "user" => "usuario_basedatos2",
        "pass" => "basedatos2-Mar-05-2025"
      );
      return $infoDB;

    } // static public function infoDatabase()

    static public function Connect()
    {
      try
       {
        /* 
          To connect to a MariaDB database using PHP's PDO (PHP Data Objects), you use the standard mysql driver. Because MariaDB is highly compatible with MySQL, they share the same PDO driver and connection syntax.        
        */

          $link = new PDO ("mysql:host=localhost;dbname=".Connection::infoDatabase()["database"],Connection::infoDatabase()["user"],

          Connection::infoDatabase()["pass"]);

          //$link->exec("set name utf8");

          $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $mitz="America/Tijuana";

          $tz = (new DateTime('now', new DateTimeZone($mitz)))->format('P');

          $link->exec("SET time_zone='$tz';");

          }catch(PDOException $e){

          die ("Error: ".$e->getMessage());

          }

          return $link;

      } // static public function connect(){

      // Validar existencia de una Tabla en la Base de datos.

      // static = Retorna un valor.

      // Si existe la tabla.
      static public function getColumnsData($table)
      {
        $database = Connection::infoDatabase()["database"];
        return Connection::connect()->query("SELECT COLUMN_NAME AS item FROM information_schema.columns WHERE table_schema = '$database' AND table_name = '$table'")->fetchAll(PDO::FETCH_OBJ);
      }

 } // class Conecction {
  
?>
