<?php 
    $racine = (isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
?>

<head>
    <title>06Games</title>
    <link rel="icon" type="image/png" href="<?= $racine ?>assets/images/logo.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="<?= $racine ?>/assets/css/main.css" />

    <script src="https://ajax.aspnetcdn.com/ajax/jquery/jquery-3.3.1.min.js"></script>
</head>

<body>
    <?php include(".templates/loading.html"); ?>

    <header>
        <a href="<?= $racine ?>"><img src="assets/images/logo.png" style="max-width: 40px;" />06Games</a>
    </header>
</body>