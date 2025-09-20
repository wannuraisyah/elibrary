<?php
include ('config.php');
if (isset($_POST["submit"])) {
    // Sanitize inputs
    $id = mysqli_real_escape_string($con, $_POST['id']);
    $title = strtoupper(mysqli_real_escape_string($con, $_POST['title']));
    $author = mysqli_real_escape_string($con, $_POST['author']);
    $type = strtoupper(mysqli_real_escape_string($con, $_POST['type']));
    $about = mysqli_real_escape_string($con, $_POST['about']);

    // Handle COVER upload
    if (isset($_FILES['cover']) && $_FILES['cover']['error'] == 0) {
        $originalCoverName = basename($_FILES['cover']['name']); // original filename
        $coverDir = "covers/";

        if (!file_exists($coverDir)) {
            mkdir($coverDir, 0755, true);
        }

        $coverName = $originalCoverName; // this will be stored in DB
        $imagepath = $coverDir . $coverName;

        // If file already exists, add timestamp
        if (file_exists($imagepath)) {
            $ext = pathinfo($originalCoverName, PATHINFO_EXTENSION);
            $nameOnly = pathinfo($originalCoverName, PATHINFO_FILENAME);
            $coverName = $nameOnly . "_" . time() . "." . $ext;
            $imagepath = $coverDir . $coverName;
        }

        if (!move_uploaded_file($_FILES["cover"]["tmp_name"], $imagepath)) {
            die("Error saving cover file.");
        }
    } else {
        die("Error uploading cover.");
    }

    // Handle FILE upload
    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
        $originalFileName = basename($_FILES['file']['name']); // original filename
        $fileDir = "files/";

        if (!file_exists($fileDir)) {
            mkdir($fileDir, 0755, true);
        }

        $fileName = $originalFileName; // this will be stored in DB
        $filepath = $fileDir . $fileName;

        // If file already exists, add timestamp
        if (file_exists($filepath)) {
            $ext = pathinfo($originalFileName, PATHINFO_EXTENSION);
            $nameOnly = pathinfo($originalFileName, PATHINFO_FILENAME);
            $fileName = $nameOnly . "_" . time() . "." . $ext;
            $filepath = $fileDir . $fileName;
        }

        if (!move_uploaded_file($_FILES["file"]["tmp_name"], $filepath)) {
            die("Error saving file.");
        }
    } else {
        die("Error uploading file.");
    }

    // ✅ Insert into database (store only filenames)
    $stmt = $con->prepare("INSERT INTO story (id, cover, title, author, type, about, file) 
                        VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $id, $coverName, $title, $author, $type, $about, $fileName);
    $stmt->execute();
    $stmt->close();

    // echo "✅ Book added successfully!";
    header("Location: book_list.php?");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Book</title>
</head>
<style>
    <?php include 'style.css' ?>
</style>
<body bgcolor="#E6EBE0">
<center>
    <h1>Add a New Book</h1>
    <div class="form-container">
        <!-- ✅ Added enctype -->
        <form class="form" method="post" action="" enctype="multipart/form-data">
            <!-- <div class="form-group">
            <label for="id">ID</label>
            <input name="id" id="id" type="text" placeholder="auto-increment" readonly>
            </div> -->
            <div class="form-group">
            <label for="title">TITLE</label>
            <input name="title" id="title" type="text" style='text-transform:uppercase' required>
            </div>
            <div class="form-group">
            <label for="author">AUTHOR</label>
            <select id="author" name="author" required>
            <option disabled selected>-choose author-</option>
                <?php
                    $show = mysqli_query($con, "SELECT * FROM writer");
                    while ($res = mysqli_fetch_array($show)) {
                        echo '<option value="' . htmlspecialchars($res['author']) . '">' . htmlspecialchars($res['author']) . '</option>';
                    }
                ?>
            </select>
            </div>
            <div class="form-group">
            <label for="type">BOOK TYPE</label>
            <input name="type" id="type" type="text" required>
            </div>
            <div class="form-group">
            <label for="about">ABOUT</label>
            <textarea cols="50" rows="10" id="about" name="about" required></textarea>
            </div>
            <div class="form-group">
            <label for="cover">BOOK COVER</label>
            <input name="cover" id="cover" type="file" required>
            </div>
            <div class="form-group">
            <label for="file">FILE</label>
            <input name="file" id="file" type="file" required>
            </div>
            <div class="card-container2">
            <button name="submit" type="submit" class="form-submit-btn">Submit</button>
            <button onclick="document.location='book_list.php'" class="form-submit-btn">Cancel</button>
            </div>
        </form>
    </div>
    <br>
</center>
</body>
</html>