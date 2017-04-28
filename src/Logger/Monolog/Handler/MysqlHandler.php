<?php

namespace Logger\Monolog\Handler;

use DB;
use Monolog\Logger;
use Monolog\Handler\AbstractProcessingHandler;

class MysqlHandler extends AbstractProcessingHandler
{
    protected $table;
    protected $connection;

    public function __construct($level = Logger::DEBUG, $bubble = true)
    {
        $this->table      = env('DB_LOG_TABLE', 'logs');
        $this->connection = env('DB_LOG_CONNECTION', env('DB_CONNECTION', 'mysql'));

        parent::__construct($level, $bubble);
    }

    protected function write(array $record)
    {
        $message = explode(': ', $record['message'], 2);

        $body    = isset($message[1]) ? $message[1] : $message[0];
        $process = isset($message[1]) ? $message[0] : null;

        $data = [
            'instance'    => gethostname(),
            'message'     => $body,
            'process'     => $process,
            'channel'     => $record['channel'],
            'level'       => $record['level'],
            'level_name'  => $record['level_name'],
            'context'     => json_encode($record['context']),
            'remote_addr' => isset($_SERVER['REMOTE_ADDR'])     ? ip2long($_SERVER['REMOTE_ADDR']) : null,
            'user_agent'  => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT']      : null,
            'created_by'  => \Auth::id() > 0 ? \Auth::id() : null,
            'created_at'  => $record['datetime']->format('Y-m-d H:i:s')
        ];

        DB::connection($this->connection)->table($this->table)->insert($data);
    }
}
