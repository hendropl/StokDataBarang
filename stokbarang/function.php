<?php
session_start();

// membuat koneksi ke database
$conn = mysqli_connect("localhost","root","", "stokbarang");

//menambah barang baru
if(isset($_POST['addnewbarang'])){  // Mengecek apakah tombol 'addnewbarang' ditekan
    $namabarang = $_POST['namabarang'];
    $deskripsi = $_POST['deskripsi'];
    $stock = $_POST['stock'];

     // Menyimpan data ke dalam tabel 'stock' di database melalui query SQL insert.
    $addtotable = mysqli_query($conn,"insert into stock (namabarang, deskripsi, stock) values('$namabarang','$deskripsi','$stock')");
    
     // Mengecek apakah query berhasil dijalankan
    if($addtotable){
        header('location:index.php');
    } else {
        echo 'Gagal';
        header('location:index.php');
    }
}

// menambah barang masuk
if(isset($_POST['barangmasuk'])) {
    $barangnya = $_POST['barangnya'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];
    
    // Get current stock from database
    $cekstocksekarang = mysqli_query($conn,"select * from stock where idbarang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);
    
    $stocksekarang = $ambildatanya['stock'];
    $tambahkanstocksekarangdenganquantity = $stocksekarang+$qty;
    
    // Insert into 'masuk' table and update stock
    $addtomasuk = mysqli_query($conn,"insert into masuk (idbarang, keterangan, qty) values('$barangnya','$penerima','$qty')");
    $updatestockmasuk = mysqli_query($conn,"update stock set stock='$tambahkanstocksekarangdenganquantity' where idbarang='$barangnya'");
    
    if($addtomasuk&&$updatestockmasuk) {
        header('location:masuk.php');
    } else {
        echo 'Gagal';
        header('location:masuk.php');
    }
}

//Menambah barang keluar
if(isset($_POST['addbarangkeluar'])){
    $barangnya = $_POST['barangnya'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];
    
    // Mengambil data stok saat ini dari tabel 'stock' berdasarkan ID barang
    $cekstocksekarang = mysqli_query($conn,"select * from stock where idbarang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);
 
    $stocksekarang = $ambildatanya['stock'];
    $tambahkanstocksekarangdenganquantity = $stocksekarang-$qty;

     // Menambahkan catatan barang keluar ke tabel 'keluar' dan Memperbarui stok barang di tabel 'stock'
    $addtokeluar = mysqli_query($conn,"insert into keluar (idbarang, penerima, qty) values('$barangnya','$penerima','$qty')");
    $updatestockmasuk = mysqli_query($conn,"update stock set stock='$tambahkanstocksekarangdenganquantity' where idbarang='$barangnya'");

    if($addtokeluar&&$updatestockmasuk){
        header('location:keluar.php');
    } else {
        echo 'Gagal';
        header('location:keluar.php');
    }
 }


//Update info stock barang
if(isset($_POST['updatebarang'])){
    $idb = $_POST['idb'];
    $namabarang = $_POST['namabarang'];
    $deskripsi = $_POST['deskripsi'];

      // Query untuk memperbarui nama dan deskripsi barang di tabel 'stock' berdasarkan ID barang
    $update = mysqli_query($conn, "update stock set namabarang='$namabarang', deskripsi='$deskripsi' where idbarang = '$idb'");
    
    if($update){
      header('location:index.php');
    } else {
      echo 'Gagal';
      header('location:index.php');
    }
}


//Menghapus barang dari stock
if(isset($_POST['hapusbarang'])){
    $idb = $_POST['idb'];

    // Query untuk menghapus barang dari tabel 'stock' berdasarkan ID barang
    $hapus = mysqli_query($conn, "delete from stock where idbarang='$idb'");

    if($hapus){
        header('location: index.php');
    } else {
        echo 'Gagal';
        header('location: index.php');
    }
};


//Mengubah data barang masuk
if(isset($_POST['updatebarangmasuk'])){
    $idb = $_POST['idb'];
    $idm = $_POST['idm'];
    $deskripsi = $_POST['keterangan'];
    $qty = $_POST['qty'];

          // Query untuk mendapatkan data stok barang dari tabel 'stock'
    $lihatstock = mysqli_query($conn, "select * from stock where idbarang='$idb'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stockskrg = $stocknya['stock'];

    // Query untuk mendapatkan data jumlah barang sebelumnya dari tabel 'masuk'
    $qtyskrg = mysqli_query($conn, "select * from masuk where idmasuk='$idm'");
    $qtynya = mysqli_fetch_array($qtyskrg);
    $qtyskrg = $qtynya['qty'];

    if($qty>$qtyskrg) { // Jika jumlah barang baru lebih besar dari jumlah sebelumnya
        $selisih = $qty-$qtyskrg;
        $kurangin = $stockskrg - $selisih;
        $kurangistocknya = mysqli_query($conn, "update stock set stock='$kurangin' where idbarang='$idb'");
        $updatenya = mysqli_query($conn, "update masuk set qty='$qty', keterangan='$deskripsi' where idmasuk='$idm'");
            if($kurangistocknya&&$updatenya){
                header('location: masuk.php');
                } else {
                echo 'Gagal';
                header('location: masuk.php');
            }
    } else { // Jika jumlah barang baru lebih kecil atau sama dengan jumlah sebelumnya
        $selisih = $qtyskrg-$qty;
        $kurangin = $stockskrg + $selisih;
        $kurangistocknya = mysqli_query($conn, "update stock set stock='$kurangin' where idbarang='$idb'");
        $updatenya = mysqli_query($conn, "update masuk set qty='$qty', keterangan='$deskripsi' where idmasuk='$idm'");
         if($kurangistocknya && $updatenya) {
            header('location:masuk.php');
                } else {
                echo 'Gagal';
                header('location:masuk.php');
         }    
    }
}

//Menghapus barang masuk
if(isset($_POST['hapusbarangmasuk'])){
    $idb= $_POST['idb'];
    $qty = $_POST['kty'];
    $idm = $_POST['idm'];
    
    // Query untuk mendapatkan data stok barang dari tabel 'stock'
    $getdatastock = mysqli_query($conn, "select * from stock where idbarang='$idb'");
    $data = mysqli_fetch_array($getdatastock);
    $stok = $data['stock'];
    
    $selisih = $stok-$qty; 
    $update = mysqli_query($conn, "update stock set stock='$selisih' where idbarang='$idb'");
    $hapusdata = mysqli_query($conn, "delete from masuk where idmasuk='$idm'");
    if($update&&$hapusdata) {
        header('location:masuk.php');
    } else {
        header('location:masuk.php');
    }
 }

//Mengubah data barang keluar
if(isset($_POST['updatebarangkeluar'])){
    $idb= $_POST['idb'];
    $idk = $_POST['idk'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];
    
      // Mendapatkan stok barang saat ini dari tabel 'stock'
    $lihatstock = mysqli_query($conn, "select * from stock where idbarang='$idb'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stockskrg = $stocknya['stock'];
    
        // Mendapatkan jumlah barang keluar sebelumnya dari tabel 'keluar'
    $qtyskrg = mysqli_query($conn, "select * from keluar where idkeluar='$idk'");
    $qtynya = mysqli_fetch_array($qtyskrg);
    $qtyskrg = $qtynya['qty'];
    
    if($qty>$qtyskrg) {  // Jika jumlah baru lebih besar dari jumlah sebelumnya
    $selisih = $qty-$qtyskrg; 
    $kurangin = $stockskrg - $selisih;
    $kurangistocknya = mysqli_query($conn, "update stock set stock='$kurangin' where idbarang='$idb'");
    $updatenya = mysqli_query($conn, "update keluar set qty='$qty', penerima='$penerima' where idkeluar='$idk'");
                if ($kurangistocknya&&$updatenya) {
                    header('location:keluar.php');
                } else {
                    echo 'Gagal';
                    header('location:keluar.php');
                }
    } else { // Jika jumlah baru lebih kecil dari jumlah sebelumnya
            $selisih = $qtyskrg-$qty;
            $kurangin = $stockskrg + $selisih;
            $kurangistocknya = mysqli_query($conn, "update stock set stock='$kurangin' where idbarang='$idb'");
            $updatenya = mysqli_query($conn, "update keluar set qty='$qty', penerima='$penerima' where idkeluar='$idk'");
        if ($kurangistocknya&&$updatenya) {
            if($kurangistocknya && $updatenya){
                header('location:keluar.php');
            } else {
                echo 'Gagal';
                header('location:keluar.php');
            }
    }
}
}


//Menghapus barang keluar
if(isset($_POST['hapusbarangkeluar'])){
    $idb = $_POST['idb'];
    $qty = $_POST['kty'];
    $idk = $_POST['idk'];
     
     // Mendapatkan data stok barang saat ini dari tabel 'stock'
    $getdatastock = mysqli_query($conn, "select * from stock where idbarang='$idb'");
    $data = mysqli_fetch_array($getdata
    
    stock);
    $stok = $data['stock'];

    $selisih = $stok+$qty;  

    $update = mysqli_query($conn, "update stock set stock='$selisih' where idbarang='$idb'");
    $hapusdata = mysqli_query($conn, "delete from keluar where idkeluar='$idk'");

    if($update&&$hapusdata){
        header('location:keluar.php');
    } else {
        header('location:keluar.php');
    }
}
?>