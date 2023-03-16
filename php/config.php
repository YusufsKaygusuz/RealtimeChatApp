<?php

// veritabanı bağlantı detayları "connection.php" adlı harici bir dosyadan dahil edilir
include "connection.php";

// mysqli_connect işlevini kullanarak veritabanına bir bağlantı oluşturun
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// veritabanına bağlantının başarılı olup olmadığını kontrol edin
if(mysqli_connect_errno()){
    // bağlantı sırasında bir hata oluşursa, echo ifadesini kullanarak özel bir hata mesajı göster
    echo "Database connection failed: " . mysqli_connect_error();
}

?>
