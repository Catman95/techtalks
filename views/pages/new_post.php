
    <div id="postAnswer">
        <p>You are answering as: <b><?= $_SESSION['username'] ?></b></p>
        <textarea name="name" rows="8" cols="80" placeholder="Your answer goes here" id="postAnswerText"></textarea>
        <button id="postAnswerBtn" class="btn addBtn btn-dark" data-id=<?= $_GET['thread_id'] ?>>Submit</button>
    </div>
