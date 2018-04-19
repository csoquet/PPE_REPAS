<?php 
namespace classes;

class User
{
    public $id;
    public $nom;
    public $prenom;
    public $tel;
    public $mail;
	public $mdp;
	
    public function __construct($data = null)
    {
        if (is_array($data)) {
            if (isset($data['id'])) $this->id = $data['id'];
            
            $this->nom = $data['nom'];
            $this->prenom = $data['prenom'];
			$this->tel = $data['tel'];
            $this->mail = $data['mail'];
            $this->mdp = $data['mdp'];
        }
    }
    public function getNomComplet()
    {
        echo $this->nom . ' ' . $this->prenom;
    }
}