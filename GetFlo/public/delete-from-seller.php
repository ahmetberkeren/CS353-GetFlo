<?php
require "../config.php";
require "../common.php";
if (isset($_GET["id"])) {
  try {
    $connection = new PDO($dsn, $username, $password, $options);

    $id = $_GET["id"];

    $sql = "DELETE FROM seller_has WHERE flowerID = :id";

    $statement = $connection->prepare($sql);
    $statement->bindValue(':id', $id);
    $statement->execute();

    $success = "Flower successfully removed";
  } catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
  }
}

?>
<?php if ($success) echo $success; ?>
<a href="sellermainpage.php">Back</a>