<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>订单详情</title>
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
<!-- ********** jQuery ********** -->

<!--<script type="text/javascript" src="http://erp.gzybsw.cn/assets/js/jquery.1.8.0.min.js"></script>-->
<script type="text/javascript"
	src="http://erp.gzybsw.cn/assets/js/jquery.js"></script>


</head>
<body ontouchstart>
	<!--主体-->
	<header class="wy-header">
		<div class="wy-header-icon-back">
			<span></span>
		</div>
		<div class="wy-header-title">订单详情</div>
	</header>
	 
	<div class="weui-content">
		<div class="weui-cells weui-cells_form wy-address-edit">
			<div class="weui-cell">
				<div class="weui-cell__hd">
					<label class="weui-label wy-lab">ID</label>
				</div>
				<div class="weui-cell__bd">
					<?=$v->id?>
				</div>
			</div>
			<div class="weui-cell">
				<div class="weui-cell__hd">
					<label class="weui-label wy-lab">产品总量</label>
				</div>
				<div class="weui-cell__bd">
					<?=$v->quantity?>
				</div>
			</div>
			<div class="weui-cell">
				<div class="weui-cell__hd">
					<label class="weui-label wy-lab">总价(不含运费)</label>
				</div>
				<div class="weui-cell__bd">
					<?=cny($v->amount)?>
				</div>
			</div>
			<div class="weui-cell">
				<div class="weui-cell__hd">
					<label class="weui-label wy-lab">运费</label>
				</div>
				<div class="weui-cell__bd">
					<?=cny($v->post_fee)?>
				</div>
			</div>
			<div class="weui-cell">
				<div class="weui-cell__hd">
					<label class="weui-label wy-lab">取货方式</label>
				</div>
				<div class="weui-cell__bd">
					<?=$v->is_post==true?"邮寄":"自取"?>
				</div>
			</div>
			<div class="weui-cell">
				<div class="weui-cell__hd">
					<label class="weui-label wy-lab">收货地址</label>
				</div>
				<div class="weui-cell__bd">
					<span class="info important<?=$v->is_post==false?" hidden":''?>"> <?=getStrProvinceName($v->province_id)?>&nbsp;<?=getStrCityName($v->city_id)?>&nbsp;<?=$v->address_info?> </span>
				</div>
			</div>
			<div class="weui-cell">
				<div class="weui-cell__hd">
					<label class="weui-label wy-lab">联系人</label>
				</div>
				<div class="weui-cell__bd">
					<?=$v->linkman?>
				</div>
			</div>
			<div class="weui-cell">
				<div class="weui-cell__hd">
					<label class="weui-label wy-lab">联系电话</label>
				</div>
				<div class="weui-cell__bd">
					<?=$v->mobile?>
				</div>
			</div>
			<div class="weui-cell">
				<div class="weui-cell__hd">
					<label class="weui-label wy-lab">订单备注</label>
				</div>
				<div class="weui-cell__bd">
					<?=$v->remark?>
				</div>
			</div>
			<div class="weui-cell">
				<div class="weui-cell__hd">
					<label class="weui-label wy-lab">订单总价</label>
				</div>
				<div class="weui-cell__bd">
					￥<?=bcadd( money($v->amount), money($v->post_fee), 2)?>
				</div>
			</div>
			<div class="weui-cell">
				<div class="weui-cell__hd">
					<label class="weui-label wy-lab">是否已付款</label>
				</div>
				<div class="weui-cell__bd">
					<?=$v->is_pay==true&&$v->is_correct==true?"是":"否";?>
				</div>
			</div>
			<div class="weui-cell">
				<div class="weui-cell__hd">
					<label class="weui-label wy-lab">付款金额</label>
				</div>
				<div class="weui-cell__bd">
					<?=cny($v->pay_amt)?>
				</div>
			</div>
			<div class="weui-cell">
				<div class="weui-cell__hd">
					<label class="weui-label wy-lab">使用代金券</label>
				</div>
				<div class="weui-cell__bd">
					<?=cny($v->coupon_volume)?>
				</div>
			</div>
			<div class="weui-cell">
				<div class="weui-cell__hd">
					<label class="weui-label wy-lab">使用现金</label>
				</div>
				<div class="weui-cell__bd">
					<?=cny($v->post_fee)?>
				</div>
			</div>
			<div class="weui-cell">
				<div class="weui-cell__hd">
					<label class="weui-label wy-lab">付款方式</label>
				</div>
				<div class="weui-cell__bd">
					<?=$v->pay_method=='alipay'?'线上付款':'线下付款';?>
				</div>
			</div>
			<div class="weui-cell">
				<div class="weui-cell__hd">
					<label class="weui-label wy-lab">付款时间</label>
				</div>
				<div class="weui-cell__bd">
					<?=substr($v->pay_time, 0, 19)?>
				</div>
			</div>
			<div class="weui-cell">
				<div class="weui-cell__hd">
					<label class="weui-label wy-lab">付款数是否正确</label>
				</div>
				<div class="weui-cell__bd">
					<?=$v->is_pay==true&&$v->is_correct==true?"是":"否";?>
				</div>
			</div>
			<div class="weui-cell">
				<div class="weui-cell__hd">
					<label class="weui-label wy-lab">订单取消情況</label>
				</div>
				<div class="weui-cell__bd">
					<?=$v->is_cancelled==true?"已取消":"正常"?>
				</div>
			</div>
			<div class="weui-cell">
				<div class="weui-cell__hd">
					<label class="weui-label wy-lab">订单提交时间</label>
				</div>
				<div class="weui-cell__bd">
					<?=substr($v->stock_time, 0, 19)?>
				</div>
			</div>
			<div class="weui-cell">
				<div class="weui-cell__hd">
					<label class="weui-label wy-lab">是否完成订单</label>
				</div>
				<div class="weui-cell__bd">
					<?=$v->is_finished==true?"是":"否";?>
				</div>
			</div>
			<div class="weui-cell">
				<div class="weui-cell__hd">
					<label class="weui-label wy-lab">完成订单时间</label>
				</div>
				<div class="weui-cell__bd">
					<?=substr($v->finish_time, 0, 19)?>
				</div>
			</div>
		</div>
		
	</div>
	<div class="wy-media-box weui-media-box_text">
		<div class="weui-media-box__bd">
			<div class="weui-media-box_appmsg ord-pro-list">
		<? $n = 0; ?>
                    <? if(!empty($products)) {?>
                        <? foreach($products as $k => $v){ ?>
                            <? $n ++; ?>
                            
                            <div class="weui-media-box__bd">
					<h1 class="weui-media-box__desc">
						<a href="<?=base_url();?>product/details/<?=$v->id?>" class="ord-pro-link"><?=$v->title?></a>
					</h1>

					<div class="clear mg-t-10">
						<div class="wy-pro-pri fl">
							<em class="num font-15">单价：￥<?=$v->amount?></em>
						</div>
						<div class="pro-amount fr">
							<span class="font-13">数量×<em class="name"><?=$v->quantity?></em></span>
						</div>
					</div>
                        <? } ?>
                    <? } ?>
                       
                            
				</div>
			</div>

					
			</div>
	</div>
	

</body>
</html>