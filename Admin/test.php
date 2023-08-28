<?php

$string = 'SECFIN035';
$int = preg_replace('/[^0-9]/', '', $string);
echo $int;