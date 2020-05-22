<?php include "templates/header.php";
require "../config.php";
require "../common.php";
session_start(); ?>
<?php
if (isset($_SESSION['accountID'])) {
    try {
        $connection = new PDO($dsn, $username, $password, $options);
        $id = $_SESSION['accountID'];

        $sql = "SELECT * FROM flowergrower WHERE growerID = :id";
        $statement = $connection->prepare($sql);
        $statement->bindValue(':id', $id);
        $statement->execute();

        $user = $statement->fetch(PDO::FETCH_ASSOC);
        $values = [
            "name" => $user['name'],
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
            "growerID" => $_SESSION['accountID'],
            "name" => $_POST['name'],
            "username" => $_POST['username'],
            "password" => $_POST['password']
        ];

        $sql = "UPDATE flowergrower
            SET name = :name,
		username = :username,
              password = :password
            WHERE growerID = :growerID;
            UPDATE users
            SET username = :username,
                password = :password
            WHERE ID = :growerID";

        $statement = $connection->prepare($sql);
        $statement->execute($user);
        header("Location: ./growermainpage.php");
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
if(isset($_POST['cancel'])) {
    header("Location: ./growermainpage.php");
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