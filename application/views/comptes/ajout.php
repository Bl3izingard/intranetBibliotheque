<div class="row">
	<div class="col">
<?php
echo form_open ( 'comptes/ajouter' );
?>

<div class="form-check form-check-inline">
			<label class="form-check-label">
<?php echo form_radio('civilite', '0', !$civilite, array("class" => "form-check-input"));?> Monsieur
</label>
		</div>
		<div class="form-check form-check-inline">
			<label class="form-check-label">
<?php echo form_radio('civilite', '1', $civilite, array("class" => "form-check-input"));?> Madame
</label>
		</div>
		<div
			class="form-group <?php if(!empty(form_error("nom"))) { echo "has-danger"; } ?>">
<?php
echo form_input ( $nom );
echo form_error ( "nom" );
?>
</div>
		<div
			class="form-group <?php if(!empty(form_error("prenom"))) { echo "has-danger"; } ?>">
<?php
echo form_input ( $prenom );
echo form_error ( "prenom" );
?>
</div>
		<div
			class="form-group <?php if(!empty(form_error("adresse"))) { echo "has-danger"; } ?>">
<?php
echo form_textarea ( $adresse );
echo form_error ( "adresse" );
?>
</div>
		<div
			class="form-group <?php if(!empty(form_error("mail"))) { echo "has-danger"; } ?>">
<?php
echo form_input ( $mail );
echo form_error ( "mail" );
?>
</div>
		<div
			class="form-group <?php if(!empty(form_error("telephone"))) { echo "has-danger"; } ?>">
<?php
echo form_input ( $telephone );
echo form_error ( "telephone" );
?>
</div>
<?php
echo form_submit ( array (
		"value" => "Ajouter",
		"class" => "btn btn-primary" ) );
if (isset ( $error_message ))
{
	echo $error_message;
}
echo form_close ();
?>

</div>
</div>
<div class="row">
<div class="col">
<a href="<?php echo $this->agent->referrer(); ?>">Retour</a>
</div>
</div>