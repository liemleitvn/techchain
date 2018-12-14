<?php 
	namespace App\Repositories\Contacts;
	

	interface AdminInterface
	{
	    function getAll();
	     
        function getById($id);
     
        function create(array $data);
     
        function update($id, array $data);
     
        function delete($id);
	}