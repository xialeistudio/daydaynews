<?php

/**
 * This is the model class for table "comment".
 *
 * The followings are the available columns in table 'comment':
 * @property integer $comment_id
 * @property string $content
 * @property string $address
 * @property integer $created_at
 * @property integer $pid
 * @property integer $news_id
 * @property string $openid
 *
 * The followings are the available model relations:
 * @property News $news
 * @property User $user
 */
class Comment extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Comment the static model class
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
		return 'comment';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('news_id, openid', 'required'),
			array('created_at, pid, news_id', 'numerical', 'integerOnly'=>true),
			array('content', 'length', 'max'=>100),
			array('address', 'length', 'max'=>16),
			array('openid', 'length', 'max'=>40),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('comment_id, content, address, created_at, pid, news_id, openid', 'safe', 'on'=>'search'),
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
			'news' => array(self::BELONGS_TO, 'News', 'news_id'),
			'user' => array(self::BELONGS_TO, 'User', 'openid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'comment_id' => 'Comment',
			'content' => 'Content',
			'address' => 'Address',
			'created_at' => 'Created At',
			'pid' => 'Pid',
			'news_id' => 'News',
			'openid' => 'Openid',
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

		$criteria->compare('comment_id',$this->comment_id);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('created_at',$this->created_at);
		$criteria->compare('pid',$this->pid);
		$criteria->compare('news_id',$this->news_id);
		$criteria->compare('openid',$this->openid,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	protected function beforeSave()
	{
		if(parent::beforeSave()){
			if($this->isNewRecord){
				$this->address = Yii::app()->request->userHostAddress;
				$this->created_at = time();
				$this->openid = Yii::app()->user->id;
			}
			return true;
		}
		return false;
	}
}