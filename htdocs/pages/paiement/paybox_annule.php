<?php
var_dump($_SERVER);
require_once dirname(__FILE__) .'/../../../sources/Afup/Bootstrap/Http.php';
$smarty->display('paybox_annule.html');
