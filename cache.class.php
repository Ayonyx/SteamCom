<?php
/* 
	caching class for SteamCom to help alleviate rapid queries to the steam
	servers. takes stored player profiles and throws them into a folder as
	xml files that can be requested for 5 minutes before they expire.
*/

class SteamCache {
	
	public function savePlayer($player, $games)
	{
		$filename = $this->getFilename($player->GetId());
		
		$information = $this->SaveData($player, $games);

		$this->WriteFile($filename, $information);
	}

	public function getPlayer($playerid, &$data, $age)
	{
		$filename = $this->getFilename($playerid);
		if(!file_exists($filename) || !is_readable($filename)) return FALSE;

		if(!((time() - filemtime($filename)) > $age)) { //persist for 5 minutes
			$temp = file_get_contents($filename);
			$data = unserialize($temp);
			return TRUE;
		} else {
			return FALSE;
		}
	}

	private function getFilename($playerid) 
	{
		return './cache/'.$playerid;
	}

	private function SaveData($player, $games)
	{
		$data['player'] = $player;
		$data['games']  = $games;

		return serialize($data);
	}

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
