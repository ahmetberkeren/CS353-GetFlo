<?php include "templates/header.php";


require "../config.php";
require "../common.php";
session_start();


if ( isset ( $_POST['MyAccount']))
{
    header("Location: ./selleraccountpage.php");
}

if ( isset($_POST["BuyFlowers"]))
{
    header("Location: ./sellerbuypage.php");
}

if ( isset($_POST["ReveivedOrderss"]))
{
    header("Location: ./sellerreceivedorderspage.php");
}

if ( isset($_POST["MyOrders"]))
{
	
    header("Location: ./sellermyorderspage.php");
}
?>


<ul>
    <li>
        <?php
        if (isset($_GET["kind"])) {
            try {
                $connection = new PDO($dsn, $username, $password, $options);

                $sql = "Select * From flowers NATURAL JOIN seller_has Where kind = :kind AND seller_stock > 0";

                $tmpkind = $_GET["kind"];

                $statement = $connection->prepare($sql);
                $statement->bindParam(':kind', $tmpkind, PDO::PARAM_STR);
                $statement->execute();

                $result = $statement->fetchAll();

            } catch(PDOException $error) {
                echo $sql . "<br>" . $error->getMessage();
            }
        }
        else {
            $connection = new PDO($dsn, $username, $password, $options);

            $sql = "Select * From flowers NATURAL JOIN seller_has Where seller_stock > 0";


            $statement = $connection->prepare($sql);
            $statement->execute();

            $result = $statement->fetchAll();
        }

        ?>
        <?php
        if ($result && $statement->rowCount() > 0) { ?>
            <h2>Flowers</h2>

            <table>
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Seller</th>
                    <th>Kind</th>
                    <th>Colour</th>
                    <th>Scent</th>
                    <th>Details</th>
                    <th>Amount</th>
                    <th>Price</th>
		    <th>Remove</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($result as $row) { ?>
                    <tr>
                        <td><?php echo escape($row["name"]); ?></td>
                        <td><?php
                            $sql = "Select * From flowersellers WHERE sellerID = :sellerID";

                            $tmpID = $row['sellerID'];

                            $statement = $connection->prepare($sql);
                            $statement->bindParam(':sellerID', $tmpID, PDO::PARAM_STR);
                            $statement->execute();

                            $result2 = $statement->fetchAll();
                            foreach ($result2 as $row2)
                                $tmpID = $row2['company_name'];
                            echo escape($tmpID); ?></td>
                        <td><?php echo escape($row["kind"]); ?></td>
                        <td><?php echo escape($row["colour"]); ?></td>
                        <td><?php echo escape($row["scent"]); ?></td>
                        <td><?php echo escape($row["details"]); ?></td>
                        <td><?php echo escape($row["seller_stock"]); ?></td>
                        <td><?php echo escape($row["price"]); ?>TL</td>
                        <td><a href="delete-from-seller.php?id=<?php echo escape($row["flowerID"]); ?>">Remove</a></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            > Stocks are empty.
        <?php }?>
    </li>
    <br>

    <?php
    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "Select distinct kind From flowers NATURAL JOIN seller_has Where seller_stock > 0";

    $tmpID = $_SESSION['accountID'];

    $statement = $connection->prepare($sql);
    $statement->bindParam(':ID', $tmpID, PDO::PARAM_STR);
    $statement->execute();

    $kindresult = $statement->fetchAll()
    ?>
    <h2>Kinds to Filter</h2>

    <table>
        <thead>
        <tr>
            <th>Kind</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($kindresult as $row) { ?>
            <tr>
                <td><a href="sellermainpage.php?kind=<?php echo escape($row["kind"]); ?>"><?php echo escape($row["kind"]); ?></a></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
<br>
    <li>
        <form  method =  "post" >

            <input type = "submit" name = "MyAccount" value=" My Account" >
        </form>
    </li>
    <br>
    <li>
        <form method = "post" >

            <input type = "submit" name = "BuyFlowers" value =  "Buy Flowers" >
        </form>

    </li>
    <br>
    <li>
        <form method = "post" >

            <input type = "submit" name = "ReceivedOrderss" value =  "Received Orderss" >
        </form>

    </li>
<br>
<li>
        <form method = "post" >

            <input type = "submit" name = "MyOrders" value =  "My Orders" >
        </form>

    </li>
<br>
</ul>



<?php include "templates/footer.php"; ?>