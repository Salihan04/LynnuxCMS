<!DOCTYPE html>
<!-- saved from url=(0071)file:///C:/wamp/www/operator/Dashboard%20Template%20for%20Bootstrap.htm -->
<?php

require '../vendor/autoload.php';
include("../phpfastcache/phpfastcache.php");

use Parse\ParseClient;

ParseClient::initialize('qjArPWWC0eD8yFmAwRjKkiCQ82Dtgq5ovIbD5ZKW', '9Yl2TD1DcjR6P1XyppzQ9NerO6ZwWBQnpQiM0MkL', 'MjYJYsSjr5wZVntUFxDvv0VpXGqhPOT8YFpULNB2');
$cache = phpFastCache("files");

use Parse\ParseObject;
use Parse\ParseQuery;

//remember to check user login
$method = $_SERVER['REQUEST_METHOD'];
$incidentId = null;
$incident = null;

$incidentHTML = '';
$resourceHTML = '';

$saveSuccess = false;

function getAllIncidentFromCacheOrQuery(){
  global $cache;
  $results = $cache->get("all_incident");
  if($results == null) {
    $query = new ParseQuery("Incident");
    $results = $query->find();

    //cache 15 minute
    $cache->set("all_incident", $results, 900);
  }
  return $results;
}

function getAllResourcesFromCacheOrQuery(){
  global $cache;
  $resources = $cache->get("all_resource");
  if($resources==null){
    $query = new ParseQuery("Resource");
    $resources = $query->find();
    $cache->set("all_resource", $resources, 1800);
  }
  return $resources;
}

if($method == 'POST') {

  try{
    $assignedResource = ParseObject::create('AssignResource');

    $incident = ParseObject::create('Incident',$_POST['incident'],true);
    $resource = ParseObject::create('Resource',$_POST['resource'],true);

    $assignedResource->set('incident', $incident);
    $assignedResource->set('resource', $resource);
    $assignedResource->increment('quantity', 1);
    $assignedResource->save();
    $saveSuccess = true;

  }catch(Exception $e){
    $saveSuccess = false;
  }
}
else if($method == 'GET'){
  if(isset($_GET['incident'])){
    $incidentId = $_GET['incident'];
    
    //get the incident from parse
    $query = new ParseQuery("Incident");
    $query->equalTo("objectId",$incidentId);
    $results = $query->find();

    $incident = $results[0];

  }
  if($incident==null){
    // try to get from Cache first.
    $results = getAllIncidentFromCacheOrQuery();

    for ($i = 0; $i < count($results); $i++) { 
      $object = $results[$i];
      $incidentHTML .= '<option value="'.$object->getObjectId().'">'.$object->get("name").'</option>';
    }
  }

  $resources = getAllResourcesFromCacheOrQuery();

  for ($i = 0; $i < count($resources); $i++) { 
    $object = $resources[$i];
    $resourceHTML .= '<option value="'.$object->getObjectId().'">'.$object->get("name").'</option>';
  }
}
?>
<html lang="en">
    <head>
    <link rel="icon" href="http://getbootstrap.com/favicon.ico">

    <title>Dashboard Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="./template_files/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="./template_files/dashboard.min.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="./template_files/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  <style id="holderjs-style" type="text/css"></style>


</head>

  <body>

    <?php
      include('menu/operator_top_menu.php');
    ?>

    <div class="container-fluid">
      <div class="row">
        <?php
          include('menu/operator_side_menu.php');
        ?>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Assign Resource</h1>

          <div class="col-md-15">

            <?php
            if($method == 'GET'){
            ?>

            <form role="form" class="form-horizontal" method="post" action="assignResource.php">
              <div class="form-group">

                <div class="panel panel-info">
                  <div class="panel-body">
                    <!-- cboTypeOfAssistance -->
                    <label class="col-sm-2 control-label" for="incident">Incident</label>
                    <div class="input-group">
                      <?php
                      if($incident!=null){
                      ?>
                        <label class="control-label"><?php echo($incident->get("name"));?></label>
                        <?php echo('<input type="hidden" class="form-control" value="'.$incident->getObjectId().'" id="incident" name="incident" required="required"/>');?>
                      <?php
                      }
                      else{

                      ?>
                      <select class="form-control" id="incident" name="incident" required="required">                    
                        <?php echo($incidentHTML);?>
                      </select>

                      <?php
                      }
                      ?>
                    
                    </div>

                    <br />

                    <!-- cboTypeOfAssistance -->
                    <label class="col-sm-2 control-label" for="resource">Resource</label>
                    <div class="input-group">
                      <select class="form-control" id="resource" name="resource" required="required">   
                        <?php echo($resourceHTML);?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-sm-2"></div><input class="btn btn-primary btn-lg" type="submit" />
              </div>
            </form>
            
            
            <?php  
            }
            else{
              if($saveSuccess){
                echo('<p>Resouce has been assigned</p>');
              }
            }
            ?>

          </div>
        <div class="col-md-2"></div>
      
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="./template_files/jquery.min.js"></script>
    <script src="./template_files/bootstrap.min.js"></script>
    <script src="./template_files/docs.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="./template_files/ie10-viewport-bug-workaround.js"></script>
  

<div id="global-zeroclipboard-html-bridge" class="global-zeroclipboard-container" style="position: absolute; left: 0px; top: -9999px; width: 15px; height: 15px; z-index: 999999999;" title="" data-original-title="Copy to clipboard">      <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" id="global-zeroclipboard-flash-bridge" width="100%" height="100%">         <param name="movie" value="/assets/flash/ZeroClipboard.swf?noCache=1413090888934">         <param name="allowScriptAccess" value="sameDomain">         <param name="scale" value="exactfit">         <param name="loop" value="false">         <param name="menu" value="false">         <param name="quality" value="best">         <param name="bgcolor" value="#ffffff">         <param name="wmode" value="transparent">         <param name="flashvars" value="trustedOrigins=getbootstrap.com%2C%2F%2Fgetbootstrap.com%2Chttp%3A%2F%2Fgetbootstrap.com">         <embed src="/assets/flash/ZeroClipboard.swf?noCache=1413090888934" loop="false" menu="false" quality="best" bgcolor="#ffffff" width="100%" height="100%" name="global-zeroclipboard-flash-bridge" allowscriptaccess="sameDomain" allowfullscreen="false" type="application/x-shockwave-flash" wmode="transparent" pluginspage="http://www.macromedia.com/go/getflashplayer" flashvars="trustedOrigins=getbootstrap.com%2C%2F%2Fgetbootstrap.com%2Chttp%3A%2F%2Fgetbootstrap.com" scale="exactfit">                
</object>
</div>
</body>
</html>