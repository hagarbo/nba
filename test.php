<?php
$url = "http://data.nba.net/data/10s/prod/v1/2019/players.json"
$json = file_get_contents('url_here');
$obj = json_decode($json);
echo $obj->access_token;
?>