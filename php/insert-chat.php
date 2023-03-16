<?php
    // oturum değişkenlerine erişmek için oturumu başlat
    session_start();

    // unique_id oturum değişkeninin ayarlanıp ayarlanmadığını kontrol edin
    if(isset($_SESSION['unique_id'])){

        // veritabanı bağlantısı kurmak için yapılandırma dosyasını ekleyin
        include_once "config.php";

        // SQL enjeksiyonunu önlemek için gelen form verilerini temizleyin ve silin
        $outgoing_id = mysqli_real_escape_string($conn, $_POST['outgoing_id']);
        $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
        $message = mysqli_real_escape_string($conn, $_POST['message']);

        // mesaj alanının boş olup olmadığını kontrol edin
        if(!empty($message)){
            // mesaj alanı boş değilse, mesajı veri tabanına ekleyin
            $sql = mysqli_query($conn, "INSERT INTO messages (incoming_msg_id,  outgoing_msg_id, msg)
                                    VALUES ('{$incoming_id}', '{$outgoing_id}', '{$message}')") or die();
        }
    }
    else{
        // unique_id oturum değişkeni ayarlanmamışsa, oturum açma sayfasına yönlendir
        header("../login.php");
    }
?>
