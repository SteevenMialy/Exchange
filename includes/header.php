<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>MultiShop - Online Shop Website Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="<?= BASE_URL ?>/img/favicon.ico" rel="icon">

    <!-- Font Awesome -->
    <link href="<?= BASE_URL ?>/lib/fontawesome/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="<?= BASE_URL ?>/lib/animate/animate.min.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>/css/style.min.css" rel="stylesheet">
</head>
<style>
    /* Overlay for blur */
    #overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.3);
        backdrop-filter: blur(6px);
        display: none;
        z-index: 999;
    }

    /* Modal */
    #authentification {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 500px;
        background: white;
        color: black;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
        display: none;
        z-index: 1000;
        font-family: Arial, sans-serif;
    }

    /* Title */
    #authentification h4 {
        margin-top: 0;
        margin-bottom: 20px;
        text-align: center;
    }

    /* Inputs */
    #authentification input {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid black;
        border-radius: 4px;
    }

    /* Button */
    #authentification button[type="submit"] {
        width: 100%;
        padding: 10px;
        background-color: rgb(255, 202.75, 12.75);
        border-color: #ffc800;
        color: #555555ff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    #authentification button[type="submit"]:hover {
        opacity: 0.85;
    }

    /* Error message shown below the password input */
    #authError {
        display: none;
        margin-top: 6px;
        padding: 6px 8px;
        border: 1px solid #e74c3c;
        background: #fdecea;
        color: #b00020;
        border-radius: 4px;
        font-size: 13px;
        width: 100%;
    }

    /* Close button */
    .close-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        background: transparent;
        border: none;
        font-size: 18px;
        cursor: pointer;
        color: black;
        transition: color 0.2s ease, transform 0.2s ease;
    }

    .close-btn:hover {
        color: red;
        transform: scale(1.1);
    }

    /* Responsive styles for the authentication modal */
    @media (max-width: 768px) {
        #authentification {
            width: 90%;
            padding: 20px;
        }

        #authentification h4 {
            font-size: 18px;
        }

        #authentification input {
            font-size: 14px;
            padding: 8px;
        }

        #authentification button[type="submit"] {
            font-size: 14px;
            padding: 8px;
        }

        .close-btn {
            font-size: 16px;
        }
    }
</style>

<!-- Blur overlay -->
<div id="overlay"></div>

<!-- Authentication Modal -->
<div id="authentification">
    <button class="close-btn" onclick="closeAuth()">✕</button>

    <h4>Enter your administrator password!</h4>

    <form action="<?= BASE_URL ?>/connect/admin" id="authForm" method="post">
        <div class="form-group">
            <input type="password" class="form-control" id="password" name="pwd" placeholder="Mot de passe" value="123" required>
            <div id="authError" role="alert" aria-live="assertive"></div>
        </div>
        <button id="switch" type="submit">Log in</button>
    </form>

</div>

<!-- Load the switch-user-mode script for AJAX authentication -->

<div class="container-fluid">
    <div class="row bg-secondary py-1 px-xl-5">
        <div class="col-lg-6 d-none d-lg-block">
            <div class="d-inline-flex align-items-center h-100">
                <a class="text-body mr-3" href="">About</a>
                <a class="text-body mr-3" href="">Contact</a>
                <a class="text-body mr-3" href="">Help</a>
                <a class="text-body mr-3" href="">FAQs</a>
            </div>
        </div>
        <div class="col-lg-6 text-center text-lg-right">
            <div class="d-inline-flex align-items-center">
                <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-bs-toggle="dropdown">My Account</button>
                    <div class="dropdown-menu dropdown-menu-right text-center">
                        <a href="<?= BASE_URL ?>/disconnect" class="dropdown-item" type="button">Log out</a>
                        <a href="<?= BASE_URL ?>/disconnect" class="dropdown-item d-none" id="simpleUserlink" type="button">Log as simple user</a>
                        <a onclick="openAuth()" class="dropdown-item" id="adminLink" type="button">Log in as admin</a>
                    </div>
                </div>
                <div class="btn-group mx-2">
                    <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-bs-toggle="dropdown">USD</button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <button class="dropdown-item" type="button">EUR</button>
                        <button class="dropdown-item" type="button">GBP</button>
                        <button class="dropdown-item" type="button">CAD</button>
                    </div>
                </div>
                <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-bs-toggle="dropdown">EN</button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <button class="dropdown-item" type="button">FR</button>
                        <button class="dropdown-item" type="button">AR</button>
                        <button class="dropdown-item" type="button">RU</button>
                    </div>
                </div>
            </div>
            <div class="d-inline-flex align-items-center d-block d-lg-none">
                <a href="" class="btn px-0 ml-2">
                    <i class="fas fa-heart text-dark"></i>
                    <span class="badge text-dark border border-dark rounded-circle" style="padding-bottom: 2px;">0</span>
                </a>
                <a href="" class="btn px-0 ml-2">
                    <i class="fas fa-shopping-cart text-dark"></i>
                    <span class="badge text-dark border border-dark rounded-circle" style="padding-bottom: 2px;">0</span>
                </a>
            </div>
        </div>
    </div>
    <div class="row align-items-center bg-light py-3 px-xl-5 d-none d-lg-flex">
        <div class="col-lg-4">
            <a href="" class="text-decoration-none">
                <span class="h1 text-uppercase text-primary bg-dark px-2">Takalo</span>
                <span class="h1 text-uppercase text-dark bg-primary px-2 ml-n1">Takalo</span>
            </a>
        </div>
        <div class="col-lg-4 col-6 text-left">
            <form action="">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for products">
                    <div class="input-group-append">
                        <span class="input-group-text bg-transparent text-primary">
                            <i class="fa fa-search"></i>
                        </span>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-lg-4 col-6 text-right">
            <p class="m-0">Customer Service</p>
            <h5 class="m-0">+012 345 6789</h5>
        </div>
    </div>
