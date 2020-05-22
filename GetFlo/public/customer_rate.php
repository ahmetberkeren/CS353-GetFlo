<?php include "templates/header.php";
require "../config.php";
require "../common.php";
session_start(); ?>
<?php
if (isset($_POST['rate_seller'])) {
    try {
        $connection = new PDO($dsn, $username, $password, $options);
        $tmpID = $_GET['orderid'];
        $subject = $_POST["subject"];
        $message = $_POST["message"];
        $value = $_POST['rate_seller'];
        $answer = false;
        $sql = "Update FlowerSeller Set rating = (rating * peopleRated + :value) / (peopleRated + 1), peopleRated = peopleRated + 1 Where sellerID = ( Select sellerID From Is_Assigned Where orderID = :orderID)";
        $statement = $connection->prepare($sql);
        $statement->bindValue(':orderID', $tmpID);
        $statement->bindValue(':value', $value);
        $statement->execute();
    } catch (PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}

if (isset($_POST['submit_courier'])) {
    try {
        $connection = new PDO($dsn, $username, $password, $options);
        $tmpID = $_GET['orderid'];
        $value = $_POST['rate_seller'];
        $answer = false;
        $sql = "Update courier Set rating = (rating * peopleRated + :value) / (peopleRated + 1), peopleRated = peopleRated + 1 Where courierID = ( Select courierID From Is_Assigned Where orderID = :orderID";
        $statement->bindValue(':value', $value);
         $statement = $connection->prepare($sql);
        $statement->bindValue(':orderID', $tmpID);
        $statement->execute();
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
        <input type="submit" name="submit_rate" value="submit"/>
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
          <input type="submit" name="submit_courier" value="submit"/>
    </p>
</li>

</body>
</html>


<?php include "templates/footer.php"; ?>
