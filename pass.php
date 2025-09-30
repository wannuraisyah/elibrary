<?php
session_start();
include "config.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title> Animated Login Form - Nothing4us </title>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <link rel="stylesheet" href="./style.css">
</head>
<style>
    <?php include('style.css'); ?>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap');
    
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'poppins',sans-serif;
    }

    body {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        background-image: url(https://user-images.githubusercontent.com/13468728/233847739-219cb494-c265-4554-820a-bd3424c59065.jpg);
        background-repeat: no-repeat;
        background-position: center;
        background-size: cover;
    }

    section {
        position: relative;
        max-width: 400px;
        background-color: transparent;
        border: 2px solid rgba(255, 255, 255, 0.5);
        border-radius: 20px;
        backdrop-filter: blur(55px);
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 2rem 3rem;
    }

    h1 {
        font-size: 2rem;
        color: #fff;
        text-align: center;
    }
</style>

<body>
    <section>
        <form method="POST">
            <h1>Login</h1>
            <div class="inputbox">
                <ion-icon name="mail-outline"></ion-icon>
                <input type="text" name="username" required>
                <label for="">Username</label>
            </div>
            <div class="inputbox">
                <ion-icon name="lock-closed-outline"></ion-icon>
                <input type="password" name="password" required>
                <label for="">Password</label>
            </div>
            <button type="submit" name="login" value="login" class="buttonh">Log in</button>
        </form>
        <?php
            if (isset($_POST["login"])) {
                $username = mysqli_real_escape_string($con, $_POST['username']);
                $password = mysqli_real_escape_string($con, $_POST['password']);

                $res = mysqli_query($con, "SELECT * FROM userpass WHERE username='$username' AND password='$password'");
                $count = mysqli_num_rows($res);
                if ($count == 0) {
                    ?>
                    <div class="alert alert-warning">
                        <strong style="color:#333">Invalid!</strong> <span style="color: red;font-weight: bold;">Username Or Password.</span>
                    </div>
                    <?php
                } else {
                    $_SESSION["username"] = $username;
                    ?>
                    <script type="text/javascript">
                        window.location = "book_list.php";
                    </script>
                    <?php  
                }
            }
        ?>
    </section>
</body>
</html>

