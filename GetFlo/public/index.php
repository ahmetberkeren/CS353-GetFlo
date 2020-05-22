<?php include "templates/header.php";
require "../common.php";
session_start();
if (isset($_POST['submitCustomer'])) {
    require "../config.php";

    try {
        $connection = new PDO($dsn, $username, $password, $options);

        $new_user = array(
            "name" => $_POST['cusname'],
            "username"  => $_POST['cususername'],
            "password"     => $_POST['cuspassword'],
            "gender"       => $_POST['cusgender'],
            "phone_number"       => $_POST['cusphonenumber']
        );

        $sql = sprintf(
            "INSERT INTO %s (%s) values (%s)",
            "customers",
            implode(", ", array_keys($new_user)),
            ":" . implode(", :", array_keys($new_user))
        );

        $statement = $connection->prepare($sql);
        $statement->execute($new_user);

        $sql = "SELECT * FROM customers WHERE username = :username AND password = :password";

        $signupusername = $_POST['cususername'];
        $signuppassword = $_POST['cuspassword'];

        $statement = $connection->prepare($sql);
        $statement->bindParam(':username', $signupusername, PDO::PARAM_STR);
        $statement->bindParam(':password', $signuppassword, PDO::PARAM_STR);
        $statement->execute();

        $result = $statement->fetchAll();
        foreach ($result as $row)
            $result2 = $row['customerID'];

        $new_user = array(
            "ID" => $result2,
            "username"  => $_POST['cususername'],
            "password"     => $_POST['cuspassword'],
            "type" => "Customer"
        );
        $sql = sprintf(
            "INSERT INTO %s (%s) values (%s)",
            "users",
            implode(", ", array_keys($new_user)),
            ":" . implode(", :", array_keys($new_user))
        );

        $statement = $connection->prepare($sql);
        $statement->execute($new_user);
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }

}

if (isset($_POST['submitSeller'])) {
    require "../config.php";

    try {
        $connection = new PDO($dsn, $username, $password, $options);

        $new_user = array(
            "company_name" => $_POST['selname'],
            "username"  => $_POST['selusername'],
            "password"     => $_POST['selpassword'],
            "rating"       => 0.0,
            "people_rated" => 0,
            "phone_number"      => $_POST['selphonenumber']
        );

        $sql = sprintf(
            "INSERT INTO %s (%s) values (%s)",
            "flowersellers",
            implode(", ", array_keys($new_user)),
            ":" . implode(", :", array_keys($new_user))
        );

        $statement = $connection->prepare($sql);
        $statement->execute($new_user);


        $sql = "SELECT * FROM flowersellers WHERE username = :username AND password = :password";

        $signupusername = $_POST['selusername'];
        $signuppassword = $_POST['selpassword'];

        $statement = $connection->prepare($sql);
        $statement->bindParam(':username', $signupusername, PDO::PARAM_STR);
        $statement->bindParam(':password', $signuppassword, PDO::PARAM_STR);
        $statement->execute();

        $result = $statement->fetchAll();
        foreach ($result as $row)
            $result2 = $row['sellerID'];

        $new_user = array(
            "ID" => $result2,
            "username"  => $_POST['selusername'],
            "password"     => $_POST['selpassword'],
            "type" => "Seller"
        );
        $sql = sprintf(
            "INSERT INTO %s (%s) values (%s)",
            "users",
            implode(", ", array_keys($new_user)),
            ":" . implode(", :", array_keys($new_user))
        );

        $statement = $connection->prepare($sql);
        $statement->execute($new_user);

    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }

}

if (isset($_POST['submitCourier'])) {
    require "../config.php";

    try {
        $connection = new PDO($dsn, $username, $password, $options);

        $new_user = array(
            "name" => $_POST['couname'],
            "username"  => $_POST['couusername'],
            "password"     => $_POST['coupassword'],
            "rating"       => 0.0,
            "people_rated" => 0,
            "phone_number"      => $_POST['couphonenumber']
        );

        $sql = sprintf(
            "INSERT INTO %s (%s) values (%s)",
            "couriers",
            implode(", ", array_keys($new_user)),
            ":" . implode(", :", array_keys($new_user))
        );

        $statement = $connection->prepare($sql);
        $statement->execute($new_user);

        $sql = "SELECT * FROM couriers WHERE username = :username AND password = :password";

        $signupusername = $_POST['couusername'];
        $signuppassword = $_POST['coupassword'];

        $statement = $connection->prepare($sql);
        $statement->bindParam(':username', $signupusername, PDO::PARAM_STR);
        $statement->bindParam(':password', $signuppassword, PDO::PARAM_STR);
        $statement->execute();

        $result = $statement->fetchAll();
        foreach ($result as $row)
            $result2 = $row['courierID'];

        $new_user = array(
            "ID" => $result2,
            "username"  => $_POST['couusername'],
            "password"     => $_POST['coupassword'],
            "type" => "Courier"
        );
        $sql = sprintf(
            "INSERT INTO %s (%s) values (%s)",
            "users",
            implode(", ", array_keys($new_user)),
            ":" . implode(", :", array_keys($new_user))
        );

        $statement = $connection->prepare($sql);
        $statement->execute($new_user);

    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }

}

