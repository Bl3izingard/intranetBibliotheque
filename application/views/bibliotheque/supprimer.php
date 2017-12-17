<div class="card text-center">
	<div class="card-header">Attention !</div>
	<div class="card-block">
		<h4 class="card-title">Etes-vous sûr de vouloir supprimer
			le livre suivant</h4>
		<p class="card-text">
    		<?php printf ( "\"<b>%s</b>\" écrit par <b>%s</b>.", $livre->titre, $livre->auteur);
						?>
    
    </p>
		<a href="<?php echo $this->agent->referrer(); ?>" class="btn btn-primary">Annuler</a>
		<a href="<?php echo current_url()?>/1" class="btn btn-danger">Supprimer</a> <br>
	</div>
</div>
