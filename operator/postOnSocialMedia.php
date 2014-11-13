<?php
require '../vendor/autoload.php';
include("../phpfastcache/phpfastcache.php");

use Parse\ParseClient;
use Parse\ParseCloud;
use Parse\ParseObject;
use Parse\ParseQuery;
use Parse\ParseRelation;

ParseClient::initialize('qjArPWWC0eD8yFmAwRjKkiCQ82Dtgq5ovIbD5ZKW', '9Yl2TD1DcjR6P1XyppzQ9NerO6ZwWBQnpQiM0MkL', 'MjYJYsSjr5wZVntUFxDvv0VpXGqhPOT8YFpULNB2');
$cache = phpFastCache("files");
// $cache->clean();
//remember to check user login
$method = $_SERVER['REQUEST_METHOD'];

if($method == "POST") {
    $result = ParseCloud::run('postOnFacebook', ['message' => $_POST['message']]);
    $result = ParseCloud::run('sendSMS', ['message' => $_POST['message']]);
    echo "Posting to social media";
    var_dump($result);
    return;
}

$html = '';

function getEnglishOrder($value){
    if($value == 1){
        return "first";
    }
    else if($value == 2){
        return "second";
    }else{
        return "third";
    }
}

function getAllEventFromCacheOrQuery(){
  global $cache;
  $results = $cache->get("all_event");
  if($results == null) {
    $query = new ParseQuery("Event");
    $results = $query->find();

    //cache 15 minute
    $cache->set("all_event", $results, 900);
  }
  return $results;
}

$result = getAllEventFromCacheOrQuery();

if(count($result)==0){
    $html .= "No event currently. ";
}
else{
    if(count($result)==1){
        $html .="There are ".count($result)." current event. ";
    }
    else{
        $html .="There are ".count($result)." current events. ";
    }

    for($i=0;$i<count($result);$i++){
        $html .= "The ".getEnglishOrder($i+1)." event is ".$result[$i]->get("name").". ";
        
        $html .= "It has ".count($result[$i]->get("incidents"))." related incidents. ";

        $resourceQueryResult = $result[$i]->getRelation("organizations")->getQuery()->find();

        for($j=0;$j<count($resourceQueryResult);$j++){
            $html .= $resourceQueryResult[$j]->get("name");
            if($j==count($resourceQueryResult)-1){
                $html .= " ";
            }
            else if($j==count($resourceQueryResult)-2){
                $html .= " and ";
            }else{
                $html .= ", ";
            }
        }
        if(count($resourceQueryResult)==1){
            $html .= "has ";
        }else{
            $html .= "have ";
        }

        $html .= "been assigned to resolve the event.";
    }
} 
    

?>
<!DOCTYPE html>
<html lang="en">
    <head>
    <link rel="icon" href="http://getbootstrap.com/favicon.ico">

    <title>Report</title>

    <!-- Bootstrap core CSS -->
    <link href="./template_files/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="./template_files/dashboard.min.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="./template_files/ie-emulation-modes-warning.js"></script>
    <script src="./template_files/parse-1.3.1.min.js"></script>
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
        <h1 class="page-header">Alert</h1>
        <form method="POST" action="./postOnSocialMedia.php" onsubmit="return confirm('Are you sure you want to post?');">
            <textarea id="message" name="message" rows="5" cols="100"><?php echo $html;?></textarea>
            <br/><br/>
            <input class="btn btn-primary btn-lg" type="Submit" value="Post" />
        </form>
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