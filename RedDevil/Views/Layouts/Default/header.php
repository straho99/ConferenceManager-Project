<!DOCTYPE html>
<html>

<head lang="en">
    <meta charset="UTF-8">
    <title>
        Conference Manager
    </title>
    <link rel="shortcut icon" type="image/ico" href="/Content/images/logo.png">
    <link rel="stylesheet" href="/Content/styles.css"/>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="http://code.jquery.com/jquery-2.1.4.js"></script>

</head>

<body>
<div class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class = "navbar-brand logo-container" href="/home/index">
                <img src="/Content/images/logo.png" alt="Conference Manager logo" class="logo-image" />
            </a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li><a href="/notifications/index">Notifications <span class="badge">7</span></a></li>
                <li><a href="/messages/index">Messages <span class="badge">11</span></a></li>
            </ul>
            <form class="navbar-form navbar-left" role="search" action="/search/index">
                <div class="form-group">
                    <input type="text" name="keyword" class="form-control" placeholder="Search">
                </div>
            </form>

            <ul class="nav navbar-nav navbar-right">
                <li><a href="/account/register">Register</a></li>
                <li><a href="/account/login">Login</a></li>
            </ul>
        </div>
    </div>
</div>
<div class="container body-content">

<?php include('messages.php'); ?>
