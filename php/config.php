<?php
    $conn = mysqli_connect("localhost","root","","chat");
    if(!$conn){
        echo "Datebase connected" . mysqli_connect_error();
    }

?>