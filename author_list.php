<?php
    include('config.php');

    $query = "SELECT * FROM writer";
    $result = mysqli_query($con, $query);
?>
<html>
<head>
    <title>index test</title>
    <style>
        <?php include('style.css'); ?>

        h1 {
            font-family: lucida handwriting;
        }
    </style>
</head>
<body class="container2">
    <center>
        <h1>Welcome to Your Library</h1>
        <h2>&#127775; LIST of AUTHORS &#127775;</h2>

        <div class="frame">
            <div class="left-buttons">
                <button class="buttonf"><span class="buttonf-content">Author List</span></button>
                <button onclick="document.location='book_list.php'" class="buttone"><span class="buttone-content">Book List</span></button>
            </div>

            <div class="right-buttons">
                <button onclick="document.location='add_book.php'" class="custom-btn btn-1">New Book</button>
                <button onclick="document.location='add_writer.php'" class="custom-btn btn-1">New Author</button>
            </div>
        </div>

        <div class="card-container">
            <?php while($res = mysqli_fetch_assoc($result)) { ?>
                <div class="card2">
                    <div class="header">
                        <center><small><?php echo htmlspecialchars($res['id']); ?></small><br>
                        <?php echo htmlspecialchars($res['author']); ?><br></center>
                    </div>
                    <a class="App-button2" href="author_info.php?id=<?php echo $res['id']; ?>">MORE</a>
                </div>
            <?php } ?>
        </div>
    </center>
</body>
<br>
<footer><center><h2>&copy; WNA</h2></center></footer>
</html>
