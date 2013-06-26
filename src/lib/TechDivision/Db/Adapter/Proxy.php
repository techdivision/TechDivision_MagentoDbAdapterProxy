<?php
/**
 * TechDivision_Db_Adapter_Service_Dummy
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

/**
 * Implements db proxy adapter proxy_mysql
 *
 * @category   TechDivision
 * @package    TechDivision_MagentoDbAdapterProxy
 * @subpackage lib
 * @copyright  Copyright (c) 1996-2012 TechDivision GmbH (http://www.techdivision.com)
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @version    ${release.version}
 * @since      Class available since Release 0.1.0
 * @author     Johann Zelger <j.zelger@techdivision.com>
 */

class TechDivision_Db_Adapter_Proxy
    extends Zend_Db_Adapter_Abstract
    implements Varien_Db_Adapter_Interface
{

    protected $service;

    public function __construct($config) {

        // check config for Adapter_Proxy_Service definition
        if (!isset($config['service_class'])) {
            throw new Exception('No proxy service_class given in config');
        }
        $this->service = new $config['service_class']($config);
    }

    protected function _getService()
    {
        return $this->service;
    }

    /**
     * Last resort caller so function not interface defined can be called
     *
     * @param $method
     * @param $args
     * @return mixed
     */
    public function __call($method, $args)
    {
        return call_user_func_array(array($this->_getService(), $method), $args);
    }

    /**
     * Begin new DB transaction for connection
     *
     * @return Varien_Db_Adapter_Pdo_Mysql
     */
    public function beginTransaction()
    {
        return $this->_getService()->beginTransaction();
    }

    /**
     * Commit DB transaction
     *
     * @return Varien_Db_Adapter_Pdo_Mysql
     */
    public function commit()
    {
        return $this->_getService()->commit();
    }

    /**
     * Roll-back DB transaction
     *
     * @return Varien_Db_Adapter_Pdo_Mysql
     */
    public function rollBack()
    {
        return $this->_getService()->rollBack();
    }

    /**
     * Retrieve DDL object for new table
     *
     * @param string $tableName the table name
     * @param string $schemaName the database or schema name
     * @return Varien_Db_Ddl_Table
     */
    public function newTable($tableName = null, $schemaName = null)
    {
        return $this->_getService()->newTable($tableName, $schemaName);
    }

    /**
     * Create table from DDL object
     *
     * @param Varien_Db_Ddl_Table $table
     * @throws Zend_Db_Exception
     * @return Zend_Db_Statement_Interface
     */
    public function createTable(Varien_Db_Ddl_Table $table)
    {
        return $this->_getService()->createTable($table);
    }

    /**
     * Create temporary table from DDL object
     *
     * @param Varien_Db_Ddl_Table $table
     * @throws Zend_Db_Exception
     * @return Zend_Db_Statement_Interface
     */
    public function createTemporaryTable(Varien_Db_Ddl_Table $table)
    {
        return $this->_getService()->createTemporaryTable($table);
    }

    /**
     * Drop table from database
     *
     * @param string $tableName
     * @param string $schemaName
     * @return boolean
     */
    public function dropTable($tableName, $schemaName = null)
    {
        return $this->_getService()->dropTable($tableName, $schemaName);
    }

    /**
     * Drop temporary table from database
     *
     * @param string $tableName
     * @param string $schemaName
     * @return boolean
     */
    public function dropTemporaryTable($tableName, $schemaName = null)
    {
        return $this->_getService()->dropTemporaryTable($tableName, $schemaName);
    }

    /**
     * Truncate a table
     *
     * @param string $tableName
     * @param string $schemaName
     * @return Varien_Db_Adapter_Interface
     */
    public function truncateTable($tableName, $schemaName = null)
    {
        return $this->_getService()->truncateTable($tableName, $schemaName);
    }

    /**
     * Checks if table exists
     *
     * @param string $tableName
     * @param string $schemaName
     * @return boolean
     */
    public function isTableExists($tableName, $schemaName = null)
    {
        return $this->_getService()->isTableExists($tableName, $schemaName);
    }

    /**
     * Returns short table status array
     *
     * @param string $tableName
     * @param string $schemaName
     * @return array|false
     */
    public function showTableStatus($tableName, $schemaName = null)
    {
        return $this->_getService()->showTableStatus($tableName, $schemaName);
    }

    /**
     * Returns the column descriptions for a table.
     *
     * The return value is an associative array keyed by the column name,
     * as returned by the RDBMS.
     *
     * The value of each array element is an associative array
     * with the following keys:
     *
     * SCHEMA_NAME      => string; name of database or schema
     * TABLE_NAME       => string;
     * COLUMN_NAME      => string; column name
     * COLUMN_POSITION  => number; ordinal position of column in table
     * DATA_TYPE        => string; SQL datatype name of column
     * DEFAULT          => string; default expression of column, null if none
     * NULLABLE         => boolean; true if column can have nulls
     * LENGTH           => number; length of CHAR/VARCHAR
     * SCALE            => number; scale of NUMERIC/DECIMAL
     * PRECISION        => number; precision of NUMERIC/DECIMAL
     * UNSIGNED         => boolean; unsigned property of an integer type
     * PRIMARY          => boolean; true if column is part of the primary key
     * PRIMARY_POSITION => integer; position of column in primary key
     * IDENTITY         => integer; true if column is auto-generated with unique values
     *
     * @param string $tableName
     * @param string $schemaName OPTIONAL
     * @return array
     */
    public function describeTable($tableName, $schemaName = null)
    {
        return $this->_getService()->describeTable($tableName, $schemaName);
    }

    /**
     * Create Varien_Db_Ddl_Table object by data from describe table
     *
     * @param $tableName
     * @param $newTableName
     * @return Varien_Db_Ddl_Table
     */
    public function createTableByDdl($tableName, $newTableName)
    {
        return $this->_getService()->createTableByDdl($tableName, $newTableName);
    }

    /**
     * Modify the column definition by data from describe table
     *
     * @param string $tableName
     * @param string $columnName
     * @param array|string $definition
     * @param boolean $flushData
     * @param string $schemaName
     * @return Varien_Db_Adapter_Pdo_Mysql
     */
    public function modifyColumnByDdl($tableName, $columnName, $definition, $flushData = false, $schemaName = null)
    {
        return $this->_getService()->modifyColumnByDdl($tableName, $columnName, $definition, $flushData, $schemaName);
    }

    /**
     * Rename table
     *
     * @param string $oldTableName
     * @param string $newTableName
     * @param string $schemaName
     * @return boolean
     */
    public function renameTable($oldTableName, $newTableName, $schemaName = null)
    {
        return $this->_getService()->renameTable($oldTableName, $newTableName, $schemaName);
    }

    /**
     * Rename several tables
     *
     * @param array $tablePairs array('oldName' => 'Name1', 'newName' => 'Name2')
     *
     * @return boolean
     * @throws Zend_Db_Exception
     */
    public function renameTablesBatch(array $tablePairs)
    {
        return $this->_getService()->renameTablesBatch($tablePairs);
    }

    /**
     * Adds new column to the table.
     *
     * Generally $defintion must be array with column data to keep this call cross-DB compatible.
     * Using string as $definition is allowed only for concrete DB adapter.
     *
     * @param string $tableName
     * @param string $columnName
     * @param array|string $definition  string specific or universal array DB Server definition
     * @param string $schemaName
     * @return Varien_Db_Adapter_Interface
     */
    public function addColumn($tableName, $columnName, $definition, $schemaName = null)
    {
        return $this->_getService()->addColumn($tableName, $columnName, $definition, $schemaName);
    }

    /**
     * Change the column name and definition
     *
     * For change definition of column - use modifyColumn
     *
     * @param string $tableName
     * @param string $oldColumnName
     * @param string $newColumnName
     * @param array|string $definition
     * @param boolean $flushData        flush table statistic
     * @param string $schemaName
     * @return Varien_Db_Adapter_Interface
     */
    public function changeColumn($tableName, $oldColumnName, $newColumnName, $definition, $flushData = false,
                                 $schemaName = null)
    {
        return $this->_getService()->changeColumn($tableName, $oldColumnName, $newColumnName, $definition, $flushData,
            $schemaName);
    }

    /**
     * Modify the column definition
     *
     * @param string $tableName
     * @param string $columnName
     * @param array|string $definition
     * @param boolean $flushData
     * @param string $schemaName
     * @return Varien_Db_Adapter_Interface
     */
    public function modifyColumn($tableName, $columnName, $definition, $flushData = false, $schemaName = null)
    {
        return $this->_getService()->modifyColumn($tableName, $columnName, $definition, $flushData, $schemaName);
    }

    /**
     * Drop the column from table
     *
     * @param string $tableName
     * @param string $columnName
     * @param string $schemaName
     * @return boolean
     */
    public function dropColumn($tableName, $columnName, $schemaName = null)
    {
        return $this->_getService()->dropColumn($tableName, $columnName, $schemaName);
    }

    /**
     * Check is table column exists
     *
     * @param string $tableName
     * @param string $columnName
     * @param string $schemaName
     * @return boolean
     */
    public function tableColumnExists($tableName, $columnName, $schemaName = null)
    {
        return $this->_getService()->tableColumnExists($tableName, $columnName, $schemaName);
    }

    /**
     * Add new index to table name
     *
     * @param string $tableName
     * @param string $indexName
     * @param string|array $fields  the table column name or array of ones
     * @param string $indexType     the index type
     * @param string $schemaName
     * @return Zend_Db_Statement_Interface
     */
    public function addIndex($tableName, $indexName, $fields, $indexType = self::INDEX_TYPE_INDEX, $schemaName = null)
    {
        return $this->_getService()->addIndex($tableName, $indexName, $fields, $indexType, $schemaName);
    }

    /**
     * Drop the index from table
     *
     * @param string $tableName
     * @param string $keyName
     * @param string $schemaName
     * @return bool|Zend_Db_Statement_Interface
     */
    public function dropIndex($tableName, $keyName, $schemaName = null)
    {
        return $this->_getService()->dropIndex($tableName, $keyName, $schemaName);
    }

    /**
     * Returns the table index information
     *
     * The return value is an associative array keyed by the UPPERCASE index key (except for primary key,
     * that is always stored under 'PRIMARY' key) as returned by the RDBMS.
     *
     * The value of each array element is an associative array
     * with the following keys:
     *
     * SCHEMA_NAME      => string; name of database or schema
     * TABLE_NAME       => string; name of the table
     * KEY_NAME         => string; the original index name
     * COLUMNS_LIST     => array; array of index column names
     * INDEX_TYPE       => string; lowercase, create index type
     * INDEX_METHOD     => string; index method using
     * type             => string; see INDEX_TYPE
     * fields           => array; see COLUMNS_LIST
     *
     * @param string $tableName
     * @param string $schemaName
     * @return array
     */
    public function getIndexList($tableName, $schemaName = null)
    {
        return $this->_getService()->getIndexList($tableName, $schemaName);
    }

    /**
     * Add new Foreign Key to table
     * If Foreign Key with same name is exist - it will be deleted
     *
     * @param string $fkName
     * @param string $tableName
     * @param string $columnName
     * @param string $refTableName
     * @param string $refColumnName
     * @param string $onDelete
     * @param string $onUpdate
     * @param boolean $purge            trying remove invalid data
     * @param string $schemaName
     * @param string $refSchemaName
     * @return Varien_Db_Adapter_Interface
     */
    public function addForeignKey($fkName, $tableName, $columnName, $refTableName, $refColumnName,
                                  $onDelete = self::FK_ACTION_CASCADE, $onUpdate = self::FK_ACTION_CASCADE,
                                  $purge = false, $schemaName = null, $refSchemaName = null)
    {
        return $this->_getService()->addForeignKey($fkName, $tableName, $columnName, $refTableName, $refColumnName,
            $onDelete, $onUpdate, $purge, $schemaName, $refSchemaName);
    }

    /**
     * Drop the Foreign Key from table
     *
     * @param string $tableName
     * @param string $fkName
     * @param string $schemaName
     * @return Varien_Db_Adapter_Interface
     */
    public function dropForeignKey($tableName, $fkName, $schemaName = null)
    {
        return $this->_getService()->dropForeignKey($tableName, $fkName, $schemaName);
    }

    /**
     * Retrieve the foreign keys descriptions for a table.
     *
     * The return value is an associative array keyed by the UPPERCASE foreign key,
     * as returned by the RDBMS.
     *
     * The value of each array element is an associative array
     * with the following keys:
     *
     * FK_NAME          => string; original foreign key name
     * SCHEMA_NAME      => string; name of database or schema
     * TABLE_NAME       => string;
     * COLUMN_NAME      => string; column name
     * REF_SCHEMA_NAME  => string; name of reference database or schema
     * REF_TABLE_NAME   => string; reference table name
     * REF_COLUMN_NAME  => string; reference column name
     * ON_DELETE        => string; action type on delete row
     * ON_UPDATE        => string; action type on update row
     *
     * @param string $tableName
     * @param string $schemaName
     * @return array
     */
    public function getForeignKeys($tableName, $schemaName = null)
    {
        return $this->_getService()->getForeignKeys($tableName, $schemaName);
    }

    /**
     * Creates and returns a new Varien_Db_Select object for this adapter.
     *
     * @return Varien_Db_Select
     */
    public function select()
    {
        return $this->_getService()->select();
    }

    /**
     * Inserts a table row with specified data.
     *
     * @param mixed $table The table to insert data into.
     * @param array $data Column-value pairs or array of column-value pairs.
     * @param arrat $fields update fields pairs or values
     * @return int The number of affected rows.
     */
    public function insertOnDuplicate($table, array $data, array $fields = array())
    {
        return $this->_getService()->insertOnDuplicate($table, $data, $fields);
    }

    /**
     * Inserts a table multiply rows with specified data.
     *
     * @param mixed $table The table to insert data into.
     * @param array $data Column-value pairs or array of Column-value pairs.
     * @return int The number of affected rows.
     */
    public function insertMultiple($table, array $data)
    {
        return $this->_getService()->insertMultiple($table, $data);
    }

    /**
     * Insert array to table based on columns definition
     *
     * @param   string $table
     * @param   array $columns  the data array column map
     * @param   array $data
     * @return  int
     */
    public function insertArray($table, array $columns, array $data)
    {
        return $this->_getService()->insertArray($table, $columns, $data);
    }

    /**
     * Inserts a table row with specified data.
     *
     * @param mixed $table The table to insert data into.
     * @param array $bind Column-value pairs.
     * @return int The number of affected rows.
     */
    public function insert($table, array $bind)
    {
        return $this->_getService()->insert($table, $bind);
    }

    /**
     * Inserts a table row with specified data
     * Special for Zero values to identity column
     *
     * @param string $table
     * @param array $bind
     * @return int The number of affected rows.
     */
    public function insertForce($table, array $bind)
    {
        return $this->_getService()->insertForce($table, $bind);
    }

    /**
     * Updates table rows with specified data based on a WHERE clause.
     *
     * @param  mixed $table The table to update.
     * @param  array $bind  Column-value pairs.
     * @param  mixed $where UPDATE WHERE clause(s).
     * @return int          The number of affected rows.
     */
    public function update($table, array $bind, $where = '')
    {
        return $this->_getService()->update($table, $bind, $where);
    }

    /**
     * Deletes table rows based on a WHERE clause.
     *
     * @param  mixed $table The table to update.
     * @param  mixed $where DELETE WHERE clause(s).
     * @return int          The number of affected rows.
     */
    public function delete($table, $where = '')
    {
        return $this->_getService()->delete($table, $where);
    }

    /**
     * Prepares and executes an SQL statement with bound data.
     *
     * @param  mixed $sql  The SQL statement with placeholders.
     *                      May be a string or Zend_Db_Select.
     * @param  mixed $bind An array of data or data itself to bind to the placeholders.
     * @return Zend_Db_Statement_Interface
     */
    public function query($sql, $bind = array())
    {
        return $this->_getService()->query($sql, $bind);
    }

    /**
     * Executes a SQL statement(s)
     *
     * @param string $sql
     * @return Varien_Db_Adapter_Interface
     */
    public function multiQuery($sql)
    {
        return $this->_getService()->multiQuery($sql);
    }

    /**
     * Fetches all SQL result rows as a sequential array.
     * Uses the current fetchMode for the adapter.
     *
     * @param string|Zend_Db_Select $sql  An SQL SELECT statement.
     * @param mixed $bind Data to bind into SELECT placeholders.
     * @param mixed $fetchMode Override current fetch mode.
     * @return array
     */
    public function fetchAll($sql, $bind = array(), $fetchMode = null)
    {
        return $this->_getService()->fetchAll($sql, $bind, $fetchMode);
    }

    /**
     * Fetches the first row of the SQL result.
     * Uses the current fetchMode for the adapter.
     *
     * @param string|Zend_Db_Select $sql An SQL SELECT statement.
     * @param mixed $bind Data to bind into SELECT placeholders.
     * @param mixed $fetchMode Override current fetch mode.
     * @return array
     */
    public function fetchRow($sql, $bind = array(), $fetchMode = null)
    {
        return $this->_getService()->fetchRow($sql, $bind, $fetchMode);
    }

    /**
     * Fetches all SQL result rows as an associative array.
     *
     * The first column is the key, the entire row array is the
     * value.  You should construct the query to be sure that
     * the first column contains unique values, or else
     * rows with duplicate values in the first column will
     * overwrite previous data.
     *
     * @param string|Zend_Db_Select $sql An SQL SELECT statement.
     * @param mixed $bind Data to bind into SELECT placeholders.
     * @return array
     */
    public function fetchAssoc($sql, $bind = array())
    {
        return $this->_getService()->fetchAssoc($sql, $bind);
    }

    /**
     * Fetches the first column of all SQL result rows as an array.
     *
     * The first column in each row is used as the array key.
     *
     * @param string|Zend_Db_Select $sql An SQL SELECT statement.
     * @param mixed $bind Data to bind into SELECT placeholders.
     * @return array
     */
    public function fetchCol($sql, $bind = array())
    {
        return $this->_getService()->fetchCol($sql, $bind);
    }

    /**
     * Fetches all SQL result rows as an array of key-value pairs.
     *
     * The first column is the key, the second column is the
     * value.
     *
     * @param string|Zend_Db_Select $sql An SQL SELECT statement.
     * @param mixed $bind Data to bind into SELECT placeholders.
     * @return array
     */
    public function fetchPairs($sql, $bind = array())
    {
        return $this->_getService()->fetchPairs($sql, $bind);
    }

    /**
     * Fetches the first column of the first row of the SQL result.
     *
     * @param string|Zend_Db_Select $sql An SQL SELECT statement.
     * @param mixed $bind Data to bind into SELECT placeholders.
     * @return string
     */
    public function fetchOne($sql, $bind = array())
    {
        return $this->_getService()->fetchOne($sql, $bind);
    }

    /**
     * Safely quotes a value for an SQL statement.
     *
     * If an array is passed as the value, the array values are quoted
     * and then returned as a comma-separated string.
     *
     * @param mixed $value The value to quote.
     * @param mixed $type  OPTIONAL the SQL datatype name, or constant, or null.
     * @return mixed An SQL-safe quoted value (or string of separated values).
     */
    public function quote($value, $type = null)
    {
        return $this->_getService()->quote($value, $type);
    }

    /**
     * Quotes a value and places into a piece of text at a placeholder.
     *
     * The placeholder is a question-mark; all placeholders will be replaced
     * with the quoted value.   For example:
     *
     * <code>
     * $text = "WHERE date < ?";
     * $date = "2005-01-02";
     * $safe = $sql->quoteInto($text, $date);
     * // $safe = "WHERE date < '2005-01-02'"
     * </code>
     *
     * @param string $text  The text with a placeholder.
     * @param mixed $value The value to quote.
     * @param string $type  OPTIONAL SQL datatype
     * @param integer $count OPTIONAL count of placeholders to replace
     * @return string An SQL-safe quoted value placed into the original text.
     */
    public function quoteInto($text, $value, $type = null, $count = null)
    {
        return $this->_getService()->quoteInto($text, $value, $type, $count);
    }

    /**
     * Quotes an identifier.
     *
     * Accepts a string representing a qualified indentifier. For Example:
     * <code>
     * $adapter->quoteIdentifier('myschema.mytable')
     * </code>
     * Returns: "myschema"."mytable"
     *
     * Or, an array of one or more identifiers that may form a qualified identifier:
     * <code>
     * $adapter->quoteIdentifier(array('myschema','my.table'))
     * </code>
     * Returns: "myschema"."my.table"
     *
     * The actual quote character surrounding the identifiers may vary depending on
     * the adapter.
     *
     * @param string|array|Zend_Db_Expr $ident The identifier.
     * @param boolean $auto If true, heed the AUTO_QUOTE_IDENTIFIERS config option.
     * @return string The quoted identifier.
     */
    public function quoteIdentifier($ident, $auto = false)
    {
        return $this->_getService()->quoteIdentifier($ident, $auto);
    }

    /**
     * Quote a column identifier and alias.
     *
     * @param string|array|Zend_Db_Expr $ident The identifier or expression.
     * @param string $alias An alias for the column.
     * @param boolean $auto If true, heed the AUTO_QUOTE_IDENTIFIERS config option.
     * @return string The quoted identifier and alias.
     */
    public function quoteColumnAs($ident, $alias, $auto = false)
    {
        return $this->_getService()->quoteColumnAs($ident, $alias, $auto);
    }

    /**
     * Quote a table identifier and alias.
     *
     * @param string|array|Zend_Db_Expr $ident The identifier or expression.
     * @param string $alias An alias for the table.
     * @param boolean $auto If true, heed the AUTO_QUOTE_IDENTIFIERS config option.
     * @return string The quoted identifier and alias.
     */
    public function quoteTableAs($ident, $alias = null, $auto = false)
    {
        return $this->_getService()->quoteTableAs($ident, $alias, $auto);
    }

    /**
     * Format Date to internal database date format
     *
     * @param int|string|Zend_Date $date
     * @param boolean $includeTime
     * @return Zend_Db_Expr
     */
    public function formatDate($date, $includeTime = true)
    {
        return $this->_getService()->formatDate($date, $includeTime);
    }

    /**
     * Run additional environment before setup
     *
     * @return Varien_Db_Adapter_Interface
     */
    public function startSetup()
    {
        return $this->_getService()->startSetup();
    }

    /**
     * Run additional environment after setup
     *
     * @return Varien_Db_Adapter_Interface
     */
    public function endSetup()
    {
        return $this->_getService()->endSetup();
    }

    /**
     * Set cache adapter
     *
     * @param Zend_Cache_Backend_Interface $adapter
     * @return Varien_Db_Adapter_Interface
     */
    public function setCacheAdapter($adapter)
    {
        return $this->_getService()->setCacheAdapter($adapter);
    }

    /**
     * Allow DDL caching
     *
     * @return Varien_Db_Adapter_Interface
     */
    public function allowDdlCache()
    {
        return $this->_getService()->allowDdlCache();
    }

    /**
     * Disallow DDL caching
     *
     * @return Varien_Db_Adapter_Interface
     */
    public function disallowDdlCache()
    {
        return $this->_getService()->disallowDdlCache();
    }

    /**
     * Reset cached DDL data from cache
     * if table name is null - reset all cached DDL data
     *
     * @param string $tableName
     * @param string $schemaName OPTIONAL
     * @return Varien_Db_Adapter_Interface
     */
    public function resetDdlCache($tableName = null, $schemaName = null)
    {
        return $this->_getService()->resetDdlCache($tableName, $schemaName);
    }

    /**
     * Save DDL data into cache
     *
     * @param string $tableCacheKey
     * @param int $ddlType
     * @return Varien_Db_Adapter_Interface
     */
    public function saveDdlCache($tableCacheKey, $ddlType, $data)
    {
        return $this->_getService()->saveDdlCache($tableCacheKey, $ddlType, $data);
    }

    /**
     * Load DDL data from cache
     * Return false if cache does not exists
     *
     * @param string $tableCacheKey the table cache key
     * @param int $ddlType          the DDL constant
     * @return string|array|int|false
     */
    public function loadDdlCache($tableCacheKey, $ddlType)
    {
        return $this->_getService()->loadDdlCache($tableCacheKey, $ddlType);
    }

    /**
     * Build SQL statement for condition
     *
     * If $condition integer or string - exact value will be filtered ('eq' condition)
     *
     * If $condition is array - one of the following structures is expected:
     * - array("from" => $fromValue, "to" => $toValue)
     * - array("eq" => $equalValue)
     * - array("neq" => $notEqualValue)
     * - array("like" => $likeValue)
     * - array("in" => array($inValues))
     * - array("nin" => array($notInValues))
     * - array("notnull" => $valueIsNotNull)
     * - array("null" => $valueIsNull)
     * - array("moreq" => $moreOrEqualValue)
     * - array("gt" => $greaterValue)
     * - array("lt" => $lessValue)
     * - array("gteq" => $greaterOrEqualValue)
     * - array("lteq" => $lessOrEqualValue)
     * - array("finset" => $valueInSet)
     * - array("regexp" => $regularExpression)
     * - array("seq" => $stringValue)
     * - array("sneq" => $stringValue)
     *
     * If non matched - sequential array is expected and OR conditions
     * will be built using above mentioned structure
     *
     * @param string $fieldName
     * @param integer|string|array $condition
     * @return string
     */
    public function prepareSqlCondition($fieldName, $condition)
    {
        return $this->_getService()->prepareSqlCondition($fieldName, $condition);
    }

    /**
     * Prepare value for save in column
     * Return converted to column data type value
     *
     * @param array $column     the column describe array
     * @param mixed $value
     * @return mixed
     */
    public function prepareColumnValue(array $column, $value)
    {
        return $this->_getService()->prepareColumnValue($column, $value);
    }

    /**
     * Generate fragment of SQL, that check condition and return true or false value
     *
     * @param string $condition     expression
     * @param string $true          true value
     * @param string $false         false value
     * @return Zend_Db_Expr
     */
    public function getCheckSql($condition, $true, $false)
    {
        return $this->_getService()->getCheckSql($condition, $true, $false);
    }

    /**
     * Generate fragment of SQL, that check value against multiple condition cases
     * and return different result depends on them
     *
     * @param string $valueName Name of value to check
     * @param array $casesResults Cases and results
     * @param string $defaultValue value to use if value doesn't confirm to any cases
     *
     * @return Zend_Db_Expr
     */
    public function getCaseSql($valueName, $casesResults, $defaultValue = null)
    {
        return $this->_getService()->getCaseSql($valueName, $casesResults, $defaultValue);
    }

    /**
     * Returns valid IFNULL expression
     *
     * @param string $column
     * @param string $value OPTIONAL. Applies when $expression is NULL
     * @return Zend_Db_Expr
     */
    public function getIfNullSql($expression, $value = 0)
    {
        return $this->_getService()->getIfNullSql($expression, $value);
    }

    /**
     * Generate fragment of SQL, that combine together (concatenate) the results from data array
     * All arguments in data must be quoted
     *
     * @param array $data
     * @param string $separator concatenate with separator
     * @return Zend_Db_Expr
     */
    public function getConcatSql(array $data, $separator = null)
    {
        return $this->_getService()->getConcatSql($data, $separator);
    }

    /**
     * Generate fragment of SQL that returns length of character string
     * The string argument must be quoted
     *
     * @param string $string
     * @return Zend_Db_Expr
     */
    public function getLengthSql($string)
    {
        return $this->_getService()->getLengthSql($string);
    }

    /**
     * Generate fragment of SQL, that compare with two or more arguments, and returns the smallest
     * (minimum-valued) argument
     * All arguments in data must be quoted
     *
     * @param array $data
     * @return Zend_Db_Expr
     */
    public function getLeastSql(array $data)
    {
        return $this->_getService()->getLeastSql($data);
    }

    /**
     * Generate fragment of SQL, that compare with two or more arguments, and returns the largest
     * (maximum-valued) argument
     * All arguments in data must be quoted
     *
     * @param array $data
     * @return Zend_Db_Expr
     */
    public function getGreatestSql(array $data)
    {
        return $this->_getService()->getGreatestSql($data);
    }

    /**
     * Add time values (intervals) to a date value
     *
     * @see INTERVAL_* constants for $unit
     *
     * @param Zend_Db_Expr|string $date   quoted field name or SQL statement
     * @param int $interval
     * @param string $unit
     * @return Zend_Db_Expr
     */
    public function getDateAddSql($date, $interval, $unit)
    {
        return $this->_getService()->getDateAddSql($date, $interval, $unit);
    }

    /**
     * Subtract time values (intervals) to a date value
     *
     * @see INTERVAL_* constants for $unit
     *
     * @param Zend_Db_Expr|string $date   quoted field name or SQL statement
     * @param int|string $interval
     * @param string $unit
     * @return Zend_Db_Expr
     */
    public function getDateSubSql($date, $interval, $unit)
    {
        return $this->_getService()->getDateSubSql($date, $interval, $unit);
    }

    /**
     * Format date as specified
     *
     * Supported format Specifier
     *
     * %H   Hour (00..23)
     * %i   Minutes, numeric (00..59)
     * %s   Seconds (00..59)
     * %d   Day of the month, numeric (00..31)
     * %m   Month, numeric (00..12)
     * %Y   Year, numeric, four digits
     *
     * @param Zend_Db_Expr|string $date   quoted field name or SQL statement
     * @param string $format
     * @return Zend_Db_Expr
     */
    public function getDateFormatSql($date, $format)
    {
        return $this->_getService()->getDateFormatSql($date, $format);
    }

    /**
     * Extract the date part of a date or datetime expression
     *
     * @param Zend_Db_Expr|string $date   quoted field name or SQL statement
     * @return Zend_Db_Expr
     */
    public function getDatePartSql($date)
    {
        return $this->_getService()->getDatePartSql($date);
    }

    /**
     * Prepare substring sql function
     *
     * @param Zend_Db_Expr|string $stringExpression quoted field name or SQL statement
     * @param int|string|Zend_Db_Expr $pos
     * @param int|string|Zend_Db_Expr|null $len
     * @return Zend_Db_Expr
     */
    public function getSubstringSql($stringExpression, $pos, $len = null)
    {
        return $this->_getService()->getSubstringSql($stringExpression, $pos, $len);
    }

    /**
     * Prepare standard deviation sql function
     *
     * @param Zend_Db_Expr|string $expressionField   quoted field name or SQL statement
     * @return Zend_Db_Expr
     */
    public function getStandardDeviationSql($expressionField)
    {
        return $this->_getService()->getStandardDeviationSql($expressionField);
    }

    /**
     * Extract part of a date
     *
     * @see INTERVAL_* constants for $unit
     *
     * @param Zend_Db_Expr|string $date   quoted field name or SQL statement
     * @param string $unit
     * @return Zend_Db_Expr
     */
    public function getDateExtractSql($date, $unit)
    {
        return $this->_getService()->getDateExtractSql($date, $unit);
    }

    /**
     * Retrieve valid table name
     * Check table name length and allowed symbols
     *
     * @param string $tableName
     * @return string
     */
    public function getTableName($tableName)
    {
        return $this->_getService()->getTableName($tableName);
    }

    /**
     * Retrieve valid index name
     * Check index name length and allowed symbols
     *
     * @param string $tableName
     * @param string|array $fields  the columns list
     * @param string $indexType
     * @return string
     */
    public function getIndexName($tableName, $fields, $indexType = '')
    {
        return $this->_getService()->getIndexName($tableName, $fields, $indexType);
    }

    /**
     * Retrieve valid foreign key name
     * Check foreign key name length and allowed symbols
     *
     * @param string $priTableName
     * @param string $priColumnName
     * @param string $refTableName
     * @param string $refColumnName
     * @return string
     */
    public function getForeignKeyName($priTableName, $priColumnName, $refTableName, $refColumnName)
    {
        return $this->_getService()->getForeignKeyName($priTableName, $priColumnName, $refTableName, $refColumnName);
    }

    /**
     * Stop updating indexes
     *
     * @param string $tableName
     * @param string $schemaName
     * @return Varien_Db_Adapter_Interface
     */
    public function disableTableKeys($tableName, $schemaName = null)
    {
        return $this->_getService()->disableTableKeys($tableName, $schemaName);
    }

    /**
     * Re-create missing indexes
     *
     * @param string $tableName
     * @param string $schemaName
     * @return Varien_Db_Adapter_Interface
     */
    public function enableTableKeys($tableName, $schemaName = null)
    {
        return $this->_getService()->enableTableKeys($tableName, $schemaName);
    }

    /**
     * Get insert from Select object query
     *
     * @param Varien_Db_Select $select
     * @param string $table     insert into table
     * @param array $fields
     * @param bool|int $mode
     * @return string
     */
    public function insertFromSelect(Varien_Db_Select $select, $table, array $fields = array(), $mode = false)
    {
        return $this->_getService()->insertFromSelect($select, $table, $fields, $mode);
    }

    /**
     * Get insert queries in array for insert by range with step parameter
     *
     * @param string $rangeField
     * @param Varien_Db_Select $select
     * @param int $stepCount
     * @return array
     */
    public function selectsByRange($rangeField, Varien_Db_Select $select, $stepCount = 100)
    {
        return $this->_getService()->selectsByRange($rangeField, $select, $stepCount);
    }

    /**
     * Get update table query using select object for join and update
     *
     * @param Varien_Db_Select $select
     * @param string|array $table
     * @return string
     */
    public function updateFromSelect(Varien_Db_Select $select, $table)
    {
        return $this->_getService()->updateFromSelect($select, $table);
    }

    /**
     * Get delete from select object query
     *
     * @param Varien_Db_Select $select
     * @param string $table the table name or alias used in select
     * @return string|int
     */
    public function deleteFromSelect(Varien_Db_Select $select, $table)
    {
        return $this->_getService()->deleteFromSelect($select, $table);
    }

    /**
     * Return array of table(s) checksum as table name - checksum pairs
     *
     * @param array|string $tableNames
     * @param string $schemaName
     * @return array
     */
    public function getTablesChecksum($tableNames, $schemaName = null)
    {
        return $this->_getService()->getTablesChecksum($tableNames, $schemaName);
    }

    /**
     * Check if the database support STRAIGHT JOIN
     *
     * @return boolean
     */
    public function supportStraightJoin()
    {
        return $this->_getService()->supportStraightJoin();
    }

    /**
     * Adds order by random to select object
     * Possible using integer field for optimization
     *
     * @param Varien_Db_Select $select
     * @param string $field
     * @return Varien_Db_Adapter_Interface
     */
    public function orderRand(Varien_Db_Select $select, $field = null)
    {
        return $this->_getService()->orderRand($select, $field);
    }

    /**
     * Render SQL FOR UPDATE clause
     *
     * @param string $sql
     * @return string
     */
    public function forUpdate($sql)
    {
        return $this->_getService()->forUpdate($sql);
    }

    /**
     * Try to find installed primary key name, if not - formate new one.
     *
     * @param string $tableName Table name
     * @param string $schemaName OPTIONAL
     * @return string Primary Key name
     */
    public function getPrimaryKeyName($tableName, $schemaName = null)
    {
        return $this->_getService()->getPrimaryKeyName($tableName, $schemaName);
    }

    /**
     * Converts fetched blob into raw binary PHP data.
     * Some DB drivers return blobs as hex-coded strings, so we need to process them.
     *
     * @mixed $value
     * @return mixed
     */
    public function decodeVarbinary($value)
    {
        return $this->_getService()->decodeVarbinary($value);
    }

    /**
     * Returns date that fits into TYPE_DATETIME range and is suggested to act as default 'zero' value
     * for a column for current RDBMS. Deprecated and left for compatibility only.
     * In Magento at MySQL there was zero date used for datetime columns. However, zero date it is not supported across
     * different RDBMS. Thus now it is recommended to use same default value equal for all RDBMS - either NULL
     * or specific date supported by all RDBMS.
     *
     * @deprecated after 1.5.1.0
     * @return string
     */
    public function getSuggestedZeroDate()
    {
        return $this->_getService()->getSuggestedZeroDate();
    }

    /**
     * Drop trigger
     *
     * @param string $triggerName
     * @return Varien_Db_Adapter_Interface
     */
    public function dropTrigger($triggerName)
    {
        return $this->_getService()->dropTrigger($triggerName);
    }

    /**
     * Get adapter transaction level state. Return 0 if all transactions are complete
     *
     * @return int
     */
    public function getTransactionLevel()
    {
        return $this->_getService()->getTransactionLevel();
    }

    /**
     * Convert date format to unix time
     *
     * @param string|Zend_Db_Expr $date
     * @return mixed
     */
    public function getUnixTimestamp($date)
    {
        return $this->_getService()->getUnixTimestamp($date);
    }

    /**
     * Convert unix time to date format
     *
     * @param int|Zend_Db_Expr $timestamp
     * @return mixed
     */
    public function fromUnixtime($timestamp)
    {
        return $this->_getService()->fromUnixtime($timestamp);
    }

    /**
     * Returns a list of the tables in the database.
     *
     * @return array
     */
    public function listTables()
    {
        return $this->_getService()->listTables();
    }

    /**
     * Creates a connection to the database.
     *
     * @return void
     */
    protected function _connect() {}

    /**
     * Test if a connection is active
     *
     * @return boolean
     */
    public function isConnected()
    {
        return $this->_getService()->isConnected();
    }

    /**
     * Force the connection to close.
     *
     * @return void
     */
    public function closeConnection()
    {
        return $this->_getService()->closeConnection();
    }

    /**
     * Prepare a statement and return a PDOStatement-like object.
     *
     * @param string|Zend_Db_Select $sql SQL query
     * @return Zend_Db_Statement|PDOStatement
     */
    public function prepare($sql)
    {
        return $this->_getService()->prepare($sql);
    }

    /**
     * Gets the last ID generated automatically by an IDENTITY/AUTOINCREMENT column.
     *
     * As a convention, on RDBMS brands that support sequences
     * (e.g. Oracle, PostgreSQL, DB2), this method forms the name of a sequence
     * from the arguments and returns the last id generated by that sequence.
     * On RDBMS brands that support IDENTITY/AUTOINCREMENT columns, this method
     * returns the last value generated for such a column, and the table name
     * argument is disregarded.
     *
     * @param string $tableName   OPTIONAL Name of table.
     * @param string $primaryKey  OPTIONAL Name of primary key column.
     * @return string
     */
    public function lastInsertId($tableName = null, $primaryKey = null)
    {
        return $this->_getService()->lastInsertId($tableName, $primaryKey);
    }

    /**
     * Begin a transaction.
     */
    protected function _beginTransaction() {}

    /**
     * Commit a transaction.
     */
    protected function _commit() {}

    /**
     * Roll-back a transaction.
     */
    protected function _rollBack() {}

    /**
     * Set the fetch mode.
     *
     * @param integer $mode
     * @return void
     * @throws Zend_Db_Adapter_Exception
     */
    public function setFetchMode($mode)
    {
        return $this->_getService()->setFetchMode($mode);
    }

    /**
     * Adds an adapter-specific LIMIT clause to the SELECT statement.
     *
     * @param mixed $sql
     * @param integer $count
     * @param integer $offset
     * @return string
     */
    public function limit($sql, $count, $offset = 0)
    {
        return $this->_getService()->limit($sql, $count, $offset);
    }

    /**
     * Check if the adapter supports real SQL parameters.
     *
     * @param string $type 'positional' or 'named'
     * @return bool
     */
    public function supportsParameters($type)
    {
        return $this->_getService()->supportsParameters($type);
    }

    /**
     * Retrieve server version in PHP style
     *
     * @return string
     */
    public function getServerVersion()
    {
        return $this->_getService()->getServerVersion();
    }


}