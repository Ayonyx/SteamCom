<?php

class SteamFriends
{
    private $m_szUsername;
    private $m_friendsList; //array of SteamPlayer class.

    function __construct($username)
    {
        $this->m_szUsername = $username;
        $this->Build();
    }

    private function Build()
    {
        $url = sprintf("http://%s/%s/%s//friends/?xml=1", SteamCom::$m_szHost,
                        is_numeric($this->m_szUsername) ? "profiles" : "id",
                        $this->m_szUsername);

        $data = simplexml_load_file($url, 'SimpleXMLElement', LIBXML_NOCDATA);
        foreach($data->friends->children() as $friend)
        {
            $this->m_friendsList[] = (string)$friend;
        }
    }

    /* GetNumFriends()
     * @use: returns number of friends;
     * --------------
     * @returns: int
     */
    public function GetNumFriends()
    {
        return count($this->m_friendsList);
    }

    public function GetFriendsList()
    {
        return $this->m_friendsList;
    }
}

?>
