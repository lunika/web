<?php
require_once ("include/config.inc.php");
?>
<?php
if (isset($id)) $id=verif_GetPost($_GET['id']);
if (isset($choix)) $choix=verif_GetPost($_GET['choix']);

if (isset($choix) && $choix=="trash")
{
 $frm = $_GET;
        $sql="DELETE FROM compta_evenement WHERE
                                 id = '".$frm['id']."'
                ";
        assert ('$cnx->prepare($sql)');
        $qid = $cnx->prepare($sql);
        $qid->execute();
}
if (sizeof($_POST) > 0)
{
 $frm = $_POST;
switch($frm[action])
{
        case "Mise A Jour":
        /*        if ( empty($frm['reglement']) )
                {
                        echo "Le champ est vide";
                } elseif ($_SESSION['ip'] != $_SERVER[REMOTE_ADDR]
                                          || $_POST['idclef'] != $_SESSION['idclef'])
                {
                        echo "Tentative de p�n�tation";
                } else {     */
                $sql="UPDATE compta_evenement SET
                                `evenement` = '".htmlentities($frm[evenement], ENT_QUOTES)."'
                                where id='".htmlentities($frm[id])."'  ";
                assert ('$cnx->prepare($sql)');
                $qid=$cnx->prepare($sql);
                $qid->execute();
        //        }
        break;

    case "Ajouter":
/*                if ( empty($frm['reglement']) )
                {
                        echo "Le champ est vide";
                } elseif ($_SESSION['ip'] != $_SERVER[REMOTE_ADDR]
                                          || $_POST['idclef'] != $_SESSION['idclef'])
                {
                        echo "Tentative de p�n�tation";
                } else {*/
                 $sql = "INSERT INTO compta_evenement (`evenement`)
                                 VALUES (
                                 '".htmlentities($frm[evenement], ENT_QUOTES)."'
                                 )";

//                assert ('$cnx->prepare($sql)');
                $qid=$cnx->prepare($sql);
                $qid->execute();
        //}
        break;

}
}
?>
<html><head>
<link rel="stylesheet" href="include/css.css" type="text/css">
</head><body>
<?php
require_once "ihead.inc.php";
?>
<span class="title">Evenement</span><br>
  <table width="100%" border="1">
    <tr>
<?php
$sql="SELECT * FROM compta_evenement order by evenement";

$cnx->beginTransaction();
$qid=$cnx->prepare($sql);
$qid->execute();
$nrow=$qid->fetchAll();

if ($nrow[0] !='')
{
        echo "<td><b>Liste</b><br>";
        echo "<table border=1>";
        $qid=$cnx->prepare($sql);
        $qid->execute();
        while($row=$qid->fetch(PDO::FETCH_OBJ))
        {
                echo "<tr>";
                echo "<td>".stripslashes($row->evenement)."</td>";
                echo "<td><a href=".$_SERVER['PHP_SELF']."?id=$row->id class=links>Edit</a></td>";
                echo "<td>";
                echo "<a ";
                echo "onClick=\"Javascript:return confirm('�tes-vous s�r de vouloir enlever cette ligne ?');\" ";
                echo "href=".$_SERVER['PHP_SELF']."?id=".$row->id."&choix=trash";
                echo " class=links>Supp</a>";
                echo "</td>";
                echo "</tr>";
        }
        echo "</table>";
        echo "</td>";
}
else
{
                echo "Aucun disponible";
}
?>
<td align="center">
<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>"  method="post">
<?php if ($id) { ?>
Modifier :
<?php
$id=htmlentities($id);
/*$sql="SELECT rubrique.id as idselect,rubrique.iduser,rubrique.nom,user.id
                FROM rubrique, user
                WHERE rubrique.iduser=user.id
                        AND rubrique.iduser='".$_SESSION['iduser']."'
                        AND user.idclef='".$_SESSION['idclef']."'
                        AND rubrique.id='$id'
        ";*/
$sql="SELECT * FROM compta_evenement WHERE id='$id' ";

assert ('$cnx->prepare($sql)');
$qid=$cnx->prepare($sql);
$qid->execute();
$row=$qid->fetch(PDO::FETCH_OBJ);
?>
<input name="id" type="hidden" value=<?php echo $id;?> ><br>
<input type="text" name="evenement"  value="<?php echo stripslashes($row->evenement); ?>"><br>

<input type="submit" name="action" value="Mise A Jour">
<?php } else { ?>
Ajouter  : <br>
<input type="text" name="evenement"  value=""><br>

<br><input type="submit" name="action" value="Ajouter">
<?php } ?>
</form>
</td>
    </tr>
  </table>

<?php
require_once "ifooter.inc.php";
?>
</body></html>