<?php

session_start();
?>

<!DOCTYPE html>
<html>
<style>

#navbar-collapse{
    width: 100%;
}
    /* Optional custom styles */
    .dropdown-submenu {
        position: relative;
    }

    .nav-default {
        background: linear-gradient(to right, #02B9FD, #2ECC71) !important;
    }

    .navbar-default .navbar-nav>.open>a,
    .navbar-default .navbar-nav>.open>a:focus,
    .navbar-default .navbar-nav>.open>a:hover {
        background-color: #2ECC71;
    }

    .nav-default .navbar-nav>li>a {
        color: white !important;
        text-decoration:none;
        list-style:none;
    }
    
    .dropdown-menu{
        background:#2ECC71;
    }


    @media (min-width: 767px) {

        .navbar-header {
            height: 7em;
            /* Adjust the height to make the header bigger */
        }

        .navbar-nav {
            margin-top: 3rem;
        }

        .navbar-brand {
            font-size: 30px;
            /* Adjust the font size to make the logo bigger */
            line-height: 100px;
            /* Vertically center the logo within the header */
            Background-color: transparent !important;
            margin-top: 0rem;
        }

        .navbar-brand img {
            height: 100px !important;
            margin-top: 0rem;
        }

    }

    @media (max-width:767px) {
        .navbar-brand {
            font-size: 40em;
            /* Adjust the font size to make the logo bigger */
            line-height: 8rem !important;
            /* Vertically center the logo within the header */
            padding: 0;
            /* Remove any default padding */

        }


        .navbar-brand img {
            max-height: 6rem;
            /* Set the maximum height for the image */
            display: block;
            /* Ensure the image is a block element */
            margin: auto;
            /* Center the image horizontally */
            margin-top: 0rem;
        }
    }

    .dropdown-submenu .dropdown-menu {
        top: 0;
        left: 100%;
        margin-top: -1px;
    }

    .btn {
        text-align: start;
    }

    /* ============ desktop view ============ */
    @media all and (min-width: 992px) {

        .dropdown-menu li {
            position: relative;
        }

        .dropdown-menu .submenu {
            display: none;
            position: absolute;
            left: 100%;
            top: -7px;
        }

        .dropdown-menu .submenu-left {
            right: 100%;
            left: auto;
        }

        .dropdown-menu>li:hover {
            background-color: #fff;
            color: black;
        }

        .dropdown-menu>li {

            color: black;
        }

        .dropdown-menu {

            color: black;
        }

        .submenu ul li {
            background-color: #fff;
            color: black;
        }

        .dropdown-menu>li:hover>.submenu {
            display: block;
        }

        .dropdown-menu.show {
            width: fit-content !important;
        }
    }

    /* ============ desktop view .end// ============ */

    /* ============ small devices ============ */
    @media (max-width: 991px) {

        .dropdown-menu .dropdown-menu {
            margin-left: 10rem;
            margin-right: 0.7rem;
            margin-bottom: .5rem;
        }

    }

    .dropdown-menu {
        width: fit-content !important;
    }

    .navbar-nav .dropdown-menu {
        position: absolute;
    }


    ul li  a {
        
        color:white !important;
    }
    
</style>


<body>
    <nav class="navbar navbar-expand-lg nav-default container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header d-flex align-items-center justify-content-between w-100">
            <a class="navbar-brand" href="index.php"><img src="/jobs/assets/images/logo45.jpeg" alt="logo">
            </a>

            <button class="navbar-toggler ml-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-collapse" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa fa-bars" aria-hidden="true"></i>
            </button>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="navbar-collapse">
            <ul class="navbar-nav mt-0">
                <li class="nav-item btn"><a href="/index.php">Home</a></li>                               
                <li class="btn btn-success"><a href="/jobs/Recruitment/unauthenticated_postings.php">Explore Jobs</a></li>

            </ul>
        </div><!-- /.navbar-collapse -->
    </nav>
    <script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function() {
        // Prevent closing from click inside dropdown
        document.querySelectorAll('.dropdown-menu').forEach(function(element) {
            element.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        });

        // Make it as an accordion for smaller screens
        if (window.innerWidth <= 991) {
            document.querySelectorAll('.dropdown-menu a').forEach(function(element) {
                element.addEventListener('click', function(e) {
                    let nextEl = this.nextElementSibling;
                    if (nextEl && nextEl.classList.contains('submenu')) {
                        // Prevent opening link if link needs to open dropdown
                        e.preventDefault();
                        // Close all other submenus
                        document.querySelectorAll('.submenu').forEach(function(submenu) {
                            if (submenu !== nextEl) {
                                submenu.style.display = 'none';
                            }
                        });
                        // Toggle display of the clicked submenu
                        if (nextEl.style.display == 'block') {
                            nextEl.style.display = 'none';
                        } else {
                            nextEl.style.display = 'block';
                        }
                    }
                });
            });
        }
    });
</script>



</body>

</html>