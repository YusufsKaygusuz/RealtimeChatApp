<?php
    session_start();
    /*
    Burada, mysqli_prepare fonksiyonuyla sorgumuzu hazırlıyoruz. Daha sonra, mysqli_stmt_bind_param
    fonksiyonuyla parametrelerimizi bağlıyoruz. Ardından, sorguyu mysqli_stmt_execute fonksiyonuyla
    çalıştırıyoruz ve sonuçları mysqli_stmt_get_result fonksiyonuyla alıyoruz. Daha sonra, sonuçları
    döngü içinde işleyebilir ve güvenli bir şekilde ekrana yazdırabiliriz.
    */
    if(isset($_SESSION['unique_id'])){
        include_once "config.php";
        $outgoing_id = $_POST['outgoing_id'];
        $incoming_id = $_POST['incoming_id'];
        $output = "";
    
        $sql = "SELECT * FROM messages LEFT JOIN users ON users.unique_id = messages.outgoing_msg_id WHERE (outgoing_msg_id = ? AND incoming_msg_id = ?) OR (outgoing_msg_id = ? AND incoming_msg_id = ?) ORDER BY msg_id";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "iiii", $outgoing_id, $incoming_id, $incoming_id, $outgoing_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
    
        while($row = mysqli_fetch_assoc($result)){
            if($row['outgoing_msg_id'] === $outgoing_id){
                $output .= '<div class="chat outgoing">
                                <div class="details">
                                    <p>'. htmlspecialchars($row['msg']) .'</p>
                                </div>
                            </div>';
            } else {
                $output .= '<div class="chat incoming">
                                <img src="php/images/'. htmlspecialchars($row['img']) .'" alt="">
                                <div class="details">
                                    <p>'. htmlspecialchars($row['msg']) .'</p>
                                </div>
                            </div>';
            }
        }
        echo $output;
    }
    else{
        header("../login.php");
    }
?>
