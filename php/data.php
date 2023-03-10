<?php
    while($row = mysqli_fetch_assoc($sql))
    {
        $sql2 = "SELECT * FROM messages WHERE (incoming_msg_id = ? OR outgoing_msg_id = ?) AND (outgoing_msg_id = ? OR incoming_msg_id = ?) ORDER BY msg_id DESC LIMIT 1";
        $stmt = mysqli_prepare($conn, $sql2);
        mysqli_stmt_bind_param($stmt, 'iiii', $row['unique_id'], $row['unique_id'], $outgoing_id, $outgoing_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row2 = mysqli_fetch_assoc($result);

        if(mysqli_num_rows($result) > 0){
            $result = $row2['msg'];
        }
        else{
            $result = "No message available";
        }
        // kelime 28'den fazlaysa mesajın kırpılması
        (strlen($result) > 26) ? $msg = substr($result, 0, 26).'...' : $msg = $result;
        // sizi ekliyorum: oturum açma kimliği msg gönderirse mesajdan önce metin yazın
        if($row2){
            ($outgoing_id == $row2['outgoing_msg_id']) ? $you = "You: " : $you = "";
        }
        else
        {
            $you = ""; 
        }
        // Kullanıcının onine olup olmadığının kontrolü
        /*
        HTML kodunu oluştururken, kullanıcı girdilerini doğrulayın ve güvenli bir şekilde işleyin.
        Örneğin, htmlspecialchars() fonksiyonu kullanarak kullanıcı girdilerindeki HTML öğelerini
        ve özel karakterleri güvenli bir şekilde kaçırabilirsiniz.
        */
        ($row['status'] == "Offline now") ? $offline = "offline" : $offline ="";

        $output .= '<a href="chat.php?user_id='.htmlspecialchars($row['unique_id'], ENT_QUOTES).'">
            <div class="content">
            <img src="php/images/'.htmlspecialchars($row['img'], ENT_QUOTES).'" alt="">
            <div class="details">
                <span>'.htmlspecialchars($row['fname'], ENT_QUOTES).' '.htmlspecialchars($row['lname'], ENT_QUOTES).'</span>
                <p>'.htmlspecialchars($you . $msg, ENT_QUOTES).'</p>
            </div>
            </div>
            <div class="status-dot '.htmlspecialchars($offline, ENT_QUOTES).'"><i class="fas fa-circle"></i></div>
        </a>';
    }
?>

