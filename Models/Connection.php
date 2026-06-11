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

      // Si existe de una Tabla, Columna.
      static public function getColumnsData($table,$columns)
      {
        $database = Connection::infoDatabase()["database"];
        // Se obtiene todas las columnas de la tabla actual que esta validando.
        $validate = Connection::connect()->query("SELECT COLUMN_NAME AS item FROM information_schema.columns WHERE table_schema = '$database' AND table_name = '$table'")->fetchAll(PDO::FETCH_OBJ);

        if (empty($validate))
        {
          return null;
        }
        else
        {
          // Para mostrar informacion en el "Postman"
          //echo '<pre>';print_r($validate); echo '</pre>'; // Muestra todos los nombres de la columna de las tablas.
          //return;          

          // Validando que las columnas que se mandan en el endpoint corresponda cunado se esta validando.

          // Realizando los ajustes para cuando son "*" es decir cuando se depliegan todos los campos.
          if ($columns[0]=="*")
            {
              array_shift($columns); // Quitando el primer elemento de un arreglo
               
            }
          // Se suman el numero de elementos que contiene en Endpoint, despues de "?" para determinar cuantos parametros se envian.
          $sum = 0;

          //echo '<pre>';print_r($columns); echo '</pre>';          


          foreach ($validate as $key => $value)
            {
              // print_r($value->item = Para mostrar solamente el nombre de la columna
              //echo '<pre>';print_r($value->item); echo '</pre>';              
              //echo '<pre>';print_r(in_array($value->item,$columns)); echo '</pre>';              
              $sum += in_array($value->item,$columns); // Determina si existe la columna en la tabla seleccionada 
                          }

           //echo '<pre>';print_r($sum); echo '</pre>';
           //echo '<pre>';print_r(count($columns)); echo '</pre>';

           // Cuando se retorna "null" es igual a Vacio

          // Compara las columnas ennviadas en el EndPoint con las encontrada en la consulta a la tabla.
           //echo '<pre>';print_r(count($columns)); echo '</pre>';           
           //echo '<pre>';print_r($sum); echo '</pre>';           

          return $sum == count($columns) ? $validate : null;

        }

      }

 } // class Conecction {
  
?>
