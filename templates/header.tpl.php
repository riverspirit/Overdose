<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Intellwiz Management Console</title>
        <link rel="stylesheet" href="css/style.css" />
        <script src="js/intellwiz.js"></script>
    </head>
    <body>
        <div id="container">
            <div id="header">
                <span class="logo" style="color:#7F7F7F; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-size:48px;">INTE</span><span style="color:#88C23E; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-size:48px;">L</span><span style="color:#7F7F7F; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-size:48px;">LWIZ</span>
                <span class="greetingText">Hello <?php echo $_SESSION['admin']['name']; ?> ( <a href="login.php?action=logout" title="Logout">Logout</a> )</span>
            </div>