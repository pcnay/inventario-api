<?php
  class RoutesController 
  {
    // Ruta Principal

    // Cuando el metodo NO es estatico se dispara automatiamente. 
    public function index()
    {
      include "Routes/Route.php";
    }
  }
?>