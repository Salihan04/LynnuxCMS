<?php
    function curPageURL($value) {
        return preg_match("/^".$value."\.php/",
            substr($_SERVER["REQUEST_URI"],10),
            $matches
            );
    }
?>
<div class="col-sm-3 col-md-2 sidebar">
  <ul class="nav nav-sidebar">
    <li <?php if(curPageURL('index')) echo 'class="active"'?> ><a href="index.php">Overview</a></li>
    <li <?php if(curPageURL('event')) echo 'class="active"'?> ><a href="event.php">Current Event</a></li>
  </ul>
  <ul class="nav nav-sidebar">
    <li <?php if(curPageURL('assignResource')) echo 'class="active"'?> ><a href="assignResource.php">Assign Resource</a></li>
    <li <?php if(curPageURL('createEvent')) echo 'class="active"'?> ><a href="createEvent.php">Create Event</a></li>
  </ul>
</div>