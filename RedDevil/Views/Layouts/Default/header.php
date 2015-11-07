<!DOCTYPE html>
<html>

<head lang="en">
    <meta charset="UTF-8">
    <title>

    </title>
    <link rel="stylesheet" href="/Content/styles.css"/>
    <script src="http://code.jquery.com/jquery-2.1.4.js"></script>

</head>

<body>
    <header>
        <a href=""><img src="/Content/images/site-logo.png"></a>
        <span>
            <strong>
                <?php if (isset($_SESSION['username'])) {
                    echo 'User: ' . $_SESSION['username'];
                }?>
            </strong>

        </span>
        <ul>
            <li><a href="user">Home</a></li>
            <li><a href="">Action</a></li>
            <li><a href="logout">Logout</a></li>
        </ul>
    </header>

<?php include('messages.php'); ?>
