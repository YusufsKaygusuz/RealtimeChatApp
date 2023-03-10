<?php
    session_start(); // // Oturum başlatılır
    if(isset($_SESSION['unique_id'])){ // Eğer oturum açıksa, kullanıcı zaten giriş yapmış demektir ve 'users.php' sayfasına yönlendirilir
        header("location: users.php");
    }
?>

<?php include_once "header.php";  ?> <!-- header.php dosyası eklenir -->
<body oncontextmenu="return false;"> <!-- sağ tıklama menüsü engellenir -->
    <div class="wrapper">
        <section class="form login">
            <header>Realtime Chat App</header>
            <form action="#">
                <div class="error-txt"></div> <!-- hata mesajları için bir div eklenir -->
                <div class="field input">
                    <label>Email Address</label>
                    <input type="text" name="email" placeholder="Enter your email">  <!-- Email adresi için input alanı ve etiketi oluşturulur -->
                </div>
                <div class="field input">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Enter your password"> <!-- Şifre için input alanı ve etiketi oluşturulur -->
                    <i class="fas fa-eye"></i> <!-- Şifrenin görünür olup olmayacağını kontrol eden bir ikon eklenir -->
                </div>
                <div class="field button"> <!-- Giriş yapmak için buton eklenir -->
                    <input type="submit" value="Continue to Chat">
                </div>
            </form>
            <div class="link">Not yet signed up? <a href="index.php">Signup now</a></div>
            <!-- Kayıt olma linki eklenir -->
        </section>
    </div>

<script src="javascript/script.js"></script>
<script src="javascript/login.js"></script>

</body>
</html>
