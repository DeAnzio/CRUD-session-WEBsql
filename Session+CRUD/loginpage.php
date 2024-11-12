<?php
session_start();
if (isset($_SESSION["user"])) {
   header("Location: mainpage.php");
}
?>
<?php
include './system/mainsystem.php';
$error = "";

            if (isset($_POST["login"])) {               
                $username = $_POST["username"];
                $password = $_POST["password"]; ;
                 $query = "SELECT * FROM user WHERE username = '$username'";
                 $result = mysqli_query($konek, $query);
                 $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
                 if ($user) {

                    if ($password === $user["password"]) {
                        $_SESSION["user"] = "yes";
                        header("Location: mainpage.php");
                        die();
                    } else {

                        $error = "Password does not match.";
                    }
                } else {

                    $error = "Username not found.";
                }
            }
            ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="./system/layer.css">
    <link rel="stylesheet" href="./system/layer1.css">
    <title>Document</title>
</head>
<body>


<div class="loginpagecontainer">
        <div class ="licontaineritem">
            <div>
                <a1>Login Page<a1>
            </div>
        <br>
        <hr width= 400px>
    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
    <?php if ($error): ?>
            <div class="mb-4 p-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="">
            <div>
                <div class="mt-2">
                <input class="input" id="username" name="username" type="username" placeholder="Masukkan username"autocomplete="username" required>
                </div>
            </div>

            <div>
                <div class="mt-2">
                    <input class="input" id="password" name="password" type="password" placeholder="Masukkan password" autocomplete="current-password" required>
                </div>
            </div>
            <br>
            <div>
                    <button type="submit" name="login" class="logreg">LOGIN</button>
            </div>    
        </form>
        <p class="offer">
            Belum punya akun? 
            <a href="registerpage.php" class="offerlink">Daftar di sini</a>
        </p>
        </div>
    </div>
</div>
</body>
</html>
