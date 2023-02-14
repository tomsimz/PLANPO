<?php
echo '
<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';

session_start();

if (!isset($_SESSION['UserID'])) {
    Header("Location: ../../../../index.html");
    exit();
}
require_once("../../db/connection.php");
?>
<?php
@$conf = $_POST["confirm"];
if (isset($conf)) {
    $c = 0;
    date_default_timezone_set('UTC');
    $timezone = 7;
    $timeTOday = gmdate("Y-m-d H:i:sa", time() + 3600 * ($timezone + date("I")));
    for ($i = 0; $i < count($conf); $i++) {
        if (trim($conf[$i]) != "") {
            //echo "chkColor $i = ".$conf[$i]."<br>";

            $sql = "SELECT id_report,qty_plan FROM update_po WHERE id_update = '" . $conf[$i] . "'";
            $re = mysqli_query($con, $sql);
            $confirm = mysqli_fetch_array($re);

            print_r($confirm["id_report"]);
            print_r($confirm["qty_plan"]);







            // $sql = "UPDATE update_po set active = 0,date_complete='" . $timeTOday . "' where id_update = '" . $conf[$i] . "'";
            // $result = mysqli_query($con, $sql) or die("Error in query: $sql ");
            if ($result) {

                // $sql = "SELECT id_report,remain_qty,active FROM report_po where id_report = '" . $confirm["id_report"] . "'";
                // $r = mysqli_query($con, $sql);
                // $row = mysqli_fetch_array($r, MYSQLI_ASSOC);

                // $conf = $row["remain_qty"] - $confirm["qty_plan"];

                // if ($i < count($_POST["confirm"])) {
                //     $sql = "UPDATE report_po set active = 0,remain_qty='" . $conf . "' where id_report = '" . $row["id_report"] . "'";
                //     $result = mysqli_query($con, $sql) or die("Error in query: $sql ");
                    
                // }
                if ($con->query($sql) === TRUE) {
                    echo '<script>
                    setTimeout(function() {
                    swal({
                        title: "Confirm Delivery",  
                        type: "success"
                    }, function() {
                        window.location = "./confirm_po.php"; 
                    });
                    }, 500);
                    </script>';
                } else {
                    echo "Error: " . $sql . "<br>" . $con->error;
                }
            
            }
        }
    }
    
} else {
    echo "null";
}
