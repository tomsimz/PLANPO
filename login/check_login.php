<?php
echo '
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';
  session_start();
  require_once("../db/connection.php");
  
  $user = mysqli_real_escape_string($con,$_POST['user']);
  $pass = mysqli_real_escape_string($con,$_POST['pass']);

  $sql = "SELECT * FROM user WHERE user = '".$user."' and pass = '".$pass."'";
  $result = mysqli_query($con,$sql);
  $row = mysqli_fetch_array($result);


  if(!$row)
  {
    echo '<script>
               setTimeout(function() {
                swal({
                    title: "Username and Password Incorrect!",  
                    type: "error"
                }, function() {
                    window.location = "../index.html"; 
                });
              }, 300);
        </script>';
    exit();
  }
  else
  {    
    
      ///* Session

    $_SESSION["UserID"] = $row["id_user"];
      session_write_close();

       if($row["position"]=="admin"){ //ถ้าเป็น admin

          Header("Location: #");

        }
        else if($row["position"]=="member"){  //ถ้าเป็นพนักงาน

          Header("Location: ../component/home.php");

        }else{
          echo '<script>
               setTimeout(function() {
                swal({
                    title: "รหัสพนักงานถูกยกเลิก",  
                    type: "error"
                }, function() {
                    window.location = "../index.html"; 
                });
              }, 300);
        </script>';
        }


      //*** Go to Main page
      //header('location:home.php?id='.$id);  
  }
  
  mysqli_close($con);
