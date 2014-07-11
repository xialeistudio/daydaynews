<?php
require_once dirname(__FILE__) . '/lib/rs.php';
require_once dirname(__FILE__) . '/lib/auth_digest.php';
require_once dirname(__FILE__) . '/lib/auth_digest.php';
require_once dirname(__FILE__) . '/lib/io.php';

class Qiniu
{
	public function __construct()
	{
		
	}

	/**
	 * 设置路径
	 * @param $key
	 * @param null $returnUrl
	 * @param null $returnBody
	 * @return string
	 */
	public function getSign($preKey = '', $returnUrl = null, $returnBody = null)
	{
		Qiniu_SetKeys(Yii::app()->params['QINIU_ACCESS_KEY'], Yii::app()->params['QINIU_SECRET_KEY']);
		$putPolicy = new Qiniu_RS_PutPolicy(Yii::app()->params['QINIU_BUCKET']);
		$putPolicy->Expires = 60*30;
		$putPolicy->SaveKey = $preKey.'$(etag)';
		$putPolicy->MimeLimit = 'image/*';

		if($returnUrl!==null)
			$putPolicy->CallbackUrl = $returnUrl;
		
		if($returnBody!==null)
			$putPolicy->CallbackBody = urldecode(http_build_query($returnBody));

		$upToken = $putPolicy->Token(null);
		
		return $upToken;
		
	}

	public function saveFile($token, $filename, $file, $ext = null)
	{
		list($ret, $err) = Qiniu_PutFile($token, $filename, $file, $ext);

		if(!empty($err)) throw new Exception(print_r($err, 1));

		return $ret;
	}

	public function getUrl($key)
	{
		return Yii::app()->params['QINIU_BUCKET_URL'].''.$key;
	}

	
}
