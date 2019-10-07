<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>结算报表</title>
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
<body ontouchstart>
	<!--主体-->
	<header class="wy-header">
		<div class="wy-header-icon-back" onclick="javascript:window.history.go(-1)">
			<span></span>
		</div>
		<div class="wy-header-title">结算报表</div>
		<script>
                    if("<?=$this->session->flashdata('flashdata', 'value');?>"!="")
                        alert("<?=$this->session->flashdata('flashdata', 'value');?>");
                </script>
	</header>
	<div class="weui-content">
	 <? $n = 0; ?>
                    <? if (!empty($logs)) {?>
                        <? foreach($logs as $k => $v){ ?>
                            <? $n ++; ?>
                        <div class="weui-panel">
			<div class="weui-panel__hd">日期：<?=$v->date?></div>
			<div class="weui-panel__bd">
				<div class="weui-media-box weui-media-box_text">

					<ul class="weui-media-box__info">
						<li class="weui-media-box__info__meta">结算金额：<em class="num"><?=cny($v->volume)?></em></li>

					</ul>
					<ul class="weui-media-box__info">
						<li class="weui-media-box__info__meta">结算前余额：<em class="num"><?=cny($v->balance_before);?></em></li>
						<li
							class="weui-media-box__info__meta weui-media-box__info__meta_extra">结算后余额：<em
							class="num">￥<?=bcsub(money($v->balance_before), money($v->volume), 2);?></em></li>
					</ul>
				</div>
			</div>
		</div>
                        <? } ?>
                    <? } ?>
		


	</div>
	<div class="page"><?=$page;?></div>
</body>
</html>
