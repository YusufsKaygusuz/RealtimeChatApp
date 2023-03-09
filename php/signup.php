<?php
    session_start();
    include_once "config.php";
    $fname = strip_tags(mysqli_real_escape_string($conn, $_POST['fname']));
    $lname = strip_tags(mysqli_real_escape_string($conn, $_POST['lname']));
    $email = mysqli_real_escape_string($conn, filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    if(!empty($fname) && !empty($lname) && !empty($email) && !empty($password))
    {
            // Geçerli e-mail kontrolü
            if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                // check that email already exist in the database or not
                $sql = mysqli_query($conn, "SELECT email FROM users WHERE email = '{$email}'");
                if(mysqli_num_rows($sql) > 0){
                    echo "$email - This email already exist !";
                }
                else
                {
                    // dosya yüklemesi kontrolü
                    if(isset($_FILES['image'])){
                        $img_name = $_FILES['image']['name']; //kullanıcı tarafından yüklenen img adını alma
                        $tmp_name = $_FILES['image']['tmp_name']; //bu geçici ad, dosyayı klasörümüze kaydetmek / taşımak için kullanılır

                        // yüklenen dosyanın fotoğraf formatın olmasının kontrolü
                        $img_explode = explode('.', $img_name); 
                        $img_ext = end($img_explode); //burada kullanıcı tarafından yüklenen bir img dosyasının uzantısını alıyoruz

                        $extensions = ['png', 'jpeg', 'jpg']; //bunlar bazı geçerli img uzantılarıdır ve bunları dizide sakladık
                        if(in_array($img_ext, $extensions) === true) //kullanıcı tarafından yüklenen img ext, herhangi bir dizi elamanı ile eşleşirse
                        {
                            $time = time(); //bu zamana ihtiyacımız var çünkü img kullanıcısını
                                            //klasörümüze yüklediğinizde, kullanıcı dosyasını şimdiki zamanla yeniden adlandırıyoruz
                                            // böylece tüm resim dosyası benzersiz ismi olacak 
                            // Resimleri depolayacağımız dosyanın yolunu verdik
                            $new_img_name = $time.$img_name;

                           if(move_uploaded_file($tmp_name, "images/".$new_img_name)){
                            $status = "Active now"; // kullanıcı kaydolduktan sonra durumu şimdi aktif olacak
                            $random_id = rand(time(), 10000000); // random id ataması

                            // users veri tabanına verileri aktarma işlemi
                            $sql2 = mysqli_query($conn, "INSERT INTO users (unique_id, fname, lname, email, password, img, status)
                            Values({$random_id}, '{$fname}', '{$lname}', '{$email}', '{$password}', '{$new_img_name}', '{$status}') ");
                           }

                           if($sql2){ // datalar insert edilmişse
                            $sql3 = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}' ");
                            if(mysqli_num_rows($sql3) > 0)
                            {
                                $row = mysqli_fetch_assoc($sql3);
                                $_SESSION['unique_id'] = $row['unique_id'];
                                echo "success";
                            }
                           }
                           else{
                            echo "Something went wrong!";
                        }  
                        }
                    }
                    else
                        {
                            echo "Please selecet an Image file - jpeg, jpg, png";
                        }
                }
            }
            else
            {
                echo "$email - This is not a valid email !"; 
            }
    }
    else{
            echo "All input field are required!";
        }
    
?>