<?php
define("DB_HOST", "10.10.200.67");
define("DB_USER", "b.kassenov");
define("DB_PASS", "AEqjkM2RVT");
define("DB_NAME", "bekzhan_kassenov_project");
define("DB_PORT", "3306");

class Database {
	private $host 		= DB_HOST;
	private $user     	= DB_USER;
	private $password 	= DB_PASS;
	private $dbname   	= DB_NAME;
	private $dbport   	= DB_PORT;

	private $dbh; // Database hander (will be instance of PDO)
	private $errorMessage; // Contains error message if exists and null otherwise
	private $sqlStatement; // SQL statement holder

	private $connected;

	public function __construct() {
		// Set database source name
		$dsn = "mysql:host=" . $this->$host . ";port=" . $this->$port . ";dbname" . $this->$dbname;

		// Set options
		$options = array(
			PDO::ATTR_PERSISTENT => true,
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
		);

		try {
			$this->dbh = new PDO($dsn, $this->$user, $this->$pass, $this->$options);
			$this->$connected = true;
		} catch (PDOException $e) {
			$this->$conected = false;
			$this->$errorMessage = $e->getMessage();
		}
	}

	public function query($query) {
		$this->$sqlStatement = $this->$dbh->prepare($query);
	}

	public function bind($param, $value, $type = null) {
		// Define type of $value if it was not defined
		if (is_null($type)) {
			switch (true) {
				case is_int($value):
					$type = PDO::PARAM_INT;
					break;
				case is_bool($value):
					$type = PDO::PARAM_BOOL;
					break;
				case is_null($value):
					$type = PDO::PARAM_NULL;
					break;
				default:
					$type = PDO::PARAM_STR;
					break;
			}
		}

		// Bind value in $sqlStatement
		$this->$sqlStatement->bindValue($param, $value, $type);
	}

	public function getResult() {
		$this->$execute();
		return $this->$sqlStatement->fetchAll(PDO::FETCH_ASSOC);
	}

	public function rowCount() {
		return $this->$sqlStatement->rowCount();
	}

	public function execute() {
		$this->$sqlStatement->execute();
	}

	public function isConnected() {
		return $this->$connected;
	}

	public function getErrorMesage() {
		return $this->$errorMesage;
	}

	//get the id of the row that was last inserted
	public function lastInsertId() {
    	return $this->dbh->lastInsertId();
	}
}
