<?php
	require_once 'database.php';
	session_start();
	if(!isset($_SESSION['UserSession']))
	{
		header('Location: index.php');
		die();
	}

	if(isset($_POST['submit_edit']))
	{
		$STH = $DBH->prepare("UPDATE Clients SET Last_Name=?, First_Name=?, Phone_Number=?, Email=?, Address=?, Gender=? WHERE Client_Id=?");
		$STH->bindParam(1, $_POST['last_name']);
		$STH->bindParam(2, $_POST['first_name']);
		$STH->bindParam(3, $_POST['phone_number']);
		$STH->bindParam(4, $_POST['email']);
		$STH->bindParam(5, $_POST['address']);
		$STH->bindParam(6, $_POST['gender']);

		
		$STH->bindParam(7, $_POST['id']);
		
		$STH->execute();
	}

	if(isset($_POST['delete']))
	{
		$STH = $DBH->prepare("DELETE FROM Clients WHERE Client_Id=$_POST[id]");
        $STH->execute();
			
	}


	if(isset($_POST['add']))
	{
		$STH = $DBH->prepare("INSERT INTO Clients (Last_Name, First_Name, Phone_Number, Email, Address, Gender) Values (?,?,?,?,?,?)");
        
		$STH->bindParam(1, $_POST['last_name']);
		$STH->bindParam(2, $_POST['first_name']);
		$STH->bindParam(3, $_POST['phone_number']);
		$STH->bindParam(4, $_POST['email']);
		$STH->bindParam(5, $_POST['address']);
		$STH->bindParam(6, $_POST['gender']);
		$STH->execute();
			
	}

?>
    <!DOCTYPE HTML>
    <html>

    <head>
        <link rel="stylesheet" href="css/bootstrap.min.css" />
        <link rel="stylesheet" href="css/bootstrap-theme.min.css" />
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>

        <script type="text/javascript">
            function validate(form) {
                return confirm('Are you certain?');
            }
        </script>
    </head>

    <body>

        <div class="container">
            <?php include 'header.php' ?>
                <!-- container -->
                <!-- content -->

                <!--Search Bar -->

                <form method="post" align="right" class="navbar-form navbar-center" role="search">
                    <div class="form-group">
                        <input name="search" type="text" class="form-control" placeholder="Search">
                    </div>
                    <button type="submit" class="btn btn-default">Submit</button>
                    <?php
                    if(isset($_POST['search']))//used for searching
                    {
                ?>
                        <button onclick="window.location=window.location.href" class="btn btn-default">Undo Search</button>
                        <?php
                    }
                ?>

                </form>


                <div class="content">
                    <?php
						if(isset($_POST['edit']))
						{
							$STH = $DBH->query("SELECT * FROM Clients WHERE Client_Id=$_POST[id]");
							$row = $STH->fetch();
							
					?>

                        <div class="panel panel-primary">




                            <div class="panel-heading">
                                Edit Client
                            </div>
                            <div class="panel-body">
                                <form role="form" method="post">
                                    <input type="hidden" name="id" value="<?= $_POST['id'] ?>">
                                    <div class="form-group">
                                        <label for="last_name">Last Name:</label>
                                        <input name="last_name" type="text" class="form-control" value="<?= $row['Last_Name'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="first_name">First Name</label>
                                        <input name="first_name" type="text" class="form-control" value="<?= $row['First_Name'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="phone_number">Phone Number</label>
                                        <input name="phone_number" type="text" class="form-control" value="<?= $row['Phone_Number'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input name="email" type="text" class="form-control" value="<?= $row['Email'] ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <input name="address" type="text" class="form-control" value="<?= $row['Address'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="gender">Gender</label>
                                        <input name="gender" type="text" class="form-control" value="<?= $row['Gender'] ?>" required>


                                    </div>
                                    <button type="submit" class="btn btn-info" name="submit_edit">Edit</button>




                                </form>
                            </div>
                        </div>

                        <?php
						}
					?>

                            <div class="panel panel-primary">
                                <div class="panel-heading" style="height: 50px">
                                    Clients
                                    <div style="float: right;">
                                        <a class="btn btn-info" href="print.php?table=clients">Print</a>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <h3 align="center">Client Information</h3>

                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Last Name</th>
                                                <th>First Name</th>
                                                <th>Phone Number</th>
                                                <th>Email</th>
                                                <th>Address</th>
                                                <th>Gender</th>
                                                <th class="text-info">Edit</th>
                                                <th class="text-danger">Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>



                                            <?php
                                            
                                            //user to search
                                            if(isset($_POST['search']))
                                            {
                                                $search = $_POST['search'];
                                            }
                                            
										$STH = $DBH->query(
                                        "SELECT * FROM Clients " . 
                                        (isset($search) ? //used for searching
                                         "WHERE First_Name LIKE '%$search%' OR Last_Name LIKE '%$search' " : //used for searching
                                         "") //used for searching
                                        );          
                                            
										while($row = $STH->fetch())
										{
								?>
                                                <tr>
                                                    <td>
                                                        <?= $row['Client_Id'] ?>
                                                    </td>
                                                    <td>
                                                        <?= $row['Last_Name'] ?>
                                                    </td>
                                                    <td>
                                                        <?= $row['First_Name'] ?>
                                                    </td>
                                                    <td>
                                                        <?= $row['Phone_Number'] ?>
                                                    </td>
                                                    <td>
                                                        <?= $row['Email'] ?>
                                                    </td>
                                                    <td>
                                                        <?= $row['Address'] ?>
                                                    </td>
                                                    <td>
                                                        <?= $row['Gender'] ?>
                                                    </td>
                                                    <td>
                                                        <form method="post">
                                                            <input type="hidden" name="id" value="<?= $row['Client_Id'] ?>">
                                                            <input type="submit" class="btn btn-info" value="Edit" name="edit">
                                                        </form>
                                                    </td>
                                                    <td>
                                                        <form method="post" onsubmit="return validate(this);">
                                                            <input type="hidden" name="id" value="<?= $row['Client_Id'] ?>">
                                                            <input type="submit" class="btn btn-danger" value="Delete" name="delete">
                                                        </form>
                                                    </td>

                                                </tr>

                                                <?php
										}
									?>

                                        </tbody>
                                    </table>


                                    <!--Add Button-->
                                    <button class="btn btn-warning" data-toggle="collapse" data-target="#demo">Add</button>


                                    <div id="demo" class="collapse" style="margin-top:10px">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                Add Client
                                            </div>
                                            <div class="panel-body">
                                                <div class="col-md-6">
                                                    <form role="form" method="post">
                                                        <input type="hidden" name="id" value="">
                                                        <div class="form-group">
                                                            <label for="last_name">Last Name:</label>
                                                            <input name="last_name" type="text" class="form-control" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="first_name">First Name</label>
                                                            <input name="first_name" type="text" class="form-control" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="phone_number">Phone Number</label>
                                                            <input name="phone_number" type="text" class="form-control" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="email">Email</label>
                                                            <input name="email" type="email" class="form-control" required>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="address">Address</label>
                                                            <input name="address" type="text" class="form-control" required>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="gender">Gender</label>
                                                            <!--<input name="gender" type="text" class="form-control" required>-->


                                                            <select name="gender" type="text" class="form-control" required>
                                                                <option value="Male">Male</option>
                                                                <option value="Female">Female</option>
                                                            </select>


                                                        </div>
                                                        <button type="submit" class="btn btn-info" name="add">Add</button>

                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>





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