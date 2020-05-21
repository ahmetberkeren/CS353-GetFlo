<?php include "templates/header.php";
require "../config.php";
require "../common.php";
session_start(); ?>
<?php
if (isset($_POST['finish'])) {
    try {
        $connection = new PDO($dsn, $username, $password, $options);
        $tmpID = $_SESSION['orderID'];
        $subject = $_POST["subject"];
        $message = $_POST["message"];

        $sql = "Insert Into complaint_form(orderID, message, subject) Values(:tmpID ,:message , :subject)";
        $statement = $connection->prepare($sql);
        $statement->bindValue(':tmpID', $tmpID);
        $statement->bindValue(':message', $message);
        $statement->bindValue(':subject', $subject);

        $statement->execute();
    } catch (PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
    ?>

<li>
    <textarea name="subject" rows="5" cols="40" placeholder="Subject..">
    </textarea>

    <textarea name="complaint" rows="40" cols="40" placeholder="Enter your complaint..">
    </textarea>

    <input type = "submit" name = "finish" value = "Finish" >

</li>

<?php include "templates/footer.php"; ?>
