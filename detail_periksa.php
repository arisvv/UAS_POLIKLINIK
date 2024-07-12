<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once("koneksi.php");
if (!isset($_SESSION['username'])) {
    header("Location: LoginUser.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap offline -->
    <link rel="stylesheet" href="assets/css/bootstrap.css"> 

    <!-- Bootstrap Online -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" 
    rel="stylesheet" 
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
    crossorigin="anonymous">   
</head>
<body>
<div class="container">
    <hr>    
    <form class="form row" method="POST" action="" name="myForm" onsubmit="return validate();">
        <?php
        $id = '';
        $id_periksa = '';
        $id_obat = '';

        if (isset($_GET['id'])) {
            $ambil = mysqli_query($mysqli, "SELECT * FROM detail_periksa
            WHERE id='" . $_GET['id'] . "'");
            
            while ($row = mysqli_fetch_array($ambil)) {
                $id = $row['id'];
                $id_periksa = $row['id_periksa'];
                $id_obat = $row['id_obat'];
            }
        ?>
        <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
        <?php
        }
        ?>
       <div class="form-group">
    <label for="inputIDPeriksa" class="form-label fw-bold">
    ID Periksa
</label>
<select class="form-select" name="id_periksa" id="inputIDPeriksa">
    <?php
    $resultPeriksa = mysqli_query($mysqli, "SELECT id FROM periksa");
    while ($rowPeriksa = mysqli_fetch_array($resultPeriksa)) {
        echo '<option value="' . $rowPeriksa['id'] . '" ' . ($id_periksa == $rowPeriksa['id'] ? 'selected' : '') . '>'
            . $rowPeriksa['id'] . '</option>';
    }
    ?>
</select>
</div>

<div class="form-group">
    <label for="inputIDObat" class="form-label fw-bold">
        ID Obat
    </label>
    <select class="form-select" name="id_obat" id="inputIDObat">
        <?php
        $resultObat = mysqli_query($mysqli, "SELECT id, nama_obat FROM obat");
        while ($rowObat = mysqli_fetch_array($resultObat)) {
            echo '<option value="' . $rowObat['id'] . '" ' . ($id_obat == $rowObat['id'] ? 'selected' : '') . '>'
                . $rowObat['nama_obat'] . ' (ID: ' . $rowObat['id'] . ')</option>';
        }
        ?>
    </select>
</div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary rounded-pill px-3" name="simpan">Simpan</button>
        </div>
    </form>

    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">ID Periksa</th>
                <th scope="col">ID Obat</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        
        <tbody>
            <?php
            $result = mysqli_query(
                $mysqli,"SELECT * FROM detail_periksa"
            );
            $no = 1;
            while ($data = mysqli_fetch_array($result)) {
            ?>
                <tr>
                    <th scope="row"><?php echo $no++ ?></th>
                    <td><?php echo $data['id_periksa'] ?></td>
                    <td><?php echo $data['id_obat'] ?></td>
                    <td>
                        <a class="btn btn-info rounded-pill px-3" 
                        href="detail_periksa.php?id=<?php echo $data['id'] ?>">Ubah
                        </a>
                        <a class="btn btn-danger rounded-pill px-3" 
                        href="detail_periksa.php?id=<?php echo $data['id'] ?>&aksi=hapus">Hapus
                        </a>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>
</body>
</html>

<?php
if (isset($_POST['simpan'])) {
    if (isset($_POST['id'])) {
        $ubah = mysqli_query($mysqli, "UPDATE detail_periksa SET 
                                        id_periksa = '" . $_POST['id_periksa'] . "',
                                        id_obat = '" . $_POST['id_obat'] . "'
                                        WHERE
                                        id = '" . $_POST['id'] . "'");
    } else {
        $tambah = mysqli_query($mysqli, "INSERT INTO detail_periksa(id_periksa, id_obat) 
                                        VALUES ( 
                                            '" . $_POST['id_periksa'] . "',
                                            '" . $_POST['id_obat'] . "'
                                            )");
    }

    echo "<script> 
            document.location='detail_periksa.php';
            </script>";
}


if (isset($_GET['aksi'])) {
    if ($_GET['aksi'] == 'hapus') {
        $hapus = mysqli_query($mysqli, "DELETE FROM detail_periksa WHERE id = '" . $_GET['id'] . "'");
    }
    echo "<script> 
            document.location='detail_periksa.php';
            </script>";
}
?>
