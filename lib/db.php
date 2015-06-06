<?php
try {
$db = new PDO('mysql:host=localhost;dbname=site', 'root', '');
$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
} catch(Exception $e) {
	echo 'Impossible de se connecter à la base de donnée';
	echo $e->getMessage();
	die();
}
?>

<!-- <?php
$select = $db->query('SELECT * FROM users');
var_dump($select->fetch());
?> -->