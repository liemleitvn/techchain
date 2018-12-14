<?php 
	namespace App\Repositories\Eloquents;
	use App\Repositories\Contacts\AdminInterface;
	
	use App\Models\Category;
	class CategoryRepository implements AdminInterface
	{

		protected $category;
	    // Constructor to bind model to repo
	    public function __construct(Category $category)
	    {
	        $this->category = $category;
	    }

	    public	function getBy(){
	    	return $this->category->orderBy('id','DESC');
	    }

	    public	function getByASC(){
	    	return $this->category->orderBy('id','ASC');
	    }

	    public	function getAll(){
	    	return $this->category->orderBy('id','DESC')->get();
	    }
	     
	    public  function getById($id){
	    	return $this->category->find($id);
	    }
	     
	    public  function create(array $data){
	    	$this->category->create($data);
	    }
	     
	    public  function update($id, array $data){
	    	$this->category->find($id)->update($data);
	    }
	     
	    public  function delete($id){
	    	$this->category->find($id)->delete();
	    }
	}