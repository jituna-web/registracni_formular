
<style>
    p{
        margin-left: 40px;
        margin-top: 20px;
        border: 2px solid black;
        border-radius: 3px;
        font-size: 25px;
        max-width: 400px;
        
    }
    body{
        background-image: url(https://images.unsplash.com/photo-1501630834273-4b5604d2ee31?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1500&q=80);

    }
</style>
<?php
require_once 'core/init.php';

if (Session::exists('home')){
    echo '<p>' . Session::flash('home') . '</p>';
}

$user = new User();
if ($user->isLoggedIn()){
   
?>
    <p>Vítejte <a href="profile.php?user=<?php echo escape($user->data()->username);  ?>"> <?php echo escape($user->data()->username); ?> </a>!</p>

    <ul>
        <li><a href="logout.php"> Odhlásit se</a></li>
        <li><a href="update.php"> Aktualizovat informace</a></li>
        <li><a href="changepassword.php">Změna hesla</a></li>
    </ul>
<?php

if (!$user->hasPermission ('admin')){
    echo '<p>Jste administrátor.</p>';
}
}else {
    echo '<p> Můžete se <a href="login.php">přihlásit</a> nebo <a href="register.php"> registrovat.</a></p>';
}

?>
