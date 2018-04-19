<?php 
namespace classes;

class Chien
{
    public $id;
    public $nom;
    public $race;
	
    public function __construct($data = null)
    {
        if (is_array($data)) {
            if (isset($data['id'])) $this->id = $data['id'];
            
            $this->nom = $data['nom'];
            $this->race = $data['race'];
        }
    }

}