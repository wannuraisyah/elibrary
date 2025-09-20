<?php
include('config.php');

// Get book ID from URL
if (!isset($_GET['id'])) {
    die("No book selected.");
}
$book_id = intval($_GET['id']);

// Fetch current book data
$result = mysqli_query($con, "SELECT * FROM story WHERE id = $book_id");
if (!$result || mysqli_num_rows($result) == 0) {
    die("Book not found.");
}
$book = mysqli_fetch_assoc($result);

if (isset($_POST["submit"])) {
    $title = strtoupper(mysqli_real_escape_string($con, $_POST['title']));
    $author = mysqli_real_escape_string($con, $_POST['author']);
    $type = strtoupper(mysqli_real_escape_string($con, $_POST['type']));
    $about = $_POST['about'];

    // Keep old cover/file by default
    $imagepath = $book['cover'];
    $filepath = $book['file'];

    // Update COVER if uploaded
    if (isset($_FILES['cover']) && $_FILES['cover']['error'] == 0) {
        $ext = pathinfo($_FILES['cover']['name'], PATHINFO_EXTENSION);
        $newfilename = uniqid("cover_", true) . "." . $ext;
        $imagepath = "covers/" . $newfilename;

        if (!file_exists('covers')) {
            mkdir('covers', 0755, true);
        }
        move_uploaded_file($_FILES["cover"]["tmp_name"], $imagepath);
    }

    // Update FILE if uploaded
    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
        $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
        $newfilename2 = uniqid("file_", true) . "." . $ext;
        $filepath = "files/" . $newfilename2;

        if (!file_exists('files')) {
            mkdir('files', 0755, true);
        }
        move_uploaded_file($_FILES["file"]["tmp_name"], $filepath);
    }

    // Update database
    $stmt = $con->prepare("UPDATE story 
        SET cover=?, title=?, author=?, type=?, about=?, file=? 
        WHERE id=?");
    $stmt->bind_param("ssssssi", $imagepath, $title, $author, $type, $about, $filepath, $book_id);
    $stmt->execute();
    $stmt->close();

    header("Location: book_info.php?id=$book_id");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book</title>
</head>
<style>
    <?php include 'style.css' ?>
</style>
<body bgcolor="#E6EBE0">
<center>
    <h1>Edit Book</h1>
    <div class="form-container">
        <form class="form" method="post" action="" enctype="multipart/form-data">
            <div class="form-group">
            <label for="id">ID</label>
            <input value="<?= htmlspecialchars($book['id']) ?>" readonly>
            </div>
            <div class="form-group">
            <label for="title">TITLE</label>
            <input name="title" id="title" type="text" 
                value="<?= htmlspecialchars($book['title']) ?>" style='text-transform:uppercase' required>
            </div>
            <div class="form-group">
            <label for="author">AUTHOR</label>
            <select id="author" name="author" required>
            <option disabled>-choose author-</option>
                <?php
                    $show = mysqli_query($con, "SELECT * FROM writer");
                    while ($res = mysqli_fetch_array($show)) {
                        $selected = ($res['author'] == $book['author']) ? "selected" : "";
                        echo '<option value="' . htmlspecialchars($res['author']) . '" ' . $selected . '>' 
                             . htmlspecialchars($res['author']) . '</option>';
                    }
                ?>
            </select>
            </div>
            <div class="form-group">
            <label for="type">BOOK TYPE</label>
            <input name="type" id="type" type="text" 
                value="<?= htmlspecialchars($book['type']) ?>" required>
            </div>
            <div class="form-group">
            <label for="about">ABOUT</label>
            <textarea required cols="50" rows="10" id="about" name="about"><?= htmlspecialchars($book['about']) ?></textarea>
            </div>
            <div class="form-group">
            <label for="cover">BOOK COVER (Leave blank to keep old)</label>
            <input name="cover" id="cover" type="file">
            <br>Current: <img src="<?= htmlspecialchars($book['cover']) ?>" width="100">
            </div>
            <div class="form-group">
            <label for="file">FILE (Leave blank to keep old)</label>
            <input name="file" id="file" type="file">
            <br>Current: <?= basename($book['file']) ?>
            </div>
            <div class="card-container2">
            <button name="submit" type="submit" class="form-submit-btn">Update</button>
            <button type="button" onclick="history.back()" class="form-submit-btn">Cancel</button>
            </div>
        </form>
    </div>
    <br>
</center>
</body>
</html>
