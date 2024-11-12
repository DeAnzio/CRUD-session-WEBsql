<?php
session_start();
if (!isset($_SESSION["user"])) {
   header("Location: loginpage.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./system/layer.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Document</title>
</head>
<body>
    <nav>
        <div class = "navbar">
            <a class ="header" >Praktikum | 123230069</a>
        </div>
            <div class="navcenter"></div>
            <t2 class="navright"><l1><a href="./system/logout.php">Logout</a></l1></t2>
    </nav>
    <div class="mainpagecontainer">
        <div class ="mpcontaineritem">
            <div>
                <a2>Selamat Datang di</a2><br>
                <a1>Praktikum Informatika<a1>
            </div>
            <div class="buttonmain1">
                <button onclick="document.location='inputdata.php'" type="button" class="buttonm1" >Lab</button>
                <button onclick="document.location='inputwaktu.php'" type="button" class="buttonm1" href=inputwaktu.php>Waktu Praktikum</button>
            </div>
        
            <div class="buttonmain2">
                <button onclick="document.location='jadwalpage.php'" type="button" class="buttonm2" >Jadwal Praktikum</button>
            </div>
        </div>
    </div>
</body>
</html>