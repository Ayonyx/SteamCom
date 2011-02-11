<?php

class Game
{
    private $m_szName;  //string
    private $m_nAppId;  //int
    private $m_szLogo;  //string
    private $m_szUrl;   //string
    private $m_nFourteen;  //two week
    private $m_nLifetime; //lifetime

    function __construct($name, $appID, $logo, $link, $twowk, $total)
    {
        $this->m_szName = $name;
        $this->m_nAppId = $appID;
        $this->m_szLogo = $logo;
        $this->m_szUrl  = $link;
        $this->m_nFourteen = $twowk;
        $this->m_nLifetime = $total;
    }

    public function GetName()
    {
        return $this->m_szName;
    }

    public function GetAppID()
    {
        return $this->m_nAppId;
    }

    public function GetLogo()
    {
        return $this->m_szLogo;
    }

    public function GetLink()
    {
        return $this->m_szUrl;
    }

    public function Get2WeekTime()
    {
        return $this->m_nFourteen;
    }

    public function GetTotalTime()
    {
        return $this->m_nLifetime;
    }
}

?>
