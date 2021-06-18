</main>
<footer id="footer">
    <div id="footerTop">
        <div id="footerPages">
            <ul>
                <?php

                    $footer_links = retrieveData("SELECT * FROM menu_items WHERE menu = 'footer'");
                    foreach($footer_links as $row){
                        echo "<li><a href=\"$row->link\" target=\"_blank\">$row->text</a></li>";
                    }

                ?>
            </ul>
        </div>
        <div id="footerContact">
            <ul>
                <li>Aleksandar Stanković 33/17</li>
                <li>aleksandar.stankovic.33.17@ict.edu.rs</li>
                <li>Some street XY</li>
                <li>Mladenovac</li>
                <li>060/7606-916</li>
            </ul>
        </div>
        <div id="footerSocial">
            <?php

                $social_links = retrieveData("SELECT * FROM menu_items WHERE menu = 'social'");
                foreach($social_links as $row){
                    echo "<a href=\"$row->link\" target=\"_blank\">$row->text</a>";
                }

            ?>
        </div>
    </div>
    <div id="footerBottom">
        <p>&copy; Copyright: Aleksandar Stanković 2019. Zero rights reserved. This is just a decoraton.</p>
    </div>
</footer>
<div class="underConstruction">
    <img src="assets/images/underconstruction.png" alt="Under construction">
    <button type="button" name="button">Got it!</button>
</div>
</div>
<script src="assets/js/jquery.js"></script>
<script src="assets/js/main.js"></script>
</body>
</html>
<?php $conn = null ?>
