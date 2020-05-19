
<?php
require "../config.php";
session_start();
if ( isset( $_SESSION["accountID"] ) )
{
    $id =  $_SESSION["accountID"];
}
if (isset($_POST['submit'])) {
    try {
        $connection = new PDO($dsn, $username, $password, $options);
        $user =[
            "name" => $_POST['cusname'],
            "password"     => $_POST['cuspassword'],
            "gender"       => $_POST['cusgender'],
            "phone_number"       => $_POST['cusphonenumber']
        ];
        $id = $_SESSION["accountID"];
        $sql = "UPDATE customers
            SET nane = :cusname,
              gender = :cusgender,
              password = :cuspasword,
              phone_number = :cusphonenumber
            WHERE id = :id";

        $statement = $connection->prepare($sql);
        $statement->execute($user);
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}

if (isset( $_SESSION["accountID"] ) )
{
    try {
        $connection = new PDO($dsn, $username, $password, $options);
        $id = $_SESSION["accountID"];
        $sql = "SELECT name , password , gender , phone_number FROM customers WHERE id = :id";
        $statement = $connection->prepare($sql);
        $statement->bindValue(':id', $id);
        $statement->execute();

        $user = $statement->fetch(PDO::FETCH_ASSOC);
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
else
{
    exit;
}
?>

<?php require "templates/header.php"; ?>

<?php if (isset($_POST['submit']) && $statement) : ?>
    <?php echo escape($_POST['firstname']); ?> successfully updated.
<?php endif; ?>

<h2>Edit a user</h2>

<form method="post">
    <?php foreach ($user as $key => $value) : ?>
        <label for="<?php echo $key; ?>"><?php echo ucfirst($key); ?></label>
        <input type="text" name="<?php echo $key; ?>"  gender="<?php echo $key; ?>" P.Number="<?php echo escape($value);  ?>" <?php echo ($key === 'id' ? 'readonly' : null); ?>>
    <?php endforeach; ?>
    <input type="submit" name="Apply Changes" value="Submit">
</form>

<a href="couriermainpage.php">Back to main Page</a>

<?php require "templates/footer.php"; ?>
