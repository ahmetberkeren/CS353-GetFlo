        <?php

    require "../config.php";
    require "../common.php";


        session_start();
            try {
                $connection = new PDO($dsn, $username, $password, $options);
                $sql = "Select orderID, status From orders Natural Join Customers Where usedID = :userID";
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

                        }
                        else
                        {?>
                        <form action="" method="post">
                            Add note:
                            <input type=text name="t1">
                            <br>
                            <br>
                            <input type=submit name="s">

                            <?php
                            if(isset($_POST['s']))
                            {
                                $a=$_POST['t1']; //accessing value from the text field
                                $connection = new PDO($dsn, $username, $password, $options);
                                $sql = "Update Order Set note = :note Where orderID = :orderID";
                                $temporder = $row["orderID"];
                                $statement = $connection->prepare($sql);
                                $statement->bindParam(':orderID', $temporder, PDO::PARAM_STR);
                                $statement->bindParam(':note', $a, PDO::PARAM_STR);
                                $statement->execute();
                            }
                            ?>
                            <?php   }?>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            > There is no empty.
        <?php }?>
    <br>
