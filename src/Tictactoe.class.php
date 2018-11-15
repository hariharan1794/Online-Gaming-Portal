<?php
	class Tictactoe {
		protected $db, $board, $sign = 'X', $cell;
		protected $total_moves = 0;
		
		public function __construct($db = '', $options = '') {
			$this->db = $db;
			$this->board = isset($options['board']) ? $options['board'] : '';
			$this->sign = isset($options['sign']) ? $options['sign'] : '';
			$this->cell = isset($options['cell']) ? $options['cell'] : '';
			$this->total_moves = isset($options['total_moves']) ? $options['total_moves'] : '';
		}

		public function next_play() {
			if($this->sign == 'X') return 'O';
			else return 'X';
		}

		public function move() {
			$sql = "UPDATE `moves` SET `$this->cell` = :sign, `play` = :play WHERE `board` = :board";

			$params = [ 
						'sign' => $this->sign,
						'play' => $this->next_play(),
						'board' => $this->board
					];

			$this->db->execute_query([
							'sql' => $sql,
							'params' => $params,
							'insert' => TRUE
						]);
		}

		public function is_over($m) {
			//top row
			if ($m['cell_00'] == $m['cell_01'] && $m['cell_01'] == $m['cell_02'])
				return $m['cell_00'];

			//middle row
			if ($m['cell_10'] == $m['cell_11'] && $m['cell_11'] == $m['cell_12'])
				return $m['cell_10'];

			//bottom row
			if ($m['cell_20'] == $m['cell_21'] && $m['cell_21'] == $m['cell_22'])
				return $m['cell_20'];

			//first column
			if ($m['cell_00'] == $m['cell_10'] && $m['cell_10'] == $m['cell_20'])
				return $m['cell_00'];

			//second column
			if ($m['cell_01'] == $m['cell_11'] && $m['cell_11'] == $m['cell_21'])
				return $m['cell_01'];

			//third column
			if ($m['cell_02'] == $m['cell_12'] && $m['cell_12'] == $m['cell_22'])
				return $m['cell_02'];

			//diagonal 1
			if ($m['cell_00'] == $m['cell_11'] && $m['cell_11'] == $m['cell_22'])
				return $m['cell_00'];

			//diagonal 2
			if ($m['cell_02'] == $m['cell_11'] && $m['cell_11'] == $m['cell_20'])
				return $m['cell_02'];

			if($this->total_moves >= 9) return 'Tie';

			return 'progress';
		}
	}
?>