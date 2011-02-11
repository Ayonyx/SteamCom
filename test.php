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
