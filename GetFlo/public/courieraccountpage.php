<?php include "templates/header.php";
require "../config.php";
require "../common.php";
session_start(); ?>
<?php
if (isset($_SESSION['accountID'])) {
    try {
        $connection = new PDO($dsn, $username, $password, $options);
        $id = $_SESSION['accountID'];

        $sql = "SELECT * FROM couriers WHERE courierID = :id";
        $statement = $connection->prepare($sql);
        $statement->bindValue(':id', $id);
        $statement->execute();

        $user = $statement->fetch(PDO::FETCH_ASSOC);
        $values = [
            "name" => $user['name'],
            "phone_number" => $user['phone_number'],
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
            "courierID" => $_SESSION['accountID'],
            "name" => $_POST['name'],
            "phone_number"     => $_POST['phone_number'],
            "username"       => $_POST['username'],
            "password"  => $_POST['password']
        ];

        $sql = "UPDATE couriers
            SET name = :name,
              phone_number = :phone_number,
              username = :username,
              password = :password
            WHERE courierID = :courierID;
            UPDATE users
            SET username = :username,
                password = :password
            WHERE ID = :courierID";

        $statement = $connection->prepare($sql);
        $statement->execute($user);
        header("Location: ./couriermainpage.php");
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
if(isset($_POST['cancel'])) {
    header("Location: ./couriermainpage.php");
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