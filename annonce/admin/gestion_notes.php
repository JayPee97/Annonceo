<?php require_once('../inc/header.inc.php');?>


<h1>GESTION DES NOTES</h1>


<?php



if (isset($_GET['action']) && $_GET['action'] == 'affichage') {
    $r = execute_requete("SELECT * FROM note");

    $content .= '<h2>Liste des notes</h2>';
    $content .= '<p>Nombres de notes : ' . $r->rowCount() . '</p>';

    $content .= '<table border="1" cellpadding="15" style="width: 80%; margin: auto">';
    $content .= '<tr style="background-color: black; color: white; text-align: center">';
    for ($i = 0; $i < $r->columnCount(); $i++) {

        $colonne = $r->getColumnMeta($i);


        $content .= "<th>$colonne[name]</th>";
    }
    $content .= '</tr>';

    while ($note = $r->fetch(PDO::FETCH_ASSOC)) {
        $content .= '<tr>';

        //var_dump($categorie);
        foreach ($note as $key => $value) {
            $content .= "<td style=\"text-align: center\">$value</td>";
        }

        $content .= '<td><a href="?action=modification&id_note=' . $note['id_note'] . '">modification</a></td>';
        $content .= '<td><a href="?action=suppression&id_article=' . $note['id_note'] . '" onclick="return( confirm(\' En êtes vous sur ?\'))">supprimer</a></td>';
        $content .= '</tr>';

    }
    $content .= '</table>';
}
?>

<a href="?action=affichage">Affichage des notes</a><br>

<?= $content ?>

<?php
if (!empty($_POST)) {
    foreach ($_POST as $key => $value) {
        $_POST[$key] = htmlentities (addslashes($value));
    }
if(isset($_GET['action']) && $_GET['action'] == 'modification'){

execute_requete("UPDATE note SET
reference = '$_POST[id_note]',
categorie = '$_POST[membre_id1]',
titre = '$_POST[membre_id2]',
titre = '$_POST[note]',
titre = '$_POST[avis]',
titre = '$_POST[date_enregistrement]',

WHERE id_note = '$_GET[id_note]'
" );

/*header('location:gestion_boutique.php?action=affichage');*/
}
else{

execute_requete("INSERT INTO article(id_note, membre_id1, membre_id2, note, avis, date_enregistrement) VALUES('$_POST[id_note]','$_POST[membre_id1]','$_POST[membre_id2]','$_POST[note]','$_POST[avis]','$_POST[date_enregistrement]')");

/*header('location:gestion_boutique.php?action=affichage');*/

}


}

?>

<?php if(isset($_GET['action']) && ($_GET['action'] == 'modification' || $_GET['action'] == 'suppression')) :

    if(isset($_GET['id_note'])){

        $r = execute_requete("SELECT * FROM note WHERE id_note = '$_GET[id_note]'");

        $article_actuel = $r->fetch(PDO::FETCH_ASSOC);
        //debug($article_actuel);
    }

    if(isset($article_actuel['reference'])){
        $reference = $article_actuel['reference'];
    }
    else{
        $reference = '';
    }

    $id_note = (isset($article_actuel['id_note'])) ? $article_actuel['id_note'] : '';
    $membre_id1 = (isset($article_actuel['membre_id1'])) ? $article_actuel['membre_id1'] : '';
    $membre_id2 = (isset($article_actuel['membre_id2'])) ? $article_actuel['membre_id2'] : '';
    $note = (isset($article_actuel['note'])) ? $article_actuel['note'] : '';
    $avis = (isset($article_actuel['avis'])) ? $article_actuel['avis'] : '';
    $date_enregistrement = (isset($article_actuel['date_enregistrement'])) ? $article_actuel['date_enregistrement'] : '';

    ?>







<form method="post">
    <label for="id_note">id_note</label><br>
    <input type="text" name="id_note" id="id_note" class="form-control" value="<?= $id_note ?>"><br>

    <label for="membre_id1">membre_id1</label><br>
    <input type="text" name="membre_id1" id="membre_id1" class="form-control" value="<?= $membre_id1 ?>"><br>

    <label for="membre_id2">membre_id2</label><br>
    <input type="text" name="membre_id2" id="membre_id2" class="form-control" value="<?= $membre_id1 ?>"><br>

    <label for="note">note</label><br>
    <input type="text" name="note" id="note" class="form-control" value="<?= $note ?>"><br>

    <label for="avis">avis</label><br>
    <input type="text" name="avis" id="avis" class="form-control" value="<?= $avis ?>"><br>

    <label for="date_enregistrement ">date_enregistrement</label><br>
    <input type="text" name="date_enregistrement" id="date_enregistrement" class="form-control" value="<?= $date_enregistrement ?>"><br>


    <input type="submit" class="btn btn-secondary" value="<?php echo ucfirst($_GET['action']); ?>">


</form>

<?php endif; ?>

<?php require_once('../inc/footer.inc.php')?>

