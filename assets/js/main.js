$(document).ready(function(){
    if(localStorage.getItem("gotit") == 'null' || localStorage.getItem("gotit") === null){
		$(".underConstruction").css("display", "flex");
	}

    let url = window.location.href;

    let pageCode = url.split("page=")[1].split("&")[0];

    //Login and register form show and hide
    $(".loginOpener").click(function(e){
        e.preventDefault();
        $("#loginForm").css("display", "flex");
        $("#registerForm").css("display", "none");
    });
    $(".loginCloser").click(function(e){
        e.preventDefault();
        $("#loginForm").css("display", "none");
    });
    $(".registerOpener").click(function(e){
        e.preventDefault();
        $("#registerForm").css("display", "flex");
        $("#loginForm").css("display", "none");
    });
    $(".registerCloser").click(function(e){
        e.preventDefault();
        $("#registerForm").css("display", "none");
    });

    //Register form validation
    let emailRegex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,6})+$/;
    let usernameRegex = /^[a-zA-Z0-9\_]{3,20}$/;
    let emailOk = false;
    let loginEmailOk = false;
    let usernameOk = false;
    let passwordOk = false;
    let tosOk = false;

    //Checks if the username and the email already exists
    //It will take two arguments
    //1. Whether the username or email are being checked
    //2. The element to get data from
    //Both arguments are strings
    function usernameAndEmailCheck(whatToCheck, element){
        $.ajax({
            url: "models/username_and_email_check.php",
            method: "post",
            dataType: "json",
            data: {
                whatToCheck: whatToCheck,
                value: $(element).val()
            },
            success: function(response){
                if(response.exists){
                    if(whatToCheck == 'email'){
                        emailOk = false;
                    }else {
                        usernameOk = false;
                    }
                    if($(element).parent().next().hasClass("validationError")){
                        $(element).parent().next().remove();
                        $(element).parent().after("<p class='validationError'>Taken</p>");
                    }else {
                        $(element).parent().after("<p class='validationError'>Taken</p>");
                    }
                }else {
                    if(whatToCheck == 'email'){
                        emailOk = true;
                    }else {
                        usernameOk = true;
                    }
                    if($(element).parent().next().hasClass("validationError")){
                        $(element).parent().next().remove();
                    }
                }
            },
            error: function(jqXHR, status, message){
                console.log(jqXHR);
            }
        });
    }

    //Funkcija koja prikazuje grešku ispod prosleđenog elementa
    function showValidationError(message, that, element = undefined){
        if(!$(that).parent().next().hasClass("validationError")){
            $(that).parent().after(`<p class="validationError">${message}</p>`);
        }
        switch(element){
            case 'username':
                usernameOk = false;
                break;
            case 'email':
                emailOk = false;
                break;
            case 'password':
                passwordOk = false;
                break;
            case 'loginEmail':
                loginEmailOk = false;
                break;
        }
    }

    //Fukcija koja sklanja greške ispod prosleđenog elementa
    function removeValidationError(that){
        if($(that).parent().next().hasClass("validationError")){
            $(that).parent().next().remove();
        }
    }

    //Na blur proverava format korisničkog imena, i da li je već u upotrebi
    $("#registerUsername").blur(function(){
        if($(this).val() != ""){
            if(!usernameRegex.test($(this).val())){
                showValidationError("Must be at least 3 characters long! Can include only letters, numbers and underscore", this, 'username');
            }else {
                usernameAndEmailCheck('username', '#registerUsername');
            }
        }else {
            usernameOk = false;
            removeValidationError(this);
        }
    });

    //Na blur proverava format email-a, i da li je već u upotrebi
    $("#registerEmail").blur(function(){
        if($(this).val() != ""){
            if(!emailRegex.test($(this).val())){
                showValidationError("Wrong e-mail format!", this, 'email');
            }else {
                usernameAndEmailCheck('email', '#registerEmail');
            }
        }else {
            emailOk = false;
            removeValidationError(this);
        }
    });

    //Na blur proverava dužinu lozinke i prikazuje potencijalnu grešku
    $("#registerPassword").blur(function(){
        if($(this).val() != ""){
            if($(this).val().length < 8){
                showValidationError("Must containt at least 8 characters", this, 'password');
            }else {
                passwordOk = true;
                removeValidationError(this);
            }
        }else {
            passwordOk = false;
            removeValidationError(this);
        }
    });

    //Na klik, smatra se da korisnik prihvata uslove, i greška se uklanja
    $("#tosCheck").click(function(){
        if($(this).parent().next().hasClass("validationError")){
            $(this).parent().next().remove();
            tosOk = true;
        }
    });

    //Na klik se radi validacija, i podaci se šalju ka fajlu za registraciju
    $("#registerBtn").click(function(e) {
        e.preventDefault();
        if(usernameOk && passwordOk && emailOk){
            if($("#tosCheck").prop("checked")){
                $.ajax({
                    url: 'models/register.php',
                    method: 'post',
                    dataType: 'json',
                    data: {
                        username: $("#registerUsername").val(),
                        email: $("#registerEmail").val(),
                        password: $("#registerPassword").val()
                    },
                    success: function(response){
                        if(response.result == 'success'){
                            $("#registerForm").css("display", "none");
                            $("#registerForm form").trigger("reset");
                            $("#loginForm").css("display", "flex");
                            $("#loginForm #loginImage p").text("Registration successful. Now, you can log in with your credentials.");
                        }else if (response.validationError) {
                            alert("There was a validation error on the server side. Please try again.");
                        }
                    },
                    error: function(jqXHR, message){
                        console.log(jqXHR.responseText);
                    }
                });
            }else {
                $("#tosCheck").parent().after(`<p class="validationError">You have to accept the terms of service</p>`);
            }
        }else {
            if(!$(this).next().hasClass("validationError")){
                $(this).after(`<p class="validationError">Make sure no fields are empty and you agree with terms of service!</p>`)
            }
        }
    });

    //Na klik, radi se validacija i podaci se šalju ka fajlu za logovanje
    $("#loginBtn").click(function(e){
        e.preventDefault();
        if(emailRegex.test($("#loginEmail").val())){
            if($("#loginEmail").parent().next().hasClass("validationError")){
                $("#loginEmail").parent().next().remove();
            }
            $.ajax({
                url: 'models/login.php',
                method: 'post',
                dataType: 'json',
                data: {
                    email: $("#loginEmail").val(),
                    password: $("#loginPassword").val()
                },
                success: function(response){
                    if(response.redirect != undefined){
                        window.location = response.redirect;
                    }
                    if(response.error != undefined){
                        if(response.error == 'Wrong password'){
                            if(!$("#loginPassword").parent().next().hasClass("validationError")){
                                $("#loginPassword").parent().after(`<p class='validationError'>${response.error}</p>`);
                            }
                        }else {
                            if(!$("#loginEmail").parent().next().hasClass("validationError")){
                                $("#loginEmail").parent().after(`<p class='validationError'>${response.error}</p>`);
                            }
                        }

                    }
                },
                error: function(message){
                    console.log(message);
                }
            });
        }else {
            if(!$("#loginEmail").parent().next().hasClass("validationError")){
                $("#loginEmail").parent().after(`<p class='validationError'>Wrong email format</p>`);
            }
        }
    });

    //Kada se izađe iz email polja kod logovanja, radi se validacija i prikazuju greške
    $("#loginEmail").blur(function(){
        if(emailRegex.test($("#loginEmail").val()) || $("#loginEmail").val() == ""){
            removeValidationError(this);
        }else {
            showValidationError('Wrong e-mail format', this, 'loginEmail');
        }
    });

    $("#loginPassword").blur(function(){
        if($(this).val() == ""){
            removeValidationError($(this));
        }
    });

    //Popunjava overview panel odgovarajućim podacima
    function fillOverviewPanel() {
        $.ajax({
            url: "models/get_overview_data.php",
            dataType: "json",
            method: "post",
            success: function(response){
                let ispis = "";
                if(response.error == undefined){
                    for(x of response.latestUsers){
                        ispis += `<tr>
                                    <td class="obsolete">${x.id}</td>
                                    <td>${x.username}</td>
                                    <td class="obsolete">${x.email}</td>
                                    <td>${x.register_time}</td>
                                </tr>`;
                    }
                    $("#latestUsersTable table tbody").html(ispis);
                    $(".totalUsers").text(response.otherData.totalUsers);
                    $(".totalPosts").text(response.otherData.totalPosts);
                    $(".totalThreads").text(response.otherData.totalThreads);
                    $(".currentlyOnline").text(response.otherData.currentlyOnline);
                    $(".bannedUsers").text(response.otherData.totalBanned);
                }else {
                    console.log(response.error);
                }
            },
            error: function(jqXHR){
                console.log(jqXHR);
            }
        });
    }

    function getSectionsForSelect(){
        $.ajax({
            url: 'models/get_sections_for_select.php',
            method: 'post',
            dataType: 'json',
            success: function(response){
                let ispis = "";
                for(x of response){
                    ispis += `
                        <option value=${x.id}>${x.title}</option>
                    `;
                }
                $("#selectSection").html(ispis);
            },
            error: function(jqXHR){
                console.log(jqXHR);
            }
        });
    }

    if(pageCode != 'show_thread' && pageCode != 'new_thread' && pageCode != 'new_post'){
        localStorage.setItem("last_pagination_part", 'null');
    }
    function loadThread(threadId, paginationPart) {
        let pageNumber = paginationPart;
        if(localStorage.getItem("last_pagination_part") != 'null'){
            pageNumber = localStorage.getItem("last_pagination_part");
        }
        $.ajax({
            url: 'models/load_thread.php',
            method: 'post',
            dataType: 'json',
            data: {
                thread_id: threadId,
                page_number: pageNumber
            },
            success: function(response) {
                if(response.error == undefined) {
                    let ispis = "";
                    for(x of response.data){
                        ispis += `
                        <div class="post">
                            <div class="postTop">
                                <div class="postData">
                                    <p>${x.post_time.substring(0, 16)}</p>
                                    ${x.is_admin_or_mod && !x.is_last_post? "<button class=\"delPostBtn btn delBtn btn-dark\" data-id=" + x.post_id + ">Remove post</button>" : ""}
                                </div>
                            </div>
                            <div class="postBottom">
                                <div class="postLeft">
                                    <div class="postCreatorAvatar"><img src="assets/images/avatars/${x.avatar}" alt="User avatar"></div>
                                    <div class="postCreatorData">
                                        <p><a href='index.php?page=show_user&id=${x.user_id}'>${x.username}</a></p>
                                        <p>${x.online_status == 1? '<i class="fas fa-circle"></i> Online' : '<i class="far fa-circle"></i> Offline'}</p>
                                        <p>Registered: ${ x.register_time.substr(0, 11)}</p>
                                        <p>Posts: ${x.no_of_posts}</p>
                                    </div>
                                </div>
                                <div class="postRight">
                                    <p>${x.content}</p>
                                </div>
                            </div>
                        </div>
                        `;
                    }
                    $("#postsHolder").html(ispis);
                    $(".delPostBtn").click(function(e){
                        deleteRow(e, 'posts');
                        loadThread(threadId, pageNumber);
                    });
                    let paginacijaIspis = '';
                    for(x of response.pagination_links){
                        paginacijaIspis += x;
                    }
                    $("#paginationLinks").html(paginacijaIspis);
                    $("#pageNumber p").text("Page: " + response.current_page);
                    $(".paginationButton").click(function(){
                        let lastPaginationPart = localStorage.setItem("last_pagination_part", $(this).attr('data-part'));
                        loadThread(threadId, $(this).attr('data-part'));
                    });
                }else {
                    console.log(response.error);
                }
            },
            error: function(jqXHR){
                console.log(jqXHR);
            }
        });
    }

    //Poziva funkciju za popunjavanje overview panela ako je stranica 'admin', na svakih deset sekundi
    if(pageCode == "admin"){
        fillOverviewPanel();
        setInterval(function(){
            fillOverviewPanel();
        }, 10000);
        getSectionsForSelect();
        setInterval(function(){
            getSectionsForSelect();
        }, 3000);
    }

    if(pageCode == "show_thread"){
        let threadId = Number(url.split("page=")[1].split("&")[1].split("=")[1]);
        //let paginationPart = Number(url.split("part=")[1]);
        loadThread(threadId, 1);
    }

    //Admin panels shifting

    //Niz koji sadrži elemente panela
    let adminPanels = [$("#overviewPanel"), $("#usersPanel"), $("#contentPanel"), $("#logsPanel"),
                        $("#bugPanel"), $("#announcementPanel"), $("#chatroomPanel"), $("#databasePanel")];


    //Čuva redni broj trenutno aktivnog panela
    let activePanel = 0;

    //Prikazuje aktivni panel na početku. To je overview panel.
    loadActivePanel(activePanel);

    //Klikom na neki od tastera, menja mu se boja, i otvara se odgovarajući panel
    $(".adminPanelsLink").click(function(){
        activePanel = $(this).attr('data-id');
        loadActivePanel(activePanel);
        $(".adminPanelsLink").css('background-color', '#fff');
        $(this).css('background-color', '#ccc');
    });

    //Sakriva sve panele izuzev trenutno aktivnog
    function loadActivePanel(panel) {
        //if(window.innerWidth > 1000){
            $(".adminPanel").css('display', 'none');
            adminPanels[panel].css('display','flex');
        //}
    }

    $("#burger").click(function(){
        if($("#drawer").css("display") == "block"){
            $("#drawer").slideUp();
        }else {
            $("#drawer").slideDown();
        }
    });

    //Vrednost koja se nalazila u polju za pretragu korisnika, kako bih osvežio tabelu sa istim vrednostima


    //Pronalazi korisnike kojima se početni deo korisničkog imena poklapa sa unetom vrednošću
    function findUser(username){
        //Čuva unetu vrednost
        findUserVal = username;
        if(/^[a-zA-Z0-9\_]*$/.test($("#findUser").val())){
            removeValidationError($("#findUser"));
            $.ajax({
                url: 'models/find_user.php',
                method: 'post',
                dataType: 'json',
                data: {
                    username: username
                },
                success: function(response){
                    let ispis = `<thead>
                        <th class="obsolete">ID</th>
                        <th>Username</th>
                        <th class="obsolete">E-mail</th>
                        <th>Role</th>
                        <th class="obsolete">Status</th>
                        <th class="obsolete">Posts</th>
                    </thead>
                    <tbody>`;
                    if(response.empty == undefined){
                        for(x of response){
                            let buttons = `
                            <td><button class="deleteUserBtn delBtn btn btn-dark" data-id=${x.id}>Del</button></td>
                            ${x.banned == 1?"<td>Banned</td>":"<td><button class='banUserBtn btn btn-dark' data-id=" + x.id + ">Ban</button></td><td><button class='givePrivBtn addBtn btn btn-dark' data-id=" + x.id + ">Role</button></td>"}
                            `;
                            ispis += `
                            <tr>
                                <td class="obsolete">${x.id}</td>
                                <td><a href="index.php?page=show_user&id=${x.id}">${x.username}</a></td>
                                <td class="obsolete">${x.email}</td>
                                <td><b>${x.userRole}</b></td>
                                <td class="obsolete">${x.online_status == 1?'online':'offline'}</td>
                                <td class="obsolete">${x.posts}</td>
                                ${x.role == 1?"":buttons}
                            </tr>
                            `;
                        }
                        ispis += '</tbody>';
                    }else {
                        ispis = '<p style="color:#aaa;padding-top:5px">No results</p>';
                    }

                    $("#usersTable").html(ispis);

                    $(".deleteUserBtn").click(function(e){
                        deleteRow(e, 'users', findUserVal);
                    });

                    $(".givePrivBtn").click(function(){
                        let user_id = $(this).attr('data-id');
                        $("#givePrivDiv").css("display", "flex");
                        $(".submitGivePriv").click(function(){
                            updateRole($("#givePrivDiv select").val(), user_id);
                        });
                    });

                    $(".banUserBtn").click(function(){
                        $.ajax({
                            url: 'models/ban_user.php',
                            method: 'post',
                            dataType: 'json',
                            data: {
                                id: $(this).attr('data-id')
                            },
                            success: function(response){
                                if(response.result == 'banned'){
                                    findUser(findUserVal);
                                }else {
                                    console.log(response);
                                }
                            },
                            error: function(jqXHR){
                                console.log(jqXHR);
                            }
                        });
                    });
                }
            });
        }else {
            showValidationError("Wrong format", $("#findUser"));
        }
    }

    $("#givePrivDiv select").change(function(){
        let textValue = '';
        let value = $("#givePrivDiv select").val();
        console.log(value);
        switch(value){
            case '1':
                textValue = "Users with this role will be able to ban, delete, and change roles of other users (except admins), to add sections, topics, and delete everything.";
                break;
            case '2':
                textValue = "Moderators can only delete posts for now.";
                break;
            case '3':
                textValue = "Basic users.";
                break;
        }
        $("#givePrivDiv p").text(textValue);
    });

    function updateRole(role, user){
        $.ajax({
            url: 'models/update_role.php',
            method: 'post',
            dataType: 'json',
            data: {
                role_id: role,
                user_id: user
            },
            success: function(response){
                //console.log(response);
            },
            error: function(jqXHR){
                console.log(jqXHR);
            }
        });
        $("#givePrivDiv").css('display', 'none');
        findUser(findUserVal);
    }

    $(".cancelGivePriv").click(function(){
        $("#givePrivDiv").css("display", "none");
    });

    function banUser(){
        $.ajax({
            url: 'models/ban_user.php',
            method: 'post',
            dataType: 'json',
            data: {
                id: $(this).attr('data-id')
            },
            success: function(response){
                if(response.result == 'banned'){
                    findUser(findUserVal);
                }
            },
            error: function(jqXHR){
                console.log(jqXHR);
            }
        });
    }

    $("#findUser").keyup(function(){
        let findUserVal = $(this).val();
        findUser(findUserVal);
    });

    //Content management

    let sectionTitleRegex = /^[A-Z]{1}[a-z]*(\s[a-z]*)*$/;
    let topicTitleRegex = /^[A-Z]{1}[a-z]*(\s[a-z]*)*$/;
    let topicDescriptionRegex = /^[A-Z]{1}[a-z]*(\s[a-z]*)*$/;

    $("#addSectionBtn").click(function(e){
        e.preventDefault();
        if(sectionTitleRegex.test($("#addSectionTitle").val())){
            $.ajax({
                url: "models/add_section.php",
                method: "post",
                dataType: "json",
                data: {
                    title: $("#addSectionTitle").val()
                },
                success: function(response){
                    alert(response.result);
                    $("#addSectionTitle").val("");
                },
                error: function (jqXHR){
                    console.log(jqXHR);
                }
            });
        }else {
            showValidationError("Only words. First letter capitalized", $("#addSectionTitle"));
        }

    });

    function findSection(val){
        if(!/[A-Za-z0-9?!.\s]/.test(val) && val != ''){
            showValidationError("Wrong format", $("#findSection"));
        }else {
            removeValidationError($("#findSection"));
            $.ajax({
                url: 'models/find_section.php',
                method: 'post',
                dataType: 'json',
                data: {
                    title: val
                },
                success: function(response){
                    let ispis = `
                    <thead>
                        <tr>
                            <th class="obsolete">ID</th>
                            <th>Title</th>
                            <th class="obsolete">Creator</th>
                        </tr>
                    </thead>
                    <tbody>
                    `;
                    if(response.result != undefined && response.result == 'empty'){
                        ispis = '<p style="color:#777">No results</p>';
                    }else {
                        for(x of response){
                            ispis += `
                            <tr>
                                <td class="obsolete">${x.id}</td>
                                <td>${x.title}</td>
                                <td class="obsolete">${x.username}</td>
                                <td><button class="deleteSectionBtn delBtn btn btn-dark" data-id=${x.id}>Del <i class="far fa-trash-alt"></i></button></td>
                            </tr>
                            `;
                        }
                        ispis += '</tbody>';
                    }
                    $("#sectionTable").html(ispis);
                    $(".deleteSectionBtn").click(function(e){
                        deleteRow(e, 'forum_sections', val);
                    });
                },
                error: function(jqXHR){
                    console.log(jqXHR);
                }
            });
        }
    }

    function findTopic(val){
        if(!/[A-Za-z0-9?!.\s]/.test(val) && val != ''){
            showValidationError("Wrong format", $("#findTopic"));
        }else {
            removeValidationError($("#findTopic"));
            $.ajax({
                url: 'models/find_topic.php',
                method: 'post',
                dataType: 'json',
                data: {
                    title: val
                },
                success: function(response){
                    let ispis = `
                    <thead>
                        <tr>
                            <th class="obsolete">ID</th>
                            <th>Title</th>
                            <th class="obsolete">Creator</th>
                            <th class="obsolete">Section</th>
                        </tr>
                    </thead>
                    <tbody>
                    `;
                    if(response.result != undefined && response.result == 'empty'){
                        ispis = '<p style="color:#777">No results</p>';
                    }else {
                        for(x of response){
                            ispis += `
                            <tr>
                                <td class="obsolete">${x.id}</td>
                                <td>${x.title}</td>
                                <td class="obsolete">${x.username}</td>
                                <td class="obsolete">${x.section}</td>
                                <td><button class="deleteTopicBtn delBtn btn btn-dark" data-id=${x.id}>Del <i class="far fa-trash-alt"></i></button></td>
                            </tr>
                            `;
                        }
                        ispis += '</tbody>';
                    }
                    $("#topicTable").html(ispis);
                    $(".deleteTopicBtn").click(function(e){
                        deleteRow(e, 'topics', val);
                    });
                },
                error: function(jqXHR){
                    console.log(jqXHR);
                }
            });
        }
    }

    function findThread(val){
        if(!/[A-Za-z0-9?!.\s]/.test(val) && val != ''){
            showValidationError("Wrong format", $("#findThreads"));
        }else {
            removeValidationError($("#findThreads"));
            $.ajax({
                url: 'models/find_thread.php',
                method: 'post',
                dataType: 'json',
                data: {
                    title: val
                },
                success: function(response){
                let ispis = `
                    <thead>
                        <tr>
                            <th class="obsolete">ID</th>
                            <th>Title</th>
                            <th class="obsolete">Creator</th>
                            <th class="obsolete">Topic</th>
                        </tr>
                    </thead>
                    <tbody>
                    `;
                    if(response.result != undefined && response.result == 'empty'){
                        ispis = '<p style="color:#777">No results</p>';
                    }else {
                        for(x of response){
                            ispis += `
                            <tr>
                                <td class="obsolete">${x.id}</td>
                                <td>${x.title}</td>
                                <td class="obsolete">${x.username}</td>
                                <td class="obsolete">${x.topic}</td>
                                <td><button class="deleteThreadBtn delBtn btn btn-dark" data-id=${x.id}>Del <i class="far fa-trash-alt"></i></button></td>
                            </tr>
                            `;
                        }
                        ispis += '</tbody>';
                    }
                    $("#threadTable").html(ispis);
                    $(".deleteThreadBtn").click(function(e){
                        deleteRow(e, 'threads', val);
                    });
                },
                error: function(jqXHR){
                    console.log(jqXHR);
                }
            });
        }
    }


    $("#findSection").keyup(function(){
        let findSectionVal = $(this).val();
        findSection(findSectionVal);
    });

    $("#findTopic").keyup(function(){
        let findTopicVal = $(this).val();
        findTopic(findTopicVal);
    });

    $("#findThreads").keyup(function(){
        let findThreadVal = $(this).val();
        findThread(findThreadVal);
    });

    $("#addTopicBtn").click(function(e){
        e.preventDefault();
        if(topicTitleRegex.test($("#addTopicTitle").val())){
            removeValidationError($("#addTopicTitle"));
            removeValidationError($("#addTopicDescription"));
            if(topicDescriptionRegex.test($("#addTopicDescription").val())){
                $.ajax({
                    url: 'models/add_topic.php',
                    method: 'post',
                    dataType: 'json',
                    data: {
                        title: $("#addTopicTitle").val(),
                        section_id: $("#selectSection").val(),
                        description: $("#addTopicDescription").val()
                    },
                    success: function(response){
                        if(response.result == 'added'){
                            alert("Success");
                            $("#addTopicTitle").val("");
                            $("#addTopicDescription").val("");
                        }else {
                            console.log(response.result);
                        }
                    },
                    error: function(jqXHR){
                        console.log(jqXHR);
                    }
                });
            }else {
                showValidationError("Description needed. Only words. First letter capitalized", $("#addTopicDescription"));
            }

        }else {
            showValidationError("Only words. First letter capitalized", $("#addTopicTitle"));
        }

    });

    //Funckija omogućava brisanje redova. Prihvata element handler, naziv tabele, i opciono, pretraživanu vrednost u slučaju da je obrisan
    //red iz neke html tabele, kako bi tabela mogla da se osveži istim vrednostima
    function deleteRow(e, table, searchVal = undefined){
        let id = parseInt(e.currentTarget.attributes['data-id'].value);
        $.ajax({
            url: 'models/delete_row.php',
            method: 'post',
            dataType: 'json',
            data: {
                table: table,
                row_id: id
            },
            success: function(response){
                if(table == 'users'){
                    if(searchVal != undefined){
                        findUser(searchVal);
                    }
                    $("#findUser").val("");
                }else if(table == 'forum_sections'){
                    if(searchVal != undefined){
                        findSection(searchVal);
                    }
                    $("#findSection").val("");
                }else if(table == 'topics'){
                    if(searchVal != undefined){
                        findTopic(searchVal);
                    }
                    $("#findTopic").val("");
                }else {
                    if(searchVal != undefined){
                        findThread(searchVal);
                    }
                    $("#findThread").val("");
                }
            },
            error: function(jqXHR){
                console.log(jqXHR);
            }
        });
    }

    //Klikom na taster, otvara se stranica za dodavanje novog thread-a na forumu
    $("#newThreadBtn").click(function(){
        lastPaginationPart = 'null';
        window.location = `index.php?page=new_thread&topic_id=${$(this).attr('data-id')}`;
    });


    //Klikom na dugme, dodaje se novi post u bazu
    $("#postAnswerBtn").click(function(){
        let thread_id = $(this).attr("data-id");
        $.ajax({
            url: 'models/add_post.php',
            method: 'post',
            dataType: 'json',
            data: {
                thread_id: thread_id,
                text: $("#postAnswerText").val()
            },
            success: function(response){
                alert(response.result);
                window.location.href = `index.php?page=show_thread&id=${thread_id}`;
            },
            error: function(jqXHR){
                console.log(jqXHR);
            }
        });
    });

    //Klikom na dugme, dodaje se novi thread
    $("#submitThreadBtn").click(function(e){
        e.preventDefault();
        function getTopicId(){
            return Number(url.substring(url.indexOf('id') + 3));
        }
        let textRegex = /^\w+/;
        let topic_id = getTopicId();
        let title = $("#newThreadTitle").val();
        let text = $("#newThreadPost").val();
        if(textRegex.test(text)){
            $.ajax({
                url: 'models/add_thread.php',
                method: 'post',
                dataType: 'json',
                data: {
                    topic_id: topic_id,
                    title: title,
                    text: text
                },
                success: function(response){
                    if(response.redirect != undefined){
                        window.location.href = response.redirect;
                    }
                },
                error: function(jqXHR){
                    console.log(jqXHR);
                }
            });
        }
    });

    //Klikom na dugme, otvara se strana za dodavanje novog posta
    $("#newPostBtn").click(function(){
        let thread_id = $(this).attr('data-id');
        window.location.href = `index.php?page=new_post&thread_id=${thread_id}`;
    });

    $(".underConstruction button").click(function(){
		$(this).parent().slideUp();
		localStorage.setItem("gotit", true);
	});

});
