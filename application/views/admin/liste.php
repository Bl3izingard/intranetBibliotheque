<div class="row">
	<?php echo form_open("comptes/liste/", array("class" => "form-inline"))?>
	<div class="col"><?php
	
	echo form_dropdown ( "field", array (
			"id" => "ID",
			"nom" => "Nom",
			"prenom" => "Prénom" ), set_value ( "field" ), array (
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
				<th scope="col">Nom</th>
				<th scope="col">Site</th>
				<th scope="col">Responsable</th>
				<th scope="col"><a
					href="<?php echo base_url("/admin/ajouter"); ?>"><button
							type="button" class="btn btn-success btn-mini">
							<i class="fa fa-plus"></i> Ajouter
						</button></a></th>
			</tr>
		</thead>
		<tbody>
  		<?php
				foreach ( $listeEmploye->result () as $compte )
				{
					printf ( '<tr>
							<th scope="row">%d</th>
							<td>%s</td>
							<td>%s</td>
							<td>%s</td>
							<td><a href="%s">Modifier</a> <a href="%s">Supprimer</a></td>
						</tr>', $compte->IDUtilisateur, $compte->nom, $compte->IDSite, $compte->IDResponsable, base_url ( "/admin/modifier/" . $compte->IDUtilisateur ), base_url ( "/admin/supprimer/" . $compte->IDUtilisateur ) );
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