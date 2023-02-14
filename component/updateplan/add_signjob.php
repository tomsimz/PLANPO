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

@$id_update = $_POST["id"];
@$qty_update = $_POST["outqty"];
@$plandue = $_POST["plandue"];
$i = count($id_update);
$r = 0;
$a = 0;

// print_r($id_update);
// print_r($qty_update);
// print_r($plandue);

if (isset($i)) {
    date_default_timezone_set('UTC');
    $timezone = 7;
    $timeTOday = gmdate("Y-m-d H:i:sa", time() + 3600 * ($timezone + date("I")));

    while ($r < $i) {
        if ($qty_update[$r] == "" || $plandue[$r] == "") {
           return 0;
        } else {

            // print_r($id_update[$r]);
            // print_r($qty_update[$r]);
            // print_r($plandue[$r]);
            // print_r("<br/>");

            $sql = "SELECT id_update FROM update_po ORDER BY id_update DESC LIMIT 0,1";
            $re = mysqli_query($con, $sql);
            $idup = mysqli_fetch_array($re, MYSQLI_ASSOC);
            if (@$idup["id_update"] == "") {
                $idup["id_update"] = "2000000";
            }
            $strid[$r] = $idup["id_update"] + 1;

            $sql = "SELECT remain_qty,output_qty FROM report_po where id_report = '" . $id_update[$r] . "'";
            $result = mysqli_query($con, $sql);
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

            //$re = $row["remain_qty"] - $qty_update[$r];
            $out = $qty_update[$r] + $row["output_qty"];

            $sql = "INSERT INTO update_po (id_update,id_report,id_user,date_update,date_plan,qty_plan,active, status )
            value($strid[$r],$id_update[$r],'".$_SESSION['UserID']."','$timeTOday','$plandue[$r]','$qty_update[$r]','2','0')";
            
            if ($con->query($sql) === TRUE) {
                
               

                $sql = "UPDATE report_po set active = 3,output_qty='" . $out . "' where id_report = '" . $id_update[$r] . "'";
                $result = mysqli_query($con, $sql) or die("Error in query: $sql ");
                
                if ($result) {
                    echo '<script>
                    setTimeout(function() {
                    swal({
                    title: "Upload PO Success",  
                    type: "success"
                    }, function() {
                    window.location = "./Job_planning.php"; 
                    });
                    }, 500);
                    </script>';
                } else {
                    echo "<script type='text/javascript'>";
                    echo "alert('Error back to Update again');";
                    echo "window.location = './job_planning.php'; ";
                    echo "</script>";
                }
                
                
            } else {
                echo "Error: " . $sql . "<br>" . $con->error;
            }
          
        }

        $r++;
    }
   
}mysqli_close($con);
?>