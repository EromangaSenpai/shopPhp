<?php
session_start();
require 'phpScripts/db.php';
if (!R::testConnection())
    exit ('Нет соединения с базой данных');


        $info = '';
        $data = array();
        $i = 0;
        $goods = R::findAll('goods');
        foreach ($goods as $item)
        {
            $data[$i] = " <tr onclick=\"GetId(this)\">
                <td>$item->id</td>
                <td>$item->productname</td>
                <td>$item->firmname</td>
                <td>$item->type</td>
                <td>$item->amount</td>
            </tr>";

           $i++;
        }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <title>Admin Page</title>
    <style>
        .background3{
            background: #780206;  /* fallback for old browsers */
            background: -webkit-linear-gradient(to top, #061161, #780206);  /* Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to top, #061161, #780206); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
        }
        hr {
            /* установим цвет и высоту */
            border:1px solid rgb(211, 211, 211);
            border-bottom-width: 0;
        }
        #navbar {
            background-color: #333;
            opacity: 0.5;
            position: fixed;
            top: 0;
            width: 100%;
            display: block;
            transition: top 0.3s;
        }

        #navbar a {
            float: left;
            display: block;
            color: #f2f2f2;
            text-align: center;
            padding: 15px;
            text-decoration: none;
            font-size: 17px;
        }


        toright{
            margin-left: 40px;
        }


    </style>
</head>
<body class="background3" style="height: 140vh">

<div id="navbar">
    <a href="CreateProductPage.php" class="text-light">Create</a>
    <a href="#" class="text-light">Update</a>
    <a href="DeleteProductPage.php" class="text-light">Delete</a>
    <a style="float: right" class="text-light" href="MainPage.php">Go back</a>
</div>

<div class="container" style="margin-top: 80px">
    <?php echo $info; $info = '';?>
    <body>

        <h2 class="text-center text-light ">Catalog</h2>
        <br>
        <input class="form-control" id="myInput" type="text" placeholder="Search..">
        <br>
        <table class="table table-dark table-hover" style="cursor: pointer">
            <thead>
            <tr>
                <th>Id</th>
                <th>Product Name</th>
                <th>Firm Name</th>
                <th>Type</th>
                <th>Amount</th>
            </tr>
            </thead>
            <tbody id="myTable">
            <?php foreach ($data as $item): echo $item; endforeach; ?>
            </tbody>
        </table>


    </body>


</div>

<script>
    function GetId(elem) {
        var date = new Date(new Date().getTime() + 30 * 1000);
        document.cookie = "id=" + elem.cells[0].innerText + ";" + "path=/; expires=" + date.toUTCString();
        document.location = 'UpdateProductPage.php';
    }
</script>

<script>
    $(document).ready(function(){
        $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myTable tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>


<script>
    var prevScrollpos = window.pageYOffset;
    window.onscroll = function() {
        var currentScrollPos = window.pageYOffset;
        if (prevScrollpos > currentScrollPos) {
            document.getElementById("navbar").style.top = "0";
        } else {
            document.getElementById("navbar").style.top = "-55px";
        }
        prevScrollpos = currentScrollPos;
    }
</script>

</body>
</html>
