<link rel="stylesheet" href="css/style.css">
<?php
require_once 'core/init.php';

$user = new User ();
if (!$user->isLoggedIn()){
    Redirect::to('index.php');
}

if (Input::exists()){
    if(Token::check(Input::get('token'))){
        
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'password_current' => array(
                'required' => true,
                'min' => 6
            ),
            'password_new' => array(
                'required' => true,
                'min' => 6
            ),
            'password_new_again' => array(
                'required' => true,
                'min' => 6,
                'matches' => 'password_new'
            )
        ));

        if($validation->passed()){

            if(Hash::make(Input::get('password_current'), $user->data()->salt) !==$user->data()->password){
                echo 'Vaše aktuální heslo je špatně';
            } else {
                $salt = Hash::salt(32);
                $user->update(array(
                    'password' => Hash::make (Input::get('password_new'), $salt),
                    'salt' => $salt
                ));

                Session::flash('home', 'Vaše heslo bylo změněno!');
                Redirect::to('index.php');
            }
        } else {
            foreach ($validation->errors() as $error){
                echo $error, '<br>';
            }
        }
    }
}

?>

<form action="action" method="post">
    <div class="field">
        <label for="password_current">Aktuální heslo</label>
        <input type="password" name="password_current" id="password_current">
    </div>

    <div class="field">
        <label for="password_new">Nové heslo</label>
        <input type="password" name="password_new" id="password_new" >
    </div>

    <div class="field">
        <label for="password_new_again">Znovu zadejte heslo</label>
        <input type="password" name="password_new_again" id="password_new_again">
    </div>

    <input type="submit" value="změnit">
    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
</form>