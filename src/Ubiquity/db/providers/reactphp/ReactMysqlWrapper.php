<?php
namespace Ubiquity\db\providers\reactphp;

use Ubiquity\db\providers\AbstractDbWrapper;
use React\MySQL\Factory;
use Workerman\Worker;

/**
 * Ubiquity\db\providers\reactphp$ReactMysqlWrapper
 * This class is part of Ubiquity
 *
 * @author jcheron <myaddressmail@gmail.com>
 * @property \React\MySQL\ConnectionInterface $dbInstance
 * @version 1.0.0
 *
 */
class ReactMysqlWrapper extends AbstractDbWrapper {

	public function __construct() {}

	public function queryColumn($sql, $columnNumber = null) {}

	public function getDSN(string $serverName, string $port, string $dbName, string $dbType = 'mysql') {
		return '@' . $serverName . ':' . $port . '/' . $dbName;
	}

	public function fetchAllColumn($statement, array $values = null, $column = null) {}

	public function ping() {
		return true;
	}

	public function commit() {}

	public function prepareStatement($sql) {}

	public function queryAll($sql, $fetchStyle = null) {
		return $this->dbInstance->query($sql);
	}

	public function releasePoint($level) {}

	public function lastInsertId() {}

	public function nestable() {
		return false;
	}

	public static function getAvailableDrivers() {
		return [
			'mysql'
		];
	}

	public function rollbackPoint($level) {}

	public function getTablesName() {}

	public function getStatement($sql) {}

	public function inTransaction() {}

	public function fetchAll($statement, array $values = null, $mode = null) {}

	public function _optPrepareAndExecute($sql, array $values = null) {
		$sql = \preg_replace('/:[[:alpha:]]+/', '?', $sql);
		return $this->dbInstance->query($sql, $values);
	}

	public function query($sql) {
		return $this->dbInstance->query($sql);
	}

	public function fetchColumn($statement, array $values = null, $columnNumber = null) {}

	public function execute($sql) {}

	public function fetchOne($statement, array $values = null, $mode = null) {}

	public function getFieldsInfos($tableName) {}

	public function bindValueFromStatement($statement, $parameter, $value) {}

	public function rollBack() {}

	public function getForeignKeys($tableName, $pkName, $dbName = null) {}

	public function beginTransaction() {}

	public function statementRowCount($statement) {}

	public function savePoint($level) {}

	public function executeStatement($statement, array $values = null) {}

	public function getPrimaryKeys($tableName) {}

	public function connect(string $dbType, $dbName, $serverName, string $port, string $user, string $password, array $options) {
		$loop = Worker::getEventLoop();
		$factory = new Factory($loop);
		$this->dbInstance = $factory->createLazyConnection($user . ':' . $password . $this->getDSN($serverName, $port, $dbName));
	}
}

