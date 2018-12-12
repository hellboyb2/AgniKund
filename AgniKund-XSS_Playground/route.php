<!-- Created By Bittu Kumar On 30-11-2018 -->

<?php

$request_uri = explode('?', $_SERVER['REQUEST_URI'], 2);
$file_path = explode('/', $request_uri[0], 5);

// Just a generic router.
switch ($file_path[1]) {

    case '':
        require './index.php';
        break;

    case 'index':
        require './index.php';
        break;

    case 'Stored':
        require './Stored.php';
        break;

    case 'Reflected':
        require './Reflected.php';
        break;

    case 'Dom':
        require './Dom.php';
        break;

    case 'About':
        require './About.php';
        break;

    case 'Stored_XSS':
        switch($file_path[2]) {

            case 'Level1':
                require './Stored/Stored_Level1.php';
                break;

            case 'Level2':
                require './Stored/Stored_Level2.php';
                break;

            case 'Level3':
                require './Stored/Stored_Level3.php';
                break;

            case 'Level4':
                require './Stored/Stored_Level4.php';
                break;

            case 'Level5':
                require './Stored/Stored_Level5.php';
                break;

            default:
                require './index.php';
                break;
        }
        break;

    case 'Reflected_XSS':
        switch($file_path[2]) {

            case 'Level1':
                require './Reflected/Reflected_Level1.php';
                break;

            case 'Level2':
                require './Reflected/Reflected_Level2.php';
                break;

            case 'Level3':
                require './Reflected/Reflected_Level3.php';
                break;

            case 'Level4':
                require './Reflected/Reflected_Level4.php';
                break;

            default:
                require './index.php';
                break;
        }
        break;

    case 'Dom_XSS':
        switch($file_path[2]) {

            case 'Level1':
                require './Dom/Dom_Level1.php';
                break;

            case 'Level2':
                require './Dom/Dom_Level2.php';
                break;

            default:
                require './index.php';
                break;
        }
        break;

    default:
        require './index.php';
        break;
}

?>