<?php
  // phpinfo();
  require_once "Controllers/Route.controller.php";
  require_once "Models/Connection.php";

  /*

    echo '<pre>'; print_r(Connection::infoDatabase());echo '</pre>';
    echo '<pre>'; print_r(Connection::infoDatabase()["database"]);echo '</pre>';
    echo '<pre>'; print_r(Connection::infoDatabase()["user"]);echo '</pre>';
    echo '<pre>'; print_r(Connection::infoDatabase()["pass"]);echo '</pre>';

    echo '<pre>'; print_r(Connection::Connect());echo '</pre>';

  */

  $index = new RoutesController();
  $index->index(); // Se dispara autoamticamente porque no es un metodo "Estatico" 

?>
