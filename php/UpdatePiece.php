<?php

$nomPiece   = addslashes(utf8_decode( $_GET['nomPiece'])) ;
$NewnomPiece   = addslashes(utf8_decode( $_GET['NewnomPiece'])) ;
  //--- Connection au SGBDR 
  $DataBase = mysqli_connect ( "localhost" , "root" , "" ) ;

  //--- Ouverture de la base de données
  mysqli_select_db ( $DataBase, "todolist" ) ;

  //--- Préparation de la requête
  $Requete1 = "UPDATE piece  SET nomPiece='".$NewnomPiece."'  WHERE nomPiece='".$nomPiece."';" ;

  $Resultat1 = mysqli_query ( $DataBase, $Requete1  )  or  die(mysqli_error($DataBase) ) ;

  //--- Déconnection de la base de données
  mysqli_close ( $DataBase ) ;  

    header("location: ".$_SERVER["HTTP_REFERER"]);
?>