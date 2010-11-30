<?php

$action = verifierAction(array('lister', 'editer'));

$tris_valides = array('Date', 'Evenement', 'catégorie', 'Description');
$sens_valides = array('asc', 'desc');
$smarty->assign('action', $action);

//$idevnt=isset($_GET['idevnt']);




require_once dirname(__FILE__).'/../../../sources/Afup/AFUP_Compta.php';
$compta = new AFUP_Compta($bdd);



if ($action == 'lister' ) {
 /*   $list_ordre = 'date';
    $list_sens = 'asc';
    $list_associatif = false;
    $list_filtre = false;
	*/
	$ev = $compta->obtenirFormesEvenements();
	$smarty->assign('evenements', $ev);

	if (!isset($_GET['idevnt']) || intval($_GET['idevnt']) == 0) {
        $idevnt= 8;
    }
    else
    {
    	$idevnt=$_GET['idevnt']; 
    }
    $smarty->assign('idevnt', $idevnt);

	$debit = $compta->obtenirSyntheseEvenement(1,$idevnt);
echo "<pre>";
	print_r($debit);
	echo "</pre>";
	$smarty->assign('debit', $debit);
	
	$credit = $compta->obtenirSyntheseEvenement(2,$idevnt);
	$smarty->assign('credit', $credit);
	
}

?>