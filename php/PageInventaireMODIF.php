<HTML>
    
<HEAD>
        <script src="jquery.js"></script>
        <link rel="stylesheet" href="../css/styles.css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
		<script src="https://kit.fontawesome.com/1afb5541c8.js" crossorigin="anonymous"></script>
		
    <title> Inventaire </title>

</HEAD>	
<body>	
    
    <!-- <?php
        $DataBase = mysqli_connect ( "localhost" , "root" , "" ) ;
        mysqli_select_db ( $DataBase, "todolist" ) ;
    ?> -->

        <section id="Menu">
			<ul>
				<div class="btn-group" role="group" aria-label="Basic example">
					<li><a href="../index.php"><button type="button" class="btn btn-primary btn-lg btn-block" id="b1">Inventaire</button></a></li>
					<li><a href="../index.php"><button type="button" class="btn btn-primary btn-lg btn-block" id="b2">To-Do list</button></a></li>
				</div>
			</ul>
		</section>

        <section id="PageInventaire">
			<section id="BarresInterraction">
				<div id="AjoutPiece" class="border border-dark rounded ">
					<form action="AjoutPiece" >
					<p class="text-monospace"><i class="fas fa-plus"></i> 			Ajouter une Pièce :<br>
					<div class="input-group mb-3">
						<div class="input-group-prepend">
							<span class="input-group-text" id="inputGroup-sizing-default">Nom Pièce</span>
						</div>	
						<input class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" type="text" name="nomObjet" value ="" placeholder="Nom.."> <input type="submit" class="btn btn-secondary" placeholder="Valider">
					</div>
					</form>
				</div>
				

				<div id="AjoutObjet" class="border border-dark rounded ">

				<form action="AjoutObjet.php" class="form-group">
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
							<span class="input-group-text" id="inputGroup-sizing-default">Nom Objet</span>
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

    <section id="ListePieces">
    <?php

        $OPTION = "PRINT" ;  
        function  ConsulterBD ()
        {
        global $OPTION ;  // indiquer que la variable est une variable globale
        global $Piece ;
        $Piece = utf8_decode($_GET['nomPiece']) ;
        
        if (  ($OPTION == 'DELETE')  Or  ($OPTION == 'UPDATE1') )
                $IdCourant = $_GET['idObjet'];
        else  $IdCourant = -1 ;

            //--- Début de table en HTML
        echo "<center>" ;
        echo "<table class='table table-bordered table-dark'  id='tableau'>" ;
        echo "<h3>" . $Piece . "</h3>";
        $DataBase = mysqli_connect ( "localhost" , "root" , "" ) ;
        mysqli_select_db ( $DataBase, "todolist" ) ;
        //--- Préparation de la requête
        $Requete = "SELECT idObjet,nomObjet,nomPiece,nomEtat FROM objet
                    Join piece on objet.idPiece = piece.idPiece
                    Join etat on objet.idEtat = etat.idEtat
                    WHERE nomPiece =  '$Piece'  " ;

        //--- Exécution de la requête (fin du script possible sur erreur ...)
        $Resultat = mysqli_query ( $DataBase, $Requete )  or  die(mysqli_error($DataBase) ) ;

        if ($OPTION == 'UPDATE1'){
            echo "<tr>  <th> Nom </th> <th> Etat </th> <th> Confirmer </th> <th> Annuler </th> </tr> "  ;
        }
        else if ($OPTION == 'DELETE'){
            echo "<tr>  <th> Nom </th> <th> Etat </th> <th> Confirmer </th> <th> Annuler </th> </tr>  " ;
        }  
            else {
                echo "<tr>  <th> Nom </th> <th> Etat </th> <th> Supprimer </th> <th> Modifier </th></tr>"  ;
            } 

            //--- Enumération des lignes du résultat de la requête
        while (  $ligne = mysqli_fetch_array($Resultat)  )
        {
            //--- Afficher une ligne du tableau HTML pour chaque enregistrement de la table 
            echo "<tr>\n" ;

            if (  ($OPTION == 'UPDATE1') )
            {
                if ( $IdCourant == $ligne['idObjet'] )
                {
                    echo "<form action='PageInventaireMODIF.php'>";
                    //echo "<td><INPUT TYPE=TEXT NAME='Id' Value='". $ligne['Id']    . "'></td>\n" ;
                    echo "<td><INPUT TYPE=TEXT NAME='nomObjet' Value='". utf8_encode($ligne['nomObjet'])    . "'</td>\n" ;
                    echo"<td>";
                            echo" <label for='nomEtat'></label><select name='nomEtat'>";
                                echo" <option name='R.A.S'>R.A.S</option>";
                                echo" <option name='A verifier'>A verifier</option>";
                            echo"  </select>";
                } 
                else
                {	//echo "<td>" . $ligne['Id']       . "</td>\n" ;
                    echo "<td>" . utf8_encode($ligne['nomObjet']) . "</td>\n" ;
                    echo "<td>" . utf8_encode($ligne['nomEtat'])    . "</td>\n" ;
                }
            }
            else
            {	//echo "<td>" . $ligne['Id']       . "</td>\n" ;
                echo "<td>" . utf8_encode($ligne['nomObjet']) . "</td>\n" ;
                echo "<td>" . utf8_encode($ligne['nomEtat'])    . "</td>\n" ;
            }
            if (  ($OPTION == 'DELETE') )
            {
                if ( $IdCourant == $ligne['idObjet'] )
                {
                    echo "<td><A HREF='PageInventaireMODIF.php?nomPiece=".$Piece."&OPTION=DELETE2&idObjet=".$ligne['idObjet']."'><i class='fas fa-minus-circle'></i></A></td>";
                    echo "<td><A HREF='PageInventaireMODIF.php?nomPiece=".$Piece."&idObjet=".$ligne['idObjet']."'><i class='fas fa-minus-circle'></i></a>";
                    echo "</td>\n" ;
                }
            }
            else if (  ($OPTION == 'UPDATE1') )
            {
                if ( $IdCourant == $ligne['idObjet'] )
                {
                    echo "<td><INPUT TYPE=HIDDEN Name='OPTION' Value='UPDATE2'>";
                    echo "<INPUT TYPE=HIDDEN Name='nomPiece' Value='".$Piece."'>";
                    echo "<INPUT TYPE=HIDDEN Name='idObjet' Value='".$ligne['idObjet']."'>";
                    echo "<INPUT TYPE=SUBMIT Value='Enregistrer' id='update1' class='btn btn-secondary'>";
                    echo "</form></td>";
                    echo "<td><A HREF='PageInventaireMODIF.php?nomPiece=".$Piece."&idObjet=".$ligne['idObjet']."'><i class='fas fa-minus-circle'></i></A>";
                    echo "</td>\n" ;
                }
            }
            else
            {   
                echo "<td><A HREF='PageInventaireMODIF.php?nomPiece=".$Piece."&OPTION=DELETE&idObjet=" . $ligne['idObjet'] . "'> <i class='fas fa-minus-circle'></i></A></td>\n" ;
                echo "<td><A HREF='PageInventaireMODIF.php?nomPiece=".$Piece."&OPTION=UPDATE1&idObjet=" . $ligne['idObjet'] . "'> <i class='fas fa-pen'></i></A></td>\n" ;
            }
            echo "</tr>\n" ;
        }

        //--- Libérer l'espace mémoire du résultat de la requête
        mysqli_free_result ( $Resultat ) ;

        //--- Déconnection de la base de données
        mysqli_close ( $DataBase ) ;  

        //--- Fin de table en HTML
        echo "</table class='table table-bordered table-dark'>" ;
        echo "<br>" ;
        echo "</center>" ;
        }
        //------------------------------------------------------------------------------
        // 
        //
        function  SupprimerBD ()
        {
        //--- récupérer le param 'Id'	
        if (  ! isset($_GET['idObjet'])  )	return;
        $Id  = $_GET['idObjet'] ;
        //  
        //--- Connection au SGBDR 
        $DataBase = mysqli_connect ( "localhost" , "root" , "" ) ;
        //--- Ouverture de la base de données
        mysqli_select_db ( $DataBase, "todolist" ) ;
        //--- Préparation de la requête
        $Requete = "Delete From objet Where idObjet='". $Id ."' Limit 1;" ;
        //--- Exécution de la requête (fin du script possible sur erreur ...)
        $Resultat = mysqli_query ( $DataBase, $Requete )  or  die(mysqli_error($DataBase) ) ;
        //--- Déconnection de la base de données
        mysqli_close ( $DataBase ) ;  
        }
        //------------------------------------------------------------------------------
        //  Enregistrer les modifications
        //
        function  UpdateBD_2 ()
        {
            $Id     = $_GET['idObjet'    ] ;
            $Objet   = addslashes(utf8_decode($_GET['nomObjet'    ])) ;
            $nomEtat   = addslashes(utf8_decode($_GET['nomEtat'    ])) ;

        $DataBase = mysqli_connect ( "localhost" , "root" , "" ) ;
        mysqli_select_db ( $DataBase, "todolist" ) ;

        $Requete = "SELECT idEtat FROM `etat` WHERE nomEtat = '".$nomEtat."' " ;
        $Resultat = mysqli_query ( $DataBase, $Requete ) or die(mysqli_error($DataBase));
        $row = mysqli_fetch_array($Resultat);
        $row2 = $row['idEtat'];
        $RequeteBIS = "UPDATE objet  SET nomObjet='".$Objet."' , idEtat='".$row2."'   WHERE idObjet=".$Id.";" ;
        $ResultatBIS = mysqli_query ( $DataBase, $RequeteBIS ) or die(mysqli_error($DataBase));
        mysqli_close ( $DataBase ) ;  
        }

        //------------------------------------------------------------------------------
        //  Programme Principal
        //
            $OPTION = 'RIEN' ;	// par défaut
        if ( count($_GET) != 0 )
        {
            if (  isset($_GET['OPTION'])  )
            {	
                $OPTION = $_GET['OPTION'] ;
                switch ( $OPTION )
                {
                    case "DELETE"  : break;
                    case "DELETE2" : SupprimerBD() ;    break;
                    case "UPDATE1" : break;
                    case "UPDATE2" : UpdateBD_2()  ;    break;
                    default        : echo "option inconnue !<br>" ;  
                }
            }
        }
            //--- Consultation ...
        ConsulterBD();
        //------------------------------------------------------------------------------

    ?>
    </section>
</section>

<?php
echo "<form action='UpdatePiece.php' class='form-container'>";
        echo "<h1>Renommer</h1>";

    echo "<label for='nomPiece'><b>Nom de la pièce</b></label>";
    echo "<input type='text' Value='". $Piece . "' name='NewnomPiece' required>";
    echo "<INPUT TYPE=HIDDEN Name='nomPiece' Value='".$Piece."'>";
    echo "<button type='submit' class='btn btn-success'>Sauvegarder</button>";
    echo "<button type='button' class='btn btn-secondary' onclick='closeForm()'>Fermer</button>";
    echo "</form>";
?>

<button class="btn btn-danger" onclick="openForm()">Supprimer la pièce</button>

</body>	
</HTML>

