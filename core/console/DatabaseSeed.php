<?php
  require __DIR__.'/../../vendor/autoload.php';
  include_once(dirname(__FILE__).'/../../config/config.php');
  include_once(dirname(__FILE__).'/../Engine/Database.php');
  include_once(dirname(__FILE__).'/../Engine/Auth.php');

  use Core\Database;


  Database::$db_type=DB_TYPE;
  Database::pdo(MYSQLI_DB_HOST, MYSQLI_DB_USER, MYSQLI_DB_PASS, MYSQLI_DB_NAME);
  Database::mysqli(MYSQLI_DB_HOST, MYSQLI_DB_USER, MYSQLI_DB_PASS, MYSQLI_DB_NAME);

  foreach (glob(dirname(__FILE__).'/../../database/*.php') as $filename)
  {
      include_once $filename;
      $fn=explode('/',$filename);
      $fn=$fn[sizeof($fn)-1];
      $fn=explode('.',$fn)[0];
      $fn = 'Database\\'.$fn;
      $con=new $fn;
      $con->seed();
      echo 'Seed Successful for '.explode('/',$filename)[sizeof(explode('/',$filename))-1].'
      ';
  }
  exit();
?>
