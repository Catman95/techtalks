<?php

    $get = $conn->query("SELECT * FROM forum_sections");
    foreach($get as $section){
        echo '
            <div class="forumSection">
                <div class="sectionHead">
                    <div class="sectionTitle">
                        <p>' . $section->title . '</p>
                    </div>
                    <div class="postsLabel obsolete">
                        <p>Threads / Posts</p>
                    </div>
                    <div class="lastPostLabel obsolete">
                        <p>Last post</p>
                    </div>
                </div>
            ';
        $getTopics = $conn->query("SELECT * FROM topics WHERE section_id = $section->id");
        if($getTopics->rowCount() > 0){
            foreach($getTopics as $topic){
                $countThreads = $conn->query("SELECT COUNT(*) as count FROM threads WHERE topic_id = $topic->id");
                $no_of_threads = $countThreads->fetch()->count;
                $countPosts = $conn->query("SELECT COUNT(*) as count FROM posts p INNER JOIN threads th ON p.thread_id = th.id WHERE th.topic_id = $topic->id");
                $no_of_posts = $countPosts->fetch()->count;
                $lastPostData = $conn->query("SELECT u.username, u.id, p.time_posted, SUBSTRING(p.content, 1, 10) as content FROM posts p INNER JOIN users u ON p.created_by = u.id INNER JOIN threads th ON p.thread_id = th.id INNER JOIN topics tp ON tp.id = th.topic_id WHERE tp.id = $topic->id ORDER BY p.time_posted DESC LIMIT 1");
                $lastPost = $lastPostData->fetch();
                $lastPostLabel = '';
                if($lastPostData->rowCount() == 1){
                    $lastPostLabel = '<p>' . $lastPost->content . '...</p>
                    <p>by <a href="index.php?page=show_user&id=' . $lastPost->id . '">' . $lastPost->username . '</a></p>
                    <p>' . substr($lastPost->time_posted, 0, 11) . '</p>';
                }else {
                    $lastPostLabel = "<p>No posts here</p>";
                }
                echo '
                <div class="topic">
                    <div class="sectionTitle">
                        <div class="topicIcon">
                            <img src="assets/images/folder.png" alt="Topic icon">
                        </div>
                        <div class="topicTitleAndDescription">
                            <div class="topicTitle">
                                <a href="index.php?page=topic&id=' . $topic->id . '"><p>' . $topic->title . '</p></a>
                            </div>
                            <div class="topicDescription">
                                <p>' . $topic->description . '</p>
                            </div>
                        </div>
                    </div>
                    <div class="postsLabel obsolete">
                        <p>Threads: ' . $no_of_threads . '</p>
                        <p>Posts: ' . $no_of_posts . '</p>
                    </div>
                    <div class="lastPostLabel obsolete">' . $lastPostLabel . '</div>
                </div>
                ';
            }
        }else {
            echo "<p style='padding: 10px'>Section empty ❗</p>";
        }

        echo "</div>";
    }

?>
