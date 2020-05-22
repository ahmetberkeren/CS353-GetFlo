<?php include "templates/header.php";
require "../config.php";
require "../common.php";
session_start();?>

<?php
if(isset($_POST['back'])) {
    header("Location: ./sellermainpage.php");
}
?>
<ul>
    <li>
        <?php
        $connection = new PDO($dsn, $username, $password, $options);

        $sql = "Select * From orders natural join is_assigned";

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
                    <th>Seller</th>
                    <th>OrderID</th>
                    <th>Delivery Address</th>
                    <th>Payment Type</th>
                    <th>Delivery Type</th>
                    <th>Additional Notes</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($result as $row) { ?>
                    <tr>
                        <td><?php
                            $sql = "Select * From order natural join is_assigned WHERE sellerID = :sellerID";

                            $tmpID = $row['sellerID'];

                            $statement = $connection->prepare($sql);
                            $statement->bindParam(':growerID', $tmpID, PDO::PARAM_STR);
                            $statement->execute();

                            $result2 = $statement->fetchAll();
                            foreach ($result2 as $row2)

                            echo escape($tmpID); ?></td>
                        <td><?php echo escape($row["orderID"]); ?></td>
                        <td><?php echo escape($row["delivery_address"]); ?></td>
                        <td><?php echo escape($row["payment_type"]); ?></td>
                        <td><?php echo escape($row["delivery_type"]); ?></td>
                        <td><?php echo escape($row["note"]); ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            > You have not get an order.
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

