<?php include "templates/header.php";
require "../config.php";
require "../common.php";
session_start(); ?>
<?php
if (isset($_POST['submitAdd'])) {
    $connection = new PDO($dsn, $username, $password, $options);
$id = $_SESSION['accountID'];
    $new_order = array(
        "name" => $_POST['name'],
	"growerID"  => $id,
        "scent"  => $_POST['scent'],
        "colour"     => $_POST['colour'],
        "price"       => $_POST['price'],
        "photo" =>  $_POST['photo'],
	"kind" =>  $_POST['kind'],
        "amount"      => $_POST['amount'],
        "details" => $_POST['details']
    );

    $sql = sprintf(
        "INSERT INTO %s (%s) values (%s)",
        "flowers",
        implode(", ", array_keys($new_order)),
        ":" . implode(", :", array_keys($new_order))
    );

    $statement = $connection->prepare($sql);
    $statement->execute($new_order);

    $sql = "Select MAX(flowerID) AS 'flowerID' From flowers";

    $statement = $connection->prepare($sql);
    $statement->execute();

    $result = $statement->fetchAll();
    foreach ($result as $row)
        $tmpfloID = $row['flowerID'];

    $sql = "INSERT INTO grower_has (grower_stock) VALUES (:amount)";
    $tmp1 = $_POST['amount'];
    $statement = $connection->prepare($sql);
    $statement->bindParam(':amount', $tmp1, PDO::PARAM_STR);

    $statement->execute();

    $sql = "INSERT INTO grower_has(growerID, flowerID) VALUES (:growerID, :flowerID)";
    $tmpcustomerID = $_SESSION['accountID'];
    $statement = $connection->prepare($sql);
    $statement->bindParam(':flowerID', $tmpfloID, PDO::PARAM_STR);
    $statement->bindParam(':growerID', $tmpcustomerID, PDO::PARAM_STR);
    $statement->execute();

    header("Location: ./growermainpage.php");
}
?>
    <h2>Add Flower</h2>

    <form method="post">
        <label for="name">Name</label>
        <input type="text" name="name" id="name">

        <label for="scent">Scent</label>
        <input type="text" name="scent" id="scent">

        <label for="colour">Colour</label>
        <input type="text" name="colour" id="colour">

        <label for="price">Price</label>
        <input type="text" name="price" id="price">

        <label for="photo">Photo</label>
        <input type="text" name="photo" id="Photo">

	<label for="kind">Kind</label>
        <input type="text" name="kind" id="kind">

	<label for="amount">Amount</label>
        <input type="text" name="amount" id="amount">

	<label for="details">Details</label>
        <input type="text" name="details" id="details">

        <input type="submit" name="submitAdd" value="Add">
    </form>


<?php include "templates/footer.php"; ?>
