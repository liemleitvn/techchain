<?php 
	namespace App\Repositories\Eloquents;
	use App\Repositories\Contacts\AdminInterface;
	
	use App\Models\Admin;
	class AdminRepository implements AdminInterface
	{

		protected $admin;

	    // Constructor to bind model to repo
	    public function __construct(Admin $admin)
	    {
	        $this->admin = $admin;
	    }

	    public	function getBy(){
	    	return $this->admin->orderBy('id','DESC');
	    }
	    
	    public	function getAll(){
	    	return $this->admin->orderBy('id','DESC')->get();
	    }
	     
	    public  function getById($id){
	    	return $this->admin->find($id);
	    }
	     
	    public  function create(array $data){
	    	$this->admin->create($data);
	    }
	     
	    public  function update($id, array $data){
	    	$this->admin->find($id)->update($data);
	    }
	     
	    public  function delete($id){
	    	$this->admin->find($id)->delete();
	    }
	}