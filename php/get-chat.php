<?php
    session_start();
    if(isset($_SESSION['unique_id'])){
        include_once "config.php";
        $outgoing_id = mysqli_real_escape_string($conn, $_POST['outgoing_id']);
        $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
        $output = "";
        
        $sql = mysqli_prepare($conn,"SELECT * FROM messages LEFT JOIN users ON users.unique_id = messages.outgoing_msg_id WHERE (outgoing_msg_id = ? AND incoming_msg_id = ?) OR (outgoing_msg_id = ? AND incoming_msg_id = ?) ORDER BY msg_id");
        mysqli_stmt_bind_param($sql, "iiii", $outgoing_id, $incoming_id, $incoming_id, $outgoing_id);
        mysqli_stmt_execute($sql);
        $result = mysqli_stmt_get_result($sql);
/*
        $sql = "SELECT * FROM messages
        LEFT JOIN users ON users.unique_id = messages.outgoing_msg_id 
        WHERE (outgoing_msg_id = {$outgoing_id} AND incoming_msg_id = {$incoming_id})
        OR (outgoing_msg_id = {$incoming_id} AND incoming_msg_id = {$outgoing_id}) ORDER BY msg_id";
*/
            while($row = mysqli_fetch_assoc($result)){
                if($row['outgoing_msg_id'] ===  $outgoing_id){ // bu eşitse, o zaman bir mesaj gönder
                    $output .= '<div class="chat outgoing">
                                <div class="details">
                                    <p>'. $row['msg'] .'</p>
                                </div>
                                </div>';
                }
                else{ // message receiver
                    $output .= '<div class="chat incoming">
                                <img src="php/images/'. $row['img'] .'" alt="">
                                <div class="details">
                                    <p>'. $row['msg'] .'</p>
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