<?php include "templates/header.php";


require "../config.php";
require "../common.php";
session_start();


if ( isset ( $_POST['MyAccount']))
{
    header("Location: /public/accountdetails.php");
}

if ( isset($_POST["MyOrders"]))
{
    header("Location: /public/customerorders.php");
}

if ( isset ( $_POST["MyBasket"]))
{
    header("Location : /public/customerbasket.php");
}

?>

<?php include "templates/footer.php"; ?>
<ul>
    <li>
        <?php
        $connection = new PDO($dsn, $username, $password, $options);
        $sql = "select distinct kind image from flower where amount > 0";
        $statement = $connection->prepare($sql);
        $statement->bindParam(':ID', $tmpID, PDO::PARAM_STR);
        $statement->execute();
        $result = $statement->fetchAll();
        ?>
        <?php
        if ($result && $statement->rowCount() > 0) { ?>
            <h2>Products By Kind</h2>
            <table>
                <thead>
                <tr>
                    <th>kind</th>
                    <th>image</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($result as $row) { ?>
                    <tr>
                        <td><?php echo escape($row["kind"]); ?></td>
                        <td><?php echo escape($row["image"]); ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            > You have not an order.
        <?php }?>
    </li>

    <li>
        <?php
        $connection = new PDO($dsn, $username, $password, $options);
        $sql2 = "select name  seller from flower where amount > 0";
        $statement = $connection->prepare($sql);
        $statement->bindParam(':ID', $tmpID, PDO::PARAM_STR);
        $statement->execute();
        $result = $statement->fetchAll();
        ?>
        <?php
        if ($result && $statement->rowCount() > 0) { ?>
            <h2>Products By Kind</h2>
            <table>
                <thead>
                <tr>
                    <th>kind</th>
                    <th>image</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($result as $row) { ?>
                    <tr>
                        <td><?php echo escape($row["kind"]); ?></td>
                        <td><?php echo escape($row["image"]); ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            > You have not an order.
        <?php }?>



    </li>
</ul>
    <br>
    <form method="post">
        <li>
            <input type="submit" name="back"
                   class="button" value="Back" /></li>
    </form>
</ul>

<li>
    <form  method =  "post" >

        <input type = "submit" name = "MyAccount" value=" My Account" >
    </form>
</li>

<li>
    <form method = "post" >

        <input type = "submit" name = "MyOrders" value =  "My Orders" >
    </form>

</li>

<li>
    <form method = "post">
        <input type = "submit" name = "MyBasket" value = "My Basket" >
    </form>

</li>