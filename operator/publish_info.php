<?php

include("../phpfastcache/phpfastcache.php");
$cache = phpFastCache("files");
$cache->clean();

?>