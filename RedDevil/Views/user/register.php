<h2>
    <?php
    if (isset(\RedDevil\View::$viewBag['title'])) {
        echo \RedDevil\View::$viewBag['title'];
    }
    ?>
</h2>

<form action="" method="post">
    <label for="username">Username: </label>
    <input type="text" name="username" id="username"/>
    <br/>
    <label for="password">Password: </label>
    <input type="password" name="password" id="password"/>
    <br/>
    <input type="submit" value="Register"/>
    <br/>
    <br/>
    Existing user? <a href="/user/login">Login</a>

</form>

<?php
?>