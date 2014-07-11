<?php

class SiteController extends Controller
{
	public function actionIndex()
	{
		echo 1;
	}

	public function actionImport()
	{
		$data = CHtml::encodeArray($_POST);
		//检查文章标题
		$news = News::model()->findByAttributes(array('title' => $data['title']));
		if (!empty($news))
		{
			die('文章已存在');
		}
		else
		{
			$data['content'] = NewsService::instance()->ubb2html($data['content']);
			$news = new News();
			$news->attributes = array(
				'title' => $data['title'],
				'description' => mb_substr(trim(strip_tags($data['content'])), 0, 20, 'UTF-8'),
				'thumb' => $data['thumb'],
				'content' => $data['content'],
				'wechat' => $data['wechat'],
				'created_at' => strtotime($data['created_at']),
				'category_id' => $data['category_id'],
				'collected_at' => time(),
			);
			$news->save();
			if (empty($news->errors))
			{
				echo 1;
			}
			else
			{
				$error = array_shift($news->errors);
				echo $error[0];
			}
		}
	}

	public function actionCategories()
	{
		$data = NewsService::instance()->loadCategory();
		echo CJSON::encode($data);
	}

	public function actionCategory($id = 0)
	{
		echo CJSON::encode(NewsService::instance()->showCategory($id));
	}

	public function actionList($id = 0, $page = 1, $size = 20)
	{
		echo CJSON::encode(NewsService::instance()->newsList($id, $page, $size));
	}

	public function actionNews($id = 0)
	{
		echo CJSON::encode(NewsService::instance()->getNews($id));
	}

	public function actionShare($id = 0)
	{
		echo CJSON::encode(NewsService::instance()->share(NewsService::instance()->getNews($id)));
	}
}