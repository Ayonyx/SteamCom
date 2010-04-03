<?php

class Game {
			
	function __construct($name, $appID, $logo, $link, $twowk, $total) 
	{	
		$this->name 	= $name;
		$this->appID 	= $appID;
		$this->logo 	= $logo;
		$this->link		= $link;
		$this->twowk	= $twowk;
		$this->total 	= $total;
	}

	public function GetName()
	{
		return $this->name;
	}

	public function GetAppID()
	{
		return $this->appID;
	}

	public function GetLogo()
	{
		return $this->logo;
	}

	public function GetLink()
	{
		return $this->link;
	}

	public function Get2WeekTime()
	{
		return $this->twowk;
	}

	public function GetTotalTime()
	{
		return $this->total;
	}
}

?>
