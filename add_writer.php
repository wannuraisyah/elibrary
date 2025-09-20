<?php
    include ('config.php');
    if (isset($_POST['submit'])) {
        $id = strtoupper($_POST['id']);
        $author = strtoupper($_POST['author']);
        $info = $_POST['info'];

        $query="INSERT INTO writer(id, author, info) VALUES('{$id}', '{$author}', '{$info}')";
        $tambah=mysqli_query($con,$query);

        if (!$tambah){
            echo "Something went wrong" . mysqli_error($con);
        }
        else{
            header("location:author_list.php");
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Author</title>
</head>
<style>
  <?php include 'style.css' ?>
</style>
<body bgcolor="#E6EBE0">
<center>
    <h1>Add a New Author</h1>
    <div class="form-container">
        <form class="form" method="post" action="">
            <!-- <div class="form-group">
            <label for="id">ID</label>
            <input name="id" id="id" type="text" placeholder="auto-increment" readonly>
            </div> -->
            <div class="form-group">
            <label for="author">AUTHOR</label>
            <input name="author" id="author" style='text-transform:uppercase' type="text" required>
            </div>
            <div class="form-group">
            <label for="info">INFO</label>
            <textarea cols="50" rows="10" id="info" name="info" required></textarea>
            </div>
            <div class="card-container2">
            <button name="submit" type="submit" class="form-submit-btn">Submit</button>
            <button onclick="document.location='author_list.php'" class="form-submit-btn">Cancel</button>
            </div>
        </form>
    </div>
    <br>
    <!-- <a href="book_list.php">Back to Library</a> -->
</center>
</body>
</html>