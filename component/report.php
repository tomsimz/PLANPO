<?php
session_start();

if (!isset($_SESSION['UserID'])) {
    Header("Location: ../index.html");
    exit();
}
print_r($_SESSION["UserID"]);

require_once("../db/connection.php");

$sql = "SELECT * FROM report_po where active = 0 ;
";
$result = mysqli_query($con, $sql);
$i = 1;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Plan PO</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="./index.css"> -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Prompt:wght@200;300&display=swap');

        * {
            box-sizing: border-box;
            font-family: 'Prompt', sans-serif;
        }

        body {
            background-color: antiquewhite;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin: 0;
        }

        .container1 {
            width: 95%;
            background-color: #fff;
            padding: 10px;

        }

        .content {
            margin: 10px;
            overflow-x: auto;
        }
    </style>
</head>

<body>
    <div class="container1">
        <div class="content">

            <a href="./import_po.php"><button class="btn btn-primary " style="margin:10px;">Import PO</button></a>
            <a href="../login/logout.php"><button class="btn btn-danger " style="margin:10px;">logout</button></a>
            <form method="post" action="./plan_po.php">
                <a type="submit"><button class="btn btn-success " style="margin:10px;">Plan PO</button></a>

                <table id="report" class="table table-bordered table-hover">
                    <thead class="table-success">
                        <tr>
                            <th>No</th>
                            <th>Customer</th>
                            <th>PO_Number</th>
                            <th>Issue_Date</th>
                            <th>Due_Date</th>
                            <th>Part_Item</th>
                            <th>Description</th>
                            <th>Order_Qty</th>
                            <th>Remain_Qty</th>
                            <th>Output_Qty</th>
                            <th>Due_Plan</th>
                            <th>Order_Status</th>
                            <th>Remark</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_array($result)) {
                        ?>
                                <tr>
                                    <td><?php echo $i ?></td>
                                    <td><?php
                                        $sql = "SELECT * FROM customer WHERE id_cus = '" . $row["id_cus"] . "'";
                                        $re = mysqli_query($con, $sql);
                                        $cus = mysqli_fetch_array($re);
                                        echo $cus["code"] ?>
                                    </td>
                                    <td><?php echo $row["po"] ?></td>
                                    <td><?php
                                        $datetimeS = new DateTime($row["issue_date"]);
                                        $issue = $datetimeS->format('d/m/Y');

                                        echo $issue; ?></td>
                                    <td><?php
                                        $datetimeS = new DateTime($row["due_date"]);
                                        $due = $datetimeS->format('d/m/Y');

                                        echo $due; ?></td>
                                    <td><?php echo $row["part_item"] ?></td>
                                    <td><?php echo $row["part_item"] ?></td>
                                    <td><?php echo number_format($row["order_qty"]) ?></td>
                                    <td><?php
                                        echo number_format($row["remain_qty"]) ?></td>
                                    <td><?php
                                        if ($row["remain_qty"] == "0") {
                                            echo number_format($row["output_qty"]);
                                        } else {
                                        ?>
                                            <input type="hidden" name="id[]" value="<?php echo $row["id_report"] ?>">
                                            <input type="number" name="outqty[]" style="width: 100px;" placeholder="<?php echo $row["output_qty"] ?>">
                                    </td>
                                <?php
                                        }
                                ?>
                                </td>
                                <td><?php
                                 $plandue = new DateTime($row["due_date"]);
                                 $pdue = $plandue->format('d/m/Y');
                                if ($row["due_update"] == "") {
                                        ?><input type="date" name="plandue[]"><?php
                                    }else if($row["remain_qty"]=="0"){
                                        echo $pdue;
                                    }
                                    else{
                                        ?><input 
                                        type="text" 
                                        name="plandue[]" 
                                        placeholder="<?php echo $pdue; ?>" 
                                        onfocus="(this.type = 'date')"
                                        onblur="(this.type='date')"
                                        style="width:150px"
                                        ><?php
                                    } ?></td>
                                <td><?php echo $row["order_status"] ?></td>
                                <td><?php echo $row["status"] ?></td>
                                </tr>

                        <?php $i++;
                            }
                        } ?>
                    </tbody>
                </table>
            </form>
        </div>

    </div>


</body>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        $('#report').DataTable();
    });
</script>

</html>