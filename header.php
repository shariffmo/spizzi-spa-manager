<link rel="stylesheet" href="css/logout.css" />

<!-- header -->
<div class="header">
	<div class="jumbotron">
		<h1>Syliva Pizzi Spa</h1>
		<div style="float: right">
			<?php
				echo date("l dS Y");
			?>
		</div>
	</div>
	<?php
		if(isset($_SESSION['UserSession']))
	    {
    ?>

		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<div class="navbar-header">
					<a class="navbar-brand" href="home.php">Sylvia Pizzi Spa</a>
				</div>
				<div>
					<ul class="nav navbar-nav">
						<li><a href="home.php">Home</a></li>
						<li><a href="employee.php">Employee</a></li>
                        <li><a href="client.php">Client</a></li>
                        <li><a href="inventory.php">Inventory</a></li>
                        <li><a href="appointment.php">Appointment</a></li>
                   

                        
                        <li class="logout"><a href="logout.php">Logout</a></li>
					</ul>
				</div>
			</div>
		</nav>
    
		<?php
	    }
	?>
</div>



<!-- /sub-header -->