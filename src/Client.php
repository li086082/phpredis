<?php
declare(strict_types = 1);

namespace cache\Client;

/**
 * Class Client
 * @package cache\Client
 */
class Client extends AbstractClient {

    use SupportedCommandsTrait;

    protected $defaultConfig = [
        "host"      => "127.0.0.1",
        "port"      => 6379,
        "timeout"   => 5.0,
        "retry"     => 10,
        "readTime"  => 5.0
    ];

    /**
     * Client constructor.
     * @param array $config
     * @example ["host"=>"", "port"=>"", "timeout"=>"", "retry"=>"", "readTime"=>""]
     */
    public function __construct(array $config){
        foreach($config as $k=>$v){
            if(array_key_exists($k, $this->defaultConfig)){
                $this->defaultConfig[$k] = $v;
            }
        }
        unset($v, $k, $config);

        $this->setConfig($this->defaultConfig);
        parent::__construct();
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return mixed|void
     * @throws UnknownMethodException
     */
    public function __call(string $name, array $arguments){
        // TODO: Implement __call() method.
        $connect = $this->getConnect();
        $supportedCommands = $this->getSupportedCommands();
        if(!array_key_exists(strtoupper($name), $supportedCommands)){
            throw new UnknownMethodException("method not supported !!!");
        }
        return $connect->$supportedCommands[strtoupper($name)](...$arguments);
    }


    public function __destruct(){
        // TODO: Implement __destruct() method.
        $this->getConnect()->close();
    }
}