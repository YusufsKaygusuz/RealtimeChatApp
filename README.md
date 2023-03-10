# RealtimeChatApp

<h2>Real-time online messaging website</h2>
<h4>Hello everyone👋👋. I am sharing a real-time messaging application with you. This project was coded using <strong>👨‍💻PHP, CSS, AJAX, and SQL.👨‍💻</strong> Firstly, let's go through the steps to run all the code smoothly. Before we start, let me briefly talk about what awaits you; 🦾🦾 </h4>
<h2>Trailer for WebSite</h2>

https://user-images.githubusercontent.com/86704802/224430524-1da60bc8-0d7d-4b65-ac55-fd85fcf66b69.mp4

♾ I have designed a simple, smooth, and secure sign-up page for every user to use seamlessly. When I say secure, what do I mean? Users are required to enter their first name, last name, email, and password at login. These form fields can be vulnerable to xcc attacks. The system prevents this.

♾ The sign-up page includes a unique hashing process for the user's password. Additionally, the system prevents users from uploading anything other than a photo with a .jpg, .png, or .jpeg file extension.

♾ After logging in, the user will be presented with an elegant and smooth chat page where they can converse safely with registered users. Security measures have been taken to prevent xcc and SQL injection vulnerabilities in the system.

♾ Users can quickly find the name they want using the search box.

♾ Users can see in real-time which users are active and inactive.


<h3>Step By Step Roadmap</h3>
<p>➡️ Step1 : The first step is to install XAMPP. XAMPP is a web server software. With XAMPP server, systems such as PHP, MariaDB, Perl, Apache, FileZilla, and MercuryMail can be installed on a computer to create a ready-made web server. phpMyAdmin is also installed as part of XAMPP server. We will be using the Apache server and MySQL services provided by XAMPP, and we will frequently use the phpMyAdmin panel. After installing XAMPP, an application interface will appear like this ⬇️⬇️⬇️.</p>

![ss1](https://user-images.githubusercontent.com/86704802/224431159-8f878b48-a986-4bf2-85cc-8b8e47391c0a.jpg)

<p>➡️ Step2 : As a second step, start the Actions of Apache and MySQL services in the XAMPP interface. In other words, activate it by pressing the start buttons in the Actions column of Apache and MySQL Sevice Modes. After running, the background of Apache and MySQL services will be green. Then click on the Explorer box in the interface of the XAMPP application and follow the following folders step by step and go to the xampp>htcdocs section. And upload the file of the software we offer you here. Now the path we will follow will be xampp>htcdocs>chatApp.</p>


![image](https://user-images.githubusercontent.com/86704802/224433014-94538b57-c18c-4110-a133-241fe65088c6.png)

<p>➡️ Step3 : The third step is to create the database. For this, you will reach the Database center by typing localhost/phpmyadmin; 2 databases should be created here. One for users data and one for messages. After making this installation, the connection between the codes of the site and the database needs to be established. We may need to change the codes in the RealtimeChatApp/php/connection.php file. </p>

    $db_host = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "chat";

<p><strong>‼️Remember this is the main link. (php/config.php)‼️</strong></p>

    include "connection.php";
    $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
    if(mysqli_connect_errno()){
      // hata oluştuğunda özel bir mesaj göster
      echo "Database connection failed: " . mysqli_connect_error();
    }

<p><strong>🛡️🛡️ A number of measures taken to prevent a bad interference in users' messaging. 🛡️🛡️</strong></p>
            
       while($row = mysqli_fetch_assoc($result)){
          if($row['outgoing_msg_id'] === $outgoing_id){
            $output .= '<div class="chat outgoing">
                <div class="details">
                 <p>'. htmlspecialchars($row['msg']) .'</p>
                 </div>
                </div>';
                     }
                     
<p><strong>🛡️🛡️ A number of measures taken to prevent a bad interference in users' messaging. 🛡️🛡️</strong></p>

         $sql = "SELECT * FROM messages LEFT JOIN users ON users.unique_id = messages.outgoing_msg_id WHERE (outgoing_msg_id = ? AND incoming_msg_id = ?) OR (outgoing_msg_id = ? AND incoming_msg_id = ?) ORDER BY msg_id";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "iiii", $outgoing_id, $incoming_id, $incoming_id, $outgoing_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);



