<link rel="stylesheet" href="css/style.css">
<?php
require_once 'core/init.php';

if(!$usernam = Input::get('user')){
    Redirect::to('index.php');
} else {
    $user = new User($username);
    if(!$user->exists()){
        Redirect::to(404);
    } else {
        $data = $user->data();
    }
    ?>
    <h3><?php echo escape($data->username); ?></h3>
    <p>Celé jméno: <?php echo escape($data->name); ?></p>
    <?php
}

