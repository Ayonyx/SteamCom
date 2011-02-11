<?php
/*  Friends
 *
 *  The friends object is used to parse information on a player's friends list.
 */
class Friends 
{
    private $m_friendsList;

    function __construct($xmldata)
    {
        $this->ParseFriends($xmldata);
    }

    private function ParseFriends($xmldata)
    {
        foreach($xmldata->friends->children() as $friend)
        {
            $t->ID = (string)$friend;
            $this->m_friendsList[] = $t;
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
