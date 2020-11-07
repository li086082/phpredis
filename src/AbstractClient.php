<?php
declare(strict_types = 1);

namespace cache\Client;

use Redis;

/**
 * Class AbstractClient
 * @package cache\Client
 *
 * @see https://github.com/phpredis/phpredis
 * @method  int             del(string|array $key)
 * @method  string|false    dump(string $key)
 * @method  int             exists(string|array $key)
 * @method  bool            expire(string $key, int $ttl)
 * @method  bool            expireAt(string $key, int $timestamp)
 * @method  array           keys(string $pattern)
 * @method  array|false     scan(&$iterator, $pattern = null, $count = 0)
 * @method  bool            move(string $key, int $dbIndex)
 * @method  bool            persist(string $key)
 * @method  string          randomKey()
 * @method  bool            rename(string $srcKey, string $dstKey)
 * @method  bool            renameNx(string $srcKey, string $dstKey)
 * @method  string          type(string $key)
 * @method  array           sort(string $key, array $options = null)
 * @method  int             ttl(string $ttl)
 *
 * @method  int             append(string $key, string $value)
 * @method
 */
abstract class AbstractClient{

    /**
     * @var array
     */
    private $config = [];

    /**
     * @var Redis
     */
    private $connect;

    public function __construct(){
        $this->connect->connect(...$this->config);
        $this->connect->setBit();
    }

    /**
     * @param string $password
     */
    protected function auth(string $password) :void {
        $this->connect->auth($password);
    }

    /**
     * @param int $index
     */
    protected function select(int $index) :void {
        $this->connect->select($index);
    }

    /**
     * @param array $config
     */
    public function setConfig(array $config): void{
        $this->config = $config;
    }

    /**
     * @return Redis
     */
    public function getConnect(): Redis{
        return $this->connect;
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public abstract function __call(string $name, array $arguments);
}