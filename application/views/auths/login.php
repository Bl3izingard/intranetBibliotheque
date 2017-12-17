<div class="row">
	<div class="col">
<?php
echo form_open ( 'auths/login' );
?>
<div
			class="form-group <?php if(!empty(form_error("user"))) { echo "has-danger"; } ?>">
<?php
echo form_input ( $user );
echo form_error ( "user", '<div class="form-control-feedback">', '<div>' );
?>
</div>
		<div
			class="form-group <?php if(!empty(form_error("passwd"))) { echo "has-danger"; } ?>">
<?php
echo form_password ( $passwd );
echo form_error ( "passwd", '<div class="form-control-feedback">', '<div>' );
?>
</div>
<?php
echo form_submit ( array (
		"value" => "Se connecter",
		"class" => "btn btn-primary" ) );
if (isset ( $error_message ))
{
	echo $error_message;
}
echo form_close ();
?>
</div>
</div>
