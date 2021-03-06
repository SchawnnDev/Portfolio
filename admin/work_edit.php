<?php
include '../lib/includes.php';

if(isset($_POST['name']) && isset($_POST['slug'])){
	checkCsrf();
	$slug = $_POST['slug'];
	if(preg_match('/^[a-z\-0-9]+$/', $slug)){
		$name = $db->quote($_POST['name']);
		$slug = $db->quote($_POST['slug']);
		$category_id = $db->quote($_POST['category_id']);
		$content = $db->quote($_POST['content']);
		if(isset($_GET['id'])){
			$id = $db->quote($_GET['id']);
			$db->query("UPDATE INTO works SET name=$name, slug=$slug, content=$content, category_id=$category_id, WHERE id=$id");
		} else {
			$db->query("INSERT INTO works SET name=$name, slug=$slug, content=$content, category_id=$category_id");
		}
		setFlash('La réalisation a bien été ajouté');
		header('Location:work.php');
		die();
	} else {
		setFlash('Le slug n\'est pas valide', 'danger');
	}
}

if(isset($_GET['id'])){
	$id = $db->quote($_GET['id']);
	$select = $db->query("SELECT * FROM works WHERE id=$id");
	if($select->rowCount() == 0){
		setFlash("Il n'y a pas de réalisation avec cette ID", 'danger');
		header('Location:work.php');
		die();
	}
	$_POST = $select->fetch();
}

$select = $db->query('SELECT id, name FROM categories ORDER BY name ASC');
$categories = $select->fetchAll();
$categories_list = array();
foreach ($categories as $category) {
	$categories_list[$category['id']] = $category['name'];
}

include '../partials/admin_header.php';
?>

<h1>Editer une réalisation</h1>

<form action="#" method="post">
	<div class="form-group">
		<label for="name">Nom de la réalisation</label>
		<?= input('name'); ?>
	</div>
	
	<div class="form-group">
		<label for="slug">URL de la réalisation</label>
		<?= input('slug'); ?>
	</div>

	<div class="form-group">
		<label for="content">Contenu de la réalisation</label>
		<?= textarea('content'); ?>
	</div>

	<div class="form-group">
		<label for="category_id">Catégorie</label>
		<?= select('category_id', $categories_list); ?>
	</div>


	<?= csrfInput(); ?>


	<button type="submit" class ="btn btn-success">Enregistrer</button>
</form>

<!-- TINYMCE -->

<?php ob_start(); ?>

<script src="<?= WEBROOT; ?>js/jquery.js"></script>
<script src="<?= WEBROOT; ?>js/tinymce/tinymce.min.js"></script>

<script>

tinyMCE.init({
        // General options
        mode : "textarea",

});

</>

<?php $script = ob_get_clean(); ?>

<?php include '../partials/footer.php'; ?>