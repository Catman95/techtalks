
    <?php
        $thread_id = $_GET['id'];
        $getPosts = $conn->query("SELECT * FROM posts WHERE thread_id = $thread_id");
        $getThreadTitle = $conn->query("SELECT title FROM threads WHERE id = $thread_id");
        $threadTitle = $getThreadTitle->fetch()->title;
        echo "<div class=\"threadHead\">
            <p>" . $threadTitle . "</p>
        </div>";
        echo "<div id='postsHolder'></div>";
        echo "<div id='pageNumber'><p></p></div>";
        echo "<div id='paginationLinks'></div>";
        if(isset($_SESSION['user_id']) && $_SESSION['banned'] == 0){
            echo "<button data-id=$thread_id class='btn btn-dark addBtn' id='newPostBtn'>Answer <i class=\"fas fa-clipboard\"></i></button>";
        }else {
            echo "<p class=\"banMsg\">You can't post because you're not logged in or you're banned</p>";
        }
    ?>
