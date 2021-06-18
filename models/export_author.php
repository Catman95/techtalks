<?php

    require "../config/config.php";

    try {
        $author = getRow("SELECT * FROM developers WHERE id = 1");
        //var_dump($author);

        $wordApp = new COM("Word.Application") or die("Unable to instantiate Word");
        $wordApp->Visible = true;

        $wordApp->Documents->Add();
        $wordApp->Selection->TypeText($author['full_name'] . "\n" . $author['short_bio'] . "\n" . "E-mail: " . $author['email'] . "\n" . "Location: " . $author['location'] . "\n" . "DOB: " . $author['dob']);

        $wordApp->Documents[1]->SaveAs("about_author.doc");

        header("../index.php?page=author");
    }catch (PDOexception $e){
        echo $e->getMessage();
        log_error($e);
    }

?>
