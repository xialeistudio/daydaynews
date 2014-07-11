<?php


class UserService
{
	private static $handler;

	/**
	 * @return UserService
	 */
	public static function getInstance()
	{
		if (!self::$handler instanceof self)
		{
			self::$handler = new self;
		}
		return self::$handler;
	}

	/**
	 * 用户增加积分
	 * @param string $type
	 * @param User $user
	 * @return mixed
	 */
	public function increaseScore($type = 'login', $user)
	{
		switch ($type)
		{
			case 'login':
				$user = $this->increaseLogin($user);
				break;
			default:
				break;
		}
		return $user;
	}

	/**
	 * 登录
	 * @param User $user
	 * @return mixed
	 */
	private function increaseLogin($user)
	{
		//每天登录增加5分
		$token = Yii::app()->cache->get($user->openid . '-login');
		if (empty($token))
		{
			$user->score += 5;
			Yii::app()->cache->set($user->openid . '-login', 1, 86400);
		}
		return $user;
	}
} 