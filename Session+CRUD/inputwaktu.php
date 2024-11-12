<?php
ob_start();
session_start();
if (!isset($_SESSION["user"])) {
   header("Location: loginpage.php");
}
?>

<?php
include "./system/mainsystem.php"
?>

<?php
            $display_query = "SELECT id_waktu, waktu_mulai, waktu_selesai FROM waktu" ;
            $display_result = $konek->query($display_query);
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
    <nav> 
        <div class = "navbar">
            <a class ="header" >Praktikum | 123230069</a>
            <t1 class ="t1">
                <l1><a href="mainpage.php">Home</a></l1>
                <l1><a href="inputdata.php">Lab</a></l1>
                <l1><a href="inputwaktu.php">Waktu</a></l1>
                <l1><a href="jadwalpage.php">Jadwal</a></l1>
            </t1>
        </div>
             <div class="navcenter"></div>
            <t2 class="navright">
                <l1><a href="./system/logout.php">Logout</a></l1>
            </t2>
    </nav>

<div class = "content">
    <div class="kiri">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Waktu</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
            if ($display_result->num_rows > 0) {
                while($data = $display_result->fetch_assoc()) { ?>
                    <tr>
                        <td> <?php echo $data["id_waktu"]; ?> </td>
                        <td> <?php echo $data["waktu_mulai"]; ?> - <?php echo $data["waktu_selesai"]; ?> </td>
                        <td> <button class="delbut"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?delete_waktu=<?php echo $data['id_waktu']; ?>" 
                        onclick="return confirm('Are you sure you want to delete this record?');" >Delete</a></button></td>
                    </tr> 
                <?php } } ?>
            </tbody>
        </table>
    </div>
    <div class ="kanan">
        <div class ="data">       
            <a1> Input Waktu Praktikum</a1>
            <hr width="500px"/>
            <a2>Masukkan Waktu Pelaksanaan Praktikum</a2>
        </div>

        <form method="POST" action="">
        <table>
            <tr>
                <th> Mulai </th>
                <th> Sampai </th>
            </tr>
            <tr>
                <td><input type="time" name="waktu_mulai" value="" class="waktu" autocomplete="waktu_mulai" required></td>
                <td><input type="time" name="waktu_selesai" value="" class="waktu" autocomplete="waktu_selesai" required></td>
            </tr>
        </table>
        <br><br>
        <div>
            <input type="submit" name="submit" value="Submit" class="submit">
        </div>
        </form>
    </div>
</div>
</body>
</html>


<?php 
    if (isset($_POST['submit'])) {
        include './system/mainsystem.php';
        $waktu_mulai =$_POST['waktu_mulai'];
        $waktu_selesai =$_POST['waktu_selesai'];
        
        $query = mysqli_query($konek, "INSERT INTO waktu VALUES('', '$waktu_mulai', '$waktu_selesai')");
            if ($query) {
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            }
        }
?>

<?php

if (isset($_GET['delete_waktu'])) {
    $id_waktu = $_GET['delete_waktu'];


    $check_query = "SELECT * FROM jadwal WHERE id_waktu = '$id_waktu'"; 
    $check_result = $konek->query($check_query);

    if ($check_result->num_rows > 0) {

        echo "<script>alert('Option Waktu ini sudah digunakan pada Jadwal yang sudah dibuat');</script>";
    } else {

        $delete_query = "DELETE FROM waktu WHERE id_waktu = '$id_waktu'";
        $delete_result = $konek->query($delete_query);

            if ($delete_result) {
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            }
    }
}
?>

<?php
ob_end_flush(); 
?>