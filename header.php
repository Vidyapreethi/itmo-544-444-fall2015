<!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>IIT Cloud Gallery</title>
        <link rel="stylesheet" href="/resources/css/foundation.css" />
        <link rel="stylesheet" href="/resources/css/foundation-mobile.css" />
        <link rel="stylesheet" href="css/foundation-mobile.css" />
        <script src="/resources/js/vendor/modernizr.js"></script>
    </head>
    <body>
        <nav class="top-bar" data-topbar role="navigation">
            <ul class="title-area">
                <li class="name">
                    <h1><a href="logon.php">Cloud Gallery</a></h1>
                </li>
                <!-- Remove the class "menu-icon" to get rid of menu icon. Take out "Menu" to just have icon alone -->
                <li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
            </ul>

            <section class="top-bar-section">
                <!-- Right Nav Section -->
                <ul class="right">
                    
                        <li class="has-dropdown">
                            <a href="#">Admin Actions</a>
                            <ul class="dropdown">
                                <li><a href="#">Init Base Data</a></li>
                                <li><a href="#">Create Customer</a></li>
                                <li><a href="#">Create Product</a></li>
                                <li><a href="#">View All Customer</a></li>
                                <li><a href="#">All Orders</a></li>
                            </ul>
                        </li>
                    
                    
                        <li class="has-dropdown">
                            <a href="#">My Account</a>
                            <ul class="dropdown">
                                <li><a href="account.php" >Account Details</a></li>
                                <li><a href="items.php" >View Orders</a></li>
                            </ul>
                        </li>
                    
                    <!--<li class="active"><a href="<c:url value="/j_spring_security_logout" />">Logout</a></li>-->
                    <li class="active"><a href="javascript:formSubmit()">Logout</a></li>
                </ul>

                <!-- Left Nav Section -->
                <ul class="left">
                    <li class="has-dropdown">
                        <a href="#">Shop</a>
                        <ul class="dropdown">
                            <li><a href="#" >All Products</a></li>
                            <li><a href="#" >All Departments</a></li>
                        </ul>
                    </li>
                </ul>

            </section>
        </nav>     

        
            <h2>Header Included</h2>
            

        <form action="logout.php" method="post" id="logoutForm">
            <input type="hidden" 
                   name="email"
                   value="<?php echo $email; ?>" />
        </form>

        <script>
            function formSubmit() {
                document.getElementById("logoutForm").submit();
            }
        </script>