<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

try {
    require './classes/WShield.php';
    require './classes/ToolBox.php';
    require './classes/Navigation.php';
    require './classes/Database.php';
    require './classes/User.php';

    $Navigation = new Navigation('page', 'files', 'home');
    $User = (isset($_SESSION['user_id']))
        ? new User(
            new Database('localhost', 'livre_or', 'root', ''),
            $_SESSION['user_id']
        )
        : null;
} catch (Exception $e) {
    die("Une erreur est survenue lors du chargement de la configuration :<br/>" . $e->getMessage());
} 