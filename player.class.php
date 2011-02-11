<?php

class AvatarSize
{
    const SMALL     = 0;
    const MEDIUM    = 1;
    const LARGE     = 2;
};

class OnlineStates
{
    const ONLINE    = 0;
    const OFFLINE   = 1;
    const AWAY      = 2;
};

class PublicStates
{
    const P_PUBLIC = "public";
    const P_PRIVATE = "private";
};

class SteamPlayer
{
    private $m_szUsername;
    private $m_szName;
    private $m_nId;
    private $m_szState;
    private $m_szStateMsg;
    private $m_aAvatars = array();
    private $m_szMemberDate;
    private $m_nRating;
    private $m_nHours2wk;
    private $m_bPublic;
    private $m_szHeadline;
    private $m_szLocation;
    private $m_szSumamry;
    private $m_szRealname;

    function __construct($username)
    {
        $this->m_szUsername = $username;
        $this->Build();
    }

    private function Build()
    {
        $url = sprintf("http://%s/%s/%s/?xml=1", SteamCom::$m_szHost,
                        is_numeric($this->m_szUsername) ? "profiles" : "id",
                        $this->m_szUsername);

        $data = simplexml_load_file($url, 'SimpleXMLElement', LIBXML_NOCDATA);

        $this->m_szName         = (string)$data->steamID;
        $this->m_nId            = (string)$data->steamID64;
        $this->m_szState        = (string)$data->onlineState;
        $this->m_szStateMsg     = (string)$data->stateMessage;
        $this->SetAvatar($data->avatarIcon);
        $this->m_szMemberDate   = (string)$data->memberSince;
        $this->m_nRating        = (float)$data->steamRating;
        $this->m_nHours2wk      = (float)$data->hoursPlayed2Wk;
        $this->m_bPublic        = ($data->privacyState == PublicStates::P_PUBLIC);
        $this->m_szHeadline     = (string)$data->headline;
        $this->m_szLocation     = (string)$data->location;
        $this->m_szSumamry      = (string)$data->summary;
        $this->m_szRealname     = (string)$data->realname;
    }
	
    private function SetAvatar($url)
    {
        $length = strlen($url);
        $base = substr($url, 0, $length-4);
        $this->m_aAvatars[AvatarSize::SMALL]    = $url;
        $this->m_aAvatars[AvatarSize::MEDIUM]   = $base.'_medium.jpg';
        $this->m_aAvatars[AvatarSize::LARGE]    = $base.'_full.jpg';
    }
	
    public function GetAvatar($size)
    {
        return $this->m_aAvatars[$size];
    }
	
    //returns string
    public function GetName()
    {
        return $this->m_szName;
    }
	
    //returns string (int64)
    public function GetId()
    {
        return $this->m_nId;
    }

    //returns string
    public function GetState()
    {
        return $this->m_szState;
    }

    //returns string
    public function GetStateMsg()
    {
        return $this->m_szStateMsg;
    }

    //returns timestamp
    public function GetJoinDate()
    {
        return $this->m_szMemberDate;
    }
	
    //returns float
    public function GetHours2Wk()
    {
        return $this->m_nHours2wk;
    }

    //returns boolean
    public function IsPublic()
    {
        return $this->m_bPublic;
    }

    //returns float
    public function GetRating()
    {
        return $this->m_nRating;
    }

    //returns string
    public function GetHeadline()
    {
        return $this->m_szHeadline;
    }

    //returns string
    public function GetLocation()
    {
        return $this->m_szLocation;
    }

    //returns string
    public function GetSummary()
    {
        return $this->m_szSumamry;
    }

    //returns string
    public function GetRealname()
    {
        return $this->m_szRealname;
    }
}

?>
