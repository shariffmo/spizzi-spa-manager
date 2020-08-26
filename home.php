<?php
	session_start();
    //if the user is not logged in, redirect them to the loggin page
	if(!isset($_SESSION['UserSession']))
	{
		header('Location: index.php');
		die();
	}

?>
    <!DOCTYPE HTML>
    <html>

    <head>
        <link rel="stylesheet" href="css/bootstrap.min.css" />
        <link rel="stylesheet" href="css/bootstrap-theme.min.css" />
        <script type="text/javascript" src="bootstrap.min.js"></script>
        <script type="text/javascript" src="jquery.min.js"></script>
    </head>

    <body>


        <div class="container">
            <?php include 'header.php' ?>
                <!-- container -->
                <!-- content -->
                <div class="content">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="well">
                                Welcome Sylvia Pizzi
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="well">
            
                                <h2>My Websites Quick Access</h2>                    
                                <ul id="horizontal-menus">
                                    <li><a href="http://www.sylviapizzispa.com/" target="_blank">Sylvia Pizzi Website</a></li>
                                    <li><a href="http://www.sylviapizzispa.com/en_products.html" target="_blank">Products</a></li>
                                    <li><a href="http://www.sylviapizzispa.com/en_treatments.html" target="_blank">Treatments</a></li>
                                    <li><a href="http://www.sylviapizzispa.com/en_symptoms.html" target="_blank">Symptoms</a></li>
                        

                                </ul>

                                <h3>Facebook</h3>

                                    <li><a href="https://www.facebook.com/SylviaPizziSpa/" target="_blank">Sylvia Spa Facebook Page</a></li>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">

                            
                        <!--     <div class="well">
                                
                            </div>
 -->

                        </div>
                    </div>
                </div>
                <!-- top-grids -->
                <!-- content -->
                <?php include 'footer.php' ?>
                    <!-- container -->
        </div>
    </body>

    </html>