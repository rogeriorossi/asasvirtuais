<?php
include ('header.php');

$page = isset($_GET['page']) ? $_GET['page'] : 'home';

switch ($page) {
    case 'sobre':
        include ('sobre.php');
        break;
    default:
        include ('home.php');
        break;
}

include ('footer.php');
?>