if (isset($_POST['submitGrower'])) {
    require "../config.php";

    try {
        $connection = new PDO($dsn, $username, $password, $options);

        $new_user = array(
            "name" => $_POST['grname'],
            "username"  => $_POST['grusername'],
            "password"     => $_POST['grpassword'],
        );

        $sql = sprintf(
            "INSERT INTO %s (%s) values (%s)",
            "flowergrower",
            implode(", ", array_keys($new_user)),
            ":" . implode(", :", array_keys($new_user))
        );

        $statement = $connection->prepare($sql);
        $statement->execute($new_user);

        $sql = "SELECT * FROM flowergrower WHERE username = :username AND password = :password";

        $signupusername = $_POST['grusername'];
        $signuppassword = $_POST['grpassword'];

        $statement = $connection->prepare($sql);
        $statement->bindParam(':username', $signupusername, PDO::PARAM_STR);
        $statement->bindParam(':password', $signuppassword, PDO::PARAM_STR);
        $statement->execute();

        $result = $statement->fetchAll();
        foreach ($result as $row)
            $result2 = $row['growerID'];

        $new_user = array(
            "ID" => $result2,
            "username"  => $_POST['grusername'],
            "password"     => $_POST['grpassword'],
            "type" => "Grower"
        );
        $sql = sprintf(
            "INSERT INTO %s (%s) values (%s)",
            "users",
            implode(", ", array_keys($new_user)),
            ":" . implode(", :", array_keys($new_user))
        );

        $statement = $connection->prepare($sql);
        $statement->execute($new_user);

    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }

}

if (isset($_POST['submitLogin'])) {
    try {
        require "../config.php";

        $connection = new PDO($dsn, $username, $password, $options);

        $sql = "SELECT *
        FROM users
        WHERE username = :username AND password = :password";

        $loginusername = $_POST['loginusername'];
        $loginpassword = $_POST['loginpassword'];

        $statement = $connection->prepare($sql);
        $statement->bindParam(':username', $loginusername, PDO::PARAM_STR);
        $statement->bindParam(':password', $loginpassword, PDO::PARAM_STR);
        $statement->execute();

        $result = $statement->fetchAll();

        foreach ($result as $row) {
            $type = $row['type'];
        }
        $_SESSION['accountID'] = $row['ID'];
        if($type == "Customer")
            header("Location: ./customermainpage.php");
        if($type == "Seller")
            header("Location: ./sellermainpage.php");
        if($type == "Courier")
            header("Location: ./couriermainpage.php");
        if($type == "Service")
            header("Location: ./servicemainpage.php");
        if($type == "Grower")
            header("Location: ./growermainpage.php");
        else echo "Invalid Username and Password!";
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
?>

    <ul>
        <?php if ((isset($_POST['submitCustomer']) || isset($_POST['submitSeller']) || isset($_POST['submitCourier'])) && $statement) { ?>
            > <?php echo $new_user['username']; ?> successfully added.
        <?php } ?>
        <li>
            <h2>Login</h2>

            <form method="post">
                <label for="username">Username</label>
                <input type="text" name="loginusername" id="loginusername">
                <label for="loginpassword">Password</label>
                <input type="text" name="loginpassword" id="loginpassword">
                <input type="submit" name="submitLogin" value="Login">
            </form>

        </li>

        <li>
            <h2>Sign Up As Customer</h2>

            <form method="post">
                <label for="name">First-Last Name</label>
                <input type="text" name="cusname" id="cusname">
                <label for="username">Username</label>
                <input type="text" name="cususername" id="cususername">
                <label for="password">Password</label>
                <input type="text" name="cuspassword" id="cuspassword">
                <label for="gender">Gender</label>
                <input type="text" name="cusgender" id="cusgender">
                <label for="phonenumber">Phone Number</label>
                <input type="text" name="cusphonenumber" id="cusphonenumber">
                <input type="submit" name="submitCustomer" value="Sign Up">
            </form>

        </li>
        <li>
            <h2>Sign Up As Flower Seller</h2>

            <form method="post">
                <label for="selname">Company Name</label>
                <input type="text" name="selname" id="selname">
                <label for="selusername">Username</label>
                <input type="text" name="selusername" id="selusername">
                <label for="selpassword">Password</label>
                <input type="text" name="selpassword" id="selpassword">
                <label for="selphonenumber">Phone Number</label>
                <input type="text" name="selphonenumber" id="selphonenumber">
                <input type="submit" name="submitSeller" value="Sign Up">
            </form>

        </li>

        <li>
            <h2>Sign Up As Courier</h2>

            <form method="post">
                <label for="couname">Name</label>
                <input type="text" name="couname" id="couname">
                <label for="couusername">Username</label>
                <input type="text" name="couusername" id="couusername">
                <label for="coupassword">Password</label>
                <input type="text" name="coupassword" id="coupassword">
                <label for="couphonenumber">Phone Number</label>
                <input type="text" name="couphonenumber" id="couphonenumber">
                <input type="submit" name="submitCourier" value="Sign Up">
            </form>

        </li>

<li>
            <h2>Sign Up As Grower</h2>

            <form method="post">
                <label for="grname">Name</label>
                <input type="text" name="grname" id="grname">
                <label for="grusername">Username</label>
                <input type="text" name="grusername" id="grusername">
                <label for="grpassword">Password</label>
                <input type="text" name="grpassword" id="grpassword">
                <input type="submit" name="submitGrower" value="Sign Up">
            </form>

        </li>
    </ul>
