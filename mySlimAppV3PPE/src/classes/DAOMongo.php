<?php 

namespace classes;

class DAOMongo
{
	public $mng;
	
	public function __construct(){
		$this->mng = new \MongoDB\Driver\Manager("mongodb://172.19.0.46:27017");
	}
	
	public function marqueCroquette() 
	{
		$query = new \MongoDB\Driver\Query([]); 
     
		$rows = $this->mng->executeQuery("slimTDBDD.marque", $query);
		
		$lesMarques = array();
		
		foreach ($rows as $row) { 

			$lesMarques[] = $row->marque;

		}
		return $lesMarques;
		
	}

	public function enregistrementRepas($date, $heure, $grammes, $marque) 
	{
		
		$bulk = new \MongoDB\Driver\BulkWrite;
		$doc = ['_id' => new \MongoDB\BSON\ObjectID, 'date' => $date, 'heure' => $heure, 'quantite' => $grammes, 'marque' => $marque, 'idChien' => $_SESSION['idChien']];
		$bulk->insert($doc);
		$this->mng->executeBulkWrite('slimTDBDD.repas', $bulk);

		
	}
	
	public function enregistrementReleves($date, $poids) 
	{
		
		$bulk = new \MongoDB\Driver\BulkWrite;
		$doc = ['_id' => new \MongoDB\BSON\ObjectID, 'date' => $date, 'poids' => $poids, 'idChien' => $_SESSION['idChien']];
		$bulk->insert($doc);
		$this->mng->executeBulkWrite('slimTDBDD.relevesPoids', $bulk);

		
	}
	
	public function StatsPoids($idChien) 
	{
		$filter = [ 'idChien' => $idChien ];   
		$options = ['sort' => ['date' => 1]];
    		
    
		$query = new \MongoDB\Driver\Query($filter, $options); 
     
		$rows = $this->mng->executeQuery("slimTDBDD.relevesPoids", $query);
		
		$lesPoids = array();
		
		foreach ($rows as $row) { 
			$ligne = array();
			
			$ligne["poids"] = $row->poids;
			$ligne["date"] = $row->date;
			
			$lesPoids[] = $ligne;

		}
		//echo var_dump($lesPoids);
		return $lesPoids;

		
	}
	
	public function StatsAlim($idChien) 
	{
		$filter = [ 'idChien' => $idChien ];    
		$options = ['sort' => ['date' => 1]];
    
		$query = new \MongoDB\Driver\Query($filter, $options); 
     
		$rows = $this->mng->executeQuery("slimTDBDD.repas", $query);
		
		$Alim = array();
		
		foreach ($rows as $row) { 
			$ligne = array();
			

			$ligne["date"] = $row->date;
			$ligne["quantite"] = $row->quantite;
			
			$Alim[] = $ligne;

		}
		//echo var_dump($Alim);
		return $Alim;

		
	}
	
	public function enregistrementMarqueCroquette($marque) 
	{
		
		$bulk = new \MongoDB\Driver\BulkWrite;
		$doc = ['_id' => new \MongoDB\BSON\ObjectID, 'marque' => $marque];
		$bulk->insert($doc);
		$this->mng->executeBulkWrite('slimTDBDD.marque', $bulk);

		
	}
	
	public function historiqueRepas($idChien) 
	{
		$filter = [ 'idChien' => $idChien ];   
		$options = ['sort' => ['date' => -1]];
    
		$query = new \MongoDB\Driver\Query($filter, $options); 
     
		$rows = $this->mng->executeQuery("slimTDBDD.repas", $query);
		
		$historiqueRepas = array();
		
		foreach ($rows as $row) { 
			$ligne = array();
			
			$ligne["date"] = $row->date;
			$ligne["heure"] = $row->heure;
			$ligne["quantite"] = $row->quantite;
			$ligne["marque"] = $row->marque;
			
			$historiqueRepas[] = $ligne;
		}
		//echo var_dump($lesPoids);
		return $historiqueRepas;
	}
	
	
	public function historiqueReleves($idChien) 
	{
		$filter = [ 'idChien' => $idChien ];   
		$options = ['sort' => ['date' => -1]];
    
		$query = new \MongoDB\Driver\Query($filter, $options); 
     
		$rows = $this->mng->executeQuery("slimTDBDD.relevesPoids", $query);
		
		$historiqueReleves = array();
		
		foreach ($rows as $row) { 
			$ligne = array();
			
			$ligne["date"] = $row->date;
			$ligne["poids"] = $row->poids;
			
			$historiqueReleves[] = $ligne;
		}
		//echo var_dump($lesPoids);
		return $historiqueReleves;
	}
	
}


	