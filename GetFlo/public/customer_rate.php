<?php include "templates/header.php";
require "../config.php";
require "../common.php";
session_start(); ?>
<?php
if (isset($_POST['finish'])) {
    try {
        $connection = new PDO($dsn, $username, $password, $options);

        $tmpID = $_GET['orderid'];

        $sql = "Select * From is_assigned Where orderID = :orderID";
        $statement = $connection->prepare($sql);
        $statement->bindValue(':orderID', $tmpID);
        $statement->execute();
        $result = $statement->fetchAll();
        foreach ($result as $row) {
            $courierid = $row['courierID'];
            $sellerid = $row['sellerID'];
        }

        $sql = "Select * From flowersellers Where sellerID = :sellerid";
        $statement = $connection->prepare($sql);
        $statement->bindValue(':sellerid', $sellerid);
        $statement->execute();
        $result = $statement->fetchAll();
        foreach ($result as $row) {
            $pr = $row['people_rated'];
            $rate = $row['rating'];
        }

        $valued = $_POST['rate_seller'];
        $answer = false;
        $sql = "Update flowersellers Set rating = :rating, people_rated = :pr Where sellerID = :sellerid";
        $statement = $connection->prepare($sql);
        $statement->bindValue(':rating', ($rate * $pr + $valued) / ($pr + 1));
        $statement->bindValue(':pr', $pr + 1);
        $statement->bindValue(':sellerid', $sellerid);
        $statement->execute();

        $valued = $_POST['rate_courier'];
        $answer = false;
        $sql = "Update couriers Set rating = :rating ,people_rated = :pr Where courierID = :courierid";
        $statement = $connection->prepare($sql);
        $statement->bindValue(':rating', ($rate * $pr + $valued) / ($pr + 1));
        $statement->bindValue(':pr', $pr + 1);
        $statement->bindValue(':courierid', $courierid);
        $statement->execute();

        header("Location: ./customermainpage.php");
    } catch (PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
?>
<?php
$tmpID = $_GET['orderid'];
echo "<h1 align='center' style = 'color: red'> {$tmpID} </h1>";
?>
<html>
<body>
<form method="post">
<li align = "center" >
    <p>
        Rate Seller
        <select name="rate_seller">
            <option value=0>Select...</option>
            <option value=1> 1</option>
            <option value=2>2</option>
            <option value=3>3</option>
            <option value=4>4</option>
            <option value=5>5</option>
            <option value=6>6</option>
            <option value= 7>7</option>
            <option value=8>8</option>
            <option value=9>9</option>
            <option value=10>10</option>

        </select>
    </p>
</li>
<li align = "center"  >
    <p>
        Rate Courier
        <select name=" rate_courier">
            <option value=0>Select...</option>
            <option value=1> 1</option>
            <option value=2>2</option>
            <option value=3>3</option>
            <option value=4>4</option>
            <option value=5>5</option>
            <option value=6>6</option>
            <option value= 7>7</option>
            <option value=8>8</option>
            <option value=9>9</option>
            <option value=10>10</option>

        </select>
    </p>
</li>
    <input type="submit" name="finish"
           class="button" value="Finish" />
</form>
</body>
</html>


<?php include "templates/footer.php"; ?>
