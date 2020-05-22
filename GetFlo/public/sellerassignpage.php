<?php include "templates/header.php";
require "../config.php";
require "../common.php";
session_start();?>

<?php
if (isset($_GET["orderid"])) {
    $_SESSION['orderid'] = $_GET['orderid'];
}
if(isset($_POST['back'])) {
    header("Location: ./sellerreceivespage.php");
}
?>
<?php
if (isset($_GET["courierid"])) {
    try {
        $connection = new PDO($dsn, $username, $password, $options);

        $id = $_SESSION["orderid"];

        $sql = "Update orders Set status = 'Assignment Sent' Where orderID = :orderID";

        $statement = $connection->prepare($sql);
        $statement->bindValue(':orderID', $id);
        $statement->execute();

        $sql = "Update is_assigned Set courierID = :id2 Where orderID = :orderID";
        $id2 = $_GET['courierid'];
        $statement = $connection->prepare($sql);
        $statement->bindValue(':orderID', $id);
        $statement->bindValue(':id2', $id2);
        $statement->execute();

    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
    header("Location: ./sellerreceivespage.php");
}

?>
<ul>
    <li>
        <?php
        $connection = new PDO($dsn, $username, $password, $options);

        $sql = "Select * From couriers";

        $tmpID = $_SESSION['accountID'];

        $statement = $connection->prepare($sql);
        $statement->bindParam(':ID', $tmpID, PDO::PARAM_STR);
        $statement->execute();

        $result = $statement->fetchAll();

        ?>
        <?php
        if ($result && $statement->rowCount() > 0) { ?>
            <h2>Current Orders</h2>

            <table>
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Rating</th>
                    <th>Phone Number</th>
                    <th>Assign</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($result as $row) { ?>
                    <tr>
                        <td><?php echo escape($row["name"]); ?></td>
                        <td><?php echo escape($row["rating"]); ?>(<?php echo escape($row["people_rated"]); ?>)</td>
                        <td><?php echo escape($row["phone_number"]); ?></td>
                        <td><a href="sellerassignpage.php?courierid=<?php echo escape($row['courierID']); ?>">Assign</a></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            > There is not an available courier.
        <?php }?>
    </li>
    <br>
    <form method="post">
        <li>
            <input type="submit" name="back"
                   class="button" value="Back" /></li>
    </form>
</ul>

<?php include "templates/footer.php"; ?>

