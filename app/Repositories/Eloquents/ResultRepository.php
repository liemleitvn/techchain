<?php 
	namespace App\Repositories\Eloquents;
	use App\Repositories\Contacts\AdminInterface;
	
	use App\Models\Result;
	class ResultRepository implements AdminInterface
	{

		protected $result;

	    // Constructor to bind model to repo
	    public function __construct(Result $result)
	    {
	        $this->result = $result;
	    }

	    public	function getBy(){
	    	return $this->result->orderBy('id','DESC');
	    }

	    public	function query(){
	    	return $this->result;
	    }

	    public	function getAll(){
	    	return $this->result->orderBy('id','DESC')->get();
	    }

	    public  function getById($id){
	    	return $this->result->find($id);
	    }
	     
	    public  function create(array $data){
	    	$this->result->create($data);
	    }
	     
	    public  function update($id, array $data){
	    	$this->result->find($id)->update($data);
	    }
	    
	    public  function updateOption(array $data, $where_x, $where_y, $where1_x, $where1_y){
	    	$this->result->where($where_x, $where_y)->where($where1_x, $where1_y)->update($data);
	    }

	    public  function delete($id){
	    	$this->result->find($id)->delete();
	    }
	}