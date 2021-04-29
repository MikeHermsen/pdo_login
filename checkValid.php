<?php include_once 'includes/cred.php'?>

<?php
    // Preparing the db
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
//  Connecting with the SQL Database
try {
     $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
     throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

// Preparing the MySQL Code
$stmt = $pdo->prepare('SELECT * FROM credentials WHERE email = :email');
$stmt->execute(['email' => strtolower($_POST['email'])]);
$user = $stmt->fetch();


// USER LATER ON AGAIN
//$hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

var_dump();

if ( password_verify($_POST['password'], $user['password']) ) {
    echo "Successfully logged in with " . $user['email'];
    die();
} else if ( $user['email'] == NULL ) {
    echo 'Account not found, Creating new account?';
    echo '
    <form action="createAccount.php" method="POST">
        <label for="email">email:</label><br>
        <input type="email" name="email" value="'. $_POST['email'] .'" required><br>
        <label for="password">password:</label><br>
        <input type="password" name="password" minlength="6" maxlength="60" value="'. $_POST['password'] .'" required><br>
        <label for="r-password">retype password:</label><br>
        <input type="password" name="r_password" minlength="6" maxlength="60" required><br><br>
        <input type="submit" value="Submit">
    </form> 
    ';
    die();
}



echo "Incorrect login <br> <a href='index.php'>LOGIN</a>";


?>
