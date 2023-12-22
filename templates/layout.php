<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title><?= $title ?></title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <link href="style.css" rel="stylesheet" /> 
    </head>
    <body>
        <header class="">
            <nav class="navbar bg-secondary navbar-expand-lg" data-bs-theme="dark">
                <div class="container-fluid d-flex justify-content-center">
                    <a class="navbar-brand" href="/">Mes projets</a>
                </div>
                </nav>
        </header>
        <div class="container mx-auto p-5">
            <?= $content ?>
        </div>
        <footer class="footer bg-secondary text-center text-lg-start">
            <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.05);">
                © 2023 Copyright:
                <a class="text-body" href="/">projet.com</a>
            </div>
        </footer>
    </body>
</html>