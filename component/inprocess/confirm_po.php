<?php
session_start();

if (!isset($_SESSION['UserID'])) {
    Header("Location: ../index.html");
    exit();
}
require_once("../../db/connection.php");

$sql = "SELECT * FROM report_po right join update_po on report_po.id_report = update_po.id_report where update_po.active != 0;
";
$result = mysqli_query($con, $sql);
$i = 1;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <!-- <meta http-equiv="refresh" content="30"> -->
    <title>Confirm PO</title>
    <style>
        @import url('https://fonts.googleapis.com/css?family=Montserrat:500');

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            background-color: #fff;
        }

        li,
        a,
        button {
            font-family: "Montserrat", sans-serit;
            font-weight: 500;
            font-size: 16px;
            color: black;
            text-decoration: none;
        }

        header {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            padding: 10px 10%;
        }

        .logo {
            width: 100PX;
            cursor: pointer;
            margin-right: auto;
        }

        .nav_links {
            list-style: none;
        }

        .nav_links li {
            display: inline-block;
            padding: 0px 20px;
        }

        .nav_links li a {
            transition: all 0.3s ease 0s;
        }

        .nav_links li a:hover {
            color: #0088a9;
            text-decoration: none;
        }

        button {
            margin-left: 20px;
            padding: 9px 25px;
            background-color: rgba(0, 136, 169, 1);
            border: none;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease 0s;
            color: #fff;

        }

        span {
            color: #fff;
            background-color: rgba(0, 136, 169, 0.8);
        }

        button:hover {
            background-color: rgba(0, 136, 169, 0.8);
        }

        .container1 {
            background-color: #fff;
            padding: 10px 2%;
            align-items: center;
            overflow: auto;
        }

        .content {
            margin: 10px;
        }
    </style>
</head>

<body>
    <header>
        <img class="logo" src="../../img/delivery.png" alt="logo">
        <nav>
            <ul class="nav_links">
                <li><a href="../home.php">Report</a></li>
                <li><a href="../import_po.php">Import PO</a></li>
                <li><a href="../updateplan/job_planning.php">Plan PO</a></li>
                <li><a href="#">Confirm PO</a></li>
            </ul>
        </nav>
        <a class="cta" href="../../login/logout.php"><button>Logout</button></a>
    </header>
    <div class="container1">
        <div class="content">
            <form method="POST" action="./complete.php">
                <button type="submit">Confirm</button>
                <table id="report" class="table table-bordered table-hover">
                    <thead class="table-success">
                        <tr>
                            <th>No</th>
                            <th>Customer</th>
                            <th>PO_Number</th>
                            <th>Due_Date</th>
                            <th>Part_Item</th>
                            <th>Description</th>
                            <th>Order_Qty</th>
                            <th>Remain_Qty</th>
                            <th>Output_Qty</th>
                            <th>Due_Plan</th>
                            <th></th>

                            </th>
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
                                        $datetimeS = new DateTime($row["due_date"]);
                                        $due = $datetimeS->format('d/m/Y');

                                        echo $due; ?></td>
                                    <td><?php $sql = "SELECT part_no,description FROM part_item WHERE id_part = '" . $row["id_part"] . "'";
                                        $re = mysqli_query($con, $sql);
                                        $part = mysqli_fetch_array($re);
                                        echo $part["part_no"] ?></td>
                                    <td><?php echo $part["description"] ?></td>
                                    <td><?php echo number_format($row["order_qty"]) ?></td>
                                    <td><?php
                                        echo number_format($row["remain_qty"]) ?></td>
                                    <td><?php
                                        echo number_format($row["qty_plan"]);
                                        ?>
                                    </td>
                                    <td> <?php $datetime = new DateTime($row["date_plan"]);
                                            $datep = $datetime->format('d/m/Y');

                                            echo $datep; ?></td>
                                    <td>

                                        <input type="checkbox" name="confirm[]" value="<?php echo $row["id_update"] ?>">
                                    </td>
                                </tr>

                        <?php $i++;
                            }
                        } ?>

                    </tbody>
                </table>
            </form>
        </div>

    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#report').DataTable();
        });
    </script>
    <!-- <script>
        window.setTimeout(function() {
            window.location.reload();
        }, 30000);
    </script> -->
</body>

</html>