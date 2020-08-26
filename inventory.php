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
        $STH = $DBH->prepare("UPDATE Item SET Name=?, Price=?, Description=? WHERE Item_Id=?");
		$STH->bindParam(1, $_POST['name']);
		$STH->bindParam(2, $_POST['price']);
        $STH->bindParam(3, $_POST['description']);
        $STH->bindParam(4, $_POST['item_id']);
        
        $STH->execute();
        
		$STH = $DBH->prepare("UPDATE Inventory SET Quantity=? WHERE Inventory_Id=?");
		$STH->bindParam(1, $_POST['quantity']);
		$STH->bindParam(2, $_POST['id']);
		
		$STH->execute();
	}

	if(isset($_POST['delete']))
	{
        
		$STH = $DBH->prepare("DELETE FROM Inventory WHERE Inventory_Id=$_POST[id]");
        
		$STH->execute();
        
        $STH = $DBH->prepare("DELETE FROM Item WHERE Item_Id=$_POST[item_id]");
        $STH->execute();
			
	}


	if(isset($_POST['add']))
	{
        
        $STH = $DBH->prepare("INSERT INTO Item (Name, Price, Description) Values (?,?,?)");
        $STH->bindParam(1, $_POST['name']);
		$STH->bindParam(2, $_POST['price']);
        $STH->bindParam(3, $_POST['description']);
        
        $STH->execute();
        
        $item_id = $DBH->lastInsertId();
        
        
		$STH = $DBH->prepare("INSERT INTO Inventory (Item_Id, Quantity) Values (?,?)");
        
        $STH->bindParam(1, $item_id);
		$STH->bindParam(2, $_POST['quantity']);

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
                            //Using inner join. Combining Inventory + Items so I can get items that are not avaibles in Inventory.
							$STH = $DBH->query("SELECT * FROM Inventory INNER JOIN Item USING(Item_Id) WHERE Inventory_Id=$_POST[id]");
							$row = $STH->fetch();							
					?>

                        <div class="panel panel-info">
                            <div class="panel-heading">
                                Edit Inventory
                            </div>
                            <div class="panel-body">
                                <form role="form" method="post">
                                    <input type="hidden" name="id" value="<?= $_POST['id'] ?>">
                                    <input type="hidden" name="item_id" value="<?= $_POST['item_id'] ?>">
                                    <div class="form-group">
                                        <label for="name">Item Name</label>
                                        <input name="name" type="text" class="form-control" value="<?= $row['Name'] ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <input name="description" type="text" class="form-control" value="<?= $row['Description'] ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="price">Price</label>
                                        <input name="price" type="number" class="form-control" value="<?= $row['Price'] ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="quantity">Quantity</label>
                                        <input name="quantity" type="number" class="form-control" value="<?= $row['Quantity'] ?>">
                                    </div>


                                    <button type="submit" class="btn btn-info" name="submit_edit">Edit</button>


                                    <!-- <button type="submit" class="btn btn-info" name="submit_edit">Cancel</button>
                                     gotta check this -->

                                </form>
                            </div>
                        </div>

                        <?php
						}
					?>

                            <div class="panel panel-primary">
                                <div class="panel-heading" style="height: 50px">
                                    Inventory

                                    <div style="float: right;">
                                        <a class="btn btn-info" href="print.php?table=inventory">Print</a>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <h3 align="center">Inventory Information</h3>

                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Item Name</th>
                                                <th>Description</th>
                                                <th>Quantity</th>
                                                <th>Price</th>

                                                <th class="text-info">Edit</th>
                                                <th class="text-danger">Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            
                                            //used for searching
                                            if(isset($_POST['search']))
                                            {
                                                $search = $_POST['search'];
                                            }
                                            
                                            
										$STH = $DBH->query(
                                        "SELECT * FROM Inventory INNER JOIN Item USING(Item_Id) " . 
                                        (isset($search) ? //used for searching
                                         "WHERE Name LIKE '%$search%' OR Description LIKE '%$search%'" : //used for searching
                                         "") //used for searching
                                        );
                                            
										while($row = $STH->fetch())
										{
								?>
                                                <tr>
                                                    <td>
                                                        <?= $row['Inventory_Id'] ?>
                                                    </td>
                                                    <td>
                                                        <?= $row['Name'] ?>
                                                    </td>
                                                    <td>
                                                        <?= $row['Description'] ?>
                                                    </td>
                                                    <td>
                                                        <?= $row['Quantity'] ?>
                                                    </td>

                                                    <td>
                                                        <?= $row['Price'] ?>
                                                    </td>


                                                    <td>
                                                        <form method="post">
                                                            <input type="hidden" name="id" value="<?= $row['Inventory_Id'] ?>">
                                                            <input type="hidden" name="item_id" value="<?= $row['Item_Id'] ?>">
                                                            <input type="submit" class="btn btn-info" value="Edit" name="edit">
                                                        </form>
                                                    </td>
                                                    <td>
                                                        <form method="post" onsubmit="return validate(this);">
                                                            <input type="hidden" name="id" value="<?= $row['Inventory_Id'] ?>">
                                                            <input type="hidden" name="item_id" value="<?= $row['Item_Id'] ?>">
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
                                                Add Item
                                            </div>
                                            <div class="panel-body">
                                                <div class="col-md-6">
                                                    <form role="form" method="post">
                                                        <input type="hidden" name="id" value="">
                                                        <div class="form-group">
                                                            <!-- <label for="item_name">Item Name</label>
                                                             <input name="item_name" type="text" class="form-control" required>-->

                                                        </div>

                                                        <div class="form-group">
                                                            <label for="name">Name</label>
                                                            <input name="name" type="text" class="form-control" required>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="description">Description</label>
                                                            <input name="description" type="text" class="form-control" required>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="price">Price</label>
                                                            <input name="price" type="number" class="form-control" required>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="quantity">Quantity</label>
                                                            <input name="quantity" type="number" class="form-control" required>
                                                        </div>

                                                        <button type="submit" class="btn btn-info" name="add">Add</button>
                                                        <button type="submit" class="btn btn-info" name="add">Cancel</button>
                                                        <!--gotta check this-->


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