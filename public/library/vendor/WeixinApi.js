var onBridgeReady = function () {
	if (typeof WeixinJSBridge == 'undefined') return;
	WeixinJSBridge.on('menu:share:appmessage', function (argv) {
		WeixinJSBridge.invoke('sendAppMessage', {
			"appid": dataForWeixin.appId,
			"img_url": dataForWeixin.MsgImg,
			"img_width": "400",
			"img_height": "400",
			"link": dataForWeixin.link,
			"desc": dataForWeixin.desc,
			"title": dataForWeixin.title
		}, function (res) {
			dataForWeixin.callback && dataForWeixin.callback();
		});
	});

	WeixinJSBridge.on('menu:share:timeline', function (argv) {
		WeixinJSBridge.invoke('shareTimeline', {
			"img_url": dataForWeixin.TLImg,
			"img_width": "400",
			"img_height": "400",
			"link": dataForWeixin.link,
			"desc": dataForWeixin.desc,
			"title": dataForWeixin.title + " - " + dataForWeixin.desc
		}, function (res) {
			dataForWeixin.callback && dataForWeixin.callback();
		});
	});

	WeixinJSBridge.on('menu:share:weibo', function (argv) {
		WeixinJSBridge.invoke('shareWeibo', {
			"content": dataForWeixin.title + "" + "-" + dataForWeixin.desc + ' ' + dataForWeixin.link,
			"url": dataForWeixin.link,
			"img_url": dataForWeixin.MsgImg,
			"pic": dataForWeixin.MsgImg,
			"img": dataForWeixin.MsgImg
		}, function (res) {
			dataForWeixin.callback && dataForWeixin.callback();
		});
	});
	WeixinJSBridge.on('menu:share:facebook', function (argv) {
		dataForWeixin.callback && dataForWeixin.callback();
		WeixinJSBridge.invoke('shareFB', {
			"img_url": dataForWeixin.TLImg,
			"img_width": "400",
			"img_height": "400",
			"link": dataForWeixin.link,
			"desc": dataForWeixin.desc,
			"title": document.title
		}, function (res) {
		});
	});
};

if (document.addEventListener) {
	document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
} else if (document.attachEvent) {
	document.attachEvent('WeixinJSBridgeReady', onBridgeReady);
	document.attachEvent('onWeixinJSBridgeReady', onBridgeReady);
}

document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
	try {
		if (typeof WeixinJSBridge == 'undefined') return;
	}
	catch (e) {
	}
});