</div>
<!-- Topbar End -->


<!-- Navbar Start -->
<div class="container-fluid bg-dark mb-30">
    <div class="row px-xl-5">
        <div class="col-lg-3 d-none d-lg-block">
            <a class="btn d-flex align-items-center justify-content-between bg-primary w-100" data-bs-toggle="collapse" href="#navbar-vertical" style="height: 65px; padding: 0 30px;">
                <h6 class="text-dark m-0"><i class="fa fa-bars me-2"></i>Categories</h6>
                <i class="fa fa-angle-down text-dark"></i>
            </a>
            <nav class="collapse position-absolute navbar navbar-vertical navbar-light align-items-start p-0 bg-light" id="navbar-vertical" style="width: calc(100% - 30px); z-index: 999;">
                <div class="navbar-nav w-100">
                    <a href="/category/" class="nav-item nav-link">Shirts</a>
                </div>
            </nav>
        </div>
        <div class="col-lg-9">
            <nav class="navbar navbar-expand-lg bg-dark navbar-dark py-3 py-lg-0 px-0">
                <a href="" class="text-decoration-none d-block d-lg-none">
                    <span class="h1 text-uppercase text-dark bg-light px-2">Multi</span>
                    <span class="h1 text-uppercase text-light bg-primary px-2 ml-n1">Shop</span>
                </a>
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                    <div class="navbar-nav mr-auto py-0">
                        <a href="<?= BASE_URL ?>/home" class="nav-item nav-link active" id="usersimpleHome">Home</a>
                        <a href="<?= BASE_URL ?>/Adminpage" class="nav-item nav-link active d-none" id="adminHome">Home</a>
                        <a href="<?= BASE_URL ?>/shop" class="nav-item nav-link">Exchange</a>
                        <a href="<?= BASE_URL ?>/shopCart" class="nav-item nav-link">History</a>
                        <a href="<?= BASE_URL ?>/checkout" class="nav-item nav-link">Checkout</a>
                        <a href="<?= BASE_URL ?>/contact" class="nav-item nav-link">Contact</a>
                        <a href="<?= BASE_URL ?>/Accueil" class="nav-item nav-link">My Objects</a>
                        <a href="<?= BASE_URL ?>/appartenance" class="nav-item nav-link">Appartenace</a>

                    </div>
                    <div class="navbar-nav ml-auto py-0 d-none d-lg-block">
                        <a href="" class="btn px-0">
                            <i class="fas fa-heart text-primary"></i>
                            <span class="badge text-secondary border border-secondary rounded-circle" style="padding-bottom: 2px;">0</span>
                        </a>
                        <a href="" class="btn px-0 ml-3">
                            <i class="fas fa-shopping-cart text-primary"></i>
                            <span class="badge text-secondary border border-secondary rounded-circle" style="padding-bottom: 2px;">0</span>
                        </a>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>
<!-- Navbar End -->

<script src="<?= BASE_URL ?>/js/switch-user-mode.js"></script>