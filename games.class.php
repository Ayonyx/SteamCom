<?php

class SteamGames {
	
	function __construct($games)
	{
		$this->gameList = $games;
		$this->ParseGames();
	}	

	private function ParseGames()
	{
		foreach($this->gameList as $game) {
			$this->numGames++;
			$this->numHours += $game->GetTotalTime();
		}
	}

	public function GetNumGames()
	{
		return $this->numGames;
	}

	public function GetHoursTotal()
	{
		return $this->numHours;
	}

	public function GetGameList()
	{
		return $this->gameList;
	}

	public function GetGame($id)
	{
		return $this->gameList[$id];
	}
}
	
?>
