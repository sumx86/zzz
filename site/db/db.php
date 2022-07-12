<?php
    require_once "fetchmodes.php";

    class DB {
        
        // the stmt object
        private $stmt = null;

        // the database handle
        public $pdo = null;

        // the query that is going to be executed
        private $_query = "";

        // fetch mode
        private $_fetchMode = null;

        // the last executed query
        private $_lastQuery = "";

        // (boolean) debug mode
        public $_debug = false;

        // the table that is being used
        private $_table = '';
        
        // array to hold the query result
        private $_resultSet = [];

        // flag for fetching all the rows
        public const ALL_ROWS = -1;

        // database options
        private $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        public function __construct($debugMode) {
            $this->_debug = $debugMode;
            try {
                $this->pdo = new PDO(zdsn, zuser, zpassword, $this->options);
                if( $this->_debug ) {
                    echo "[INFO] - Database Connection Success!";
                }
            } catch (\PDOException $e) {
                throw new \PDOException($e->getMessage(), (int)$e->getCode());
            }
        }

        /*
         * Set the fetching mode [PDO::FETCH_ASSOC, PDO::FETCH_LAZY, etc...]
         */
        public function setFetchMode($mode) {
            if( Str::contains($mode, ':') ) {
                $this->_fetchMode[0] = FetchModes::$modes[explode(':', $mode)[0]];
                $this->_fetchMode[1] = explode(':', $mode)[1];
            } else {
                $this->_fetchMode = $mode;
            }
            return $this;
        }

        /*
         * Set the fetching mode for the query
         */
        public function setMode() {
            is_array($this->_fetchMode)
                   ? $this->stmt->setFetchMode($this->_fetchMode[0], $this->_fetchMode[1])
                   : $this->stmt->setFetchMode($this->_fetchMode);
        }

        /*
         * Set the current table for the queries and check if it actually exists (not intended for raw queries)
         */
        public function setTable($tableName) {
            $schemaArray = $this->pdo->query("select table_schema from information_schema.tables where table_name='$tableName'")->fetchAll($this->_fetchMode);
            foreach($schemaArray as $data) {
                if( $data['TABLE_SCHEMA'] == zdbname ) {
                    $this->_table = $tableName;
                }
            } return $this;
        }

        /*
         * Execute a raw query
         */
        public function rawQuery($query, $params, $expectResult, $numRows = -1) {
            if(!Str::is_empty($query)) {
                $this->stmt = $this->pdo->prepare($query);
                if( Str::contains($query, '?') ) {
                    $this->bindValuesAndExecute($params);
                } else {
                    $this->setMode();
                    $this->stmt->execute();
                }
                $this->_lastQuery = $query;
                return $expectResult ? $this->getResult($numRows) : null;
            }
        }

        /*
         * Build a raw query
         */
        public function buildRawQuery($type, $elements, $table, $columns, $values) {
            switch($type) {
                case 'select':
                    break;
                case 'insert':
                    $query = "insert into $table";
                    break;
                case 'update':
                    $query = "update $table set";
                    break;
                case 'delete':
                    $query = "delete from $table";
                    break;
            }
        }

        /*
         * Bind values in $this->stmt
         */
        public function bindValues($values) {
            foreach($values as $index => $bindValue) {
                switch(Str::lower(gettype($bindValue))) {
                    case 'integer':
                        $this->stmt->bindValue($index + 1, $bindValue, PDO::PARAM_INT);
                        break;
                    case 'string':
                        $this->stmt->bindValue($index + 1, $bindValue, PDO::PARAM_STR);
                        break;
                }
            }
        }

        /*
         * Bind values in $this->stms and execute the query
         */
        public function bindValuesAndExecute($values) {
            $this->bindValues($values);
            if(!is_null($this->_fetchMode)) {
                $this->setMode();
            }
            $this->stmt->execute();
        }

        /*
         * 
         */
        public function getResult($numRows) {
            if( $numRows == self::ALL_ROWS ) {
                $numRows = $this->stmt->rowCount();
            }
            $results = [];
            for( $i = 0 ; $i < $numRows ; $i++ ) {
                array_push($results, $this->stmt->fetch());
            }
            $this->stmt->closeCursor();
            return $results;
        }

        /*
         * Execute the query
         */
        public function runQuery() {
            // function that executes the query
        }

        /*
         * Insert '$tableData' in current table
         */
        public function insert($tableData) {

        }

        /*
         * Retrieve '$tableData' from current table and only '$rowcount' number of rows
         */
        public function get($tableData, $rowcount) {

        }

        /*
         * Add a WHERE subquery to the query string with the specified $conditionData
         */
        public function where($conditionData) {

        }

        /*
         * Build the prepared statement
         */
        public function _buildPrepareQuery($tableData) {
            
        }

        /*
         * Get the table that is currently being used (string)
         */
        public function getTable() {
            return $this->_table;
        }

        /*
         * Get the last executed query (string)
         */
        public function getLastQuery() {
            return $this->_lastQuery;
        }

        public function __destruct() {
            if(!is_null($this->stmt)) {$this->stmt = null;}
            if(!is_null($this->pdo))  {$this->pdo  = null;}
        }

        /*
         * Close the connection
         */
        public function close() {
            if( !is_null($this->pdo) ) {
                $this->pdo = null;
            }
        }
    }
?>