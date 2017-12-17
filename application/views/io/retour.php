<?php echo form_open("io/out/", array("class" => "form-inline"))?>
<div class="col"><?php

echo form_input ( array (
		"type" => 'input',
		"id" => "ID",
		"name" => "ID",
		"placeholder" => "Code barre livre",
		'class' => 'form-control form-control-sm' ) );
?>
	</div>
<div class="col"><?php

echo form_dropdown ( "user", $dataUser, null, array (
		'id' => 'user',
		'class' => 'form-control form-control-sm' ) );
?>
	</div>
<div class="col"><?php

echo form_submit ( array (
		"value" => "Emprunter",
		"class" => "btn btn-primary btn-small" ) );
?></div>
<?php echo form_close (); ?>
<div>
<p><?php if(!empty($erreur)) { echo $erreur; } ?></p>
<p><?php echo form_error("ID") ?></p>
<a href="<?php echo base_url("io"); ?>">Retour</a>
</div>
	