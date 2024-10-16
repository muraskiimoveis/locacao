<?php

$nums = array(12, 23, 5, 9 50);
sort($nums, SORT_NUMERIC);
$res = array();

for ($i = reset($nums); $i <= end($nums); $i++) {
    if (!in_array($i, $nums)) {
        array_push($res, $i);
    }
}

?>