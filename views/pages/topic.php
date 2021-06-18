

<?php
$topic_id = $_GET['id'];

$topicInfo = $conn->prepare("SELECT * FROM topics WHERE id = ?");
$topicInfo->bindValue(1, $topic_id);
$topicInfo->execute();
$Row = $topicInfo->fetch();
$title = $Row->title;

echo "
<div class=\"sectionHead\">
    <div class=\"sectionTitle\">
        <p>" . $title . "</p>
    </div>
    <div class=\"postsLabel obsolete\">
        <p>Posts</p>
    </div>
    <div class=\"lastPostLabel obsolete\">
        <p>Last post</p>
    </div>
</div>";

if(isset($_SESSION['user_id'])){
    echo "<div><button id=\"newThreadBtn\" class=\"addBtn btn btn-dark\" data-id='$topic_id'>New thread <i class=\"fas fa-clipboard\"></i></button></div>";
}

$getThreads = $conn->query("SELECT th.*, u.username FROM threads th INNER JOIN users u ON th.created_by = u.id WHERE topic_id = $topic_id");

if($getThreads->rowCount() > 0){
    foreach($getThreads as $thread){
        $countPosts = $conn->query("SELECT COUNT(*) as count FROM posts WHERE thread_id = $thread->id");
        $no_of_posts = $countPosts->fetch()->count;
        $checkLastPost = $conn->query("SELECT p.*, u.username, u.id as user_id FROM posts p INNER JOIN users u ON p.created_by = u.id WHERE thread_id = $thread->id ORDER BY time_posted DESC LIMIT 1");
        $lastPost = $checkLastPost->fetch();
        $last_post_by = $lastPost->username;
        $last_time_posted = $lastPost->time_posted;
        echo "
        <div class=\"topic\">
            <div class=\"sectionTitle\">
                <div class=\"topicIcon\">
                    <img src=\"assets/images/document.png\" alt=\"Topic icon\">
                </div>
                <div class=\"topicTitleAndDescription\">
                    <div class=\"topicTitle\">
                        <a href='index.php?page=show_thread&id=" . $thread->id . "&part=1'><p>" . $thread->title . "</p></a>
                    </div>
                    <div class=\"topicDescription\">
                        <p>By <a href='index.php?page=show_user&id=" . $thread->created_by . "'>" . $thread->username . "</a></p>
                    </div>
                </div>
            </div>
            <div class=\"postsLabel obsolete\">
                <p>Posts: " . $no_of_posts . "</p>
            </div>
            <div class=\"lastPostLabel obsolete\">
                <p>by <a href=\"index.php?page=show_user&id=" . $lastPost->user_id . "\">" . $last_post_by . "</a></p>
                <p>" . substr($last_time_posted, 0, 11) . " - " . substr($last_time_posted, 11, 5) . "</p>
            </div>
        </div>
        ";
    }
}else {
    echo "<p style='padding: 30px'>No threads here</p>";
}

?>
