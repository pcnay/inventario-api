<?php
  require_once "Models/Post.model.php";

  class PostController
  {
    // Metodo para crear datos.
    static public function postData($table,$data)
    {
      // Se hace llamado al modelo.
      $response = PostModel::postData($table,$data);
      echo'<pre>';print_r($response);echo '</pre>';
      return;

    }
  }
?>
