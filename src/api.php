<?php
	include('Database.class.php');
	include('Mail.class.php');
	include('Tictactoe.class.php');

	include('functions.php');

	// This function will perform the required action
	function run() {
		$func = $_POST['func'];
		if(!isset($func)) {
			json([
				'msg' => 'Parameter missing!'
			]);
		}

		if(!function_exists($func)) {
			json([
				'msg' => 'Requested action not available.'
			]);
		}

		$func();
	}

	function create_game() {
		$name = $_POST['name'];
		$email = $_POST['email'];
		$sign = $_POST['sign'];
		$board = $_POST['board'];

		if(empty($board))
			$board = uniqid();

		// Creating new db instance
		$db = new Database();

		// Check whether user exists or not
		$player = get_user($email);

		$player_id = isset($player['id']) ? $player['id'] : '';

		// If user not exists, insert into `users` table
		if(empty($player)) {
			$sql = 'INSERT INTO `users`(`name`, `email_id`) VALUES(:name, :email)';

			$params = [
						'name' => $name,
						'email' => $email
					];
			
			$result = $db->execute_query([
								'sql' => $sql,
								'params' => $params,
								'insert' => TRUE
							]);

			$player_id = $result;
		}

		$game = get_game($board);

		if(count($game) >= 2) {
			$sign = '';
			$flag = 0;
		} else {
			if(isset($game[0]['player_sign']) == 'X') $sign = 'O';
			else $sign = 'X';

			$flag = 1;
		}

		// Insert game details to `game` table
		$sql = 'INSERT INTO `game`(`board`, `player_id`, `player_sign`, `flag`) VALUES(:board, :player_id, :player_sign, :flag)';

		$params = [
					'board' => $board, 
					'player_id' => $player_id,
					'player_sign' => $sign,
					'flag' => $flag
				];

		$result = $db->execute_query([
						'sql' => $sql,
						'params' => $params,
						'insert' => TRUE
					]);

		$moves = get_board($board);

		// Insert data to `moves` table
		if(empty($moves)) {			
			$sql = 'INSERT INTO `moves` (`board`, `play`) VALUES (:board, :play)';

			$params = [
						'board' => $board, 
						'play' => 'X'
					];

			$result = $db->execute_query([
							'sql' => $sql,
							'params' => $params,
							'insert' => TRUE
						]);
		}

		if($result) {
			json([
				'msg' => 'Game initiated successfully',
				'board' => $board,
				'sign' => $sign
			]);
		} else {
			json([
				'status' => false,
				'msg' => 'Game not initiated'
			]);
		}
	}

	function tic_tac_toe() {
		$board = $_POST['board'];
		$sign = $_POST['sign'];
		$cell = $_POST['cell'];
		$total_moves = $_POST['moves'];

		$db = new Database();

		$game = new Tictactoe($db, [
								'board' => $board,
								'sign' => $sign,
								'cell' => $cell,
								'total_moves' => $total_moves
							]);

		$game->move();

		$moves = array_slice(get_board($board), 2, -2);
		
		$msg = $game->is_over($moves);

		json([
				'msg' => $msg
			]);
	}

	function get_players() {
		$board = $_POST['board'];

		$data = get_game($board);

		$play = get_board($board);
		$play = $play['play'];

		foreach ($data as $user) {
			$users[] = get_user(
							$user['player_id'], 
							[
								'sign' => $user['player_sign'], 
								'flag' => $user['flag'],
								'play' => $play
							]
						);
		}

		json([
				'users' => array_filter($users)
			]);
	}

	function get_moves() {
		$board = $_POST['board'];

		$moves = get_board($board);

		$game = new Tictactoe();

		$check_moves = array_slice($moves, 2, -2);
		
		$msg = $game->is_over($check_moves);

		json([
				'moves' => $moves,
				'msg' => $msg
			]);
	}

	// Send Mail
	function send_mail() {
		$email = $_POST['email'];
		$link = $_POST['board'];

		$mail 	= new Mail([
						'email' => $email,
						'link' => $link
					]);

		$result = $mail->send_mail();

		if($result) {
			json([
				'msg' => 'Mail sent successfully'
			]);
		}			
	}

	// This function send JSON back to front-end
	function json($array = array('')) {
		$defaults = array(
						'status' => true,
						'msg' => 'success'
					);

		$array = array_filter(array_merge($defaults, $array));

		echo json_encode($array);
		exit;
	}

	run();
?>