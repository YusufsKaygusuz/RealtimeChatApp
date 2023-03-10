<?php
    session_start();
    if(!isset($_SESSION['unique_id'])){
        header("location: login.php");
    }
?>

<?php include_once "header.php";  ?>
<body oncontextmenu="return false;">
    <div class="wrapper">
        <section class="chat-area">
            <header>

            <?php
                include_once "php/config.php";
                // URL parametresindeki `user_id` değerini güvenli bir şekilde alıyorum
                $user_id = mysqli_real_escape_string($conn, $_GET['user_id']);
                // Veritabanından ilgili kullanıcının tüm bilgilerini seçiyorum
                    $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$user_id}");
                    if(mysqli_num_rows($sql) > 0)
                    {
                        // Veritabanından alınan verileri $row değişkenine atıyorum
                        $row = mysqli_fetch_assoc($sql);
                    }
                ?>
                <a href="users.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
                <img src="php/images/<?php echo $row['img'] ?>" alt="">
                <div class="details">
                    <span><?php echo $row['fname'] . " " . $row['lname']  ?></span>
                    <p><?php echo $row['status'] ?></p>
                </div>  
            </header>
            <div class="chat-box"> 
                
            </div>
            <form action="#" class="typing-area" autocomplete="off">
                <input type="text" name="outgoing_id" value="<?php echo $_SESSION['unique_id']; ?>" hidden>
                <input type="text" name="incoming_id" value="<?php echo $user_id; ?>" hidden>
                <input type="text" name="message" class="input-field" placeholder="type a message here...">
                <button><i class="fab fa-telegram"></i></button>
            </form>
        </section>
    </div>

    <script src="javascript/chat.js"></script>
</body>
</html>
