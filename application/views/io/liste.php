<div class="row">
	<?php echo form_open("io/liste/", array("class" => "form-inline"))?>
	<div class="col"><?php
	
	echo form_dropdown ( "field", array (
			"id" => "ID",
			"titre" => "Titre",
			"genre" => "Genre",
			"auteur" => "Auteur",
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
			"value" => "Emprunt",
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
				<th scope="col">Editeur</th>
				<th scope="col">Nom Prénom</th>
				<th scope="col">Date Limite</th>
				<th scope="col"><a href="<?php echo base_url("/io/out"); ?>"><button
							type="button" class="btn btn-success btn-mini">
							<i class="fa fa-plus"></i> Ajouter
						</button></a></th>
			</tr>
		</thead>
		<tbody>
  		<?php
				foreach ( $listeEmprunt->result () as $emprunt )
				{
					printf ( '<tr>
							<th scope="row">%d</th>
							<td>%s</td>
							<td>%s</td>
							<td>%s %s</td>
							<td>%s</td>
							<td><a href="%s">Retourner</a></td>
						</tr>', $emprunt->ID, $emprunt->titre, $emprunt->editeur, $emprunt->nom, $emprunt->prenom, date("d/m/Y", strtotime($emprunt->dateEmprunt . ' + ' . $emprunt->duree . 'days')), base_url ( "/io/in/" . $emprunt->ID ) );
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