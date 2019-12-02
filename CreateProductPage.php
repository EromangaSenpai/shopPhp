<?php
if (!isset($_SESSION))
    session_start();

require 'phpScripts/db.php';

if (!R::testConnection())
    exit ('Нет соединения с базой данных');

if(isset($_SESSION['key'])) {
    $user = R::findOne('users', 'email = ?', array($_SESSION['email']));




    $info = '';
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if ($_FILES && $_FILES['filename']['error'] == UPLOAD_ERR_OK && $_FILES['filename']['size'] <= '20000000') {
            $name = $_FILES['filename']['name'];
            $uniq = uniqid();
            $upload_dir = getcwd() . "\img" . '\\' . $uniq . '_' . $name;

            move_uploaded_file($_FILES['filename']['tmp_name'], $upload_dir);

            $goods = R::dispense('goods');
            $goods->image_path = 'img' . '/' . $uniq . '_' . $name;
            $goods->description = $_POST['description'];
            $goods->shortdescription = $_POST['shortdescription'];
            $goods->productname = $_POST['product'];
            $goods->firmname = $_POST['firm'];
            $goods->color = $_POST['color'];
            $goods->price = $_POST['price'];
            $goods->amount = $_POST['amount'];
            $goods->type = $_POST['type'];
            R::store($goods);

            $info = "<div class=\"alert alert-success alert-dismissible\">
  <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
  <strong>Success!</strong> Product was successfully added to store.
</div>";

        } else {
            $info = "<div class=\"alert alert-danger alert-dismissible\">
  <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
  <strong>Error!</strong> An error was occurred please try again.
</div>";
        }

    }
}

else
{
    header("Location: 403.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" href="css/admin-pages.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <title>Admin Page</title>

</head>
<body class="background3" style="height: 140vh">

<div id="navbar">
    <a href="#" class="text-light">Create</a>
    <a href="ProductPage.php" class="text-light">Update</a>
    <a href="DeleteProductPage.php" class="text-light">Delete</a>
    <a href="SendMail.php" class="text-light">Mail</a>
    <a style="float: right" class="text-light" href="MainPage.php">Go back</a>
</div>

<div class="container" style="margin-top: 80px">
<?php echo $info; $info = '';?>
    <h2 class="text-center text-light">Add product</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
        <br>
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="customFile" name="filename" accept="image/*" required>
                <label class="custom-file-label" for="customFile">Choose file</label>
            </div>
            <hr>
        <div class="row form-group">
            <div class="col-sm-12">
                <label for="shortdesc" class="text-light">Short Description:</label>
                <input value="" type="text" maxlength="100" name="shortdescription" class="form-control" id="shortdesc" placeholder="Short description" required>
            </div>
        </div>
        <div class="form-group">
            <label for="textarea" class="text-light">Description:</label>
            <textarea maxlength="4000" name="description" class="form-control" id="textarea" rows="3" placeholder="Product description" required></textarea>
        </div>
        <hr>
        <div class="row form-group">
            <div class="col-sm-6">
                <label for="product" class="text-light">Product:</label>
                <input value="" type="text" maxlength="40" name="product" class="form-control" id="product" placeholder="Product name" required>
            </div>
            <div class="col-sm-6">
                <label for="firm" class="text-light">Firm:</label>
                <input value="" type="text" maxlength="40" name="firm" class="form-control" id="firm" placeholder="Firm name" required>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-sm-4">
                <label for="color" class="text-light">Color:</label>
                <input type="color" maxlength="40" name="color" class="form-control" id="product" required>
            </div>
            <div class="col-sm-2">
                <label for="price" class="text-light">Price:</label>
                <input type="number" name="price" class="form-control" id="price" placeholder="Price" required>
            </div>
            <div class="col-sm-2">
                <label for="amount" class="text-light">Amount:</label>
                <input type="number" name="amount" class="form-control" id="amount" placeholder="Amount" required>
            </div>
            <div class="col-sm-4">
                <label for="type" class="text-light">Gadget Type:</label>
                    <select id="type" name="type" class="custom-select m-0">
                        <option value="smartphone" selected>Smartphone</option>
                        <option value="laptop">Laptop</option>
                        <option value="tv">TV</option>
                    </select>
            </div>
        </div>
        <hr>
        <div class="form-row justify-content-around form-group">
            <button type="reset" class="col-3 btn btn-danger" name="reset">Reset</button>
            <button type="submit" class="col-3 btn btn-success" name="add">Add</button>
        </div>

    </form>


</div>

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
