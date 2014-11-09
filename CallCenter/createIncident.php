<?php

require '../vendor/autoload.php';
include("../phpfastcache/phpfastcache.php");

use Parse\ParseClient;
use Parse\ParseObject;
use Parse\ParseQuery;
 
ParseClient::initialize('qjArPWWC0eD8yFmAwRjKkiCQ82Dtgq5ovIbD5ZKW', '9Yl2TD1DcjR6P1XyppzQ9NerO6ZwWBQnpQiM0MkL', 'MjYJYsSjr5wZVntUFxDvv0VpXGqhPOT8YFpULNB2');
$cache = phpFastCache("files");

$query = new ParseQuery("AssistanceType");
$assistanceTypes = $query->find();

$method = $_SERVER['REQUEST_METHOD'];

if($method == 'POST') {
	$cache->delete("all_incident");
	$reporter = ParseObject::create('Reporter');
	$reporter->set('name', $_POST['name']);
	$reporter->set('mobile_no', $_POST['mobileNo']);
	$reporter->set('NRIC', $_POST['NRIC']);
	$reporter->set('address', $_POST['address']);
	$reporter->set('typeOfAssistance', $_POST['typeOfAssistance']);
	$reporter->save();

	$incident = ParseObject::create('Incident');
	$incident->set('name', $_POST['incidentName']);
	$incident->set('description', $_POST['incidentDescription']);
	$incident->set('priority', intval($_POST['priority']));
	$incident->set('reporter',$reporter);
	$incident->save();

	echo("Saved successfully");
}
else if($method == 'GET') {
?>

<html ng-app>
	<head>

		<!-- Bootstrap -->
		<link href="http://getbootstrap.com/dist/css/bootstrap.min.css" rel="stylesheet">
		<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.2/angular.min.js"></script>
		<script src="//www.parsecdn.com/js/parse-1.3.1.min.js"></script>
		<title>Create Incident</title>
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

							<div class="panel panel-info">
								<div class="panel-heading">
									Reporter Information
								</div>
								<div class="panel-body">
							
									<!-- txtReporterName -->
									<label class="col-sm-4 control-label" for="txtReporterName">Name</label>
									<div class="input-group">
										<span class="input-group-addon">*</span>
										 <input type="text" class="form-control" id="txtReporterName" name="name" placeholder="Name" required="required"/>
									</div>

									<br />

									<!-- txtNRIC -->
									<label class="col-sm-4 control-label" for="txtNRIC">NRIC</label>
									<div class="input-group">
										<span class="input-group-addon">*</span>
										 <input type="text" class="form-control" id="txtNRIC" name="NRIC" placeholder="txtNRIC" required="required">
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
									<div class="input-group">
										<select class="form-control" id="cboTypeOfAssistance" name="typeOfAssistance" required="required">
											<?php
												foreach ($assistanceTypes as $assistanceType) 
												{
													$assistanceTypeName = $assistanceType->get('name');
											?>
													<option value="<?=$assistanceTypeName?>"><?=$assistanceTypeName?></option>
											<?php
												}
											?>
										</select>
									</div>
								</div>
							</div>
						</div>

						<div class="panel panel-info">
							<div class="panel-heading">
								Incident Information
							</div>
							<div class="panel-body">
								<!-- txtIncidentName -->
								<label class="col-sm-4 control-label" for="txtIncidentName">Incident Name</label>
								<div class="input-group">
									<span class="input-group-addon">*</span>
									 <input type="text" class="form-control" id="txtIncidentName" name="incidentName" placeholder="Incident Name" required="required"/>
								</div>

								<br />

								<!-- txtIncidentDescription -->
								<label class="col-sm-4 control-label" for="txtIncidentDescription">Incident Description</label>
								<div class="input-group">
									<span class="input-group-addon">*</span>
									 <input type="text" class="form-control" id="txtIncidentDescription" name="incidentDescription" placeholder="Incident Description" required="required"/>
								</div>

								<br />

								<!-- cboPriority -->
								<label class="col-sm-4 control-label" for="cboPriority">Priority</label>
								<div class="input-group">
									<span class="input-group-addon">*</span>
									 <input type="text" class="form-control" id="cboPriority" name="priority" placeholder="Priority" required="required"/>
								</div>

								<br />

								<input class="btn btn-primary btn-lg" type="submit" id="submit"/>

							</div>
					</form>
				</div>
				<div class="col-md-2"></div>
			</div>
		</div>

		
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	</body>	
</html>

<?php
}
?>