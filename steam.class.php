<?php

include('player.class.php');
include('games.class.php');
include('game.class.php');

function sort_games($one, $two) {
	return($one->GetTotalTime() < $two->GetTotalTime());
}

class SteamCom {
	private $host = "steamcommunity.com";
	private $data = array();
	private $idnum;
	private $username;
	private $profilexml, $gamesxml, $friendsxml;
	private $gamesList = array();
	
	public  $player;
	public  $games;

	function __construct($username)
	{
		if(is_numeric($username)) {
			$this->idnum = true;
		} else {
			$this->idnum = false;
		}
		
		$this->username = $username;
		$this->GetProfileData();
		$this->GetGamesData();
		$this->player = new Player($this->data);
		$this->games  = new SteamGames($this->gameList);
	}

	public function GetProfileData()
	{
		$url  = 'http://';
		$url .= $this->host;
		if($this->idnum) {
			$url .= '/profiles/';
		} else {
			$url .= '/id/';
		}
		$url .= $this->username;
		$url .= '/?xml=1';
			
		$this->profilexml = simplexml_load_file($url, 'SimpleXMLElement', LIBXML_NOCDATA);		
			
		$this->ParseProfileData();
	}

	public function GetGamesData()
	{
		$url  = 'http://';
		$url .= $this->host;
		if($this->idnum) {
			$url .= '/profiles/';
		} else {
			$url .= '/id/';
		}
		$url .= $this->username;
		$url .= '/games/?xml=1';

		$this->gamesxml = simplexml_load_file($url, 'SimpleXMLElement', LIBXML_NOCDATA);
	
		$this->ParseGamesData();
	}
	
	public function GetFriendsData()
	{
		$this->friendsxml = simplexml_load_file('http://'.$this->host.'/id/'.$this->username.'/friends/?xml=1');
	}
	
	private function ParseProfileData()
	{
		$this->data['steamID'] 			= (string)$this->profilexml->steamID;
		$this->data['steamID64'] 		= $this->profilexml->steamID64[0];
		$this->data['onlineState'] 		= (string)$this->profilexml->onlineState;
		$this->data['stateMessage'] 	= (string)$this->profilexml->stateMessage;
		$this->data['avatarIcon']		= (string)$this->profilexml->avatarIcon;
		$this->data['memberSince']		= (string)$this->profilexml->memberSince;
		$this->data['steamRating'] 		= (float)$this->profilexml->steamRating;
		$this->data['hoursPlayed2Wk']	= (float)$this->profilexml->hoursPlayed2Wk;
		$this->data['privacyState'] 	= (string)$this->profilexml->privacyState;
	}

	private function ParseGamesData()
	{
		if((string)$this->profilexml->privacyState == "public") {
			foreach($this->gamesxml->games->children() as $game) {
				$t = new Game((string)$game->name, (int)$game->appID, (string)$game->logo, (string)$game->storeLink, (float)$game->hoursLast2Weeks, (float)$game->hoursOnRecord);
				$this->gameList[] = $t;
			}

			usort($this->gameList, "sort_games");
		}
	}
}
?>
