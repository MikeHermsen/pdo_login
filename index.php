<!DOCTYPE html>
<html lang="nl">

<?php include_once 'includes/head.html' ?>

<form action="checkValid.php" method="POST">
    <input type="email" name="email" />
    <input type="password" name="password" minlength="3" maxlength="200" />
    <button type="submit" value="Submit">Submit</button>
</form>

</html>