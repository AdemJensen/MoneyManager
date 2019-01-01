<?php

include "lib/FormBase.php";
include "lib/AccurateTime.php";
include "lib/Basic.php";

$core = new FormBase();

$core->add_return_code("SUCCESS", 0);

$core->add_post("time");
$core->add_post("type");
$core->add_post("amount");
$core->add_post("comment");
$core->validate_isset();

$time = $core->get_post("time");
$type = $core->get_post("type");
$amount = $core->get_post("amount");
$comment = $core->get_post("comment");

$core->sql_insert("list", "time, type, amount, comment", "'$time', '$type', '$amount', '$comment'");
$core->return_success("SUCCESS", "A record has been submitted successfully.");