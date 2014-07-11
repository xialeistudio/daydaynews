<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property string $openid
 * @property string $avatar
 * @property string $nickname
 * @property string $email
 * @property integer $created_at
 * @property integer $login_at
 * @property integer $score
 * @property integer $state
 *
 * The followings are the available model relations:
 * @property Comment[] $comments
 */
class User extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('openid', 'required'),
			array('created_at, login_at, score, state', 'numerical', 'integerOnly'=>true),
			array('openid, nickname, email', 'length', 'max'=>40),
			array('avatar', 'length', 'max'=>128),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('openid, avatar, nickname, email, created_at, login_at, score, state', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'comments' => array(self::HAS_MANY, 'Comment', 'openid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'openid' => 'Openid',
			'avatar' => '头像',
			'nickname' => '昵称',
			'email' => '邮箱',
			'created_at' => '注册时间',
			'login_at' => '最近登录',
			'score' => '积分',
			'state' => '状态',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('openid',$this->openid,true);
		$criteria->compare('avatar',$this->avatar,true);
		$criteria->compare('nickname',$this->nickname,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('created_at',$this->created_at);
		$criteria->compare('login_at',$this->login_at);
		$criteria->compare('score',$this->score);
		$criteria->compare('state',$this->state);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	protected function beforeSave()
	{
		if(parent::beforeFind()){
			if($this->isNewRecord){
				$this->created_at = time();
				$this->score = 100;
			}
			return true;
		}
		return false;
	}
}