<?php
	require_once('Prizes.class.php');
	
	$game = new Prizes;
	$game->announce($game->roll());
	