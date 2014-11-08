<!DOCTYPE html>
<!-- saved from url=(0071)file:///C:/wamp/www/operator/Dashboard%20Template%20for%20Bootstrap.htm -->
<?php
require '../vendor/autoload.php';

use Parse\ParseClient;
use Parse\ParseObject;
use Parse\ParseQuery;
use Parse\ParseRelation;

ParseClient::initialize('qjArPWWC0eD8yFmAwRjKkiCQ82Dtgq5ovIbD5ZKW', '9Yl2TD1DcjR6P1XyppzQ9NerO6ZwWBQnpQiM0MkL', 'MjYJYsSjr5wZVntUFxDvv0VpXGqhPOT8YFpULNB2');

//remember to check user login
$method = $_SERVER['REQUEST_METHOD'];

$incidentHTML = '';
$errorMessage= '';
$reporterHTML = '';

function getProperDateFormat($value){
  $dateFormatString = 'Y-m-d\TH:i:s.u';
  $date = date_format($value, $dateFormatString);
  $date = substr($date, 0, -3) . 'Z';
  return $date;
}


if($method == 'GET'){
  if(isset($_GET['id'])){
    $incidentId = $_GET['id'];

    $query = new ParseQuery("Incident");
    $result = $query->get($incidentId);
    
    $incidentHTML .= '<label class="col-sm-3">Id</label>';
    $incidentHTML .= '<p class="col-sm-9">'.$result->getObjectId().'</p>';
    $incidentHTML .= '<br/>';

    $incidentHTML .= '<label class="col-sm-3">Name</label>';
    $incidentHTML .= '<p class="col-sm-9">'.$result->get("name").'</p>';
    $incidentHTML .= '<br/>';

    $incidentHTML .= '<label class="col-sm-3">Status</label>';
    $incidentHTML .= '<p class="col-sm-9">'.$result->get("status").'</p>';
    $incidentHTML .= '<br/>';

    $incidentHTML .= '<label class="col-sm-3">Description</label>';
    $incidentHTML .= '<p class="col-sm-9">'.$result->get("description").'</p>';
    $incidentHTML .= '<br/>';

    $incidentHTML .= '<label class="col-sm-3">Location</label>';
    
    if($result->get("location")!=null){
      $incidentHTML .= '<p class="col-sm-9">'.$result->get("location")->getLatitude().','.$result->get("location")->getLongitude().'</p>';
    }else{
      $incidentHTML .= '<p class="col-sm-9">no location details</p>';
    }

    $incidentHTML .= '<br/>';

    $incidentHTML .= '<label class="col-sm-3">Created At</label>';
    $incidentHTML .= '<p class="col-sm-9">'.getProperDateFormat($result->getCreatedAt()).'</p>';
    $incidentHTML .= '<br/>';


    $result->get("reporter")->fetch();
    $reporter = $result->get("reporter");
    $reporterHTML .= '<label class="col-sm-3">Reporter</label>';
    if($reporter==null){
      $reporterHTML .= '<p class="col-sm-9">no reporter</p>';
    }else{
      $reporterHTML .= '<p class="col-sm-9">'.$reporter->get("name").'</p>';
      $reporterHTML .= '<br/>';
      $reporterHTML .= '<label class="col-sm-3">Mobile Phone</label>';
      $reporterHTML .= '<p class="col-sm-9">'.$reporter->get("mobile_no").'</p>';
      $reporterHTML .= '<br/>';
      $reporterHTML .= '<label class="col-sm-3">Address</label>';
      $reporterHTML .= '<p class="col-sm-9">'.$reporter->get("address").'</p>';
      $reporterHTML .= '<br/>';
      $reporterHTML .= '<label class="col-sm-3">NRIC</label>';
      $reporterHTML .= '<p class="col-sm-9">'.$reporter->get("NRIC").'</p>';
      $reporterHTML .= '<br/>';
      $reporterHTML .= '<label class="col-sm-3">Requested Resources</label>';
      $reporterHTML .= '<p class="col-sm-9">'.$reporter->get("typeOfAssistance").'</p>';

    }


    $resourceHTML = '';
    $queryAssignResource = new ParseQuery("AssignResource");
    $queryAssignResource->equalTo("incident", $result);
    $assignResourceResults = $queryAssignResource->find();
    $resourceHTML .= '<ol>';
    for($j=0;$j<count($assignResourceResults);$j++){
      $resourceHTML .= '<li>';
      $assignResourceResults[$j]->get('resource')->fetch();
      $resourceHTML .= $assignResourceResults[$j]->get('resource')->get('name');
      $resourceHTML .= '</li>';
    }
    $resourceHTML .= '</ol><br/>';

    $resourceHTML .= '<button class="btn btn-primary btn-lg" type="button" onclick="location.href = \'\assignResource.php';
    $resourceHTML .= '?incident='.$result->getObjectId();
    $resourceHTML .= '\'">assign resource</button>';


  }
}
?>
<html lang="en">
    <head>
    <link rel="icon" href="http://getbootstrap.com/favicon.ico">

    <title>Incident Detail</title>

    <!-- Bootstrap core CSS -->
    <link href="http://getbootstrap.com/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="http://getbootstrap.com/examples/dashboard/dashboard.css" rel="stylesheet">

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
          <h1 class="page-header">Incident Details</h1>

          <div class="form-horizontal form-group">
          <?php
            echo $incidentHTML;
          ?>
            
          </div>
          <br/>
          <h2 class="page-header">Reporter</h2>
          <?php
            echo $reporterHTML;
          ?>
          <br/>
          <br/>
          <h2 class="page-header">Resources</h2>
          <?php
            echo $resourceHTML;
          ?>

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