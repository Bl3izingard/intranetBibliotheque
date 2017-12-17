<div class="card text-center">
	<div class="card-header">Attention !</div>
	<div class="card-block">
		<h4 class="card-title">Etes-vous sûr de vouloir supprimer
			l'utilisateur suivant</h4>
		<p class="card-text">
    		<?php
						if ($user->civilite)
						{
							$civilite = "Madame ";
						}
						else
						{
							$civilite = "Monsieur ";
						}
						printf ( "%s <b>%s %s</b> habitant au %s.<br>Joignable au <b>%s</b> et par mail à l'adresse mail <b>%s</b>.", $civilite, $user->nom, $user->prenom, $user->adresse, $user->telephone, $user->mail );
						?>
    
    </p>
		<a href="<?php echo $this->agent->referrer(); ?>" class="btn btn-primary">Annuler</a>
		<a href="<?php echo current_url()?>/1" class="btn btn-danger">Supprimer</a> <br>
	</div>
</div>
