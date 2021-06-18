<?php
    $user_id = $_GET['id'];
    $User = getUserData($user_id);
?>


    <div id="showUserHolder">
        <h1><?= $User->username ?></h1>
        <p><?= ($User->online_status == 1? '<i class="fas fa-circle"></i> Online' : '<i class="far fa-circle"></i> Offline') ?></p>
        <div id="avatarAndBio">
            <img src="assets/images/avatars/<?= $User->avatar ?>" alt="User avatar">
            <p><?= $User->short_bio ?></p>
        </div>
        <div id="showUserData">
            <p><b>E-mail: </b><?= $User->email ?></p>
            <p><b>Member since: </b><?= $User->register_time ?></p>
            <p><b>Role: </b><?= getUserRole($User->role) ?></p>
        </div>
        <div id="latestUserPosts">
            <h3>Latest posts</h3>
            <?php
                $usersPosts = getUsersPosts($User->id, 3);
                if(sizeof($usersPosts) > 0){
                    echo "<table class='customTable'><thead><tr><th>Text</th><th>Date</th></tr></thead><tbody>";
                    foreach($usersPosts as $row){
                        $date = substr($row->time_posted, 0, 11);
                        echo "<tr>
                            <td>$row->content</td>
                            <td>$date</td>
                        </tr>";
                    }
                    echo "</tbody></table>";
                }else {
                    echo "<p>This user has never posted</p>";
                }

            ?>
        </div>
    </div>
