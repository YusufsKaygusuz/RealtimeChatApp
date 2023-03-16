<?php
    session_start(); // Bir PHP oturumu başlatın
    include_once "config.php"; // Veritabanı yapılandırma dosyasını dahil et
    
    $email = trim($_POST['email']); // Get the email input value and remove whitespace from the beginning and end
    $password = trim($_POST['password']); // Get the password input value and remove whitespace from the beginning and end
    
    if(!empty($email) && !empty($password)) // Hem e-posta hem de şifre alanlarının boş olup olmadığını kontrol edin
    {
        // Şifre Hashing işlemi
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Hazırlanan Tablolar
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?"); // E-posta girişi için yer tutucu içeren bir SQL ifadesi hazırlayın
        $stmt->bind_param("s", $email); // E-posta giriş değerini yer tutucuya bağla
        $stmt->execute(); // SQL deyimini çalıştır
        $result = $stmt->get_result(); // Yürütülen SQL ifadesinden sonuç kümesini alın

        if($result->num_rows > 0) // Sonuç kümesinde en az bir satır varsa, bu e-posta giriş değerinin veritabanında var olduğu anlamına gelir
        {
            $row = $result->fetch_assoc(); // Sonuç kümesinin ilişkisel dizisini alın
            if(password_verify($password, $row['password']))
                // Veritabanında depolanan karma parolayı kullanarak parolayı doğrulayın
            {
                $status = "Active now"; // Durumu "Şimdi aktif" olarak ayarla
                // Kullanıcı Girişini Temizle
                $unique_id = htmlspecialchars($row['unique_id']);// XSS saldırılarını önlemek için özel karakterleri HTML varlıklarına dönüştürün

                // Hazırlanan Ekstreler
                $sql2 = $conn->prepare("UPDATE users SET status = ? WHERE unique_id = ?");
                $sql2->bind_param("ss", $status, $unique_id);
                $sql2->execute();

                if($sql2){
                    $_SESSION['unique_id'] = $row['unique_id'];
                    echo "success";
                    exit();
                }
            }
            else{
                echo "Email or Password is incorrect!"; // Şifre yanlışsa bir hata mesajını yankıla
            }
        }
        else{
            echo "Email is invalid!"; // E-posta veritabanında yoksa bir hata mesajını echo et
        }
    }
    else{
        echo "All input fields are required!"; // E-posta veya şifre alanı boşsa bir hata mesajını yankıla
    }
?>
