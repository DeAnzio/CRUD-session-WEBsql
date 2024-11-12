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
            $display_query = "SELECT id_lab, lab FROM lab" ;
            $display_result = $konek->query($display_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./system/layer1.css">
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
    <div>

<div class = "content">

    <div class="kiri">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Lab</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
            if ($display_result->num_rows > 0) {
                while($data = $display_result->fetch_assoc()) { ?>
                    <tr>
                        <td> <?php echo $data["id_lab"]; ?> </td>
                        <td> <?php echo $data["lab"]; ?> </td>
                        <td> <button class="delbut"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?delete_id=<?php echo $data['id_lab']; ?>" 
                        onclick="return confirm('Are you sure you want to delete this record?');" >Delete</a></button> </td>

                <?php } } ?>
            </tbody>
        </table>
    </div>

    <div class = "kanan">
        <div class ="data">       
            <a1>Input Data Lab</a1>
            <hr width="350px"/>
            <a2>Masukkan Ruang Lab yang tersedia</a2>
        </div>

        <form method="POST" action="">
            <input type="text" name="lab" placeholder="Input Nama Lab" require class="input2" autocomplete="lab" required>
            <br><br>
            <input type="submit" name="submit" value="Submit" class="submit">
        </form>

    </div>  
</div>

</body>
</html>

<?php 
    if (isset($_POST['submit'])) {
        include './system/mainsystem.php';
        $lab =$_POST['lab'];
        if (empty($lab)) {
            $error_message = "Nama Lab tidak boleh kosong!";
        } else {
            $query = mysqli_query($konek, "INSERT INTO lab VALUES('', '$lab')");
            if ($query) {
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            }
        }  }
?>

<?php
if (isset($_GET['delete_id'])) {
    $id_lab = $_GET['delete_id'];

    $check_query = "SELECT * FROM jadwal WHERE id_lab = '$id_lab'"; 
    $check_result = $konek->query($check_query);

    if ($check_result->num_rows > 0) {

        echo "<script>alert('Lab ini sudah dipakai di Jadwal yang sudah dibuat');</script>";
    } else {

        $delete_query = "DELETE FROM lab WHERE id_lab = '$id_lab'";
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