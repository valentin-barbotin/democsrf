<?php
require("header.php");
define("SECRETKEY", "Csecraay");

function generateCSRFToken() {
    $data = session_id() . time();
    $hash = hash_hmac('sha256',$data,SECRETKEY) . time();
    setcookie('csrf_token', $hash, 0, '', '', false, true);
}

function checkCSRFToken() {
    if (is_null($_COOKIE['csrf_token'])) {
        return false;
    }
    
    $timestampToken = substr($_COOKIE['csrf_token'],-10);
    $data = session_id() . $timestampToken;
    $hash = hash_hmac('sha256',$data,SECRETKEY);

    return hash_equals($_COOKIE['csrf_token'], $hash.$timestampToken);

}


if (isset($_COOKIE['csrf_token'])) {

    $check = checkCSRFToken();
    echo boolval($check);

    if ($check) {
        generateCSRFToken();
    } else {
        die("err csrf");
    }
} else {
    generateCSRFToken();
    header('Location: login.php');
    die();
}

if (!empty($_POST)) {
    $login = $_POST['login'];
    $password = $_POST['password'];

    $_SESSION['login'] = $login;
    $_SESSION['password'] = $password;
    print_r($_SESSION);
}

?>

<body>
    
<form action="" method="post">
    <input type="text" name="login" placeholder="login">
    <input type="password" name="password" placeholder="password">
    <button>Login</button>
</form>

</body>
</html>