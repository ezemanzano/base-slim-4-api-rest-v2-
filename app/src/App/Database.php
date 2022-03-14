<?php

declare(strict_types=1);

use App\Helper\LoggerLog;

$container['db'] = static function (): PDO {
    $dsn = sprintf(
        'mysql:host=%s;dbname=%s;port=%s;charset=%s',
        $_SERVER['DB_HOST'],
        $_SERVER['DB_NAME'],
        $_SERVER['DB_PORT'],
        $_SERVER['DB_CHARSET'],
    );
    
    $pdo = new MyPdo($dsn, $_SERVER['DB_USER'], $_SERVER['DB_PASS']);
    
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

    return $pdo;
};

/**
 **********************************************
 * CUSTOM PDO
 **********************************************
 */

class MyPdo extends PDO {

    public function __construct(
        $dsn,
        $username = null,
        $password = null
    )
    {
        parent::__construct(
            $dsn,
            $username,
            $password
        );
    }

    public function query(string $query, ?int $fetchMode = null, mixed ...$fetchModeArgs)
    {
        
        MyPdoLog::printLogStart($query);
        
        try {
            $result = parent::query($query);
        }catch(Exception $e){
            throw new Exception($e->getMessage().' SQL: '.$query);
        }
        
        MyPdoLog::printLogEnd($query);
        
        return $result;
    }

    public function prepare(string $query, $options = array())
    {
        return new MyPdoStatement(parent::prepare($query, $options));
    }

}

/**
 **********************************************
 * CUSTOM PDOStatement
 **********************************************
 */

class MyPdoStatement {

    /**
     * The PDOStatement we decorate
     */

    private $statement;

    public function __construct(PDOStatement $statement)
    {
        $this->statement = $statement;
    }

    /**
     * Other than execute pass all other calls to the PDOStatement object
     * @param string $function_name
     * @param array $parameters arguments
     */
    
    public function __call($function_name, $parameters)
    {
        return call_user_func_array(array($this->statement, $function_name), $parameters);
    }

    /**
     * When execute is called record the time it takes and
     * then log the query
     * @return PDO result set
     */

    public function execute($parameters = array())
    {
        $query = trim(preg_replace(
            '/\s+/',
            ' ',
           PdoDebugger::show($this->statement->queryString, $parameters)
        ));
        
        MyPdoLog::printLogStart($query);
        
        try {
            $result = $this->statement->execute($parameters);
        }catch(Exception $e){
            throw new Exception($e->getMessage().' SQL: '.$query);
        }
        
        MyPdoLog::printLogEnd($query);
        return $result;
    }
}

/**
 **********************************************
 * Log PDO
 **********************************************
 */

class MyPdoLog {

    public function __construct() { }

    public static function printLogStart(string $query)
    {

        $log = LoggerLog::get('sql');
        
        if(LoggerLog::PROFILE){
            $log->info('Query Start', ['timer' => [md5($query) => 'start']]);
        }

        $log->info($query);
    
    }

    public static function printLogEnd(string $query)
    {
        
        if(LoggerLog::PROFILE){
            $log = LoggerLog::get('sql');
            $log->info('Query Stop', ['timer' => [md5($query) => 'stop']]);
        }

    }
}