<?php
session_start();

if (!isset($_SESSION['UserID'])) {
    Header("Location: ../index.html");
    exit();
}
require_once("../db/connection.php");
?>
<?php

@$id_update = $_POST["id"];
@$qty_update = $_POST["outqty"];
@$plandue = $_POST["plandue"];
$i = count($id_update);
$r = 0;
$a = 0;
if (isset($i)) {
    date_default_timezone_set('UTC');
    $timezone = 7;
    $timeTOday = gmdate("Y-m-d H:i:sa", time() + 3600 * ($timezone + date("I")));

    while ($r < $i) {
        if ($qty_update[$r] == "") {
            $a++;
        } else {

            print_r($id_update[$r]);
            print_r($qty_update[$r]);
            print_r("<br/>");

            $sql = "SELECT remain_qty,output_qty FROM report_po where id_report = '" . $id_update[$r] . "'";
            $result = mysqli_query($con, $sql);
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $re = $row["remain_qty"] - $qty_update[$r];
            $out = $qty_update[$r] + $row["output_qty"];

            //print_r($re);
            //print_r($out);

            $sql = "UPDATE report_po set remain_qty = '" . $re . "',output_qty='" . $out . "',due_update = '".$plandue[$r]."',plan_date='".$timeTOday."' where id_report = '" . $id_update[$r] . "'";
            $result = mysqli_query($con, $sql) or die("Error in query: $sql ");
        }

        $r++;
    }
    mysqli_close($con);
    if ($result) {
        echo "<script type='text/javascript'>";
        echo "alert('Update Succesfuly');";
        echo "window.location = './report.php'; ";
        echo "</script>";
    } else {
        echo "<script type='text/javascript'>";
        echo "alert('Error back to Update again');";
        echo "window.location = './report.php'; ";
        echo "</script>";
    }
}
?>