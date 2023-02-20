<?php
echo '
<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';

session_start();

if (!isset($_SESSION['UserID'])) {
    Header("Location: ../index.html");
    exit();
}
require_once("../../db/connection.php");
?>
<?php

@$item = $_POST["item"];
@$dep = $_POST["dep"];
$i = count($item);
$r = 0;

if (isset($i)) {

    while ($r < $i) {
        if ($item[$r] == "" || $dep[$r] == "") {
           break;
        } else {
            $sql = "SELECT id_part FROM part_item ORDER BY id_part DESC LIMIT 0,1";
            $re = mysqli_query($con, $sql);
            $part = mysqli_fetch_array($re, MYSQLI_ASSOC);
            if (@$part["id_part"] == "") {
                $part["id_part"] = "1";
            }
            $idpart[$r] = $part["id_part"] + 1;


            $sql = "INSERT INTO part_item (id_part,part_no,description,status )
            value($idpart[$r],'".$item[$r]."','".$dep[$r]."','0')";
            
            if ($con->query($sql) === TRUE) { 
                    echo '<script>
                    setTimeout(function() {
                    swal({
                    title: "Add Part Item Success",  
                    type: "success"
                    }, function() {
                    window.location = "./additem.php"; 
                    });
                    }, 500);
                    </script>';                
            }            
        }
        $r++;
    }    

}mysqli_close($con);
?>