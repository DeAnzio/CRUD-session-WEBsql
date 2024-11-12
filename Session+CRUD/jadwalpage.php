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
<div class = "content">    
    <div class="kiri">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>MK Praktikum</th>
                    <th>Jurusan</th>
                    <th>Lab</th>
                    <th>Waktu</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
            if ($display_result->num_rows > 0) {
                while($data = $display_result->fetch_assoc()) { ?>
                    <tr>
                        <td> <?php echo $data["id_jadwal"]; ?> </td>
                        <td> <?php echo $data["mk"]; ?> </td>
                        <td> <?php echo $data["jurusan"]; ?> </td>
                        <td> <?php echo $data["nama_lab"]; ?> </td>
                        <td> <?php echo $data["waktu_mulai"]; ?> - <?php echo $data["waktu_selesai"]; ?> </td>                         
                        <td> <div class="but"> <button class="editbut" onclick="window.location.href='editpage.php?id=<?php echo $data['id_jadwal']; ?>'">Edit</button>
                            <button class="delbut"><a href="<?php ?>?delete_id=<?php echo $data['id_jadwal']; ?>" 
                            onclick="return confirm('Are you sure you want to delete this record?');" >Delete</a></button></div></td>
                    </tr> 
                <?php } } ?>
            </tbody>
        </table>
    </div>

    <div class="kanan">
            <div class ="data">       
                <a1>Input Jadwal Praktikum</a1>
                <hr width="500px"/>
                <a2>Buat jadwal praktikum sesuai dengan yang diinginkan</a2>
            </div>
            <br><br><br>
        <div class="isikanan">
            <form method="POST" action ="">
                <br><input type="text" name="matkul" placeholder="Masukkan MK Praktikum" class="input2" autocomplete="matkul" required> 

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
                <option value="template" >Masukkan Waktu</option>
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
                <br>  
                </select>
                <br>
                <br>
                <div class="isikanan2">
                <input type="submit" name="submit" value="submit" class="submit2">
                <input type="submit" name="Reset" value="Reset" class="reset2">
                </div>
            </form>
        </div>

    </div>
</div>  
</body>
</html>


<?php
if (isset($_POST["submit"])) {

    $mk = $_POST['matkul'];
    $pilihan = isset($_POST['pilihan']) ? $_POST['pilihan'] : '';
    $lab = $_POST['lab'];
    $waktu = $_POST['waktu'];
    $error_message = '';

    
    $check_query = "SELECT * FROM jadwal WHERE mk = '$mk' AND jurusan = '$pilihan' AND id_lab = '$lab' AND id_waktu = '$waktu'";
    $check_result = mysqli_query($konek, $check_query);

    if (mysqli_num_rows($check_result) > 0) {

        echo "<script>alert('Kelas dan Waktu sudah digunakan oleh matakuliah yang lain');</script>";
    } else {

        $query = mysqli_query($konek, "INSERT INTO jadwal (mk, jurusan, id_lab, id_waktu) VALUES('$mk', '$pilihan', '$lab', '$waktu')");
        if ($query) {
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            $error_message = "Error inserting data: " . mysqli_error($konek);
        }
    }
}
    
?>
<?php
if (isset($_GET['delete_id'])) {
    $id_jadwal = $_GET['delete_id'];
    $delete_query = "DELETE FROM jadwal WHERE id_jadwal = '$id_jadwal'";
    $delete_result = $konek->query($delete_query);

    if ($delete_result) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } 
}
?>

<?php
ob_end_flush(); 
?>