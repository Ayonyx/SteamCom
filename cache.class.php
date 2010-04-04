<?php

class SteamCache {
	/* function savePlayer:
		expects:
			* player - player object
			* games  - games object
		returns:
			* void
		purpose:
			* saves a serialized file with needed information
	*/	
	public function savePlayer($player, $games)
	{
		$filename = $this->getFilename($player->GetId());
		
		$information = $this->SaveData($player, $games);

		$this->WriteFile($filename, $information);
	}

	/* function getPlayer
		expects:
			* playerid - steam id
			* data - variable to store unserialized data
			* age - how long should files be read from before overwrite
		returns:
			* boolean
		purpose:
			* retrieve and unserialize cached information
	*/
	public function getPlayer($playerid, &$data, $age)
	{
		$filename = $this->getFilename($playerid);
		if(!file_exists($filename) || !is_readable($filename)) return FALSE;

		if(!((time() - filemtime($filename)) > $age)) {
			$temp = file_get_contents($filename);
			$data = unserialize($temp);
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	/* function getFilename
		expects:
			* playerid - steam id
		returns:
			* filepath
		purpose: 
			* get file path for playerid
	*/
	private function getFilename($playerid) 
	{
		return './cache/'.$playerid;
	}
	
	/* function SaveData
		expects:
			* player - player object
			* games  - game object
		returns:
			* serialized array
		purpose:
			* put objects into an array for storage
	*/
	private function SaveData($player, $games)
	{
		$data['player'] = $player;
		$data['games']  = $games;

		return serialize($data);
	}

	/* function WriteFile
		expects:
			* filename - path to the file
			* information - serialized information to write to the file
		returns:
			* void
		purpose:
			* create cache file
	*/
	private function WriteFile($filename, $information)
	{
		ob_start();
		
		$file = fopen($filename, 'w');
		fwrite($file, $information);

		fclose($file);
		ob_end_flush();
	}
}

?>
