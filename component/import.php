<?php
session_start();

if (!isset($_SESSION['UserID'])) {
    Header("Location: ../index.html");
    exit();
}
require_once("../db/connection.php");

$sql = "SELECT * FROM report_po where status = 0 ;
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

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round|Open+Sans">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css">

    <!-- <meta http-equiv="refresh" content="30"> -->
    <title>Home</title>
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

        .table-wrapper {
            width: 900px;
            margin: 10px 0;
            background: #fff;
            padding: 20px;
            box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
        }

        .table-title {
            padding-bottom: 10px;
            margin: 0 0 10px;
        }

        .table-title h2 {
            margin: 6px 0 0;
            font-size: 22px;
        }

        .table-title .add-new {
            float: right;
            height: 30px;
            font-weight: bold;
            font-size: 12px;
            text-shadow: none;
            min-width: 100px;
            border-radius: 50px;
            line-height: 13px;
        }

        .table-title .add-new i {
            margin-right: 4px;
        }

        table.table {
            table-layout: fixed;
        }

        table.table tr th,
        table.table tr td {
            border-color: #e9e9e9;
        }

        table.table th i {
            font-size: 13px;
            margin: 0 5px;
            cursor: pointer;
        }

        table.table th:last-child {
            width: 100px;
        }

        table.table td a {
            cursor: pointer;
            display: inline-block;
            margin: 0 5px;
            min-width: 24px;
        }

        table.table td a.add {
            color: #27C46B;
        }

        table.table td a.edit {
            color: #FFC107;
        }

        table.table td a.delete {
            color: #E34724;
        }

        table.table td i {
            font-size: 19px;
        }

        table.table td a.add i {
            font-size: 24px;
            margin-right: -1px;
            position: relative;
            top: 3px;
        }

        table.table .form-control {
            height: 32px;
            line-height: 32px;
            box-shadow: none;
            border-radius: 2px;
        }

        table.table .form-control.error {
            border-color: #f50000;
        }

        table.table td .add {
            display: none;
        }
    </style>
    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
            var actions = $("table td:last-child").html();
            // Append table with add row form on add new button click
            $(".add-new").click(function() {
                $(this).attr("enable", "disabled");
                var index = $("table tbody tr:last-child").index();
                var row = '<tr>' +
                    '<td style="background-color: #e2e2e2;"></td>' +
                    '<td style="background-color: #e2e2e2;"></td>' +
                    '<td style="background-color: #e2e2e2;"></td>' +
                    '<td style="background-color: #e2e2e2;"></td>' +
                    '<td><input type="text" class="form-control" name="partno[]" ></td>' +
                    '<td><input type="text" class="form-control" name="qty[]" ></td>' +

                    '</tr>';
                $("table").append(row);

            });

        });
    </script>
    
</head>

<body>
    <header>
        <img class="logo" src="../img/delivery.png" alt="logo">
        <nav>
            <ul class="nav_links">
                <li><a href="#">Report</a></li>
                <li><a href="./import_po.php">Import PO</a></li>
                <li><a href="./updateplan/job_planning.php">Plan PO</a></li>
                <li><a href="../component/inprocess/confirm_po.php">Confirm PO</a></li>
            </ul>
        </nav>
        <a class="cta" href="../login/logout.php"><button>Logout</button></a>
    </header>
    <div class="container1">
        <form method="post" action="./update_po.php">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-8">
                        <h2>Import <b>PO</b></h2>
                    </div>

                    <div class="col-sm-4">
                        <button type="submit" class="btn btn-success " style="margin-right:10px;float:right;width:100px"> Comfirm</button>
                    </div>
                </div>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width: 10%;">PO_Number</th>
                        <th style="width: 20%;">Customer</th>
                        <th style="width: 10%;">Issue_Date</th>
                        <th style="width: 10%;">Due_Date</th>
                        <th style="width: 20%;">Part_no</th>
                        <th style="width: 10%;">Qty</th>

                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="text" name="po" class="form-control" required></td>
                        <td><select name="cus" class="chosen" data-placeholder="Choose tags ..." style="width: 350px;">
                                <option value=""></option>
                                <?php

                                $sql = "SELECT * FROM customer ";
                                $re = mysqli_query($con, $sql);
                                $cus = mysqli_fetch_array($re);

                                while ($cus = mysqli_fetch_array($re)) {
                                    if ($cus["status_cus"] == "0") {
                                ?>
                                        <option value="<?php echo $cus["id_cus"] ?>"><?php echo $cus["code"] . ": " . $cus["name_cus"]; ?></option>
                                <?php
                                    } else {
                                        echo "Not Machine";
                                    }
                                }

                                ?>
                            </select>
                        </td>
                        <td><input type="date" name="issue" class="form-control"></td>
                        <td><input type="date" name="due" class="form-control"></td>
                        <td>
                            <input type="text" class="form-control" name="partno[]">
                        </td>
                        <td><input type="number" name="qty[]" class="form-control"></td>

                    </tr>
                </tbody>
            </table>
            <a href="./home.php" class="btn btn-warning " style="width:100px"> Back</button></a>
            <button type="button" class="btn btn-info add-new" style="float:right;width:150px"><i class="fa fa-plus"></i> Add New</button>



        </form>


    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>


    <script type="text/javascript">
        $(".chosen").chosen();
    </script>
    <!-- <script>
        window.setTimeout(function() {
            window.location.reload();
        }, 30000);
    </script> -->
</body>

</html>