<?php

class SteamGames
{
    private $m_gameList;
    private $m_nGamesTotal;
    private $m_nHoursTotal;

    function __construct($games)
    {
        $this->m_gameList = $games;
        $this->ParseGames();
    }

    private function ParseGames()
    {
        foreach($this->m_gameList as $game)
        {
            $this->m_nGamesTotal++;
            $this->m_nHoursTotal += (float)$game->GetTotalTime();
        }
    }

    public function GetNumGames()
    {
        return $this->m_nGamesTotal;
    }

    public function GetHoursTotal()
    {
        return $this->m_nHoursTotal;
    }

    public function GetGameList()
    {
        return $this->m_gameList;
    }

    public function GetGame($id)
    {
        return $this->m_gameList[$id];
    }
}
	
?>
