<?php
echo "string";
	class Database {
		protected $host = 'localhost';
		protected $port = '';
		protected $name = 'gamecenter';
		protected $user = 'root';
		protected $password = 'Hariican17';

		public function __construct() {
			try {
				$mysql_conn_string = 'mysql:host='.$this->host.';port='.$this->port.';dbname='.$this->name.'';
				$this->db = new PDO($mysql_conn_string, $this->user, $this->password);
				$this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
				$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$this->db->exec('set names utf8');
			} catch(Exception $e) {
				return "Cannot connect to database: {$e->getMessage()}";
				exit;
			}
		}

		public function __destruct() {
			unset($this->dbinfo);
			unset($this->db);
		}

		public function execute_query($params = array()) {
			$defaults = array(
				'unique' => FALSE,
				'params' => [],
				'insert' => FALSE,
				'returnKey' => TRUE
			);

			$params = array_merge($defaults, $params);

			$prepared_query = $this->db->prepare($params['sql']);

			$query_response = $prepared_query->execute($params['params']);

			if($params['insert'] == TRUE) {
				if($params['returnKey'] == TRUE) {
					return $this->db->lastInsertId();
				}
				return $query_response;
			}

			if($params['unique'] == TRUE) {
				return $prepared_query->fetch(PDO::FETCH_ASSOC);
			} else {
				return $prepared_query->fetchAll(PDO::FETCH_ASSOC);
			}
		}
	}
?>
