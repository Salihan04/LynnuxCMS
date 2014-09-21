<html>
	<head>

		<!-- Bootstrap -->
		<link href="/LynnuxCMS/css/bootstrap.min.css" rel="stylesheet">
		
	</head>
	<body>
		
		<div class="container">
 			<nav class="navbar navbar-default" role="navigation">
				<div class="container-fluid">
			    <!-- Brand and toggle get grouped for better mobile display -->
			    <div class="navbar-header">
					<a class="navbar-brand" href="#">CMS Call Center</a>
			    </div>
			</nav>

 			<div class="row">
 				<div class="col-md-2"></div>
 				<div class="col-md-6">
					<h1>Create Incident</h1>
					<form role="form" class="form-horizontal" method="post" action="createIncident.php">
						<div class="form-group">

							<br />

							<!-- txtName -->
							<label class="col-sm-4 control-label" for="txtName">Name</label>
							<div class="input-group">
								<span class="input-group-addon">*</span>
								 <input type="text" class="form-control" id="txtName" name="name" placeholder="Name" required="required"/>
							</div>

							<br />

							<!-- txtMobileNo -->
							<label class="col-sm-4 control-label" for="txtMobileNo">Mobile Number</label>
							<div class="input-group">
								<span class="input-group-addon">*</span>
								 <input type="text" class="form-control" id="txtMobileNo" name="mobileNo" placeholder="Mobile Number" required="required">
							</div>

							<br />

							<!-- txtAddress -->
							<label class="col-sm-4 control-label" for="txtAddress">Address</label>
							<div class="input-group">
								<span class="input-group-addon">*</span>
								 <input type="text" class="form-control" id="txtAddress" name="address" placeholder="Address" required="required">
							</div>

							<br />

							<!-- cboTypeOfAssistance -->
							<label class="col-sm-4 control-label" for="cboTypeOfAssistance">Type of Assistance</label>
						
							<select class="form-control" id="cboTypeOfAssistance" name="typeOfAssistance" required="required">
								<option value="volvo">Volvo</option>
								<option value="saab">Saab</option>
								<option value="mercedes">Mercedes</option>
								<option value="audi">Audi</option>
							</select>
						
						</div>
					</form>
				</div>
				<div class="col-md-2"></div>
			</div>
		</div>

		
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	    <!-- Include all compiled plugins (below), or include individual files as needed -->
	    <script src="js/bootstrap.min.js"></script>
	</body>	
</html>