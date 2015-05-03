<?php
class Cache{

	// @var to save folder name
	protected $saveFolder = '/units/';
	// @var to save settings file name
	protected $settingFile = '/settings.cache.php';
	// @var to save extension cached files 
	protected $ext = '.cache.php';
	// @var to save chased data
	protected $data = null;
	// @var to save class object
	protected static $Cache = null;
	
	/* 
	*  @function construct
	*  @return none
	*/
	private function __construct()
	{
		$this->data = $this->run();
	}
	
	/* 
	*  @function callStatic to call functions as static functions
	*  @return none
	*/
	public static function __callStatic($name, $args)
	{
		if(!self::$Cache)
			self::$Cache = new self();
		if($name == 'set'){
			if(count($args) == 2) self::$Cache->set($args[0], $args[1]);
			if(count($args) == 3) self::$Cache->set($args[0], $args[1], $args[2]);
		}else if($name == 'get'){
			if(count($args) == 0) return self::$Cache->get();
			if(count($args) == 1) return self::$Cache->get($args[0]);
		}else if($name == 'has'){
			if(count($args) == 1) return self::$Cache->has($args[0]);
		}else if($name == 'delete'){
			if(count($args) == 0) self::$Cache->delete();
			if(count($args) == 1) self::$Cache->delete($args[0]);
		}
	}
	
	/* 
	*  @function to set cached data
	*  @return none
	*/
	protected function set($name, $value, $time = true){
		if($time !== true){
			$this->data[$name] = time()+(60*$time);
		}else{
			$this->data[$name] = $time;
		}
		//$this->setSettings($data);
		$this->setContent($name, $value);
	}
	
	
	/* 
	*  @function to get cached data
	*  @return cached value by name, array of some cached data or array of all cached data
	*/
	protected function get($name = null){
		if(is_string($name)){
			if(!$this->fileExist($name))
				return null;
			else
				return $this->getContent($name);
		}else if($name == null){
			$out = array();
			foreach($this->data as $key=>$value){
				if($this->fileExist($key))
					$out[$key] = $this->getContent($key);;
			}
			return $out;
		}else if(is_array($name)){
			$out = array();
			foreach($name as $value){
				if(isset($this->data[$value]))
					$out[$value] = $this->getContent($value);;
			}
			return $out;
		}
		return null;
	}
	
	
	/* 
	*  @function to check in cached data is set
	*  @return true if exists
	*  @return false if not exists
	*/
	protected function has($name){
		if(isset($this->data[$name])){
			if($this->fileExist($name)){
				return true;
			}else{
				unset($this->data[$name]);
				return false;
			}
		}
		if($this->fileExist($name)){
			$this->deleteFile($name);
		}
		return false;
	}
	
	/* 
	*  @function to delete cached data
	*  @return none
	*/
	protected function delete($name = null){
		if(is_string($name))
		{
			$this->deleteFile($name);
			if(isset($this->data[$name])){
				unset($this->data[$name]);
			}
		}else if(is_array($name)){
			foreach($name as $value)
			{
				$this->deleteFile($value);
				if(isset($this->data[$value]))
					unset($this->data[$value]);
			}
		}else if($name === null){
			$this->data = array();
			$this->deleteAll();
		}
	}
	
	/* 
	*  @function to check and return cached data
	*  @return array
	*/
	protected function run(){
		if($this->data == null)
			$this->data = $this->getSettings();
		$out = $this->data;
		foreach($this->data as $key=>$value){
			if($value < time() or $value == false){
				unset($out[$key]);
				$this->deleteFile($key);
			}
		}
		$this->data = $out;
		return $out;
	}
	
	/* 
	*  @function to build settings file if not exists
	*  @return none
	*/
	protected function bulid(){
		chmod(__DIR__, 0770);
		if(!file_exists(__DIR__ . $this->saveFolder))
		{
			mkdir(__DIR__ .$this->saveFolder, 0770);
			$htaccess = '<Files "*">order allow,denydeny from all</Files>';
			file_put_contents(__DIR__ .$this->saveFolder.'.htaccess',$htaccess);
			file_put_contents(__DIR__ .$this->settingFile, json_encode(array()));
		}
	}
	
	/* 
	*  @function to check if the file exists
	*  @return none
	*/
	protected function fileExist($name)
	{
		if(file_exists(__DIR__ .$this->saveFolder.$name.$this->ext))
			return true;
		else
			return false;
	}
	
	/* 
	*  @function to get cached data from file
	*  @return none
	*/
	protected function getContent($name)
	{
		if($this->fileExist($name))
			return json_decode(file_get_contents(__DIR__ .$this->saveFolder.$name.$this->ext));
		else
			return null;
	}
	
	/* 
	*  @function to save cached data in file
	*  @return none
	*/
	protected function setContent($name, $value)
	{
		file_put_contents(__DIR__ .$this->saveFolder.$name.$this->ext,json_encode($value));
	}
	
	/* 
	*  @function to save setting in file
	*  @return none
	*/
	protected function setSettings($data)
	{
		file_put_contents(__DIR__ .$this->settingFile, json_encode($data));
	}
	
	/* 
	*  @function get setting from file if exists or empty array if not exists
	*  @return arrays
	*/
	protected function getSettings()
	{
		if(!file_exists(__DIR__ .$this->settingFile)){
			$this->bulid();
			return array();
		}else{
			return json_decode(file_get_contents(__DIR__ .$this->settingFile), true);
		}
	}
	
	/* 
	*  @function to delete if exists
	*  @return none
	*/
	protected function deleteFile($name)
	{
		if($this->fileExist($name))
			unlink(__DIR__ .$this->saveFolder.$name.$this->ext);
	}	
	
	/* 
	*  @function to delete all files if exists
	*  @return none
	*/
	protected function deleteAll()
	{
		foreach(glob(__DIR__ .$this->saveFolder. '/*') as $file)
		{ 
			if(file_exists($file))
			{
				unlink($file);
			}
		}
	}
	
	/* 
	*  @function destruct
	*  @return none
	*/
	public function __destruct() {
		$this->setSettings($this->data);
	}
}
?>
