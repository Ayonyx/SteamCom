<?php

class Friends {

	function __construct($xmldata) 
	{
		$this->friendslist = $this->parseFriends($xmldata);	
	}


	private function parseFriends($xmldata)
	{
		foreach($xmldata->friends->children() as $friend) {
			$t->ID = (string)$friend;
			
			$this->friendCount++;
			$this->friendslist[] = $t; 
		}
	}

	public function numFriends()
	{
		return $this->friendCount;
	}

	public function getFriendsList()
	{
		return $this->friendslist;
	}
}

?>
