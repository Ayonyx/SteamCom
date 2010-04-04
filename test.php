<?php
	require('steam.class.php');

	if(isset($_REQUEST['player']) && !empty($_REQUEST['player'])) {
		$profile = new SteamCom($_REQUEST['player']);

		echo "Name: ".$profile->player->GetName();
		echo "<br/>";
		echo "64ID: ".$profile->player->GetId();
		echo "<br/>";
		echo "<img src='".$profile->player->GetAvatar('large')."'/>";
		echo "<br/>";
		if($profile->player->isPublic()) {
			echo "Status: ".$profile->player->GetStateMsg();
			echo "<br/>";
			echo "Joined: ".$profile->player->GetJoinDate();
			echo "<br/>";
			echo "Hours: ".$profile->games->GetHoursTotal();
			echo "<br/>";
			echo "Games: ".$profile->games->GetNumGames();
			echo "<br/>";
	
			$topgame = $profile->games->GetGame(0);
			echo "Top Played: <a href='".$topgame->GetLink()."'>".$topgame->GetName()."</a> - ".$topgame->GetTotalTime()." hrs";
			echo "<br/>";
	
			echo "Friends: ".$profile->friends->numFriends();
		} else {
			echo "Private Profile";
		}
	} else {
		echo "Player ID / Profile Name needed";
	}
?>
