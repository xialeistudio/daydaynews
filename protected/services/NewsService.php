<?php

class NewsService extends Service
{
	/**
	 * @param string $className
	 * @return NewsService
	 */
	public static function instance($className = __CLASS__)
	{
		return parent::instance($className);
	}

	public function fetch()
	{
		return 221;
	}

	/**
	 * 加载分类
	 * @return Category[]
	 */
	public function loadCategory()
	{
		$data = Yii::app()->cache->get('category');
		if (empty($data))
		{
			$data = Category::model()->findAll('display = 1');
			Yii::app()->cache->set('category', $data);
		}
		return $data;
	}


	/**
	 * Ubb2html
	 * @param $msg
	 * @return mixed
	 */
	public function ubb2html($msg)
	{
		$msg = preg_replace("/\\t/is", "  ", $msg);
		$msg = preg_replace("/\[h1\](.+?)\[\/h1\]/is", "<h1>\\1</h1>", $msg);
		$msg = preg_replace("/\[h2\](.+?)\[\/h2\]/is", "<h2>\\1</h2>", $msg);
		$msg = preg_replace("/\[h3\](.+?)\[\/h3\]/is", "<h3>\\1</h3>", $msg);
		$msg = preg_replace("/\[h4\](.+?)\[\/h4\]/is", "<h4>\\1</h4>", $msg);
		$msg = preg_replace("/\[ul\](.+?)\[\/ul\]/is", "<ul>\\1</ul>", $msg);
		$msg = preg_replace("/\[li\](.+?)\[\/li\]/is", "<li>\\1</li>", $msg);
		$msg = preg_replace("/\[url\](http:\/\/.+?)\[\/url\]/is", "<a href=\"\\1\"  target=\"_blank\">\\1</a>", $msg);
		$msg = preg_replace("/\[url\](.+?)\[\/url\]/is", "<a href=\"http://\\1\"  target=\"_blank\">http://\\1</a>", $msg);
		$msg = preg_replace("/\[url=(http:\/\/.+?)\](.*)\[\/url\]/is", "<a href=\"\\1\"  target=\"_blank\">\\2</a>", $msg);
		$msg = preg_replace("/\[url=(.+?)\](.*)\[\/url\]/is", "<a href=http://\"\\1\"  target=\"_blank\">\\2</a>", $msg);
		$msg = preg_replace("/\[img\](.+?)\[\/img\]/is", "<img src=\"\\1\">", $msg);
		$msg = preg_replace("/\[upload=gif\](.+?)\[\/upload\]/is", "<img  border=\"0\"  src=\"\\1\">", $msg);
		$msg = preg_replace("/\[upload=jpg\](.+?)\[\/upload\]/is", "<img  border=\"0\"  src=\"\\1\">", $msg);
		$msg = preg_replace("/\[center\](.+?)\[\/center\]/is", " <div align=\"center\">\\1</div>", $msg);
		$msg = preg_replace("/\[sound\](.+?)\[\/sound\]/is", "<bgsound src=\\1>", $msg);
		$msg = preg_replace("/\[color=(.+?)\](.+?)\[\/color\]/is", "<font color=\\1>\\2</font>", $msg);
		$msg = preg_replace("/\[size=(.+?)\](.+?)\[\/size\]/is", "<font size=\\1>\\2</font>", $msg);
		$msg = preg_replace("/\[sup\](.+?)\[\/sup\]/is", "<sup>\\1</sup>", $msg);
		$msg = preg_replace("/\[sub\](.+?)\[\/sub\]/is", "<sub>\\1</sub>", $msg);
		$msg = preg_replace("/\[pre\](.+?)\[\/pre\]/is", "<pre>\\1</pre>", $msg);
		$msg = preg_replace("/\[email\](.+?)\[\/email\]/is", "<a href=mailto:\\1>\\1</a>", $msg);
		$msg = preg_replace("/\[i\](.+?)\[\/i\]/is", "<i>\\1</i>", $msg);
		$msg = preg_replace("/\[i=s\](.+?)\[\/i\]/is", "<i>\\1</i>", $msg);
		$msg = preg_replace("/\[b\](.+?)\[\/b\]/is", "<b>\\1</b>", $msg);
		$msg = preg_replace("/\[u\](.+?)\[\/u\]/is", "<u>\\1</u>", $msg);
		$msg = preg_replace("/\[strike\](.+?)\[\/strike\]/is", "<strike>\\1</strike>", $msg);
		$msg = preg_replace("/\[marquee\](.+?)\[\/marquee\]/is", "<marquee>\\1</marquee>", $msg);
		$msg = preg_replace("/\[quote\](.+?)\[\/quote\]/is", "<blockquote>引用:</font><hr>\\1<hr></blockquote>", $msg);
		$msg = preg_replace("/\[code\](.+?)\[\/code\]/is", "<blockquote><font size='1' face='Times New Roman'>code:</font><hr color='lightblue'><i>\\1</i><hr color='lightblue'></blockquote>", $msg);
		$msg = preg_replace("/\[sig\](.+?)\[\/sig\]/is", "<div style='text-align: left; color: darkgreen; margin-left: 5%'>--------------------------\\1--------------------------</div>", $msg);
		return $msg;
	}

