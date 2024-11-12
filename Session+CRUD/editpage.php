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
            $display_query = "SELECT jadwal.id_jadwal, jadwal.mk, jadwal.jurusan, lab.lab AS nama_lab, waktu.waktu_mulai, waktu.waktu_selesai
                                FROM jadwal
                                JOIN lab ON jadwal.id_lab = lab.id_lab
                                JOIN waktu ON jadwal.id_waktu = waktu.id_waktu";
            $display_result = $konek->query($display_query);
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
<div class="mainpagecontainer">
    <div class="kanan">
            <div class ="data">       
                <a1>Ubah Jadwal Praktikum</a1>
                <hr width="500px"/>
                <a2>Buat jadwal praktikum sesuai dengan yang diinginkan</a2>
            </div>
            <br><br><br>
        <div class="isikanan">
            <form method="POST" action ="">
                <br><input type="text" name="matkul" placeholder="Masukkan MK Praktikum" class="input2" autocomplete="matkul" required>
                <?php 
                    $id_jadwal = $_GET['id']; 
                    $query = "SELECT id_jadwal FROM jadwal";
                    $result = $konek->query($query);
                    $row = $result->fetch_assoc();
                
                ?>
                <input type="radio" name="pilihan" id="IF" value="IF" autocomplete="pilihan" required> <label for="IF">IF</label>        
                <input type="radio" name="pilihan" id="SI" value="SI" autocomplete="pilihan" required> <label for="SI">SI</label><br>
                

                <br><select id="lab" name="lab" class="input3" autocomplete="lab" required><br>
                <option value="template">Masukkan Nama Lab</option>
                <?php
                    $query = "SELECT id_lab, lab FROM lab";
                    $result = $konek->query($query);
                        if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row["id_lab"] . "'>" . $row["lab"] . "</option>";
                        }
                        } else {
                            echo "<option value=''>No items available</option>";
                        }
                ?>

            </select><br>
                <br><select id="waktu" name="waktu" class="input3" autocomplete="waktu" required><br>
                <option value="template">Masukkan Waktu</option>
                    <?php
                        $query = "SELECT id_waktu, waktu_mulai, waktu_selesai FROM waktu";
                        $result = $konek->query($query);
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row["id_waktu"] . "'>" . $row["waktu_mulai"] ." - ". $row["waktu_selesai"] ."</option>";
                            }
                        } else {
                            echo "<option value=''>No items available</option>";
                        }

                        ?>
                </select>
                <br><br>
                <input type="submit" name="submit" value="submit"  class="submit">
                <br><br>
                <input type="submit" name="Reset" value="Reset"  class="submit">
            </form>
        </div>
    </div>
</div>
</body>
</html>

<?php
if (isset($_POST["submit"])) {

$mk =$_POST['matkul'];
$pilihan = $_POST['pilihan'];
$lab =$_POST['lab'];
$waktu =$_POST['waktu'];
$query=mysqli_query($konek,"UPDATE jadwal SET mk='$mk',jurusan='$pilihan',id_lab='$lab',id_waktu='$waktu'");
    if($query){ 
        echo " Update berhasil, Lanjut Input Data?";
        header("Location: jadwalpage.php");}
}
?>

<?php
ob_end_flush(); 
?>