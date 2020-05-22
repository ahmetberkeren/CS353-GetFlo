<?php include "templates/header.php";
require "../config.php";
require "../common.php";
session_start(); ?>
<?php
if(isset($_POST['back'])) {
    header("Location: ./customermainpage.php");
}
?>
<?php
$connection = new PDO($dsn, $username, $password, $options);

$sql = "Select * From flowers NATURAL JOIN seller_has Where flowerID = :flowerID";

$tmpID = $_GET['flowerid'];

$statement = $connection->prepare($sql);
$statement->bindParam(':flowerID', $tmpID, PDO::PARAM_STR);
$statement->execute();

$result = $statement->fetchAll();
foreach ($result as $row)
    $amount = $row['seller_stock'];
?>
<?php
if (isset($_POST['submitBuy']) && $_POST['orderamount'] > $amount) {
    echo "Not enough flower!";
}
else if (isset($_POST['submitBuy'])) {
    $connection = new PDO($dsn, $username, $password, $options);

    $new_order = array(
        "payment_type" => $_POST['orderpayment'],
        "delivery_address"  => $_POST['orderaddress'],
        "delivery_type"     => $_POST['orderdelivery'],
        "note"       => $_POST['ordernote'],
        "status" => "Sent to Seller",
        "is_accepted"      => 0,
        "order_time" => date("Y-m-d")
    );

    $sql = sprintf(
        "INSERT INTO %s (%s) values (%s)",
        "orders",
        implode(", ", array_keys($new_order)),
        ":" . implode(", :", array_keys($new_order))
    );

    $statement = $connection->prepare($sql);
    $statement->execute($new_order);

    $sql = "Update seller_has Set seller_stock = :amount Where flowerID = :flowerID";

    $new_amount = $amount - $_POST['orderamount'];
    $tmpID = $_GET['flowerid'];

    $statement = $connection->prepare($sql);
    $statement->bindParam(':amount', $new_amount, PDO::PARAM_STR);
    $statement->bindParam(':flowerID', $tmpID, PDO::PARAM_STR);
    $statement->execute();

    $sql = "Select MAX(orderID) AS 'orderID' From orders";

    $statement = $connection->prepare($sql);
    $statement->execute();

    $result = $statement->fetchAll();
    foreach ($result as $row)
        $tmporderID = $row['orderID'];

    $sql = "Select * From seller_has WHERE flowerID = :flowerID";

    $tmpID = $_GET['flowerid'];

    $statement = $connection->prepare($sql);
    $statement->bindParam(':flowerID', $tmpID, PDO::PARAM_STR);
    $statement->execute();

    $result = $statement->fetchAll();
    foreach ($result as $row)
        $tmpID = $row['sellerID'];

    $sql = "INSERT INTO is_assigned(orderID, sellerID, customerID) VALUES (:orderID, :sellerID, :customerID)";
    $tmpcustomerID = $_SESSION['accountID'];
    $statement = $connection->prepare($sql);
    $statement->bindParam(':orderID', $tmporderID, PDO::PARAM_STR);
    $statement->bindParam(':sellerID', $tmpID, PDO::PARAM_STR);
    $statement->bindParam(':customerID', $tmpcustomerID, PDO::PARAM_STR);
    $statement->execute();


    header("Location: ./customermainpage.php");
}
?>
    <h2>Create Order</h2>

    <form method="post">
        <label for="orderamount">Amount</label>
        <input type="text" name="orderamount" id="orderamount">
        <label for="orderaddress">Address</label>
        <input type="text" name="orderaddress" id="orderaddress">
        <label for="orderpayment">Payment Type</label>
        <input type="text" name="orderpayment" id="orderpayment">
        <label for="orderdelivery">Delivery Type</label>
        <input type="text" name="orderdelivery" id="orderdelivery">
        <label for="ordernote">Note</label>
        <input type="text" name="ordernote" id="ordernote">
        <input type="submit" name="submitBuy" value="Buy">
    </form>
<form method="post">
    <li>
        <input type="submit" name="back"
               class="button" value="Cancel" /></li>
</form>

<?php include "templates/footer.php"; ?>
