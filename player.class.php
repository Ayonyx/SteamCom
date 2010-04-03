<?php

class Player {
    private $name, $id;
    private $state, $statemsg;
    private $avatars = array();
    private $memberdate;
    private $rating, $hours2wk;
	private $public;

	/* Constructor Paramaters:
		data :
			* steamID 			- the player's name
			* steamID64 		- the player's 64bit numerical identifiers
			* onlineState		- the players online or offline status
			* stateMessage		- the status message for the player's profile
			* privacyState		- is the profile public or private
			* avatarIcon		- a url to the players avatar
			* memberSince		- the date the player joined steam
			* steamRating		- the players rating on steam
			* hoursPlayed2Wk	- the number of hours the player played in the last two weeks
	*/
	function __construct($data) //array
    {
        if(is_array($data)) {
            $this->name         = $data['steamID'];
            $this->id           = $data['steamID64'];
            $this->state        = $data['onlineState'];
            $this->statemsg     = $data['stateMessage'];
			$this->public		= $data['privacyState'];

            $this->SetAvatar($data['avatarIcon']);

            $this->memberdate   = $data['memberSince'];
            $this->rating       = $data['steamRating'];
            $this->hours2wk     = $data['hoursPlayed2Wk'];
    	}
	}
	
	/* Function: SetAvatar
		expects:
			* url - url to the players avatar.

		returns:
			* void

		purpose:
			* SetAvatar takes the simple avatar url from the
			  constructor and adds the other two sizes of the
			  image to the player object avatars array.
	*/
    private function SetAvatar($url)
    {
        $length = strlen($url);
        $base = substr($url, 0, $length-4);
        $this->avatars['small'] = $url;
        $this->avatars['medium'] = $base.'_medium.jpg';
        $this->avatars['large'] = $base.'_full.jpg';
    }
	
	/* Function: GetAvatar
		expects:
			* size - small, medium, large

		returns:
			* url - web address

		purpose:
			* GetAvatar returns the web address of what ever
			  size avatar the user calls the function with.
	*/
    public function GetAvatar($size)
    {
        switch($size) {
            case 'large':
                return($this->avatars['large']);
                break;
            case 'medium':
                return($this->avatars['medium']);
                break;
            case 'small':
            default:
                return($this->avatars['small']);
        }
    }
	
	//returns player name
    public function GetName()
    {
        return($this->name);
    }
	
	//returns player id
    public function GetId()
    {
        return($this->id);
    }

	//returns online / offline
    public function GetState()
	{ 
		return($this->state);
    }

	//returns message related to state
    public function GetStateMsg()
    {
        return($this->statemsg);
    }

	//returns the date the player joined steam
    public function GetJoinDate()
    {
        return($this->memberdate);
    }
	
	//returns the 2k play time for player
    public function GetHours2Wk()
    {
        return($this->hours2wk);
    }

	//returns boolean for if the profile is public
	public function isPublic()
	{
		if($this->public == "friendsonly") {
			return FALSE;
		} else {
			return TRUE;
		}
	}

}

?>
