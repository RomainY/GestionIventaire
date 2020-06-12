<?php
        $DataBase = mysqli_connect ( "localhost" , "root" , "" ) ;
        mysqli_select_db ( $DataBase, "todolist" ) ;
?>
<!DOCTYPE html>
<html>
	<head>
		<title>ToDoList</title>
		<link rel="stylesheet" href="css/styles.css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
		<script src="https://kit.fontawesome.com/1afb5541c8.js" crossorigin="anonymous"></script>
		<script src="jquery/jquery.js"></script>
	</head>
	<body>
		<!-- Barre de navigations en haut -->
			<section id="Menu">
			<ul>
				<div class="btn-group" role="group" aria-label="Basic example">
					<li><button type="button" class="btn btn-primary btn-lg btn-block" id="b1">Inventaire</button>  </li>
					<li><button type="button" class="btn btn-primary btn-lg btn-block" id="b2">To-Do list</button></li>
				</div>
			</ul>
		</section>
		<!-- Debut de la page inventaire -->
	<div id="Page1">
		<section id="PageInventaire">
			<section id="BarresInterraction">
				<div id="AjoutPiece" class="border border-dark rounded ">
					<form action="php/AjoutPiece.php" >
					<p class="text-monospace"><i class="fas fa-plus"></i> 			Ajouter une Pièce :<br>
					<div class="input-group mb-3">
						<div class="input-group-prepend">
							<span class="input-group-text" id="inputGroup-sizing-default">Nom Pièce</span>
						</div>	
						<input class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" type="text" name="nomPiece" value ="" placeholder="Nom.."> <input type="submit" class="btn btn-secondary" placeholder="Valider">
					</div>
					</form>
				</div>
				

				<div id="AjoutObjet" class="border border-dark rounded ">

				<form action="php/AjoutObjet.php" class="form-group">
					<p class="text-monospace"><i class="fas fa-plus"></i> Ajouter un Objet :</p> 
					<div class="form-group">

						<?php
						$Requete = "SELECT * FROM `piece` " ;
						$Resultat = mysqli_query ( $DataBase, $Requete )  or  die(mysqli_error($DataBase) ) ;

					
						echo "<select name='idPiece' id='objet-piece' class='form-control' >";
						while (  $ligne = mysqli_fetch_array($Resultat)  )
							{   
								echo "<option name='idPiece' value=". utf8_encode($ligne['idPiece']) .">" . utf8_encode($ligne['nomPiece']) . "</option>";                
							}
						echo "</select>"; 


						$Requete = "SELECT * FROM `etat` " ;
						$Resultat = mysqli_query ( $DataBase, $Requete )  or  die(mysqli_error($DataBase) ) ;

						echo "<select name='idEtat' id='objet-etat' class='form-control'>";
						while (  $ligne = mysqli_fetch_array($Resultat)  )
							{   
								echo "<option name='idEtat' value=". utf8_encode($ligne['idEtat']) .">" . utf8_encode($ligne['nomEtat']) . "</option>";                
							}
						echo "</select>";
						?>
					</div>
					<div class="input-group mb-3">
						<div class="input-group-prepend">
							<span class="input-group-text" id="inputGroup-sizing-default" name="nomObjet" value="" >Nom Objet</span>
						</div>	
						<input class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" type="text" name="nomObjet" value ="" placeholder="Nom.."> <input type="submit" class="btn btn-secondary" placeholder="Valider">
						
					</div> 
				</form>
			</section>
		</section>

		<div id="BarreDeRecherche">       
			<p>Chercher un Objet ?</p>
			<form action="" class="formulaire">
			
			<div class="input-group mb-3">
				<input type="text" class="form-control" placeholder="Nom de l'objet" aria-label="Recipient's username" aria-describedby="basic-addon2">
			</div>	
		</form>
		</div>
		<br>
		<section id="ListePieces">
		<ul class="list-group">	
			
		<?php
			$Requete = "SELECT * FROM piece" ;
			$Resultat = mysqli_query ( $DataBase, $Requete )  or  die(mysqli_error($DataBase) ) ;
			while (  $ligne = mysqli_fetch_array($Resultat)  )
				{
					echo "<h3 >" . utf8_encode($ligne['nomPiece']) . "</h3>";
					$Piece = utf8_encode($ligne['nomPiece']);
					echo "<ul>";
					$Requete2 = "SELECT nomObjet,nomPiece,nomEtat FROM objet
					Join piece on objet.idPiece = piece.idPiece
					Join etat on objet.idEtat = etat.idEtat
					WHERE nomPiece =  '$Piece'  " ;
					$Resultat2 = mysqli_query ( $DataBase, $Requete2 )  or  die(mysqli_error($DataBase) ) ;        
					while (  $ligne = mysqli_fetch_array($Resultat2)  )
						{
							echo "<li class='list-group-item'>" . utf8_encode($ligne['nomObjet']) . " <i class='fas fa-arrow-right'></i> " . utf8_encode($ligne['nomEtat']) ."</li>"; 
						}  
					//echo "<li> |+| Ajouter un Objet </li>";
					echo "<li class='list-group-item'> <A HREF='php/PageInventaireMODIF.php?nomPiece=".$Piece ."'>Modifier </A> </li>";
					echo "</ul>";         
				}
			mysqli_close ( $DataBase ) ; 
			
			
		
		?>
		</ul>
    </section>
	</div> 
		<!-- DEBUT DE LA PAGE TODOLIST -->
		<div id="Page2">
			<section>
				<div id="BarresInterraction">
					<h2> Trier  : 
						<select>
							<option> Urgent </option>
							<option> Important </option>
							<option> Moyen </option>
							<option> Faible </option>
						</select>
					</h2> 
				</div>   

				<div id="TacheRecurrentes">
						<h3>Tache Récurrentes :</h3>
						<ul style="list-style-type:square;">
							<li>Noter compteur</li>
							<li>...</li>
						</ul>
				</div>

				<div id="TacheNonRecurrentes">
					<h3>Cuisine \/</h3>
					<ul style="list-style-type:square;">
						<li>Nettoyer grille pain</li>
						<li>Réparer four</li>
						<li>Démonter frigo</li>
						<a href="AjouterTache.html"> <input type="submit" value="Ajouter une tâche"></a>
					</ul>
				</div>
			</section>
		</div>
	</body>
	<!-- Script jquery pour mettre tout sur une page Page inventaire / Page To Do list -->
<script>
		$(document).ready(function(){
			$("#b1").click(function(){
				$("#Page2").hide();
				$("#Page1").show();		
				});
			$("#b2").click(function(){
				$("#Page1").hide();
				$("#Page2").show();			
			});
		});
</script>
</html>