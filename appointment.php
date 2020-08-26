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
		$STH = $DBH->prepare("UPDATE Appointment SET Employee_Id=?, Client_Id=?, Duration=?, Appointment_Date=?, Treatment_Type=?, Price=? WHERE Appointment_Id=?");
		$STH->bindParam(1, $_POST['employee_id']);
		$STH->bindParam(2, $_POST['client_id']);
		$STH->bindParam(3, $_POST['duration']);
		$STH->bindParam(4, $_POST['appointment_date']);
		$STH->bindParam(5, $_POST['treatment_type']);
		$STH->bindParam(6, $_POST['price']);
		
		$STH->bindParam(7, $_POST['id']);
		
		$STH->execute();
	}

	if(isset($_POST['delete']))
	{
		$STH = $DBH->prepare("DELETE FROM Appointment WHERE Appointment_Id=$_POST[id]");
		$STH->execute();
			
	}


	if(isset($_POST['add']))
	{
		$STH = $DBH->prepare("INSERT INTO Appointment (Employee_Id, Client_Id, Duration, Appointment_Date, Treatment_Type, Price) Values (?,?,?,?,?,?)");
         
        $STH->bindParam(1, $_POST['employee_id']);
		$STH->bindParam(2, $_POST['client_id']);
		$STH->bindParam(3, $_POST['duration']);
		$STH->bindParam(4, $_POST['appointment_date']);
		$STH->bindParam(5, $_POST['treatment_type']);
		$STH->bindParam(6, $_POST['price']);
		
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
							$STH = $DBH->query("SELECT * FROM Appointment WHERE Appointment_Id=$_POST[id]");
							$row = $STH->fetch();
							
					?>

                        <div class="panel panel-primary">


                            <div class="panel-heading">
                                Edit Appointment
                            </div>
                            <div class="panel-body">
                                <form role="form" method="post">
                                    <input type="hidden" name="id" value="<?= $_POST['id'] ?>">
                                     <div class="form-group">
                                        <label for="employee_id">Employee</label>
                                        <!--<input name="employee_id" type="text" class="form-control" required>-->
                                        <select class="form-control" name="employee_id">
                                            <?php
                                                $STH = $DBH->query(
                                                "Select * From Employees");
                                                while($emp_row = $STH->fetch())
                                                {
                                            ?>
                                                <option value="<?= $emp_row['Employee_Id'] ?>"  <?= $row['Employee_Id'] == $emp_row['Employee_Id'] ? "selected='selected'" : "" ?>>
                                                    <?= $emp_row['First_Name'] . ' ' . $emp_row['Last_Name'] ?>
                                                </option>
                                                <?php
                                                }
                                            ?>

                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="client_Id">Client</label>

                                        <select class="form-control" name="client_id">

                                            <?php
                                                $STH = $DBH->query("SELECT * FROM Clients");
                                                while($cl_row = $STH->fetch())
                                                {
                                            ?>
                                                <option value="<?= $cl_row['Client_Id'] ?>" <?= $row['Client_Id'] == $cl_row['Client_Id'] ? "selected='selected'" : "" ?>>
                                                    <?= $cl_row['First_Name'] . ' ' . $cl_row['Last_Name'] ?>
                                                </option>
                                                <?php
                                                }
                                            ?>

                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="duration">Duration</label>
                                        <input name="duration" type="number" class="form-control" value="<?= $row['Duration'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="appointment_date">appointment date</label>
                                        <input name="appointment_date" type="date" class="form-control" value="<?= $row['Appointment_Date'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="treatment_type">treatment type</label>
                                        <input name="treatment_type" type="text" class="form-control" value="<?= $row['Treatment_Type'] ?>">

                                    </div>
                                    <div class="form-group">
                                        <label for="price">price</label>
                                        <input name="price" type="number" class="form-control" value="<?= $row['Price'] ?>">
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
                                    Appointment
                                    <div style="float: right;">
                                        <a class="btn btn-info" href="print.php?table=appointment">Print</a>
                                    </div>
                                </div>

                                <div class="panel-body">
                                    <h3 align="center">Appointment Information</h3>

                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Employee</th>
                                                <th>Client</th>
                                                <th>Duration</th>
                                                <th>Appointment Date</th>
                                                <th>Treatment Type</th>
                                                <th>Price</th>
                                                <!--
                                                <th>Therapist</th>
-->

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
                                        
                                            
                                        //Since First_Name are all over. It is ambiguity just to put First_Name as Columns Name. So I am specifiying which table and which colums and changing that variable to a new one.
                                        //Ex. Employees.First_Name as efirst
										$STH = $DBH->query(
                                        "SELECT 
                                         Employees.First_Name as efirst, Employees.Last_Name as elast, 
                                         Clients.First_Name as cfirst, Clients.Last_Name as clast, 
                                         Appointment_Date, Treatment_Type, Price, Duration,
                                         Appointment_Id
                                         FROM Employees
                                         INNER JOIN Appointment USING(Employee_Id) 
                                         INNER JOIN Clients USING(Client_Id) " . 
                                        (isset($search) ? //used for searching
                                         "WHERE Treatment_Type LIKE '%$search%' OR Employee_Id LIKE '%$search' " : //used for searching
                                         "") //used for searching
                                        );    
                   
										while($row = $STH->fetch())
										{
								?>
                                                <tr>
                                                    <td>
                                                        <?= $row['efirst'] . " " . $row['elast'] ?>
                                                    </td>
                                                    <td>
                                                        <?= $row['cfirst'] . " " . $row['clast'] ?>
                                                    </td> 
                                                    
                  
                                                    <td>
                                                        <?= $row['Duration'] ?>
                                                    </td>
                                                    <td>
                                                        <?= $row['Appointment_Date'] ?>
                                                    </td>
                                                    <td>
                                                        <?= $row['Treatment_Type'] ?>
                                                    </td>
                                                    <td>
                                                        <?= $row['Price'] ?>
                                                    </td>
                                                    <td>
                                                        <form method="post">
                                                            <input type="hidden" name="id" value="<?= $row['Appointment_Id'] ?>">
                                                            <input type="submit" class="btn btn-info" value="Edit" name="edit">
                                                        </form>
                                                    </td>
                                                    <td>
                                                        <form method="post" onsubmit="return validate(this);">
                                                            <input type="hidden" name="id" value="<?= $row['Appointment_Id'] ?>">
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
                                                Add Appointment
                                            </div>
                                            <div class="panel-body">
                                                <div class="col-md-6">
                                                    <form role="form" method="post">
                                                        <input type="hidden" name="id" value="">

                                                        <div class="form-group">
                                                            <label for="employee_id">Employee</label>
                                                            <!--<input name="employee_id" type="text" class="form-control" required>-->
                                                            <select class="form-control" name="employee_id">
                                                                <?php
                                                                    $STH = $DBH->query(
                                                                    "Select * From Employees");
                                                                    while($row = $STH->fetch())
                                                                    {
                                                                ?>
                                                                    <option value="<?= $row['Employee_Id'] ?>">
                                                                        <?= $row['First_Name'] . ' ' . $row['Last_Name'] ?>
                                                                    </option>
                                                                    <?php
                                                                    }
                                                                ?>

                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="client_Id">Client</label>

                                                            <select class="form-control" name="client_id">

                                                                <?php
                                                                    $STH = $DBH->query(
                                                                    "Select * From Clients");
                                                                    while($row = $STH->fetch())
                                                                    {
                                                                ?>
                                                                    <option value="<?= $row['Client_Id'] ?>">
                                                                        <?= $row['First_Name'] . ' ' . $row['Last_Name'] ?>
                                                                    </option>
                                                                    <?php
                                                                    }
                                                                ?>

                                                            </select>
                                                        </div>



                                                        <div class="form-group">
                                                            <label for="duration">Duration</label>
                                                            <input name="duration" type="text" class="form-control" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="appointment_date">Appointment</label>
                                                            <input name="appointment_date" type="date" class="form-control" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="treatment_type">Treatment Type</label>


                                                            <select name="treatment_type" type="text" class="form-control" required>

                                                                <optgroup label="Facial Care">
                                                                    <option value="Photorejuvenation">Photorejuvenation</option>
                                                                    <option value="Pigmented and Vascular Lesions"> Pigmented and Vascular Lesions</option>
                                                                    <option value="Medical Facial">Medical Facial</option>
                                                                    <option value="Oxygen Facial">Oxygen Facial</option>
                                                                </optgroup>

                                                                <optgroup label="Body Treatment">
                                                                    <option value="Cellulite">Cellulite</option>
                                                                    <option value="Exfoliation & Wrap"> Exfoliation and Wrap</option>
                                                                    <option value="Back">Back</option>
                                                                </optgroup>

                                                                <optgroup label="Massage">
                                                                    <option value="Traditional Massage">Traditional Massage</option>
                                                                    <option value="Deep Tissue Massage">Deep Tissue Massage</option>
                                                                    <option value="Massage With Therapeutical Essential Oils">Massage With Therapeutical Essential Oils</option>
                                                                    <option value="Reiki">Reik</option>
                                                                    <option value="Signature Massage">Signature Massage</option>
                                                                </optgroup>

                                                            </select>

                                                            <!--
                                                            <input name="treatment_type" type="text" class="form-control" required>
-->
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="price">Price</label>

                                                            <input name="price" type="text" class="form-control" required>
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