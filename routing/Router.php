<?php 

//If no controller goto 404 

class Router
{
	public function loadController($name, $method, $args = array()) 
	{
		if (file_exists('app/controllers/' .$name. '.php')) { 
			$controller = $this->createNewController($name, $method, $args); 
		} else {
			$controller = new Home(); //error 404
		}
 
		return $controller; 
	}

	public function createNewController($name, $method, $args = array())  
	{	
		 $this->controller_obj = controllerFactory::buildController($name, $method, $args); 

		 return $this->controller_obj;
	}

}

?> 