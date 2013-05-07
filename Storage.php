<?php


namespace Teacup\Orm;


class Storage {


	/**
	 * @var array
	 */
	static public $instances = array('default' => array());


	/**
	 * Creates a new instance of PDO or returns an existing one.
	 *
	 * @static
	 * @param string $name
	 * @return \PDO
	 * @throws \OutOfBoundsException
	 */
	static public function get($name) {
		if(!isset(self::$instances[$name])) {
			throw new \OutOfBoundsException(sprintf('Storage "%s" invalid', $name));
		}

		$config = self::$instances[$name];
		if($config instanceof \PDO) {
			$instance = $config;
		} else {
			$instance = new \PDO(
					isset($config['dsn']) ? $config['dsn'] : 'mysql:host=localhost',
					isset($config['user']) ? $config['user'] : 'root',
					isset($config['password']) ? $config['password']: '',
					isset($config['option']) ? $config['option'] : array()
			);
		}

		return $instance;
	}

}