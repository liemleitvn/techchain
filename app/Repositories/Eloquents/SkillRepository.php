<?php 
	namespace App\Repositories\Eloquents;
	use App\Repositories\Contacts\AdminInterface;
	
	use App\Models\Skill;
	class skillRepository implements AdminInterface
	{

		protected $skill;

	    // Constructor to bind model to repo
	    public function __construct(Skill $skill)
	    {
	        $this->skill = $skill;
	    }
	    
	    public	function getBy(){
	    	return $this->skill->orderBy('id','DESC');
	    }
	    public	function getByASC(){
	    	return $this->skill->orderBy('id','ASC');
	    }

	    public	function getAll(){
	    	return $this->skill->orderBy('id','DESC')->get();
	    }
	     
	    public  function getById($id){
	    	return $this->skill->find($id);
	    }
	     
	    public  function create(array $data){
	    	$this->skill->create($data);
	    }
	     
	    public  function update($id, array $data){
	    	$this->skill->find($id)->update($data);
	    }
	     
	    public  function delete($id){
	    	$this->skill->find($id)->delete();
	    }
	}