<?php include "templates/header.php";
require "../config.php";
require "../common.php";
session_start(); ?>
<?php
if (isset($_GET["complaintid"])) {
    try {
        $connection = new PDO($dsn, $username, $password, $options);

        $id = $_GET["complaintid"];

        $sql = "Update complaint_form Set is_answered = TRUE Where complaintID = :complaintID";

        $statement = $connection->prepare($sql);
        $statement->bindValue(':orderID', $id);
        $statement->execute();

    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
    if($id > 0) {
        //Warn
    }
}
?>
<ul>
    <li>
        <?php
        $connection = new PDO($dsn, $username, $password, $options);

        $sql = "Select * From complaint_form NATURAL JOIN is_assigned Where is_answered = false";

        $statement = $connection->prepare($sql);
        $statement->execute();

        $result = $statement->fetchAll();

        ?>
        <?php
        if ($result && $statement->rowCount() > 0) { ?>
            <h2>Complaint Forms</h2>

            <table>
                <thead>
                <tr>
                    <th>Subject</th>
                    <th>Customer</th>
                    <th>Seller</th>
                    <th>Courier</th>
                    <th>Message</th>
                    <th>Response</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($result as $row) { ?>
                    <tr>
                        <td><?php echo escape($row['subject']); ?></td>
                        <td><?php
                            $sql = "Select * From customers WHERE customerID = :customerID";

                            $tmpID = $row['customerID'];

                            $statement = $connection->prepare($sql);
                            $statement->bindParam(':customerID', $tmpID, PDO::PARAM_STR);
                            $statement->execute();

                            $result2 = $statement->fetchAll();
                            foreach ($result2 as $row2)
                                $tmpID = $row2['name'];
                            echo escape($tmpID); ?></td>
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
                        <td><?php
                            $sql = "Select * From couriers WHERE courierID = :courierID";

                            $tmpID = $row['courierID'];

                            $statement = $connection->prepare($sql);
                            $statement->bindParam(':courierID', $tmpID, PDO::PARAM_STR);
                            $statement->execute();

                            $result2 = $statement->fetchAll();
                            foreach ($result2 as $row2)
                                $tmpID = $row2['name'];
                            echo escape($tmpID); ?></td>
                        <td><?php echo escape($row["message"]); ?></td>
                        <td><a href="couriermainpage.php?complaintid=<?php echo escape($row["complaintID"]); ?>">Warn Seller & Courier</a></td>
                        <td><a href="couriermainpage.php?complaintid=<?php echo escape(-1 * $row["complaintID"]); ?>">Ignore</a></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            > You have not a complaint form.
        <?php }?>
    </li>
</ul>

<?php include "templates/footer.php"; ?>

