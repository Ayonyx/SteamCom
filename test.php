<?php
    require('steam.class.php');

    if(isset($_REQUEST['player']) && !empty($_REQUEST['player']))
    {
        $profile = new SteamCom($_REQUEST['player']);

        echo "Name: ".$profile->m_player->GetName();
        echo "<br/>";
        echo "64ID: ".$profile->m_player->GetId();
        echo "<br/>";
        echo "<img src='".$profile->m_player->GetAvatar(AvatarSize::LARGE)."'/>";
        echo "<br/>";

        if($profile->m_player->IsPublic())
        {
            echo "Status: ".$profile->m_player->GetStateMsg();
            echo "<br/>";
            echo "Location: ".$profile->m_player->GetLocation();
            echo "<br/>";
            echo "Headline: ".$profile->m_player->GetHeadline();
            echo "<br/>";
            echo "Summary: ".$profile->m_player->GetSummary();
            echo "<br/>";
            echo "Real Name: ".$profile->m_player->GetRealname();
            echo "<br/>";
            echo "Joined: ".$profile->m_player->GetJoinDate();
            echo "<br/>";
            echo "Hours: ".$profile->m_games->GetHoursTotal();
            echo "<br/>";
            echo "Games: ".$profile->m_games->GetNumGames();
            echo "<br/>";

            $topgame = $profile->m_games->GetGame(0);
            echo "Top Played: <a href='".$topgame->GetLink()."'>".$topgame->GetName()."</a> - ".$topgame->GetTotalTime()." hrs";
            echo "<br/>";

            echo "Friends: ".$profile->m_friends->GetNumFriends();
            echo "<br/><hr/>";
            //friend hax
            $friends = $profile->m_friends->GetFriendsList();
            $friend0 = new SteamPlayer($friends[0]->ID);
            $friend1 = new SteamPlayer($friends[1]->ID);
            $friend2 = new SteamPlayer($friends[2]->ID);
            echo "Friend Name: ".$friend0->GetName();
            echo "<br/>";
            echo "Friend Name: ".$friend1->GetName();
            echo "<br/>";
            echo "Friend Name: ".$friend2->GetName();
            echo "<br/><hr/>";

            for($i = 0; $i < $profile->m_games->GetNumGames(); ++$i)
            {
                $game = $profile->m_games->GetGame($i);
                echo "<a href='".$game->GetLink()."'><img src='".$game->GetLogo()."'/></a>";
                echo "Game: ".$game->GetName();
                echo "<hr/>";
            }
        }
        else
        {
            echo "Private Profile";
        }
    }
    else
    {
        echo "Player ID / Profile Name needed<br/> try <a href='http://ayonyx.net/SteamCom/test.php?player=_zula'>here</a>.";
    }
?>
<br/>
<br/>
<br/>
<a href="https://github.com/Ayonyx/SteamCom">[SteamCom]munity PHP Class</a>
