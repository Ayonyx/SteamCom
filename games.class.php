<?php

function sort_games($one, $two)
{
    return($one->GetTotalTime() < $two->GetTotalTime());
}

class SteamGames
{
    private $m_szUsername;
    private $m_gameList;
    private $m_nGamesTotal;
    private $m_nHoursTotal;

    function __construct($username)
    {
        $this->m_szUsername = $username;
        $this->Build();
    }

    private function Build()
    {
        $url = sprintf("http://%s/%s/%s/games/?xml=1", SteamCom::$m_szHost,
                        is_numeric($this->m_szUsername) ? "profiles" : "id",
                        $this->m_szUsername);

        $data = simplexml_load_file($url, 'SimpleXMLElement', LIBXML_NOCDATA);

        foreach($data->games->children() as $game)
        {
            $t = new Game((string)$game->name,
                          (int)$game->appID,
                          (string)$game->logo,
                          (string)$game->storeLink,
                          (float)$game->hoursLast2Weeks,
                          (float)$game->hoursOnRecord);
            $this->m_nGamesTotal++;
            $this->m_nHoursTotal += (float)$game->hoursOnRecord;
            $this->m_gameList[] = $t;
        }

        usort($this->m_gameList, "sort_games");
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
