<?php

include "connection.php";

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if(mysqli_connect_errno()){
    // hata oluştuğunda özel bir mesaj göster
    echo "Database connection failed: " . mysqli_connect_error();
}

?>
