<?php

class DB extends PDO
{


	private $hostname = 'localhost';
	private $port = 5432;
	private $database = 'bd_visitante';
	private $username = 'postgres';
	private $password = 'postgres';
	private $pdo;
	private $sQuery;
	private $bConnected = false;
	private $parameters;




	public function __construct()
	{
		$dsn = 'pgsql:dbname=' . $this->database . ';host=' . $this->hostname . ';port=' . $this->port;
		parent::__construct($dsn, $this->username, $this->password);

		// Establecer la codificación de caracteres UTF-8 para PostgreSQL
		$this->exec("SET NAMES 'UTF8'");
	}

	public function CloseConnection()
	{
		$this->pdo = null;
		$this->bConnected = false;
	}

	private function Init($query, $parameters = [])
	{
		if (!$this->bConnected) {
			return;
		}
		try {
			$this->sQuery = $this->prepare($query);

			$this->bindMore($parameters);
			if (!empty($this->parameters)) {
				foreach ($this->parameters as $param) {
					$parameters = explode("\x7F", $param);
					$this->sQuery->bindParam($parameters[0], $parameters[1]);
				}
			}
			$this->sQuery->execute();
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
		$this->parameters = [];
	}

	public function bind($para, $value)
	{
		$this->parameters[] = ":" . $para . "\x7F" . utf8_encode($value);
	}

	public function bindMore($parray)
	{
		if (!empty($parray) && is_array($parray)) {
			foreach ($parray as $column => $value) {
				$this->bind($column, $value);
			}
		}
	}

	public function column($query, $params = null)
	{
		$this->Init($query, $params);
		$columns = $this->sQuery->fetchAll(PDO::FETCH_COLUMN);
		return $columns;
	}

	public function row($query, $params = null, $fetchmode = PDO::FETCH_ASSOC)
	{
		$this->Init($query, $params);
		return $this->sQuery->fetch($fetchmode);
	}

	public function single($query, $params = null)
	{
		$this->Init($query, $params);
		return $this->sQuery->fetchColumn();
	}
}
