<?php include "templates/header.php";
require "../config.php";
require "../common.php";
session_start(); ?>
<?php
if (isset($_POST['finish'])) {
    try {
        $connection = new PDO($dsn, $username, $password, $options);
        $tmpID = $_GET['orderid'];
        $subject = $_POST["subject"];
        $message = $_POST["message"];
        $answer = false;
        $sql = "Insert Into complaint_form(orderID, message, subject , is_answered ) Values(:tmpID ,:message , :subject , :answer)";
        $statement = $connection->prepare($sql);
        $statement->bindValue(':tmpID', $tmpID);
        $statement->bindValue(':message', $message);
        $statement->bindValue(':subject', $subject);
        $statement->bindValue(':answer', $answer);

        $statement->execute();
    } catch (PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
?>
<?php
$tmpID = $_GET['orderid'];
echo "<h1 align='center' style = 'color: red'> {dfdfs} </h1>";
?>
<html>
<body>
<li align = "center" >
    <textarea  name="subject" rows="5" cols="40" placeholder="Subject.." >
    </textarea>
</li>
<li align = "center"  >
    <textarea  name="complaint" rows="10" cols="40" placeholder="Enter your complaint.." >
    </textarea>
</li>
<li align = "center">
    <input type = "submit" name = "finish" value = "Finish" > </input>
</li>
</body>
</html>


<?php include "templates/footer.php"; ?>
