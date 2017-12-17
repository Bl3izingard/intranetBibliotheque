<div class="row">
	<div class="col">
<?php
echo form_open ( 'admin/ajouter' );
?>

<div
			class="form-group <?php if(!empty(form_error("utilisateur"))) { echo "has-danger"; } ?>">
<?php
echo form_dropdown ( "utilisateur", $utilisateur );
echo form_error ( "utilisateur" );
?>
</div>
		<div
			class="form-group <?php if(!empty(form_error("responsable"))) { echo "has-danger"; } ?>">
<?php
echo form_dropdown ( "responsable", $responsable );
echo form_error ( "responsable" );
?>
</div>
		<div
			class="form-group <?php if(!empty(form_error("nom"))) { echo "has-danger"; } ?>">
<?php
echo form_input ( $nom );
echo form_error ( "nom" );
?>
</div>
		<div
			class="form-group <?php if(!empty(form_error("motDePasse"))) { echo "has-danger"; } ?>">
<?php
echo form_input ( $motDePasse );
echo form_error ( "motDePasse" );
?>
</div>
		<?php
echo form_submit ( array (
		"value" => "Ajouter",
		"class" => "btn btn-primary" ) );
echo form_close ();
?>

</div>
</div>
<div class="row">
	<div class="col">
		<a href="<?php echo $this->agent->referrer(); ?>">Retour</a>
	</div>
</div>