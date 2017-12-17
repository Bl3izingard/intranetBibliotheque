<div class="row">
	<?php echo form_open("bibliotheque/liste/", array("class" => "form-inline"))?>
	<div class="col"><?php
	
	echo form_dropdown ( "field", array (
			"id" => "ID",
			"titre" => "Titre",
			"genre" => "Genre",
			"auteur" => "Auteur",
			"nomSite" => "Nom du site" ), set_value ( "field" ), array (
			'id' => 'field',
			'class' => 'form-control form-control-sm' ) );
	?>
	
	</div>
	<div class="col"><?php
	
	echo form_input ( array (
			'type' => 'input',
			'name' => 'search',
			'id' => 'search',
			'value' => set_value ( 'search' ),
			'class' => 'form-control form-control-sm' ) );
	?></div>
	<div class="col"><?php
	
	echo form_submit ( array (
			"value" => "Rechercher",
			"class" => "btn btn-primary btn-small" ) );
	?></div>
	<?php echo form_close (); ?>
</div>
<div>
	<table class="table">
		<thead class="thead-dark">
			<tr>
				<th scope="col">#</th>
				<th scope="col">Titre</th>
				<th scope="col">Résume</th>
				<th scope="col">Type</th>
				<th scope="col">Auteur</th>
				<th scope="col">Genre</th>
				<th scope="col">Localisation</th>
				<th scope="col"><a href="<?php echo base_url("/bibliotheque/ajouter"); ?>"><button
							type="button" class="btn btn-success btn-mini">
							<i class="fa fa-plus"></i> Ajouter
						</button></a></th>
			</tr>
		</thead>
		<tbody>
  		<?php
				foreach ( $listeLivre->result () as $livre )
				{
					printf ( '<tr>
							<th scope="row">%d</th>
							<td>%s</td>
							<td>%s</td>
							<td>%s</td>
							<td>%s</td>
							<td>%s</td>
							<td>%s</td>
							<td><a href="%s">Modifier</a> <a href="%s">Supprimer</a></td>
						</tr>', $livre->ID, $livre->titre, $livre->courtResume, $livre->type, $livre->auteur, $livre->genre, $livre->nomSite, base_url ( "/bibliotheque/modifier/" . $livre->ID ), base_url ( "/bibliotheque/supprimer/" . $livre->ID ) );
				}
				?>
    
	</tbody>
	</table>
</div>
<div class="row">
	<div class="col">
		<a href="<?php echo base_url(); ?>">Retour</a>
	</div>
</div>