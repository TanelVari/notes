<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Võrgurakendused I, eksam (Tanel Vari)</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <meta name="description" content="Võrgurakendused I, eksam 2017 kevad">
    <meta name="author" content="Tanel Vari">
</head>
<body>
<div id="container">
    <div id="menu_container">
        <ul id="menu">
            <li><a href="?">Algusesse</a></li>
            <?php if(isset($_SESSION['username'])): ?>
                <li><a href="?page=add">Lisa märkus</a></li>
                <li><a href="?page=logout">Logi välja</a></li>
            <?php endif; ?>
        </ul>
    </div>
    <div id="content">