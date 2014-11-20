<?php 

class controllerFactory 
{
	public static function buildController($className, $method, $args = array() )
	{

		 if(class_exists($className)) 
		 {
			$obj = new ReflectionMethod($className, $method); 
			 	
			$obj->invokeArgs(new $className, $args);

				return $obj; 
		 } else {
			throw new Exception('Error - Class '.$className. 'does not exist!'); 
		 }


	}

}

?> 