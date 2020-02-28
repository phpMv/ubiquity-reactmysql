<?php
namespace Ubiquity\orm\core\prepared;

use Ubiquity\orm\DAO;
use Ubiquity\events\DAOEvents;
use Ubiquity\events\EventsManager;
use Ubiquity\db\SqlUtils;
use React\MySQL\QueryResult;

class DAOPreparedQueryByIdAsync extends DAOPreparedQueryById {

	public function executeThen(callable $onSuccess, $params = [], $useCache = false) {
		$cp = $this->conditionParser;
		$cp->setKeyValues($params);
		$promise = $this->db->prepareAndExecute($this->tableName, SqlUtils::checkWhere($cp->getCondition()), $this->fieldList, $cp->getParams(), $useCache);
		$promise->then(function (QueryResult $command) use ($useCache, $onSuccess) {
			$query = $command->resultRows;
			$oneToManyQueries = [];
			$manyToOneQueries = [];
			$manyToManyParsers = [];
			$className = $this->className;
			$object = DAO::_loadObjectFromRow(\current($query), $className, $this->invertedJoinColumns, $manyToOneQueries, $this->oneToManyFields, $this->manyToManyFields, $oneToManyQueries, $manyToManyParsers, $this->accessors, $this->transformers);
			if ($this->hasIncluded) {
				DAO::_affectsRelationObjects($className, $this->firstPropKey, $manyToOneQueries, $oneToManyQueries, $manyToManyParsers, [
					$object
				], $this->included, $useCache);
			}
			EventsManager::trigger(DAOEvents::GET_ONE, $object, $className);
			$onSuccess($object);
		});
	}
}

