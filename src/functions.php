<?php
	function get_game($board) {
		$db = new Database();

		$sql = 'SELECT `id`, `board`, `player_id`, `player_sign`, `flag` FROM `game` WHERE `board` = :board';

		$params = [
					'board' => $board
				];

		return $db->execute_query([
						'sql' => $sql,
						'params' => $params
					]);
	}

	function get_user($id, $options = '') {
		if(empty($options)) $options = array();

		$db = new Database();

		$sql = 'SELECT `id`, `name`, `email_id` FROM `users` WHERE `id` = :id OR `email_id` = :email';

		$params = [
					'id' => $id,
					'email' => $id
				];

		$user = $db->execute_query([
						'sql' => $sql,
						'params' => $params,
						'unique' => TRUE
					]);

		if(empty($user)) $user = array();

		return array_merge($user, $options);	
	}

	function get_board($id) {
		$db = new Database();

		$sql = 'SELECT `id`, `board`, `cell_00`, `cell_01`, `cell_02`, `cell_10`, `cell_11`, `cell_12`, `cell_20`, `cell_21`, `cell_22`, `play`, `win` FROM `moves` WHERE `id` = :id OR `board` = :board';

		$params = [
					'id' => $id,
					'board' => $id
				];

		return $db->execute_query([
						'sql' => $sql,
						'params' => $params,
						'unique' => TRUE
					]);
	}

?>