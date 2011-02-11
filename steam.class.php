<?php

include('player.class.php');
include('games.class.php');
include('game.class.php');
include('friends.class.php');
include('cache.class.php');

class SteamCom
{
    static public $m_szHost = "steamcommunity.com";
    private $m_cache;

    public  $m_player;
    public  $m_games;
    public  $m_friends;

    function __construct($username)
    {
        $this->m_cache = new SteamCache();

        //TODO: fix cache
        //check if we've cached this players information?
        //if(!$this->m_cache->GetPlayer($username, $data, 120))
        {
            //request live information
            $this->m_player = new SteamPlayer($username);

            if($this->m_player->IsPublic())
            {
                $this->m_games  	= new SteamGames($username);
                $this->m_friends 	= new SteamFriends($username);
            }
            else
            {
                $this->m_games          = NULL;
                $this->m_friends	= NULL;
            }

            //$this->m_cache->SavePlayer($this->m_player, $this->m_games, $this->m_friends);
        }
        /*else
        {
            //restore from cache
            $this->m_player     = $data['player'];
            $this->m_games      = $data['games'];
            $this->m_friends    = $data['friends'];
        }*/
    }

}
?>
