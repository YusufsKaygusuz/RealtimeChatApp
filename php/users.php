<?php
    session_start(); // Session başlatılır.
    include_once "config.php";  // Veritabanı bağlantı bilgileri içeren config dosyası dahil edilir.
    $outgoing_id = $_SESSION['unique_id']; // Aktif kullanıcının benzersiz kimliği alınır.
    $sql = mysqli_query($conn, "SELECT * FROM users WHERE NOT unique_id = {$outgoing_id}"); // Kullanıcılar tablosundan aktif kullanıcının haricindeki kullanıcılar sorgulanır.
    $output = ""; // Boş bir değişken tanımlanır.

    if(mysqli_num_rows($sql) == 1){  // Eğer sorgudan sadece bir sonuç dönerse "No users are available to chat" mesajı oluşturulur.
        $output .= "No users are available to chat"; //"Mesajlaşabileceğiniz kullanıcı bulunamadı.";
    }
    else if(mysqli_num_rows($sql) > 0) // Eğer sorgudan birden fazla sonuç dönerse "data.php" dosyası dahil edilir.
    {
        include "data.php";
    }
    echo $output;  // Oluşturulan çıktı echo ile yayılır.

?>
