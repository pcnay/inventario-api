<?php
  class Connection 
  {
    // Informacion de la Base De Datos
    // "static" = Para que retorne la informacion y se almacena en una variable.
    // Cuando no se escribe la palabra "static" cuando no requiere que almacene, cuando se ejecuta ella funcion y tiene la instruccion "echo" o "include" 
    static public function infoDatabase()
    {
      $infoDB = array (
        "database" => "bd_BaseDatos1",
        "user" => "usuario_basedatos1",
        "pass" => "basedatos1-Mar-05-2025"
      );
      return $infoDB;

    } // static public function infoDatabase()

    static public function Connect()
    {
      try
       {
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

 } // class Conecction {
  
?>
