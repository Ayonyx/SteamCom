<?php

include('player.class.php');
include('games.class.php');
include('game.class.php');
include('friends.class.php');
include('cache.class.php');

function sort_games($one, $two)
{
    return($one->GetTotalTime() < $two->GetTotalTime());
}

class SteamCom
{
    private $m_szHost = "steamcommunity.com";
    private $m_aData = array();
    private $m_bId;
    private $m_szUsername;
    private $profilexml, $gamesxml, $friendsxml;
    private $m_gamesList = array();
    private $m_cache;

    public  $m_player;
    public  $m_games;
    public  $m_friends;

    function __construct($username)
    {
        $this->m_bId = is_numeric($username);

        $this->m_cache = new SteamCache;

        $this->m_szUsername = $username;

        if(!$this->m_cache->GetPlayer($this->m_szUsername, $data, 2 * 60))
        {
            $this->m_player = $this->GetProfileData();

            if($this->m_player->IsPublic())
            {
                $this->GetGamesData();
                $this->GetFriendsData();
                $this->m_games  	= new SteamGames($this->m_gamesList);
                $this->m_friends 	= new Friends($this->friendsxml);
            }
            else
            {
                $this->m_games          = NULL;
                $this->m_friends	= NULL;
            }

            $this->m_cache->SavePlayer($this->m_player, $this->m_games, $this->m_friends);
        }
        else
        {
            $this->m_player     = $data['player'];
            $this->m_games      = $data['games'];
            $this->m_friends    = $data['friends'];
        }
    }

    public function GetProfileData()
    {
        $url = sprintf("http://%s/%s/%s/?xml=1", $this->m_szHost,
                       $this->m_bId ? "profiles" : "id", $this->m_szUsername);

        $this->profilexml = simplexml_load_file($url, 'SimpleXMLElement', LIBXML_NOCDATA);

        $this->ParseProfileData();
        return new Player($this->m_aData);
    }

    public function GetGamesData()
    {
        $url = sprintf("http://%s/%s/%s/games/?xml=1", $this->m_szHost,
                        $this->m_bId ? "profiles" : "id", $this->m_szUsername);

        $this->gamesxml = simplexml_load_file($url, 'SimpleXMLElement', LIBXML_NOCDATA);

        $this->ParseGamesData();
    }

    public function GetFriendsData()
    {
        $url = sprintf("http://%s/%s/%s//friends/?xml=1", $this->m_szHost,
                        $this->m_bId ? "profiles" : "id", $this->m_szUsername);

        $this->friendsxml = simplexml_load_file($url, 'SimpleXMLElement', LIBXML_NOCDATA);
    }

    private function ParseProfileData()
    {
        $this->m_aData['steamID']           = (string)$this->profilexml->steamID;
        $this->m_aData['steamID64']         = (string)$this->profilexml->steamID64;
        $this->m_aData['onlineState']       = (string)$this->profilexml->onlineState;
        $this->m_aData['stateMessage']      = (string)$this->profilexml->stateMessage;
        $this->m_aData['avatarIcon']        = (string)$this->profilexml->avatarIcon;
        $this->m_aData['memberSince']       = (string)$this->profilexml->memberSince;
        $this->m_aData['steamRating']       = (float)$this->profilexml->steamRating;
        $this->m_aData['hoursPlayed2Wk']    = (float)$this->profilexml->hoursPlayed2Wk;
        $this->m_aData['privacyState']      = (string)$this->profilexml->privacyState;
        $this->m_aData['headline']          = (string)$this->profilexml->headline;
        $this->m_aData['location']          = (string)$this->profilexml->location;
        $this->m_aData['summary']           = (string)$this->profilexml->summary;
        $this->m_aData['realname']          = (string)$this->profilexml->realname;
    }

    private function ParseGamesData()
    {
        if((string)$this->profilexml->privacyState == PublicStates::P_PUBLIC)
        {
            foreach($this->gamesxml->games->children() as $game)
            {
                $t = new Game((string)$game->name,
                              (int)$game->appID,
                              (string)$game->logo,
                              (string)$game->storeLink,
                              (float)$game->hoursLast2Weeks,
                              (float)$game->hoursOnRecord);
                $this->m_gamesList[] = $t;
            }

            usort($this->m_gamesList, "sort_games");
        }
    }
}
?>
