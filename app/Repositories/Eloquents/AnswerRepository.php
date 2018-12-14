<?php 
	namespace App\Repositories\Eloquents;
	use App\Repositories\Contacts\AdminInterface;
	
	use App\Models\Answer;
	class AnswerRepository implements AdminInterface
	{

		protected $answer;

	    // Constructor to bind model to repo
	    public function __construct(Answer $answer)
	    {
	        $this->answer = $answer;
	    }

	    public	function getBy($desc){
	    	return $this->answer->orderBy('id',!isset($desc)?'DESC' : 'ASC');
	    }
	    
	    public	function getAll(){
	    	return $this->answer->orderBy('id','DESC')->get();
	    }
	     
	    public  function getById($id){
	    	return $this->answer->find($id);
	    }
	     
	    public  function create(array $data){
	    	$this->answer->create($data);
	    }
	     
	    public  function update($id, array $data){
	    	$this->answer->find($id)->update($data);
	    }
	     
	    public  function delete($id){
	    	$this->answer->find($id)->delete();
	    }
	}