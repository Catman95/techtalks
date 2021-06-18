
    <div id="adminHolder">
        <?php include "views/fixed/admin_panels_nav.php"; ?>
        <div class="adminPanel" id="overviewPanel">
            <div class="adminPanelHead">
                <div class="adminPanelsLinkIcon"><i class="fas fa-chart-pie"></i></div>Overview
            </div>
            <div class="adminPanelContent">
                <div id="overviewData">
                    <div class="overviewDataItem">
                        <div class="overviewDataItemHead">
                            <p>Users</p>
                        </div>
                        <div class="overviewDataItemBottom">
                            <div class="overviewDataItemBottomLeft">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="overviewDataItemBottomRight">
                                <p class="totalUsers"></p>
                            </div>
                        </div>
                    </div>
                    <div class="overviewDataItem">
                        <div class="overviewDataItemHead">
                            <p>Posts</p>
                        </div>
                        <div class="overviewDataItemBottom">
                            <div class="overviewDataItemBottomLeft">
                                <i class="fas fa-pencil-alt"></i>
                            </div>
                            <div class="overviewDataItemBottomRight">
                                <p class="totalPosts"></p>
                            </div>
                        </div>
                    </div>
                    <div class="overviewDataItem">
                        <div class="overviewDataItemHead">
                            <p>Threads</p>
                        </div>
                        <div class="overviewDataItemBottom">
                            <div class="overviewDataItemBottomLeft">
                                <i class="fas fa-clipboard"></i>
                            </div>
                            <div class="overviewDataItemBottomRight">
                                <p class="totalThreads"></p>
                            </div>
                        </div>
                    </div>
                    <div class="overviewDataItem">
                        <div class="overviewDataItemHead">
                            <p>Visits</p>
                        </div>
                        <div class="overviewDataItemBottom">
                            <div class="overviewDataItemBottomLeft">
                                <i class="fas fa-chart-bar"></i>
                            </div>
                            <div class="overviewDataItemBottomRight">
                                <p class="totalVisits">
                                    <?php

                                    $totalVisits = 0;

                                    foreach(readLogFile() as $log){
                                        if(substr($log, 0, 11) == 'Page access'){
                                            $totalVisits++;
                                        }
                                    }

                                    echo $totalVisits;

                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="overviewDataItem">
                        <div class="overviewDataItemHead">
                            <p>Currently online</p>
                        </div>
                        <div class="overviewDataItemBottom">
                            <div class="overviewDataItemBottomLeft">
                                <i class="fas fa-plug"></i>
                            </div>
                            <div class="overviewDataItemBottomRight">
                                <p class="currentlyOnline"></p>
                            </div>
                        </div>
                    </div>
                    <div class="overviewDataItem">
                        <div class="overviewDataItemHead">
                            <p>Banned</p>
                        </div>
                        <div class="overviewDataItemBottom">
                            <div class="overviewDataItemBottomLeft">
                                <i class="fas fa-user-slash"></i>
                            </div>
                            <div class="overviewDataItemBottomRight">
                                <p class="bannedUsers"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="overviewBottom">
                    <div id="pageAccess">
                        <h3>Page visits</h3>
                        <?php

                            //Prvi broj je broj poseta u poslednja 24h, drugi je broj poseta uopšte, a treći je udeo u procentima
                            $pages = ['home' => [0, 0, 0, 'Home'], 'admin' => [0, 0, 0, 'Admin'], 'account_settings' => [0, 0, 0, 'Account settings'], 'new_post' => [0, 0, 0, 'New post'], 'new_thread' => [0, 0, 0, 'New thread'],
                            'show_user' => [0, 0, 0, 'Show user'], 'author' => [0, 0, 0, 'Author'], 'show_thread' => [0, 0, 0, 'Show thread'], 'topic' => [0, 0, 0, 'Topic'], 'not_found' => [0, 0, 0, 'Not found'], 'access_forbidden' => [0, 0, 0, 'Access forbidden']];

                            $totalVisits = 0;

                            foreach(readLogFile() as $log){
                                if(substr($log, 0, 11) == 'Page access'){
                                    $timestamp = substr($log, strpos($log, 'Timestamp: ') + 11, 20);
                                    $time = strtotime($timestamp);
                                    $first_bracket = strpos($log, '[');
                                    $first_comma = strpos($log, ',');
                                    $length = $first_comma - $first_bracket;
                                    $page = substr($log, $first_bracket + 1, $length - 1);
                                    mark_visit($page, $time);
                                }
                            }

                            show_page_visits($pages);

                        ?>
                    </div>
                </div>
                <div id="logFileDiv">
                    <h3>Logs</h3>
                    <p id="log">
                        <?php

                            foreach(readLogFile() as $log){
                                echo $log . "<br>";
                            }

                        ?>
                    </p>
                </div>

            </div>
        </div>
        <div class="adminPanel" id="usersPanel">
            <div class="adminPanelHead">
                <div class="adminPanelsLinkIcon"><i class="fas fa-user-friends"></i></div>Users
            </div>
            <div id="givePrivDiv">
                <h3>Choose role</h3>
                <select>
                    <?php
                        try {
                            $roles = retrieveData("SELECT * FROM user_roles");
                            foreach($roles as $row){
                                echo "<option value=$row->id>" . ucfirst($row->role) . "</option>";
                            }
                        } catch (PDOException $e) {
                            log_error($e);
                            echo $e->getMessage();
                        }
                    ?>
                </select>
                <p>Users with this role will be able to ban, delete, and change roles of other users (except admins), to add sections, topics, and delete everything.</p>
                <button class="btn addBtn btn-dark submitGivePriv">Submit</button>
                <button class="btn delBtn btn-dark cancelGivePriv">Cancel</button>
            </div>
            <div class="adminPanelContent">
                <div class="adminPanelContentHolder">
                    <h3>Find users</h3>
                    <input type="text" id="findUser" class="adminSearchBar" placeholder="Username">
                    <table class="customTable" id="usersTable">
                    </table>
                </div>
                <div class="adminPanelContentHolder">
                    <div class="customTable" id="latestUsersTable">
                        <h3>Latest users</h3>
                        <table>
                            <thead>
                                <tr>
                                    <th class="obsolete">ID</th>
                                    <th>Username</th>
                                    <th class="obsolete">E-mail</th>
                                    <th>Register timestamp</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                        <a href="models/excel_export2.php" class="exportLink excel">Export to excel <i class="fas fa-file-excel"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="adminPanel" id="contentPanel">
            <div class="adminPanelHead">
                <div class="adminPanelsLinkIcon"><i class="fas fa-clipboard"></i></div>Content
            </div>
            <div class="adminPanelContent">
                <div class="adminPanelContentHolder">
                    <form class="addContent" id="addSectionForm">
                        <h3>Add section</h3>
                        <input type="text" placeholder="Section title" id="addSectionTitle">
                        <button id="addSectionBtn" class="addBtn btn btn-dark">Add</button>
                    </form>
                </div>
                <div class="adminPanelContentHolder">
                    <form class="addContent" id="addTopicForm">
                        <h3>Add topic</h3>
                        <input type="text" placeholder="Topic title" id="addTopicTitle">
                        <input type="text" id="addTopicDescription" placeholder="Short description">
                        <select id="selectSection">
                        </select>
                        <button id="addTopicBtn" class="addBtn btn btn-dark">Add</button>
                    </form>
                </div>
                <div class="adminPanelContentHolder">
                    <h3>Find sections</h3>
                    <input type="text" id="findSection" class="adminSearchBar" placeholder="Section title">
                    <table class="customTable" id="sectionTable">
                    </table>
                </div>
                <div class="adminPanelContentHolder">
                    <h3>Find topics</h3>
                    <input type="text" id="findTopic" class="adminSearchBar" placeholder="Topic title">
                    <table class="customTable" id="topicTable">
                    </table>
                </div>
                <div class="adminPanelContentHolder">
                    <h3>Find threads</h3>
                    <input type="text" id="findThreads" class="adminSearchBar" placeholder="Thread title">
                    <table class="customTable" id="threadTable">
                    </table>
                </div>
            </div>
        </div>
        <!--COMING SOON
        <div class="adminPanel" id="logsPanel">
            <div class="adminPanelHead">
                <div class="adminPanelsLinkIcon"><i class="fas fa-file-alt"></i></div>Logs
            </div>
            <div class="adminPanelContent">

            </div>
        </div>
        <div class="adminPanel" id="bugPanel">
            <div class="adminPanelHead">
                <div class="adminPanelsLinkIcon"><i class="fas fa-bug"></i></div>Bug reports
            </div>
            <div class="adminPanelContent">

            </div>
        </div>
        <div class="adminPanel" id="announcementPanel">
            <div class="adminPanelHead">
                <div class="adminPanelsLinkIcon"><i class="fas fa-drum"></i></div>Announcements
            </div>
            <div class="adminPanelContent">

            </div>
        </div>
        <div class="adminPanel" id="chatroomPanel">
            <div class="adminPanelHead">
                <div class="adminPanelsLinkIcon"><i class="fas fa-comments"></i></div>Admin chatroom
            </div>
            <div class="adminPanelContent">

            </div>
        </div>
        <div class="adminPanel" id="databasePanel">
            <div class="adminPanelHead">
                <div class="adminPanelsLinkIcon"><i class="fas fa-database"></i></div>Browse database
            </div>
            <div class="adminPanelContent">

            </div>
        </div>-->
    </div>
