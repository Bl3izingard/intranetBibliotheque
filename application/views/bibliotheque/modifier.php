<div class="row">
	<div class="col">
<?php
echo form_open ( 'bibliotheque/modifier' );

echo form_hidden ( "id", $id );
?>

		<div
			class="form-group <?php if(!empty(form_error("titre"))) { echo "has-danger"; } ?>">
<?php
echo form_input ( $titre );
echo form_error ( "titre" );
?>
</div>
		<div
			class="form-group <?php if(!empty(form_error("resume"))) { echo "has-danger"; } ?>">
<?php
echo form_textarea ( $resume );
echo form_error ( "resume" );
?>
</div>
		<div
			class="form-group <?php if(!empty(form_error("courtResume"))) { echo "has-danger"; } ?>">
<?php
echo form_textarea ( $courtResume );
echo form_error ( "courtResume" );
?>
</div>
		<div
			class="form-group <?php if(!empty(form_error("type"))) { echo "has-danger"; } ?>">
<?php
echo form_dropdown ( "type", $type );
echo form_error ( "type" );
?>
</div>
		<div
			class="form-group <?php if(!empty(form_error("editeur"))) { echo "has-danger"; } ?>">
<?php
echo form_dropdown ( "editeur", $editeur );
echo form_error ( "editeur" );
?>
</div>
		<div
			class="form-group <?php if(!empty(form_error("site"))) { echo "has-danger"; } ?>">
<?php
echo form_dropdown ( "site", $site );
echo form_error ( "site" );
?>
</div>
		<div
			class="form-group <?php if(!empty(form_error("genre[]"))) { echo "has-danger"; } ?>">
<?php
$i = 0;
$nElement = 8;
foreach ( $genre as $k => $v )
{
	if ($i % $nElement == 0)
	{
		echo '<div class="row"><div class="col">';
	}
	
	printf ( '<div class="form-check form-check-inline">
			<label class="form-check-label">
%s %s			
			</label>
		</div>', form_checkbox ( $v ), $k );
	
	if ($i == $nElement || $i == count($genre)-1)
	{ 
		echo '</div></div>';
	}
	$i++;
}
echo form_error ( "genre[]" );
?>
</div>
<div
			class="form-group <?php if(!empty(form_error("auteur[]"))) { echo "has-danger"; } ?>">
<?php
$i = 0;
$nElement = 8;
foreach ( $auteur as $k => $v )
{
	if ($i % $nElement == 0)
	{
		echo '<div class="row"><div class="col">';
	}
	
	printf ( '<div class="form-check form-check-inline">
			<label class="form-check-label">
%s %s			
			</label>
		</div>', form_checkbox ( $v ), $k );
	
	if ($i == $nElement || $i == count($auteur)-1)
	{ 
		echo '</div></div>';
	}
	$i++;
}
echo form_error ( "auteur[]" );
?>
</div>
<?php
echo form_submit ( array (
		"value" => "Modifier",
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