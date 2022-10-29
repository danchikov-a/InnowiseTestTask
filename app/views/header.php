<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User form</title>

    <link rel="stylesheet" href="/css/user.css" type="text/css">
    <link rel="stylesheet" href="/css/app.css" type="text/css">
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarExample01">
                <?php use App\Services\CartService;

                if (isset($_COOKIE["userName"])): ?>
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 list-group-horizontal">
                    <li class="nav-item active">
                        <a class="nav-link" aria-current="page" href="/">Main page</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" aria-current="page" href="/welcome">Home page</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" aria-current="page" href="/file">File upload</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" aria-current="page" href="/products">Catalog</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" aria-current="page" href="/logout">Log out</a>
                    </li>
                </ul>
                    <a href="../cart"> Cart: </a>
                <?php else: ?>
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 list-group-horizontal">
                    <li class="nav-item active">
                        <a class="nav-link" aria-current="page" href="/registration">Registration</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" aria-current="page" href="/login">Login</a>
                    </li>
                </ul>
                <?php endif; ?>
            </div>
        </div>
    </nav>
</header>