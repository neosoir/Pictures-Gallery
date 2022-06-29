<?php

$id = $_GET['id'];
$sql = $this->db->prepare("SELECT data FROM " . BCPG_TABLE . " WHERE id = %d", $id );
$resultado = $this->db->get_var( $sql );

?>





