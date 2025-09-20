<?php
include ('config.php');

$id = $_GET['id'];

// Get current data
$edit = mysqli_query($con, "SELECT * FROM writer WHERE id='$id'");
$res = mysqli_fetch_array($edit);

$author = $res['author'];
$info   = $res['info'];

if (isset($_POST['submit'])) {
    $id     = $_POST['id'];
    $author = strtoupper($_POST['author']);  // make uppercase
    $info   = $_POST['info'];

    // ✅ Correct UPDATE query
    $query = "UPDATE writer SET author='$author', info='$info' WHERE id='$id'";
    $update = mysqli_query($con, $query);

    if (!$update) {
        echo "Something went wrong: " . mysqli_error($con);
    } else {
        header("Location: author_info.php?id=$id");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Author</title>
</head>
<style>
    <?php include 'style.css' ?>
</style>
<body bgcolor="#E6EBE0">
<center>
    <br>
    <h1>Edit Author Info</h1>
    <br>
    <div class="form-container">
        <!-- ✅ Must add method="post" -->
        <form class="form" method="post" action="">
            <div class="form-group">
                <label for="id">ID</label>
                <input name="id" id="id" type="text" value="<?php echo $id; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="author">AUTHOR</label>
                <input name="author" id="author" type="text" style="text-transform:uppercase" 
                       value="<?php echo $author; ?>">
            </div>
            <div class="form-group">
                <label for="info">INFO</label>
                <textarea id="info" name="info"><?php echo $info; ?></textarea>
            </div>
            <div class="card-container2">
                <!-- ✅ Button needs name="submit" -->
                <button type="submit" name="submit" class="form-submit-btn">Submit</button>
                <button type="button" onclick="history.back()" class="form-submit-btn">Cancel</button>
            </div>
        </form>
    </div>
</center>
</body>
</html>