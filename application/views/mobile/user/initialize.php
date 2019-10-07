<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>马上付款成为正式代理</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport"
	content="width=device-width, initial-scale=1, user-scalable=no">
<meta name="description"
	content="Write an awesome description for your new site here. You can edit this line in _config.yml. It will appear in your document head meta (for Google search results) and in your feed.xml site description.
">
<link rel="stylesheet"
	href="<?=base_url();?>assets/Mobilecss/lib/weui.min.css">
<link rel="stylesheet"
	href="<?=base_url();?>assets/Mobilecss/css/jquery-weui.css">
<link rel="stylesheet"
	href="<?=base_url();?>assets/Mobilecss/css/style.css">
</head>

<script type="text/javascript">
	//调用微信JS api 支付
	function jsApiCall()
	{
		WeixinJSBridge.invoke(
			'getBrandWCPayRequest',
			<?=$jsApiParameters?>,
			function(res){
				//alert(res.err_code+res.err_desc+res.err_msg)
				//WeixinJSBridge.log(res.err_msg);
				//alert(res.err_code+res.err_desc+res.err_msg);
				 if(res.err_msg == 'get_brand_wcpay_request:cancel')
				 {
					 //处理取消支付的事件逻辑NaNget_brand_wcpay_request:ok
			    	  alert('取消支付');
				}
				else if(res.err_msg == "get_brand_wcpay_request:ok")
			    {
					 alert('支付成功');
					 window.location.href='http://erp.gzybsw.cn/user/return_wxpay';
					 /*使用以上方式判断前端返回,微信团队郑重提示：
					 res.err_msg将在用户支付成功后返回 ok，但并不保证它绝对可靠。
					 这里可以使用Ajax提交到后台，处理一些日志，如Test控制器里面的ajax_PaySuccess方法。
					 */
					
			    }
				else
				{
					alert('支付失败');
					 //alert('支付成功');
					 //window.location.href='http://erp.gzybsw.cn';
					// alert('支付成功');
					// alert(res.err_code+res.err_desc+res.err_msg);
			   }
			}
		);
	}

	function callpay()
	{
		if (typeof WeixinJSBridge == "undefined"){
		    if( document.addEventListener ){
		        document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
		    }else if (document.attachEvent){
		        document.attachEvent('WeixinJSBridgeReady', jsApiCall); 
		        document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
		    }
		}else{
		    jsApiCall();
		}
	}
	</script>
	

<body>
	<!--主体-->
	<header class="wy-header">
		<div class="wy-header-icon-back" onclick="javascript:window.history.go(-1)">
			<span></span>
		</div>
		<div class="wy-header-title">马上付款成为正式代理</div>
	</header>
	<div class="weui-content">
		<div class="weui-panel">
			<div class="weui-panel__bd">
				<div class="weui-media-box weui-media-box_small-appmsg">
					<div class="weui-cells">

						<div class="weui-cell weui-cell_access" href="javascript:;">
							<div class="weui-cell__bd weui-cell_primary">
								<p class="font-14">
									<span class="mg-r-10">加入代理费用</span><span
										class="fr txt-color-red">￥<em class="num"><?=cny($pay_amt)?></em></span>
								</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="wy-media-box weui-media-box_text">
			<div class="mg10-0 t-c">
				总金额：<span class="wy-pro-pri mg-tb-5"><em class="num font-20">￥<?=cny($pay_amt)?></em></span>
			</div>
			<div class="mg10-0">
				<a onclick="callpay()" class="weui-btn weui-btn_primary">微信付款</a>
			</div>
		</div>
	</div>




</body>
</html>
