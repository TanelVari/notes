<?php

/*** connect_db ***/
function connect_db(){
	global $connection;

    $config = include("config.php");

	$connection = mysqli_connect($config["host"], $config["user"], $config["pass"], $config["db"]) or die("Can't connect to database - ".mysqli_error());
	mysqli_query($connection, "SET CHARACTER SET UTF8") or die("Cannot set character set - ".mysqli_error($connection));
}

/*** login ***/
function login(){
    global $connection;

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['login'])){

        // check if form fields are filled
        if (empty($_POST['username'])){
            $errors[] = 'Kasutajanimi on puudu';
        }
        if (empty($_POST['password'])){
            $errors[] = 'Parool on puudu';
        }

        // if errors then do errors on login page
        if (!empty($errors)){
            include_once('views/login.php');
            die();
        }
        else { // if no errors then try to login
            $u = mysqli_real_escape_string($connection, $_POST['username']);
            $p = mysqli_real_escape_string($connection, $_POST['password']);

            $sql = "SELECT * FROM tvari_eksam_users WHERE BINARY name = '".$u."' AND password = SHA1('".$p."')";
            $result = mysqli_query($connection, $sql);

            if ($result && mysqli_num_rows($result) == 1){

                $row = mysqli_fetch_assoc($result);
                $_SESSION['username'] = $row['name'];
                $_SESSION['user_id'] = $row['id'];

                header("Location: ?");
                die();
            }
            else {
                include_once('views/login.php');
            }
        }
    }
    else {
        include_once('views/login.php');
    }
}

/*** logout ***/
function logout(){
	$_SESSION = array();
	session_destroy();
	header("Location: ?");
}

/*** add_users ***/
function add_user(){
    global $connection;

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['add_user'])){


        $u = mysqli_real_escape_string($connection, htmlspecialchars($_POST['username']));
        $p = mysqli_real_escape_string($connection, htmlspecialchars($_POST['password']));

        $sql = "INSERT INTO tvari_eksam_users (name, password) VALUES ('".$u."', SHA1('".$p."'))";
        $result = mysqli_query($connection, $sql);

        if ($result && mysqli_insert_id($connection) > 0){
            $_SESSION['username'] = htmlspecialchars($_POST['username']);
            $_SESSION['user_id'] = mysqli_insert_id($connection);

            header("Location: ?");
            die();
        }
        else{
            $errors[] = 'Kasutaja lisamine ebaõnnestus';
            include_once('views/add_user.php');
            die();
        }
    } else {
        include_once('views/add_user.php');
        die();
    }
}


/*** show_notes ***/
function show_notes(){
    global $connection;

    if (!isset($_SESSION['username'])){
        header("Location: ?page=login");
        die();
    } else if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['add_note']) && !empty($_POST['comment'])) {
        $post = mysqli_real_escape_string($connection, htmlspecialchars($_POST['comment']));
        $uid = mysqli_real_escape_string($connection, htmlspecialchars($_SESSION['user_id']));

        $sql = "INSERT INTO tvari_eksam_notes (note, user_id) VALUES ('".$post."',".$uid.")";

        $result = mysqli_query($connection, $sql);

        if ($result && mysqli_insert_id($connection) > 0){
            include_once('views/show_notes.php');
            die();
        }
    }
    else {
        include_once('views/show_notes.php');
    }
}

?>