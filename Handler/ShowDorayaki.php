
<?php
  $dorayaki = new App\Controller\Dorayaki();
  $cntdata = count($dorayaki->readAll());
  for($i = 0; $i < cntdata; $i++){
    $data = $dorayaki-readAll()[$i];
    echo "<tr><td>";
    print_r($data["name"]);
    echo "<tr><td>";
    print_r($data["desc"]);
    echo "<tr><td>";
    print_r($data["price"]);
    echo "<tr><td>";
    print_r($data["stock"]);
  }
?>
