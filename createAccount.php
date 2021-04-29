

<?php
include_once 'includes/cred.php';

// Creating the statement to connect with the database
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

try { // Trying connecting with the database
     $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    echo "Try again later.";
}


// Running sql code check wether the exist or not.
$stmt = $pdo->prepare('SELECT * FROM credentials WHERE email = :email');
$stmt->execute(['email' => strtolower($_POST['email'])]);
$user = $stmt->fetch();

$pas_length = strlen($_POST['password']);


// If email is not in database
if ( $user['email'] == NULL ) {
    
    // Checking if the password meets the requirments
    if ($_POST['password'] == $_POST['r_password'] && 8 < $pas_length && $pas_length < 60 ) {

            // Creating the sql code that will be runned that will make the new account. 
            $stmt = $pdo->prepare('INSERT INTO credentials(email, password) VALUES  (:email, :password)');

            // Encrypting the password before storing in the database
            $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

            // Binding the parameters to the placeholders.
            $stmt->bindParam(':email', $_POST['email'], PDO::PARAM_STR, 100);
            $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR, 100);

            // Sending the credentials to the database
            if ($stmt->execute()) {
                echo "Succesfully created an new account.<br><a href='index.php'>LOGIN</a>";
            }
        die();
    }
    echo "Password does not match";
    die();
}

echo "Email exist <a href='index.php'>LOGIN</a>";

?>

