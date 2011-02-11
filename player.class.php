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

class Player
{
    private $m_szName;
    private $m_nId;
    private $m_szState;
    private $m_szStateMsg;
    private $m_aAvatars = array();
    private $m_szMemberdate;
    private $m_nRating;
    private $m_nHours2wk;
    private $m_bPublic;
    private $m_szHeadline;
    private $m_szLocation;
    private $m_szSumamry;
    private $m_szRealname;

    function __construct($data)
    {
        if(is_array($data))
        {
            $this->m_szName         = $data['steamID'];
            $this->m_nId            = $data['steamID64'];
            $this->m_szState        = $data['onlineState'];
            $this->m_szStateMsg     = $data['stateMessage'];
            $this->m_bPublic        = ($data['privacyState'] != PublicStates::P_PRIVATE);
            $this->SetAvatar($data['avatarIcon']);
            $this->m_szMemberdate   = $data['memberSince'];
            $this->m_nRating        = $data['steamRating'];
            $this->m_nHours2wk      = $data['hoursPlayed2Wk'];
            $this->m_szHeadline     = $data['headline'];
            $this->m_szLocation     = $data['location'];
            $this->m_szSumamry      = $data['summary'];
            $this->m_szRealname     = $data['realname'];
        }
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
        return $this->m_szMemberdate;
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
