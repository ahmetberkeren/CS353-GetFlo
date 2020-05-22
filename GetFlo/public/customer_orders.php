        <?php

    require "../config.php";
    require "../common.php";


        session_start();
            try {
                $connection = new PDO($dsn, $username, $password, $options);
                $sql = "Select orderID, status From orderss Natural Join Customer Where usedID = :userID";
                $temp = $_SESSION["userID"];
                $statement = $connection->prepare($sql);
                $statement->bindParam(':userID', $temp, PDO::PARAM_STR);
                $statement->execute();
                $result = $statement->fetchAll();

            } catch(PDOException $error) {
                echo $sql . "<br>" . $error->getMessage();
            }
                ?>

        <?php
        if(isset($_POST['s']))
        {
            $a=$_POST['t1']; //accessing value from the text field
            echo "The name of the person is:-".$a; //displaying result
        }

        if( isset($_POST["file"]) )
        {
            header("Location: ./customer_complaint.php?orderID=<?php echo escape($row["orderID"])");
        }
        if(isset($_POST['s']))
        {
            $a=$_POST['t1']; //accessing value from the text field
            $connection = new PDO($dsn, $username, $password, $options);
            $sql = "Update Order Set note = :note Where orderID = :orderID";
            $temporder = $row["orderID"];
            $temp = $_SESSION["userID"];
            $statement = $connection->prepare($sql);
            $statement->bindParam(':orderID', $temporder, PDO::PARAM_STR);
            $statement->bindParam(':note', $temp, PDO::PARAM_STR);
            $statement->execute();
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
                        $approved = strcmp($row["status"] , "Done" );
                        if( $approved == 0 )
                        {
                        <form  method =  "post" >

                            <input type = "submit" name = "file" value=" File a complaint" >
                        </form>
                        <form  method =  "post" >

                            <input type = "submit" name = "rate" value="Rate Seller/ courier" >
                        </form>
                        }
                        else
                        {
                        <form action="" method="post">
                            Add note:
                            <input type=text name="t1">
                            <br>
                            <br>
                            <input type=submit name="s">
                        }
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            > There is no empty.
        <?php }?>
    <br>