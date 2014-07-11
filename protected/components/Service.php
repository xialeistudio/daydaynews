<?php


class Service extends CComponent
{
	private static $_instance = array();

	/**
	 * 实例化
	 * @param string $className
	 * @return Service
	 */
	public static function instance($className = __CLASS__)
	{
		if (empty(self::$_instance[$className]))
		{
			self::$_instance[$className] = new $className();
		}
		return self::$_instance[$className];
	}

}
