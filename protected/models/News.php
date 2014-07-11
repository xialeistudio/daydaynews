<?php

/**
 * This is the model class for table "news".
 *
 * The followings are the available columns in table 'news':
 * @property integer $news_id
 * @property string $title
 * @property string $description
 * @property string $thumb
 * @property string $content
 * @property integer $hits
 * @property integer $share
 * @property integer $state
 * @property string $wechat
 * @property integer $created_at
 * @property integer $collected_at
 * @property integer $category_id
 *
 * The followings are the available model relations:
 * @property Comment[] $comments
 * @property Category $category
 */
class News extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return News the static model class
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
		return 'news';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('category_id', 'required'),
			array('hits, share, state, created_at, collected_at, category_id', 'numerical', 'integerOnly'=>true),
			array('title, wechat', 'length', 'max'=>40),
			array('description', 'length', 'max'=>100),
			array('thumb', 'length', 'max'=>128),
			array('content', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('news_id, title, description, thumb, content, hits, share, state, wechat, created_at, collected_at, category_id', 'safe', 'on'=>'search'),
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
			'comments' => array(self::HAS_MANY, 'Comment', 'news_id'),
			'category' => array(self::BELONGS_TO, 'Category', 'category_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'news_id' => 'News',
			'title' => 'Title',
			'description' => 'Description',
			'thumb' => 'Thumb',
			'content' => 'Content',
			'hits' => 'Hits',
			'share' => 'Share',
			'state' => 'State',
			'wechat' => 'Wechat',
			'created_at' => 'Created At',
			'collected_at' => 'Collected At',
			'category_id' => 'Category',
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

		$criteria->compare('news_id',$this->news_id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('thumb',$this->thumb,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('hits',$this->hits);
		$criteria->compare('share',$this->share);
		$criteria->compare('state',$this->state);
		$criteria->compare('wechat',$this->wechat,true);
		$criteria->compare('created_at',$this->created_at);
		$criteria->compare('collected_at',$this->collected_at);
		$criteria->compare('category_id',$this->category_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}