<div id="loginForm">
    <form>
        <i class="fas fa-window-close loginCloser"></i>
        <p class="formTitle">MEMBER LOGIN</p>
        <div class="inputHolder">
            <input type="email" placeholder="E-mail*" id="loginEmail" autocomplete="on" spellcheck="false"><i class="fas fa-at"></i>
        </div>
        <div class="inputHolder">
            <input type="password" placeholder="Password*" id="loginPassword"><i class="fas fa-key"></i>
        </div>
        <button id="loginBtn">Log in</button><br>
        <div class="formLinkHolder">
            <a href="#">Forgot password?</a>
            <a href="#" class="registerOpener">Register</a>
        </div>
    </form>
    <div id="loginImage">
        <p>If you don't have an account and you want to join the discussion, you'll have to register first.</p>
    </div>
</div>
<div id="registerForm">
    <form>
        <i class="fas fa-window-close registerCloser"></i>
        <p class="formTitle">NEW ACCOUNT</p>
        <div class="inputHolder">
            <input type="text" id="registerUsername" placeholder="Username*" spellcheck="false" autocomplete="off"><i class="fas fa-user"></i>
        </div>
        <div class="inputHolder">
            <input type="email" placeholder="E-mail*" id="registerEmail" autocomplete="on" spellcheck="false"><i class="fas fa-at"></i>
        </div>
        <div class="inputHolder">
            <input type="password" placeholder="Password*" id="registerPassword"><i class="fas fa-key"></i>
        </div>
        <div class="tosHolder">
            <label for="#tosCheck">I accept the <a href="data/tos.txt">terms of service</a></label>
            <input type="checkbox" id="tosCheck">
        </div>
        <button id="registerBtn">Register</button><br>
        <div class="formLinkHolder">
            <a href="#" class="loginOpener">Already have an account?</a>
        </div>
    </form>
    <div id="registerImage">
        <p>When you register, you'll become a member of the forum, and you'll be able to start new threads, and post in others.</p>
    </div>
</div>
