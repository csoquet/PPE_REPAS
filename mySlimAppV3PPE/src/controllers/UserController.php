<?php
namespace controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use classes\DAOUser;
use classes\DAOMongo;

class UserController{

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function connect(Request $request, Response $response, $args)
    {
		$params = $request->getQueryParams();
		$message="";
		
		if(isset($params['error'])){
			$message = "Merci de vous authentifier";
		}
		return $this->container->view->render($response, 'login.html', [
			'message' => $message
		]);
        //return $this->container->view->render($response, 'login.html');
    }

    public function login(Request $request, Response $response, $args)
    {
        $data = $request->getParsedBody();
		$donnees = [];
		$donnees['login'] = filter_var($data['login'], FILTER_SANITIZE_STRING);
		$donnees['mdp'] = filter_var($data['mdp'], FILTER_SANITIZE_STRING);
		
		$daoUser = new DAOUser($this->container->db);
		$leUser = $daoUser->login($donnees['login'], $donnees['mdp']);
		
		if($leUser){
			$_SESSION['user'] = $leUser;
			$_SESSION['idUser'] = $leUser['id'];
			$_SESSION['nomUser'] = $leUser['nom'];
			$_SESSION['prenomUser'] = $leUser['prenom'];
			//echo var_dump($_SESSION);
			return $response->withRedirect('./accueil');
		}else{
			return $response->withRedirect('./?error=invalidCredentials'); 
		}
    }

    public function accueil(Request $request, Response $response, $args)
    {
		if(isset($_SESSION['user'])){
			return $this->container->view->render($response, 'accueil.html');
		}else{
			return $response->withRedirect('./?error=unauthorized'); 
		}
	
    }

	
	 public function listeChien(Request $request, Response $response, $args)
    {
        $data = $request->getParsedBody();

		
		$daoUser = new DAOUser($this->container->db);
		$lesChiens = $daoUser->listeChien();
		
		if($lesChiens){
			return $this->container->view->render($response, 'listeChien.html', [
			'listeChien' => $lesChiens]);
		}else{
			return $response->withRedirect('./accueil'); 
		}
			//array('case 1' => 55)
    }

	
	 public function menu(Request $request, Response $response, $args)
    {
        $data = $request->getParsedBody();
		$donnees = [];
		$donnees['id'] = filter_var($_REQUEST['chien'], FILTER_SANITIZE_STRING);
		
		$daoUser = new DAOUser($this->container->db);
		$leChien = $daoUser->menu($donnees['id']);
		
		$params = $request->getQueryParams();
		$message="";
		
		if(isset($_SESSION['enregistrementRepas'])){
			$message = "Vous avez bien enregistré votre repas";
			unset($_SESSION['enregistrementRepas']);
		}
		
		if(isset($_SESSION['enregistrementReleves'])){
			$message = "Vous avez bien enregistré le poids de votre chien";
			unset($_SESSION['enregistrementReleves']);
		}
		
		if(isset($_SESSION['enregistrementMarqueCroquette'])){
			$message = "Vous avez bien ajouter la marque de croquette";
			unset($_SESSION['enregistrementMarqueCroquette']);
		}
		
		if($leChien){
			$_SESSION['idChien'] = $donnees['id'];
			$_SESSION['nomChien'] = $leChien['nom'];
			return $this->container->view->render($response, 'menu.html', [
			'leChien' => $leChien, 'message' => $message]);
		}
		
		$message= "";
		
			//array('case 1' => 55)
    }
	
	public function repas(Request $request, Response $response, $args)
    {
        $data = $request->getParsedBody();
		
		
		$daoMongo = new DAOMongo();
		$lesMarques = $daoMongo->marqueCroquette();
		
		
		return $this->container->view->render($response, 'repas.html', ['leChien' => $_SESSION['nomChien'], 'lesMarques' => $lesMarques]);
		
		
			//array('case 1' => 55)
    }
	
	public function enregistrementRepas(Request $request, Response $response, $args)
    {	
        $data = $request->getParsedBody();
		$donnees = [];
		$donnees['date'] = filter_var($data['date'], FILTER_SANITIZE_STRING);
		$donnees['heure'] = filter_var($data['heure'], FILTER_SANITIZE_STRING);
		$donnees['grammes'] = filter_var($data['grammes'], FILTER_SANITIZE_STRING);
		$donnees['marque'] = filter_var($data['marque'], FILTER_SANITIZE_STRING);
		
		$daoMongo = new DAOMongo();
		$lesMarques = $daoMongo->enregistrementRepas($donnees['date'], $donnees['heure'], $donnees['grammes'], $donnees['marque']);
		
		$_SESSION["enregistrementRepas"] = true;
		
		
		return $response->withRedirect('./menu?chien='.$_SESSION['idChien']);
			//return $response->redirect('./menu', array('idChien' => $_SESSION['idChien'])); 
//		return $this->container->view->render($response, 'menu.html');
		
		
			//array('case 1' => 55)
			
			
    }
	
