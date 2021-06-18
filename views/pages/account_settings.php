<?php
    $User = getUserData($_SESSION['user_id']);
?>

<div id="accountSettingsHolder">
    <h1><?= $User->username ?>'s account</h1>
    <form action="models/update_user.php" method="post" enctype="multipart/form-data">
        <div id="avatarSettings">
            <div class="avatarHolder">
                <img src="assets/images/avatars/<?= $User->avatar ?>" alt="User avatar">
            </div>
            <label for="avatarInput">Change avatar</label>
            <input type="file" id="avatarInput" name="avatar_input">
        </div>
        <p><span class="validationError">ATTENTION:</span> Make sure the image is at least 250px wide and high<br>for decent quality</p>
        <h3>Biography</h3>
        <textarea rows="14" cols="80" placeholder="Short biography. (Optional)" spellcheck="false" name="shortBioInput"><?= $User->short_bio ?></textarea>
        <input type="submit" value="Update account" name="updateSubmit">
    </form>
</div>
