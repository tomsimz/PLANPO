<?php
session_start();

if (!isset($_SESSION['UserID'])) {
    Header("Location: ../index.html");
    exit();
}
require_once("../../db/connection.php");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Add Item</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round|Open+Sans">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">

    <!-- <link rel="stylesheet" href="./import_po.css"> -->
    <style>
        @import url('https://fonts.googleapis.com/css?family=Montserrat:500');

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            /* background-color: #fff; */
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



        button:hover {
            background-color: rgba(0, 136, 169, 0.8);
        }


        .container1 {
            margin: 10px auto;
            width: 50%;
            background-color: #fff;
            padding: 5px;

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
                    '<td><input type="text" class="form-control" name="item[]" ></td>' +
                    '<td><input type="text" class="form-control" name="dep[]" ></td>' +

                    '</tr>';
                $("table").append(row);

            });

        });
    </script>
</head>

<body>
    <header>
        <img class="logo" src="../../img/delivery.png" alt="logo">
        <nav>
            <ul class="nav_links">
                <li><a href="../home.php">Report</a></li>
                <li><a href="../import_po.php">Import PO</a></li>
                <li><a href="../updateplan/job_planning.php">Plan PO</a></li>
                <li><a href="../inprocess/confirm_po.php">Confirm PO</a></li>
            </ul>
        </nav>
        <a class="cta" href="../login/logout.php"><button>Logout</button></a>
    </header>
    <div class="container1">
        <form method="post" action="./additemupdate.php">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-6">
                        <h2>Add <b>Item</b></h2>
                    </div>
                    <div class="col-sm-4">

                    </div>
                    <div class="col-sm-2">
                        <button type="submit" class="btn btn-success " style="margin-right:10px;float:right;width:100px"> Comfirm</button>
                    </div>
                </div>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width: 20%;">Part_no</th>
                        <th style="width: 10%;">Decription</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="text" class="form-control" name="item[]" required></td>
                        <td><input type="text" name="dep[]" class="form-control" required></td>
                    </tr>
                </tbody>
            </table>
            <!-- <a href="./home.php" class="btn btn-warning " style="width:100px"> Back</button></a> -->
            <button type="button" class="btn btn-info add-new" style="float:right;width:150px"><i class="fa fa-plus"></i> Add New</button>



        </form>


    </div>

</body>
<script type="text/javascript">
    $(".chosen").chosen();
</script>

</html>