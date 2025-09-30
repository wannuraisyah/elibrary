<?php
    include('config.php');
    
    $query = "SELECT * FROM story";
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
        <h2>&#127775; LIST of BOOKS &#127775;</h2>

        <div class="frame">
            <div class="left-buttons">
                <button onclick="document.location='author_list.php'" class="buttone"><span class="buttone-content">Author List</span></button>
                <button class="buttonf"><span class="buttonf-content">Book List</span></button>
            </div>
            <div class="card3">
                <div style="margin-bottom:5px; display:flex; gap:10px; align-items:center;">
                    <label for="sortSelect">Sort by:</label>
                    <select id="sortSelect">
                        <option value="title">Title</option>
                        <option value="author">Author</option>
                    </select>
                    <button id="sortDirBtn" data-dir="asc">SORT</button>
                </div>
            </div>
            <div class="right-buttons">
                <button onclick="document.location='add_book.php'" class="custom-btn btn-1">New Book</button>
                <button onclick="document.location='add_writer.php'" class="custom-btn btn-1">New Author</button>
            </div>
        </div>
        <br>
        <div class="card-container">
            <?php while($res = mysqli_fetch_assoc($result)) { ?>
                <div class="card" 
                    data-title="<?= htmlspecialchars($res['title']) ?>" 
                    data-author="<?= htmlspecialchars($res['author']) ?>">
                    <img src="covers/<?= htmlspecialchars($res['cover']); ?>" width="200" height="200" alt="Cover">
                    <div class="header">
                        <center>
                            <small><?= htmlspecialchars($res['id']); ?></small><br>
                            <?= htmlspecialchars($res['author']); ?><br>
                            <?= htmlspecialchars($res['title']); ?>
                        </center>
                    </div>
                    <button class="App-button" onclick=document.location="book_info.php?id=<?= $res['id']; ?>">READ</button>
                </div>
            <?php } ?>
        </div>
        <script>
        const sortSelect = document.getElementById('sortSelect');
        const sortBtn = document.getElementById('sortDirBtn');
        const container = document.querySelector('.card-container');

        function sortCards() {
            const key = sortSelect.value;
            const dir = sortBtn.dataset.dir;
            const cards = Array.from(container.querySelectorAll('.card'));

            // Fade out
            cards.forEach(card => card.classList.add('fade-out'));

            // After fade-out ends, sort and fade in
            setTimeout(() => {
                cards.sort((a, b) => {
                    const valA = a.dataset[key].toLowerCase();
                    const valB = b.dataset[key].toLowerCase();
                    return dir === 'asc' ? valA.localeCompare(valB) : valB.localeCompare(valA);
                });
                cards.forEach(card => container.appendChild(card));

                // Fade back in
                requestAnimationFrame(() => {
                    cards.forEach(card => card.classList.remove('fade-out'));
                });
            }, 400); // match CSS transition time
        }

        // Toggle direction
        sortBtn.addEventListener('click', () => {
            sortBtn.dataset.dir = sortBtn.dataset.dir === 'asc' ? 'desc' : 'asc';
            sortBtn.textContent = sortBtn.dataset.dir === 'asc' ? '⬆️ ASC' : '⬇️ DESC';
            sortCards();
        });

        // Change sort key
        sortSelect.addEventListener('change', sortCards);
        </script>
    </center>
</body>
<br>
<footer><center><h2>&copy; WNA</h2></center></footer>
</html>
