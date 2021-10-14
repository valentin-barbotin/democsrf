<?php
require("header.php");
require("functions.php");


// if (isset($_COOKIE['csrf_token'])) {

//     $check = checkCSRFToken();
//     if ($check) {
//         $csrftoken = generateCSRFToken();
//     } else {
//         setcookie('csrf_token', '', 1, '', '', false, true);
//         echo "CSRF Token is invalid";
//     }
// } else {
//     $csrftoken = generateCSRFToken();
// }

$csrftoken = generateCSRFToken(); // A chaque affichage de la page, on génère un nouveau token

if (!empty($_POST)) {
    $login = $_POST['login'];
    $password = $_POST['password'];

    $check = checkCSRFToken(); // On vérifie que le token est valide (dans le formulaire de connection)
    if (!$check) {
        die("CSRF Token is invalid");
    }

    if (empty($login) || empty($password)) {
        echo "<h3>Veuillez remplir tous les champs</h3><br><br>";
    } else {
        if ($login == "admin" && $password == "admin") { // Authentification très sécurisée*
            $_SESSION['login'] = $login;
            $_SESSION['password'] = $password;
        } else {
            echo "<h3>Identifiants incorrects</h3><br><br>";
        }
    }

}

if (isset($_SESSION['login']) && isset($_SESSION['password'])) { // Si l'utilisateur est connecté on affiche son username
    print_r($_SESSION);
    $login = $_SESSION['login'];
    echo "<h3>Vous êtes connecté: $login</h3><br><br>";
}

?>

<body>
    
<form action="" method="post">
    <input type="text" name="login" placeholder="login">
    <input type="password" name="password" placeholder="password">
    <input type="hidden" name="csrf_token" value="<?php echo $csrftoken ?>"> <!-- On ajoute un champ caché qui contient le token (ajout) -->
    <button>Login</button>
</form>

</body>
</html>