<?php 

namespace classes;

class DAOUser
{
    private $connection;
    
    public function __construct($connection)
    {
        $this->connection = $connection;
    }
	
    public function find($id)
    {
        $stmt = $this->connection->prepare('
            SELECT * 
             FROM user 
             WHERE id = :id
        ');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        // Set the fetchmode to populate an instance of 'User'
        // This enables us to use the following:
        //     $user = $repository->find(1234);
        //     echo $user->firstname;
        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'User');
        return $stmt->fetch();
    }
	public function login($log, $mdp)
    {
		$sql = '
            SELECT * 
             FROM user 
             WHERE mail = :mail and mdp = :mdp
        ';
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':mail', $log);
		$stmt->bindParam(':mdp', $mdp);
        $stmt->execute();
        
        // Set the fetchmode to populate an instance of 'User'
        // This enables us to use the following:
        //     $user = $repository->find(1234);
        //     echo $user->firstname;
        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'User');
		$leUser = $stmt->fetch();
		/*
		echo "debug **********************************************";
		
		echo var_dump($leUser);
        echo "debug **********************************************";
		*/
		return $leUser;
    }
	
    public function findAll()
    {
        $stmt = $this->connection->prepare('
            SELECT * FROM user
        ');
        $stmt->execute();
        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'User');
        
        // fetchAll() will do the same as above, but we'll have an array. ie:
        //    $users = $repository->findAll();
        //    echo $users[0]->firstname;
        return $stmt->fetchAll();
    }
    public function save(\User $user)
    {
        // If the ID is set, we're updating an existing record
        if (isset($user->id)) {
            return $this->update($user);
        }
        $stmt = $this->connection->prepare('
            INSERT INTO users 
                (nom, prenom, tel, mail, mdp) 
            VALUES 
                (:nom, :prenom , :tel, :mail, :mdp)
        ');
        $stmt->bindParam(':nom', $user->nom);
        $stmt->bindParam(':prenom', $user->prenom);
        $stmt->bindParam(':tel', $user->tel);
        $stmt->bindParam(':mail', $user->mail);
		$stmt->bindParam(':mdp', $user->mdp);
        return $stmt->execute();
    }
    public function update(\User $user)
    {
        if (!isset($user->id)) {
            // We can't update a record unless it exists...
            throw new \LogicException(
                'Cannot update user that does not yet exist in the database.'
            );
        }
        $stmt = $this->connection->prepare('
            UPDATE user
            SET nom = :nom,
                prenom = :prenom,
                tel = :tel,
                mail = :mail,
				mdp = :mdp
            WHERE id = :id
        ');
        $stmt->bindParam(':nom', $user->nom);
        $stmt->bindParam(':prenom', $user->prenom);
        $stmt->bindParam(':tel', $user->tel);
        $stmt->bindParam(':mail', $user->mail);
		$stmt->bindParam(':mdp', $user->mdp);
        $stmt->bindParam(':id', $user->id);
        return $stmt->execute();
    }
	
	public function listeChien()
    {
		
        $stmt = $this->connection->prepare('SELECT id, nom, race FROM chien where idUser ='.$_SESSION['idUser']);
        $stmt->execute();
        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'Chien');
        
        // fetchAll() will do the same as above, but we'll have an array. ie:
        //    $users = $repository->findAll();
        //    echo $users[0]->firstname;
        return $stmt->fetchAll();
    }
	
	public function menu($idChien)
    {
		
        $stmt = $this->connection->prepare('SELECT id, nom, race FROM chien where id = :id');
        $stmt->bindParam(':id', $idChien);
        $stmt->execute();
        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'Chien');
		
        // fetchAll() will do the same as above, but we'll have an array. ie:
        //    $users = $repository->findAll();
        //    echo $users[0]->firstname;
        return $stmt->fetch();
    }
	
	
}