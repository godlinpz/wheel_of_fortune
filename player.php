<?php
    require_once('Player.class.php');

    $plr = new Player;

    // var_dump($plr->registeredPlayers());

    $plr->answer ($plr->checkData([
        'name'  => req('player_name')
    ,   'phone' => req('player_phone')
    ,   'prizes' => explode(',', req('prizes'))
    ,   'tries' => req('tries')
    ]));
