<?php
session_start();
if (isset($_SESSION["user"])) {
   header("Location: mainpage.php");
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./system/layer.css">
    <link rel="stylesheet" href="./system/layer1.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Document</title>
</head>
<body>


<div class="loginpagecontainer">
    <div class ="licontaineritem">
        <div>
            <a1>REGISTER PAGE<a1>
            <hr>
            <a2>Silahkan buat akun terlebih dahulu</a2>
        </div>
    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
        <form method="POST" action="">
            <div>
                <div class="mt-2">
                <input class="input" id="username" name="username" type="username" placeholder="Masukkan username" autocomplete="username" required>
                </div>
            </div>

            <div>
                <div class="mt-2">
                    <input class="input" id="password" name="password" type="password" placeholder="Masukkan password" autocomplete="current-password" required>
                </div>
            </div>
            <br>
            <div>
                    <button type="submit" name="login" class="logreg">Sign in</button>
            </div>    

            <?php
        include "./system/mainsystem.php";
            if (isset($_POST["submit"])) {
                $username =$_POST['username'];
                $password =$_POST['password'];

                $errors = array();

            if (empty($username) OR empty($password)){
                    array_push($errors,"All fields are required");
                   }
                if (strlen($password)<8) {
                    array_push($errors,"Password must be at least 8 charactes long");
                   }


        require_once "./system/mainsystem.php";
           $sql = "SELECT * FROM user WHERE username = '$username'";
           $result = mysqli_query($konek, $sql);
           $rowCount = mysqli_num_rows($result);
           if ($rowCount>0) {
            array_push($errors,"Email already exists!");
           }
           if (count($errors)>0) {
            foreach ($errors as $error) {
                echo "<div class='alert alert-danger'>$error</div>";
            }
           }else{
                $query="INSERT INTO user (username,password) VALUES (?,?)";
                 $stmt = mysqli_stmt_init($konek);
                 $prepareStmt = mysqli_stmt_prepare($stmt,$query);
                 if ($prepareStmt) {
                     mysqli_stmt_bind_param($stmt,"ss",$username, $password);
                     mysqli_stmt_execute($stmt);
                     echo "<script>alert('Registrasi berhasil, silakan login.');</script>";
                     header("Location: loginpage.php");
                 }else{
                     echo "<script>alert('Registrasi gagal, silakan coba lagi.');</script>";}
                 }
                }
            ?>
            </form>
        <p class="offer">
            Sudah punya akun? 
            <a href="loginpage.php" class="offerlink">Login di sini</a>
        </p>
    </div>
</div>   

</body>
</html>   

