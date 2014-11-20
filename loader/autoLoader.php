<?php 

class Autoloader 
{	

	 /**
	 * Method will load in any classes we are trying to access but have not yet included. 
	 * 
	 *   
	 * @access public
	 * @param $className
	 */ 
	public static function loadClasses($className) 
	{ 
		
		//This will itterate over each file path until we find a match. If we do find a match this code will still itterate to find a macth
		//Would be faster if we stopped itterating when we find a match

		$paths = include('../penguin-framwork/system/systemPaths.php'); 

		foreach ($paths as $path) { 
    	  
    	  	$file_name =  $path . $className . '.php'; 

			$file_name = strtolower($file_name);	

			//echo '<br /> trying to load in - ' . $file_name . '.........<br />'; 
    	  	
    	  	if (file_exists($file_name))  {
    	  		
    	  		//echo '<br /> opend file' . $file_name . '<br />'; 
				
				include ($file_name);
		
			} else {
				
				//File not found - throw exception
				//echo "<br /> Error - no file found for " . $file_name;
			
			}
		
		}
		
	} 

	 /**
	 * Will be called each time we try to call a class that is not yet included.
	 */ 
   public static function findClass() 
   {
	   
	   	spl_autoload_register(array(__CLASS__, 'loadClasses'));
  
   }
 
}


?> 	