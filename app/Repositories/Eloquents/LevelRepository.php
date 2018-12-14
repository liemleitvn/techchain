<?php 
	namespace App\Repositories\Eloquents;
	use App\Repositories\Contacts\AdminInterface;
	
	use App\Models\Level;
	class LevelRepository implements AdminInterface
	{

		protected $level;

	    // Constructor to bind model to repo
	    public function __construct(Level $level)
	    {
	        $this->level = $level;
	    }

	    public	function getBy(){
	    	return $this->level->orderBy('id','DESC');
	    }
	    
	    public	function getAll(){
	    	return $this->level->orderBy('id','DESC')->get();
	    }
	     
	    public  function getById($id){
	    	return $this->level->find($id);
	    }
	     
	    public  function create(array $data){
	    	$this->level->create($data);
	    }
	     
	    public  function update($id, array $data){
	    	$this->level->find($id)->update($data);
	    }
	     
	    public  function delete($id){
	    	$this->level->find($id)->delete();
	    }
	}