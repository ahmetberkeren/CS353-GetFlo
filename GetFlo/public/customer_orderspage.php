<?php include "templates/header.php";

    require "../config.php";
    require "../common.php";


        session_start();
            try {
                $connection = new PDO($dsn, $username, $password, $options);
                $sql = "Select orderID , status from orders where orderID in (Select orderID From is_assigned Where customerID = :userID)";
                $temp = $_SESSION["accountID"];
                $statement = $connection->prepare($sql);
                $statement->bindParam(':userID', $temp, PDO::PARAM_STR);
                $statement->execute();
                $result = $statement->fetchAll();

            } catch(PDOException $error) {

                echo $sql . "<br>" . $error->getMessage();
            }
                ?>

        <?php



        if ( $statement->rowCount() > 0) { ?>
            <h2>My Orders</h2>
            <table>
                <thead>
                <tr>
                    <th>order ID</th>
                    <th>statues</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($result as $row) { ?>
                    <tr>
                        <td><?php echo escape($row["orderID"]); ?></td>
                        <td><?php echo escape($row["status"]); ?>TL</td>
                        <?php
                        $approved = strcmp($row["status"] , "Done" );
                        if( $approved == 0 )
                        {?>
                        <td><a href="customer_rate.php?orderid=<?php echo escape($row["orderID"]); ?>">Rate Courier Seller</a></td>
                        <td><a href="customer_complaint.php?orderid=<?php echo escape($row["orderID"]); ?>" >File a complaint</a></td>
                        <?php

                        }?>
                       
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>

            > There is no order.
        <?php }?>
    <br>
