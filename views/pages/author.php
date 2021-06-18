<?php
    try {
        $author = getRow("SELECT * FROM developers WHERE id = 1");
    }catch (PDOexception $e){
        echo $e->getMessage();
        log_error($e);
    }
?>
<div id="showUserHolder">
    <h1><?= $author['full_name'] ?></h1>
    <div id="avatarAndBio">
        <img src="assets/images/<?= $author['image_link'] ?>" alt="Author picture">
        <p><?= $author['short_bio'] ?></p>
    </div>
    <div id="showUserData">
        <p><b>E-mail: </b><?= $author['email'] ?></p>
        <p><b>Location: </b><?= $author['location'] ?></p>
        <p><b>DOB: </b><?= $author['dob'] ?></p>
    </div>
    <a href="models/export_author.php" class="exportLink word">Export to word <i class="fas fa-file-word"></i></a>
</div>
