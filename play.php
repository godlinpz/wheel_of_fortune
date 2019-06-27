<?
    require_once('Prizes.class.php');
    require_once('Player.class.php');

	start_session();

    $player = new Player;
	$prizes = new Prizes;

	$cmd = req('cmd');
	$msg = ["error" => "Ерунда какая-то происходит..."];

	$user = sess('user');
	if(!$user) $user = [];

	foreach(['free_run_used', 'ticket_taken', 'share_taken', 'ticket_used', 'share_used'] as $c)
		if( intval(cookie($c)) ) $user[$c] = 1;

	foreach(['user_name', 'user_phone'] as $c)
		if( cookie($c) && !$user[$c] ) $user[$c] =  clear_string(cookie($c));

	if ($cmd === 'run')
	{
		$run_type = req('run_type');
		$error = '';

		$run_types = [ 'free_run' => 'free_run_used', 'ticket' => 'ticket_used', 'share' => 'share_used'];

		if( isset($run_types[$run_type]) )
		{
			$rtu = $run_types[$run_type];

			if( $user[$rtu] )
				$msg = ["error" => "Эта попытка уже использована"];
			else
			{
				set_cookie($rtu, $user[$rtu] = 1);

				$prize = $prizes->roll();
				$user['prizes'][] = [$run_type, $prize];

				$cnt =  count($user['prizes']);

				$user['last_prize'] = $user['prizes'][ ($cnt < 3) ? ($cnt-1) : 2 ][1];

				set_cookie('last_prize',  "".$user['last_prize']);

				$msg = ["prize" => $prize];
			}
		}
		else
		{
     		$msg = ["error" => "Хакер что ли?"];
		}

	}
	elseif($cmd === 'register')
	{
		if( !req('user_name') || !req('user_phone') )
			$msg = ["error" => "Укажите Ваши имя и телефон!"];
		else
		{
			$user['user_name']  = clear_string(req('user_name'));
			$user['user_phone'] = clear_phone (req('user_phone'));

			set_cookie('user_name',  $user['user_name']);
			set_cookie('user_phone', $user['user_phone']);

			$msg = ["msg" => "OK"];
		}
	}
	elseif($cmd === 'get_ticket')
	{
		if( $user['ticket_taken'] )
			$msg = ["warn" => "Вы уже использовали эту возможность!"];
		else
		{
			$user['ticket_taken'] = 1;
			set_cookie('ticket_taken', 1);
			$msg = ["msg" => 1];
		}
	}
	elseif($cmd === 'get_share')
	{
		if( $user['share_taken'] )
			$msg = ["warn" => "Вы уже использовали эту возможность!"];
		else
		{
			$user['share_taken'] = 1;
			set_cookie('share_taken', 1);
			$msg = ["msg" => 1];
		}
		
	}

	sess('user', $user);

	$msg['debug'] = print_r($_SESSION, true);

	echo json_encode($msg);
	