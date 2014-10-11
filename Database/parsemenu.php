<?php
  function getDBConnection() { #connects to sql database
    try {
      $pdo = new PDO("mysql:host=localhosy;dbname=BURGERBAR", 
        "root", "3.00x10^8m/s");
    }

    catch (PDOException $e) {
      $response = "Failed to connect: ";
      $response .= $e->getMessage();
      die($response);
    }

    echo "Successfully connected to BurgerBar Database!<br><br>";
    return $pdo;
  }

  function getMenuItems($file_name) { #parses menu in json format
    $json = file_get_contents($file_name);
    $jsonIter = new RecursiveIteratorIterator(
      new RecursiveArrayIterator(json_decode($json, TRUE)),
      RecursiveIteratorIterator::SELF_FIRST);
    return $jsonIter;
  }

  function prepareStatement($pdo, $table, $type, $id, $info) {
    $statment = $pdo->prepare(
      "INSERT INTO :table
      (:type, name, price)
      VALUES
      (:id, :name, :price)"
    );
    $statement->bindParam(':table', $table);
    $statement->bindParam(':type', $type);
    $statement->bindParam(':id', $id);
    $statement->bindParam(':name', $info['name']);
    $statement->bindParam(':price', $info['price']);
  }

  function buildItemInfo($pdo, $jsonIter) {
    foreach ($jsonIter as $key => $val) {
      if (is_array($val)) {
        if($key === 'meats') {
          $type = 'meat_id';
          foreach ($val as $id=> $info) {
            prepareStatement($pdo, $key, $type, $id, $info);
          }
        }
      }
    }
  }
       
  function printMenu($jsonIter) {
    foreach ($jsonIter as $key => $val) {
      if (is_array($val)) {
        echo "$key:<br>";
      } else {
          echo "$key => $val<br>";
      }
    }
  }

  $menu_loc = "/var/www/html/CSE_3330/BurgerBarRepo/BurgerBar/menu.json";
  $menu = getMenuItems($menu_loc);
  buildItemInfo($menu);
  #printMenu($menu);
?>
