<?php
    require 'kueri-mall.php';
    $kueriMall = new kueriMall();

    session_start();
    if (!isset($_SESSION['id_patner'])) { //Cek Session Patner
        header('Location:login');
    }

    $bDToko = $kueriMall->bDToko($_GET['it']);
    $rowToko = mysqli_fetch_assoc($bDToko);

    // ===============================
    // Daftar Toko
    if (isset($_POST['edit_toko'])) {

        $nama_foto = $_FILES['gambar']['name'];
        if ($nama_foto == "") {
            $alert = 'nofoto';
            $nama_baru = $rowToko['logo_img'];
            $nama_foto_s = '';
            $tempat_upload = '';
            $a = $kueriMall->eToko($_GET['it'], $_POST['nama_toko'],$_POST['no_telp'],$_POST['kota'],$_POST['alamat'],$nama_baru, $nama_foto_s, $tempat_upload, $alert);
            if ($a == 'Berhasil') {
                echo '<script>alert("Berhasil Edit Profil Toko"); window.location="my-web"</script>';
            }elseif ($a == "Gagal") {
                echo '<script>alert("Gagal Edit Profil Toko"); </script>';
            }
            else{
                echo '<script>alert("Terjadi Kesalahan, Ukuran File Terlalu Besar!!");</script>';
            }
        }else{
            $alert = 'witfoto';
            $nama_foto_s = $_FILES['gambar']['tmp_name'];
            $tempat_upload = "assets/img/patner/icon-toko/";
            
            $temp = explode(".", $_FILES["gambar"]["name"]);//untuk mengambil nama file gambarnya saja tanpa format gambarnya
            $nama_baru = round(microtime(true)) . '.' . end($temp);//fungsi untuk membuat nama acak
    
            $format = pathinfo($nama_foto, PATHINFO_EXTENSION); // Mendapatkan format file
            if( ($format == "jpg") or ($format == "png") ){
                $a = $kueriMall->eToko($_GET['it'], $_POST['nama_toko'],$_POST['no_telp'],$_POST['kota'],$_POST['alamat'],$nama_baru, $nama_foto_s, $tempat_upload,$alert);
                if ($a == 'Berhasil') {
                    echo '<script>alert("Berhasil Edit Profil Toko"); window.location="my-web"</script>';
                }elseif ($a == "Gagal") {
                    echo '<script>alert("Gagal Edit Profil Toko"); </script>';
                }
                else{
                    echo '<script>alert("Terjadi Kesalahan, Ukuran File Terlalu Besar!!");</script>';
                }
            }else{ // else validasi format
                echo '<script>alert("Format Gambar Harus JPG atau PNG"); </script>';
            }
        }
        
    }

    
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
        integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <title>Bestore Mall</title>
    <link rel="shortcut icon" href="assets/img/svg/icon/BESTORE LOGO NO BACKGROUND.svg" type="image/x-icon">
    <!-- css Utama -->
    <link rel="stylesheet" href="assets/css/styles.css">
    <!-- Css This Page -->
    <link rel="stylesheet" href="assets/css/my-web.css">
    <!-- Css Font -->
    <link rel="stylesheet" href="assets/css/font.css">

    <!-- Begin:Slide -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <!-- End:Slide -->

    <!-- Sidebar -->
    <link rel="stylesheet" href="assets/css/sidebar.css">
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
    <!-- Sidebar -->
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar  -->

        <!-- Page Content  -->
        <div id="content">
            <div class="container d-toko-patner">
                <div class="row justify-content-center nav-top sticky-top">
                    <div class="col-11 div-nav">
                        <div class="row align-items-center">
                            <div class="col-2">
                                <button class="btn btn-back" onclick="goBack()">
                                    <svg fill="#111" width="0.2400in" height="0.4400in" id="Capa_1"
                                        enable-background="new 0 0 482.239 482.239"
                                        viewBox="0 0 482.239 482.239" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="m206.812 34.446-206.812 206.673 206.743 206.674 24.353-24.284-165.167-165.167h416.31v-34.445h-416.31l165.236-165.236z" />
                                    </svg>
                                </button>
                            </div>
                            <div class="col-10">
                                <h5>Edit Toko</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center form-daftar">
                    <div class="col-11">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <div class="row justify-content-center">
                                    <div class="col-7 preview-b-p text-center">
                                        <img src="assets/img/patner/upload image.svg" id="gambar_cek"
                                            alt="Preview Gambar" width="50%">
                                    </div>
                                    <div class="col-7 d-btn">
                                        <button type="button" class="btn btn-gambar">Browse</button>
                                    </div>
                                    <div class="col-7 d-browse">
                                        <input type="file" class="form-control-file" id="preview_gambar" name="gambar" value="<?=$rowToko['logo-img']?>" accept="image/*">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                              <label for="formGroupExampleInput">Nama Toko Online</label>
                              <input type="text" name="nama_toko" class="form-control" id="formGroupExampleInput" value="<?=$rowToko['nama_toko']?>" required="" placeholder="Mamat Furniture">
                            </div>
                            <div class="form-group">
                                <label for="formGroupExampleInput2">No Telepon</label>
                                <input type="text" name="no_telp" class="form-control" id="formGroupExampleInput2" value="<?=$rowToko['no_telp']?>" required="" placeholder="08xx">
                            </div>
                            <div class="form-group">
                                <label for="formGroupExampleInput2">Kota</label>
                                <input type="text" name="kota" class="form-control" id="formGroupExampleInput2" value="<?=$rowToko['kota']?>" required="" placeholder="Jakarta">
                            </div>
                            <div class="form-group">
                                <label for="formGroupExampleInput2">Alamat</label>
                                <input type="text" name="alamat" class="form-control" id="formGroupExampleInput2" value="<?=$rowToko['alamat']?>" required="" placeholder="Jln. Kenangan Indah">
                            </div>
                            <button type="submit" class="btn btn-daftar" name="edit_toko">Edit</button>
                          </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="overlay"></div>

    <!-- Optional JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
        integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous">
    </script>

    <!-- Sidebar -->
    <!-- jQuery Custom Scroller CDN -->
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js">
    </script>
    <!-- Sidebar -->

    </script>

    <!-- Untuk Kembali Kehalaman Sebelumnya -->
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
    <script>
        function bacaGambar(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#gambar_cek').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#preview_gambar").change(function () {
            bacaGambar(this);
        });
    </script>
    <!-- Untuk Kembali Kehalaman Sebelumnya -->
    <!-- Initialize Swiper -->
</body>
</html>