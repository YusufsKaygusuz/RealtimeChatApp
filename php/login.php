<?php
    session_start();
    include_once "config.php";
    
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    
    if(!empty($email) && !empty($password))
    {
        // Password Hashing
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepared Statements
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0)
        {
            $row = $result->fetch_assoc();
            if(password_verify($password, $row['password']))
            {
                $status = "Active now";
                // Sanitize User Input
                $unique_id = htmlspecialchars($row['unique_id']);

                // Prepared Statements
                $stmt = $conn->prepare("UPDATE users SET status = ? WHERE unique_id = ?");
                $stmt->bind_param("ss", $status, $unique_id);
                $stmt->execute();

                if($stmt->affected_rows == 1){
                    $_SESSION['unique_id'] = $unique_id;
                    echo "success";
                }
            }
            else{
                echo "Email or Password is incorrect!";
            }
        }
        else{
            echo "Email or Password is incorrect!";
        }
    }
    else{
        echo "All input fields are required!";
    }
?>
