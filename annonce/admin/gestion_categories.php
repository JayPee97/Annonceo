<?php require_once('../inc/header.inc.php');?>





<?php
if (isset($_GET['action']) && $_GET['action'] == 'affichage') {

    $r = execute_requete("SELECT * FROM categorie");

    $content .= '<h2>Liste des catégories</h2>';
    $content .= '<p>Nombres de catégories : ' . $r->rowCount() . '</p>';

    $content .= '<table border="1" cellpadding="15" style="width: 80%; margin: auto">';
    $content .= '<tr style="background-color: black; color: white; text-align: center">';
    for ($i = 0; $i < $r->columnCount(); $i++) {

        $colonne = $r->getColumnMeta($i);


        $content .= "<th>$colonne[name]</th>";
    }
    $content .= '</tr>';

    while ($categorie = $r->fetch(PDO::FETCH_ASSOC)) {
        $content .= '<tr>';

        //var_dump($categorie);
        foreach ($categorie as $key => $value) {
            $content .= "<td style=\"text-align: center\">$value</td>";
        }

        $content .= '<td><a href="?action=modification&id_categorie=' . $categorie['id_categorie'] . '">modification</a></td>';
        $content .= '<td><a href="?action=suppression&id_categorie=' . $categorie['id_categorie'] . '">Supprimer</a></td>';
        $content .= '</tr>';

    }
    $content .= '</table>';
}
?>

<h1>GESTION DES CATEGORIES</h1>

<a href="?action=affichage">Affichage des catégories</a><br>

<a href="?action=ajout">Ajouter une catégorie</a><br>


<?= $content ?>

<?php
if (!empty($_POST)) { // Si le formulaire a été validé et qu'il y a des infos dedans (le $_POST n'est pas vide)
foreach ($_POST as $key => $value) {
$_POST[$key] = htmlentities (addslashes($value));
}

//var_dump($_POST);
if(isset($_GET['action']) &&  $_GET['action'] == 'ajout') {



execute_requete("UPDATE categorie SET
reference = '$_POST[id_categorie]',
titre = '$_POST[titre]',
motscles = '$_POST[motscles]',

WHERE id_categorie = '$_GET[id_categorie]'
" );

header('location:gestion_categories.php?action=ajout');
}
else{

    execute_requete("INSERT INTO categorie(titre, motscles) VALUES('$_POST[titre]','$_POST[motscles]')");

    header('location:gestion_categories.php?action=ajout');

}
}
?>

<?php
if (!empty($_POST)) {
    foreach ($_POST as $key => $value) {
        $_POST[$key] = htmlentities (addslashes($value));
    }
    if(isset($_GET['action']) && $_GET['action'] == 'modification'){

        execute_requete("UPDATE categorie SET
reference = '$_POST[id_categorie]',
categorie = '$_POST[titre]',
titre = '$_POST[motscles]',

WHERE id_categorie = '$_GET[id_categorie]'
" );

        /*header('location:gestion_boutique.php?action=affichage');*/
    }
    else{

        execute_requete("INSERT INTO article(id_categorie, titre, motscles) VALUES('$_POST[id_categorie]','$_POST[titre]','$_POST[motscles]')");

        /*header('location:gestion_boutique.php?action=affichage');*/

    }


}

if (isset($_GET['action']) && ($_GET['action'] == 'modification' || $_GET['action'] == 'suppression')) :

if (isset($_GET['id_note'])) {

    $r = execute_requete("SELECT * FROM categorie WHERE id_categorie = '$_GET[id_note]'");

    $article_actuel = $r->fetch(PDO::FETCH_ASSOC);
    //debug($article_actuel);
}

if (isset($article_actuel['reference'])) {
    $reference = $article_actuel['reference'];
} else {
    $reference = '';
}

$id_categorie = (isset($article_actuel['id_categorie'])) ? $article_actuel['id_categorie'] : '';
$titre = (isset($article_actuel['titre'])) ? $article_actuel['titre'] : '';
$motscles = (isset($article_actuel['motscles'])) ? $article_actuel['motscles'] : '';
?>






<form method="post">
    <label for="titre">Titre</label><br>
    <input type="text" name="titre" id="titre" class="form-control" placeholder="Titre de la salle"><br>

    <label for="motscles">Description Courte</label><br>
    <textarea name="motscles" id="motscles" cols="30" rows="10" placeholder="Description courte de votre annonce" ></textarea><br>


    <br><button type="submit" class="btn btn-primary">Enregistrer</button>


</form>

<?php endif; ?>

<?php require_once('../inc/footer.inc.php')?>




