<?php

  include 'Library/autoload.php';              //Auto chargement des classes
  include 'Config/App.inc.php';                //Paramètres de l'application

  session_start();                             //Démarrage de la session

  //Déconnexion
  if(isset($_GET['reset']))
  {
    SessionManager::deleteConnection();
  }

  //Gestion de la session
  SessionManager::createConnection();
  
  //Application
  if(SessionManager::isConnected())
  {
    echo '<a href="'.REDIRECT_URI.'">Refresh</a> <br />' . "\n";
    echo '<a href="'.REDIRECT_URI.'?reset">Reset</a> <br />' . "\n";

    //Récupération de l'authentification
    $authTwinoid = $_SESSION['authTwinoid'];
    Debug::showVariable($authTwinoid);

    //Gestion de l'API Hordes
    $hordesApi = new HordesAPI($authTwinoid->getToken());
    Debug::showVariable($hordesApi->getMe());

    //Gestion des erreurs
    if($hordesApi->errors())
    {
      $description = $hordesApi->getErrorsDescriptions();

      foreach($hordesApi->getErrors() as $key => $error)
      {
        echo $error . ' : ' . $description[$key] . '<br/>';
      }
    }

  }
?>