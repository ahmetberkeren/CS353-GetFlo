<?php include "templates/header.php";


require "../config.php";
require "../common.php";
session_start();




?>


<ul>
    <li>
        <?php
        if (isset($_GET["kind"])) {
            try {
                $connection = new PDO($dsn, $username, $password, $options);

                $sql = "Select * From flowers natural join grower_has where kind = :kind AND grower_stock>0";

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

            $sql = "Select * From flowers natural join grower_has where grower_stock>0";


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
                    <th>Grower</th>
                    <th>Kind</th>
                    <th>Colour</th>
                    <th>Scent</th>
                    <th>Details</th>
                    <th>Amount</th>
                    <th>Price</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($result as $row) { ?>
                    <tr>

                        <td><?php
                            $sql = "Select * From flowers natural join grower_has  Where grower_stock>0";



                            $statement = $connection->prepare($sql);
                            $statement->execute();

                            $result2 = $statement->fetchAll();
                            foreach ($result2 as $row2)
                                 ?></td>
                        <td><?php echo escape($row["growerID"]); ?></td>
                        <td><?php echo escape($row["kind"]); ?></td>
                        <td><?php echo escape($row["colour"]); ?></td>
                        <td><?php echo escape($row["scent"]); ?></td>
                        <td><?php echo escape($row["details"]); ?></td>
                        <td><?php echo escape($row["grower_stock"]); ?></td>
                        <td><?php echo escape($row["price"]); ?>TL</td>

                        <td><a href="sellerpaypage.php?flowerid=<?php echo escape($row["flowerID"]); ?>">Buy</a></td>
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

    $sql = "Select distinct kind From flowers natural join grower_has  Where grower_stock>0";

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
        <?php foreach ($result as $row) { ?>
            <tr>
                <td><a href="sellerpaypage.php?kind=<?php echo escape($row["kind"]); ?>"><?php echo escape($row["kind"]); ?></a></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>


</ul>



<?php include "templates/footer.php"; ?>