	/**
	 * 获取分类信息
	 * @param int $id
	 * @return CActiveRecord|mixed
	 */
	public function showCategory($id = 0)
	{
		$data = Yii::app()->cache->get('category-' . $id);
		if (empty($data))
		{
			$data = Category::model()->findByPk($id);
			Yii::app()->cache->set('category-' . $id, $data);
		}
		return $data;
	}


	/**
	 * 获取文章列表
	 * @param int $category_id
	 * @param int $page
	 * @param int $pageSize
	 * @return array
	 */
	public function newsList($category_id = 0, $page = 1, $pageSize = 20)
	{
		$criteria = new CDbCriteria();
		if ($category_id > 0)
		{
			$criteria->condition = 'category_id = :category_id';
			$criteria->params = array(
				':category_id' => $category_id
			);
		}
		$count = News::model()->count($criteria);
		$criteria->order = 'collected_at DESC';
		$criteria->offset = ($page - 1) * $pageSize;
		$criteria->limit = $pageSize;
		$key = "news-category-$category_id-offset-{$criteria->offset}-limit-$pageSize";
		$data = Yii::app()->cache->get($key);
		if (empty($data))
		{
			$data = News::model()->findAll($criteria);
			Yii::app()->cache->set($key, $data, 3600);
		}
		return array(
			'total' => $count,
			'data' => $data
		);
	}

	/**
	 * 读取文章
	 * @param int $id
	 * @return CActiveRecord|mixed
	 */
	public function getNews($id = 0)
	{
		$key = 'news-' . $id;
		$data = Yii::app()->cache->get($key);
		if (empty($data))
		{
			$data = News::model()->findByPk($id);
			//缓存文章正文10分钟
			Yii::app()->cache->set($key, $data,600);
		}
		$this->hits($data);
		return $data;
	}

	/**
	 * 分享+1
	 * @param $news News
	 * @return mixed
	 */
	public function share($news)
	{
		$news->share = $news->share + 1;
		$news->save();
		return $news;
	}

	/**
	 * 点击数+1
	 * @param $news News
	 * @return mixed
	 */
	public function hits($news)
	{
		//访问量+1
		$check = Yii::app()->cache->get('news-' . $news->news_id - 'id-' . Yii::app()->request->userHostAddress);
		if (empty($check))
		{
			$news->hits = $news->hits + 1;
			$news->save();
			Yii::app()->cache->set('news-' . $news->news_id - 'id-' . Yii::app()->request->userHostAddress, 1);
		}
		return $news;
	}
} 