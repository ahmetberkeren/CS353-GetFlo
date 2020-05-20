<?php include "templates/header.php";
require "../config.php";
require "../common.php";
session_start(); ?>
<?php
if (isset($_SESSION['accountID'])) {
    try {
        $connection = new PDO($dsn, $username, $password, $options);
        $id = $_SESSION['accountID'];

        $sql = "SELECT * FROM customers WHERE customerID = :id";
        $statement = $connection->prepare($sql);
        $statement->bindValue(':id', $id);
        $statement->execute();

        $user = $statement->fetch(PDO::FETCH_ASSOC);
        $values = [
            "name" => $user['name'],
            "phone_number" => $user['phone_number'],
            "gender" => $user['gender'],
            "username" => $user['username'],
            "password" => $user['password']
        ];
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
} else {
    echo "Something went wrong!";
    exit;
} ?>
<?php
if (isset($_POST['submit'])) {
    try {
        $connection = new PDO($dsn, $username, $password, $options);
        $user =[
            "customerID" => $_SESSION['accountID'],
            "name" => $_POST['name'],
            "phone_number"     => $_POST['phone_number'],
            "gender" => $_POST['gender'],
            "username"       => $_POST['username'],
            "password"  => $_POST['password']
        ];

        $sql = "UPDATE customers
            SET name = :name,
              phone_number = :phone_number,
              username = :username,
              gender = :gender,
              password = :password
            WHERE customerID = :customerID;
            UPDATE users
            SET username = :username,
                password = :password
            WHERE ID = :customerID";

        $statement = $connection->prepare($sql);
        $statement->execute($user);
        header("Location: ./customermainpage.php");
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
if(isset($_POST['cancel'])) {
    header("Location: ./customermainpage.php");
}
?>
    <h2>Edit your account</h2>

    <form method="post">
        <?php foreach ($values as $key => $value) : ?>
            <label for="<?php echo $key; ?>"><?php echo ucfirst($key); ?></label>
            <input type="text" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="<?php echo escape($value); ?>" <?php echo ($key === 'id' ? 'readonly' : null); ?>>
        <?php endforeach; ?>
        <input type="submit" name="submit" value="Apply Changes">
    </form>
    <br>
    <form method="post">
        <li>
            <input type="submit" name="cancel"
                   class="button" value="Cancel" /></li>
    </form>
<?php require "templates/footer.php"; ?>