<?php
session_start();

if (!isset($_SESSION['UserID'])) {
    Header("Location: ../index.html");
    exit();
}

echo '
<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';

include("../db/connection.php");

$po = $_POST["po"];
$cus = $_POST["cus"];
$issue = $_POST["issue"];
$due = $_POST["due"];
$partno = $_POST["partno"];
$qty = $_POST["qty"];
$i = 0;
$p = count($partno);
if ($po != null) {

    date_default_timezone_set('UTC');
    $timezone = 7;
    $timeTOday = gmdate("Y-m-d H:i:sa", time() + 3600 * ($timezone + date("I")));

    if(!$po||!$cus||!$issue||!$due){
        return 0;
    }else{
        while ($i < count($partno)) {
            if (!$partno[$i] || !$qty) {
                return 0;
            } else {
    
                if ($i < $p) {
                    $sql = "SELECT id_report FROM report_po ORDER BY id_report DESC LIMIT 0,1";
                    $result = mysqli_query($con, $sql);
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    if (@$row["id_report"] == "") {
                        $row["id_report"] = "1000000";
                    }
                    $strid = $row["id_report"] + 1;
                }
                $sql = "SELECT id_part FROM part_item where part_no = '" . $partno[$i] . "'";
                $re = mysqli_query($con, $sql);
                $part = mysqli_fetch_array($re, MYSQLI_ASSOC);
                @$partn = $part["id_part"];           
                    
                $sql = "INSERT INTO report_po (id_report, id_cus, po,id_part, issue_date, due_date, import_date, order_qty,remain_qty, output_qty,active, status )
                                        value($strid,$cus,'$po','$partn','$issue','$due','$timeTOday','$qty[$i]','$qty[$i]','0','2','0')";
                if ($con->query($sql) === TRUE) {
                    echo '<script>
            setTimeout(function() {
             swal({
                 title: "Upload PO Success",  
                 type: "success"
             }, function() {
                 window.location = "./import_po.php"; 
             });
            }, 500);
            </script>';
                } else {
                    echo "Error: " . $sql . "<br>" . $con->error;
                }
            }
            $i++;
        }
    }
    
    
}
$con->close();
