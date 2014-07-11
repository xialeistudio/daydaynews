<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	private $_id;
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		/** @var $user User */
		$user = User::model()->findByPk($this->username);
		if(empty($user)){
			$this->errorCode = self::ERROR_USERNAME_INVALID;
			$this->errorMessage = '用户不存在';
		}else{
			$this->_id = $user->openid;
			$this->setState('nickname',$user->nickname);
			$this->setState('login_at',$user->login_at);
			$this->setState('avatar',$user->avatar);
			//更新登陆时间
			$user->login_at = time();
			//积分增加
			UserService::getInstance()->increaseScore('login',$user);
			$user->save();
			$this->errorCode = self::ERROR_NONE;
		}

		return !$this->errorCode;
	}

	public function getId()
	{
		return $this->_id;
	}
}