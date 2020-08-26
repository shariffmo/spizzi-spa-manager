<?php
	require_once 'database.php';
	session_start();
    //if the user is not logged in, redirect them to the loggin page
	if(!isset($_SESSION['UserSession']))
	{
		header('Location: index.php');
		die();
	}

    //if an edit form is submitted, update the row with the new data
	if(isset($_POST['submit_edit']))
	{
        //use prepared statements because they are safer, they prevent sql injections
		$STH = $DBH->prepare("UPDATE Employees SET First_Name=?, Last_Name=?, Hired_Date=?, Salary=?, Email=?, Phone_Number=?, Address=?, Birthday=? WHERE Employee_Id=?");
        
        //binds parameters the the ? respectively
		$STH->bindParam(1, $_POST['first_name']);
		$STH->bindParam(2, $_POST['last_name']);
		$STH->bindParam(3, $_POST['hired_date']);
		$STH->bindParam(4, $_POST['salary']);
		$STH->bindParam(5, $_POST['email']);
		$STH->bindParam(6, $_POST['phone_number']);
		$STH->bindParam(7, $_POST['address']);
		$STH->bindParam(8, $_POST['birthday']);
		
		$STH->bindParam(9, $_POST['id']);
		
		$STH->execute();
	}


	if(isset($_POST['delete']))
	{
		$STH = $DBH->prepare("DELETE FROM Employees WHERE Employee_Id=$_POST[id]");
		$STH->execute();
			
	}

    
	if(isset($_POST['add']))
	{
		$STH = $DBH->prepare("INSERT INTO Employees (Last_Name, First_Name, Hired_Date, Salary, Email, Phone_Number, Address, Birthday) Values (?,?,?,?,?,?,?,?)");
        
        $STH->bindParam(1, $_POST['first_name']);
		$STH->bindParam(2, $_POST['last_name']);
		$STH->bindParam(3, $_POST['hired_date']);
		$STH->bindParam(4, $_POST['salary']);
		$STH->bindParam(5, $_POST['email']);
		$STH->bindParam(6, $_POST['phone_number']);
		$STH->bindParam(7, $_POST['address']);
		$STH->bindParam(8, $_POST['birthday']);
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




                <!--Search Bar Essential -->
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
                    
                    //get the data for the employee that has to be editted
						if(isset($_POST['edit']))
						{
							$STH = $DBH->query("SELECT * FROM Employees WHERE Employee_Id=$_POST[id]");
							$row = $STH->fetch();// retrieves a single row, since there should only be one row
							
					?>

                        <div class="panel panel-primary">

                            <div class="panel-heading">
                                Edit Employee

                            </div>
                            <div class="panel-body">
                                <form role="form" method="post">
                                    <input type="hidden" name="id" value="<?= $_POST['id'] ?>">
                                    <div class="form-group">
                                        <label for="first_name">First Name:</label>
                                        <input name="first_name" type="text" class="form-control" value="<?= $row['First_Name'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="last_name">Last Name</label>
                                        <input name="last_name" type="text" class="form-control" value="<?= $row['Last_Name'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="hired_date">Hired Date</label>
                                        <input name="hired_date" type="date" class="form-control" value="<?= $row['Hired_Date'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="salary">Salary</label>
                                        <input name="salary" type="number" class="form-control" value="<?= $row['Salary'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input name="email" type="email" class="form-control" value="<?= $row['Email'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="phone_number">Phone Number</label>
                                        <input name="phone_number" type="text" class="form-control" value="<?= $row['Phone_Number'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <input name="address" type="text" class="form-control" value="<?= $row['Address'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="birthday">Birthday</label>
                                        <input name="birthday" type="date" class="form-control" value="<?= $row['Birthday'] ?>">
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
                                    Employees

                                    <div style="float: right;"> 
                                        <a class="btn btn-info" href="print.php?table=employees">Print</a>  <!-- (print.php?table=employees) go to print.php and select the table employees. -->
            
                                    </div>

                                </div>
                                <div class="panel-body">
                                    <h3 align="center">Employee Information</h3>

                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Email</th>
                                                <th>Phone Number</th>
                                                <th>Hired date</th>
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
                                            
                                    
                                        // %$search%  is means find fields that are LIKE what you wrote in the search box.
										$STH = $DBH->query(
                                        "SELECT * FROM Employees " . 
                                        (isset($search) ? //used for searching
                                         "WHERE First_Name LIKE '%$search%' OR Last_Name LIKE '%$search' " : //used for searching
                                         "") //used for searching
                                        );
                           
										while($row = $STH->fetch())
										{
								?>
                                                <tr>
                                                    <td>
                                                        <?= $row['Employee_Id'] ?>
                                                    </td>
                                                    <td>
                                                        <?= $row['First_Name'] ?>
                                                    </td>
                                                    <td>
                                                        <?= $row['Last_Name'] ?>
                                                    </td>
                                                    <td>
                                                        <?= $row['Email'] ?>
                                                    </td>
                                                    <td>
                                                        <?= $row['Phone_Number'] ?>
                                                    </td>
                                                    <td>
                                                        <?= $row['Hired_Date'] ?>
                                                    </td>
                                                    <td>
                                                        <form method="post">
                                                            <input type="hidden" name="id" value="<?= $row['Employee_Id'] ?>">
                                                            <input type="submit" class="btn btn-info" value="Edit" name="edit">
                                                        </form>
                                                    </td>
                                                    <td>
                                                        <form method="post" onsubmit="return validate(this);">
                                                            <input type="hidden" name="id" value="<?= $row['Employee_Id'] ?>">
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
                                                Add Employee
                                            </div>
                                            <div class="panel-body">
                                                <div class="col-md-6">
                                                    <form role="form" method="post">
                                                        <input type="hidden" name="id" value="">
                                                        <div class="form-group">
                                                            <label for="first_name">First Name:</label>
                                                            <input name="first_name" type="text" class="form-control" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="last_name">Last Name</label>
                                                            <input name="last_name" type="text" class="form-control" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="hired_date">Hired date</label>
                                                            <input name="hired_date" type="date" class="form-control" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="email">Email</label>
                                                            <input name="email" type="email" class="form-control" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="birthday">Birth date</label>
                                                            <input name="birthday" type="date" class="form-control" required>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="gender">Gender</label>
                                                            <input name="gender" type="text" class="form-control" required>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="phone_number">Phone number</label>
                                                            <input name="phone_number" type="text" class="form-control" required>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="address">Address</label>
                                                            <input name="address" type="text" class="form-control" required>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="salary">Salary</label>
                                                            <input name="salary" type="number" class="form-control" required>
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