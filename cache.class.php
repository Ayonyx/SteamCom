<?php

class SteamCache
{
	/* function SavePlayer($player, $games, $friends)
         * @use: save serilized information to cache file
         * --------------
         * @parameter: $player - player information
         * @parameter: $games - player's game information
         * @parameter: $friends - player's friends
         * --------------
         * @returns: void
         */
	public function SavePlayer($player, $games, $friends)
	{
            $filename = $this->GetFilename($player->GetId());

            $information = $this->SaveData($player, $games, $friends);

            $this->WriteFile($filename, $information);
	}

	/* function GetPlayer($playerid, &$data, $age)
         * @use: retrieve and unserialize cached information younger than $age.
         * --------------
         * @parameter: playerid - steam id
         * @parameter: data - by reference to store player data.
         * @age:       age before we overwrite.
         * --------------
         * @returns: bool
         */
	public function GetPlayer($playerid, &$data, $age)
	{
            $filename = $this->GetFilename($playerid);
            if(!file_exists($filename) || !is_readable($filename)) return FALSE;

            if(!((time() - filemtime($filename)) > $age))
            {
                $temp = file_get_contents($filename);
                $data = unserialize($temp);
                return TRUE;
            }
            else
            {
                return FALSE;
            }
	}
	
	/* function getFilename($playerid)
         * @use: get file path for player cache
         * --------------
         * @parameter: playerid - steam id.
         * --------------
         * @returns: string
	*/
	private function GetFilename($playerid)
	{
            return './cache/'.$playerid;
	}
	
	/* function SaveData($player, $games, $friends)
         * @use: creates an array and serializes information for storage.
         * --------------
         * @parameter: player - player object
         * @parameter: games - game object
         * @parameter: friends - friend object
         * --------------
         * @returns: serialized array
         */
	private function SaveData($player, $games, $friends)
	{
            $data['player'] = $player;
            $data['games']  = $games;
            $data['friends'] = $friends;

            return serialize($data);
	}

	/* function WriteFile($filename, $information)
         * @use: write serialized $information to $filename
         * --------------
         * @parameter: filename
         * @parameter: information - serialized array
         * --------------
         * @returns: void
	*/
	private function WriteFile($filename, $information)
	{
            ob_start();

            $file = fopen($filename, 'w');
            fwrite($file, $information);

            fclose($file);
            ob_end_flush();
	}
}

?>
