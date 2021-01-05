<?php
$pass = $_POST['pass'];

if(isset($_COOKIE['admin']) || md5($pass) == '37ca261de5b105952bd256c1576cb567') {
    //Cookie for an hour
    setcookie('admin', 'admin access', time() + 3600, '/');
    include '../secure/images_manager_content.php';
} else {
    if (isset($_POST)) {
        echo '<form method="POST" action="images_manager.php">';
        echo '    Pass <input type="password" name="pass"></input><br/>';
        echo '    <input type="submit" name="submit" value="Valider"></input>';
        echo '</form>';
    }
}
?>
