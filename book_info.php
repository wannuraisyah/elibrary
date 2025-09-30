<?php
include('config.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // prevent SQL injection
    $query = "SELECT * FROM story WHERE id = $id LIMIT 1";
    $show = mysqli_query($con, $query);

    if ($show && mysqli_num_rows($show) > 0) {
        $res = mysqli_fetch_assoc($show);
    } else {
        die("Book not found.");
    }
} else {
    die("No book ID provided.");
}
?>
<!DOCTYPE html>
<html>
<head>
<title>INFO</title>
<style>
    <?php include 'style.css' ?>
    .container {
        position: relative;
        text-align: center;
        color: black;
    }
    .centered {
        position: absolute;
        top: 50%;
        left:48%;
        transform: translate(-50%, -250%);
    }
    table {
        text-align: center;
    }
    .btn-group .button {
        background-color: #ffffff;
        border: 1px solid green;
        color: black;
        padding: 8px 80px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        cursor: pointer;
        float: left;
    }
    a{
        width: 100px;
    }

    img {
        border-radius: 3px;
    }

    h1{
			font-family: mv boli;
    }
</style>
</head>
<body class="container">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <button onclick="document.location='book_list.php'" class="buttonback">
        <svg height="20" width="20" xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 1024 1024"><path d="M874.690416 495.52477c0 11.2973-9.168824 20.466124-20.466124 20.466124l-604.773963 0 188.083679 188.083679c7.992021 7.992021 7.992021 20.947078 0 28.939099-4.001127 3.990894-9.240455 5.996574-14.46955 5.996574-5.239328 0-10.478655-1.995447-14.479783-5.996574l-223.00912-223.00912c-3.837398-3.837398-5.996574-9.046027-5.996574-14.46955 0-5.433756 2.159176-10.632151 5.996574-14.46955l223.019353-223.029586c7.992021-7.992021 20.957311-7.992021 28.949332 0 7.992021 8.002254 7.992021 20.957311 0 28.949332l-188.073446 188.073446 604.753497 0C865.521592 475.058646 874.690416 484.217237 874.690416 495.52477z"></path></svg>
        <span>Back to library</span>
    </button>

    <center>
        <h1>Book Info</h1>
        <br>
        <table class="tablebi" bgcolor="white" border="1" bordercolor="#000000" cellspacing="0" cellpadding="5" style="width:40%; align:center">
            <tr>
                <td>
                    <center>
                        <br>
                        <img src="covers/<?php echo htmlspecialchars($res['cover']); ?>" width="150" height="200" alt="Cover">
                        <br><br>
                        <?php 
                            echo nl2br(htmlspecialchars($res['title'])) . "<br>" . 
                                 nl2br(htmlspecialchars($res['author'])) . "<br><br>" . 
                                 nl2br(htmlspecialchars(str_replace("\r\n", "\n", $res['about']))); 
                        ?>
                    </center>
                </td>
            </tr>
        </table>
        <br>
        <!-- open PDF -->
        <a href="files/<?php echo htmlspecialchars($res['file']); ?>" target="_blank" class="buttonb">READ NOW
            <svg class="icon" viewBox="0 0 24 24" fill="currentColor">
                <path fill-rule="evenodd"
                d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm4.28 10.28a.75.75 0 000-1.06l-3-3a.75.75 0 10-1.06 1.06l1.72 1.72H8.25a.75.75 0 000 1.5h5.69l-1.72 1.72a.75.75 0 101.06 1.06l3-3z"
                clip-rule="evenodd"></path>
            </svg>
        </a>
        <br>
        <?php
            $pull = mysqli_query($con, "SELECT * FROM story WHERE id = '$id' LIMIT 1");
            
            if ($pull && mysqli_num_rows($pull) > 0) {
                $story = mysqli_fetch_assoc($pull);
        ?>
    <center>
        <a href="edit_book.php?id=<?php echo $story['id']; ?>" class="buttond">
            EDIT
            <svg class="iconc" viewBox="0 0 24 24" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm4.28 10.28a.75.75 0 000-1.06l-3-3a.75.75 0 10-1.06 1.06l1.72 1.72H8.25a.75.75 0 000 1.5h5.69l-1.72 1.72a.75.75 0 101.06 1.06l3-3z"
                    clip-rule="evenodd"></path>
            </svg>
        </a>
    </center>
    <?php
            }
        ?>
        <br>
        <?php
            $author = mysqli_real_escape_string($con, $res['author']);
            $pull = mysqli_query($con, "SELECT * FROM writer WHERE author = '$author' LIMIT 1");
            
            if ($pull && mysqli_num_rows($pull) > 0) {
                $writer = mysqli_fetch_assoc($pull);
        ?>
    <center>
        <a href="author_info.php?id=<?php echo $writer['id']; ?>" class="buttonc">
            AUTHOR
            <svg class="iconc" viewBox="0 0 24 24" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm4.28 10.28a.75.75 0 000-1.06l-3-3a.75.75 0 10-1.06 1.06l1.72 1.72H8.25a.75.75 0 000 1.5h5.69l-1.72 1.72a.75.75 0 101.06 1.06l3-3z"
                    clip-rule="evenodd"></path>
            </svg>
        </a>
    </center>
    <?php
            }
        ?>
    </center>
</body>
<br>
<footer><center><h2>&copy; wannuraisyah</h2></center></footer>
</html>
