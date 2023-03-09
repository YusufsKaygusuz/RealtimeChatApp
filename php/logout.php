<?php
    session_start();
    if(isset($_SESSION['unique_id'])){ //kullanıcı giriş yaptıysa bu sayfaya gelin aksi halde giriş sayfasına gidin
        include_once "config.php";
        $logout_id = mysqli_real_escape_string($conn, $_GET['logout_id']);
        if(isset($logout_id)){ // çıkış kimliği ayarlanmışsa
            $status = "Offline now";
            // Kullanıcı oturumu kapattıktan sonra, bu durumu çevrimdışı olarak ve giriş formunda güncelleyeceğiz
            // kullanıcı başarıyla oturum açtıysa, durumu tekrar aktif olarak güncelleyeceğiz
            $sql = mysqli_query($conn, "UPDATE users SET status = '{$status}' WHERE unique_id = {$logout_id}");
            if($sql){
                session_unset();
                session_destroy();
                header("location: ../login.php");
            }
        }
        else{
            header("location: ../users.php");
        }
    }
    else{
        header("location: ../login.php");
    }


?>