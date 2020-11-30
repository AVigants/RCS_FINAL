<?php
    date_default_timezone_set('Europe/Riga');

    if (isset($_GET["page"])) {
        $file = __DIR__ . "/controllers/" . $_GET["page"] . "_controller.php";
        session_start();
    }

    if(file_exists($file)){
        
        if($_GET['page'] === 'login'){
            require_once $file;
        } 
        else if (isset($_SESSION['user_id'])){
            require_once $file;
        } 
        else{
        Header("Location: /be_project_mvc/?page=login");
        }
    } else {
        Header("Location: /be_project_mvc/?page=login");
    }
?>