	public function relevesPoids(Request $request, Response $response, $args)
    {
        $data = $request->getParsedBody();
				
		
		return $this->container->view->render($response, 'relevesPoids.html', ['leChien' => $_SESSION['nomChien']]);
		
		
			//array('case 1' => 55)
    }
	
	
	public function enregistrementReleves(Request $request, Response $response, $args)
    {	
        $data = $request->getParsedBody();
		$donnees = [];
		$donnees['date'] = filter_var($data['date'], FILTER_SANITIZE_STRING);
		$donnees['poids'] = filter_var($data['poids'], FILTER_SANITIZE_STRING);

		
		$daoMongo = new DAOMongo();
		$lesMarques = $daoMongo->enregistrementReleves($donnees['date'], $donnees['poids']);
		
		$_SESSION["enregistrementReleves"] = true;
		
		
		return $response->withRedirect('./menu?chien='.$_SESSION['idChien']);
			//return $response->redirect('./menu', array('idChien' => $_SESSION['idChien'])); 
//		return $this->container->view->render($response, 'menu.html');
		
		
			//array('case 1' => 55)
			
			
    }
	
	public function statistiques(Request $request, Response $response, $args)
    {	
        $data = $request->getParsedBody();

		
		$daoMongo = new DAOMongo();
		$lesPoids = $daoMongo->StatsPoids($_SESSION['idChien']);
			
		$Alim = $daoMongo->StatsAlim($_SESSION['idChien']);
			
		return $this->container->view->render($response, 'statistiques.html', ['lesPoids' => $lesPoids, 'Alim'=> $Alim] );
			//return $response->redirect('./menu', array('idChien' => $_SESSION['idChien'])); 
//		return $this->container->view->render($response, 'menu.html');
		
		
			//array('case 1' => 55)
			
			
    }
	
	public function enregistrementMarqueCroquette(Request $request, Response $response, $args)
    {	
        $data = $request->getParsedBody();
		$donnees = [];
		$donnees['marque'] = filter_var($data['newMarque'], FILTER_SANITIZE_STRING);

		
		$daoMongo = new DAOMongo();
		$laMarque = $daoMongo->enregistrementMarqueCroquette($donnees['marque']);
		
		$_SESSION["enregistrementMarqueCroquette"] = true;
		
		
		return $response->withRedirect('./menu?chien='.$_SESSION['idChien']);
			//return $response->redirect('./menu', array('idChien' => $_SESSION['idChien'])); 
//		return $this->container->view->render($response, 'menu.html');
	
    }
	
	
	public function historiqueRepas(Request $request, Response $response, $args)
    {	
        $data = $request->getParsedBody();

		
		$daoMongo = new DAOMongo();
		$historiqueRepas = $daoMongo->historiqueRepas($_SESSION['idChien']);
			
			
	return $this->container->view->render($response, 'historiqueRepas.html', ['historiqueRepas' => $historiqueRepas] );
			//return $response->redirect('./menu', array('idChien' => $_SESSION['idChien'])); 
//		return $this->container->view->render($response, 'menu.html');			
    }
	
	public function historiqueReleves(Request $request, Response $response, $args)
    {	
        $data = $request->getParsedBody();

		
		$daoMongo = new DAOMongo();
		$historiqueReleves = $daoMongo->historiqueReleves($_SESSION['idChien']);
			
			
	return $this->container->view->render($response, 'historiqueReleves.html', ['historiqueReleves' => $historiqueReleves] );
			//return $response->redirect('./menu', array('idChien' => $_SESSION['idChien'])); 
//		return $this->container->view->render($response, 'menu.html');			
    }
	
	public function retourMenu(Request $request, Response $response, $args)
    {	
        $data = $request->getParsedBody();
			
			
	return $response->withRedirect('./menu?chien='.$_SESSION['idChien']);
			//return $response->redirect('./menu', array('idChien' => $_SESSION['idChien'])); 
//		return $this->container->view->render($response, 'menu.html');			
    }
	public function deconnexion(Request $request, Response $response, $args)
    {	
        $data = $request->getParsedBody();
		session_destroy();
		return $response->withRedirect('./');		
    }
	


}