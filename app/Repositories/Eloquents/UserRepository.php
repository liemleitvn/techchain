<?php 
	namespace App\Repositories\Eloquents;
	use App\Repositories\Contacts\AdminInterface;
	
	use App\Models\User;
	class UserRepository implements AdminInterface
	{

		protected $user;

	    // Constructor to bind model to repo
	    public function __construct(User $user)
	    {
	        $this->user = $user;
	    }
	    
	    public	function getBy(){
	    	return $this->user->orderBy('id','DESC');
	    }

	    public	function getAll(){
	    	return $this->user->orderBy('id','DESC')->get();
	    }
	     
	    public  function getById($id){
	    	return $this->user->find($id);
	    }
	     
	    public  function create(array $data){
	    	$this->user->create($data);
	    }
	     
	    public  function update($id, array $data){
	    	$this->user->find($id)->update($data);
	    }
	     
	    public  function delete($id){
	    	$this->user->find($id)->delete();
	    }
	}