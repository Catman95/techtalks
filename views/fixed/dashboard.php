<div id="dashboard">
    <div id="userData">
            <p>Logged in as <?= $_SESSION['username']; ?></p>
    </div>
    <div id="dashboardLinks">

        <?php

            $dashboard_links = retrieveData("SELECT * FROM menu_items WHERE menu = 'dashboard'");
            foreach($dashboard_links as $row){
                if($row->link == 'index.php?page=admin'){
                    if($_SESSION['role'] == 1){
                        echo "<a href=\"$row->link\">$row->text</a>";
                    }
                }else {
                    echo "<a href=\"$row->link\">$row->text</a>";
                }
            }

        ?>
    </div>
</div>
