<?php
namespace Ubiquity\orm;

use Ubiquity\orm\core\prepared\DAOPreparedQueryByIdAsync;
use Ubiquity\orm\core\prepared\DAOPreparedQueryOne;
use Ubiquity\orm\core\prepared\DAOPreparedQueryAll;

class DAOAsync extends DAO {

	public static function prepareGetById($name, $className, $included = false) {
		return self::$preparedDAOQueries[$name] = new DAOPreparedQueryByIdAsync($className, $included);
	}

	public static function prepareGetOne($name, $className, $condition = '', $included = false) {
		return self::$preparedDAOQueries[$name] = new DAOPreparedQueryOne($className, $condition, $included);
	}

	public static function prepareGetAll($name, $className, $condition = '', $included = false) {
		return self::$preparedDAOQueries[$name] = new DAOPreparedQueryAll($className, $condition, $included);
	}

	public static function executePreparedThen($name, $onSuccess, $params = [], $useCache = false) {
		if (isset(self::$preparedDAOQueries[$name])) {
			self::$preparedDAOQueries[$name]->executeThen($onSuccess, $params, $useCache);
		}
	}
}

