<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>月报表增量</title>
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
		<div class="wy-header-icon-back">
			<span></span>
		</div>
		<div class="wy-header-title">月报表增量<?if(isset($bills[0])):?>(<?=  date('Y-M', strtotime($bills[0]->date_from))?> - <?=date('Y-M', strtotime($bills[0]->date_to))?>)<?endif?></div>
		<script>
                    if("<?=$this->session->flashdata('flashdata', 'value');?>"!="")
                        alert("<?=$this->session->flashdata('flashdata', 'value');?>");
                </script>
	</header>
	<div class="weui-content">
	 <? $n = 0; ?>
                    <? foreach($bills as $k => $v){ ?>
                        <? $n ++; ?>
                        <div class="weui-panel">
			<div class="weui-panel__hd">日期：<?=$v->date?></div>
			<div class="weui-panel__bd">
				<div class="weui-media-box weui-media-box_text">

					<ul class="weui-media-box__info">
						<li class="weui-media-box__info__meta">自身业绩：<em class="num"><?=cny($v->self_turnover)?></em></li>
						<li
							class="weui-media-box__info__meta weui-media-box__info__meta_extra">收益(不含推荐)：<em
							class="num"><?=cny($v->normal_return_profit_sub2self)?></em></li>
					</ul>
					<ul class="weui-media-box__info">
						<li class="weui-media-box__info__meta">下级业绩：<em class="num"><?=cny($v->sub_turnover)?></em></li>
						<li
							class="weui-media-box__info__meta weui-media-box__info__meta_extra">收益(推荐收益)：<em
							class="num"><?=cny($v->extra_return_profit_sub2self)?></em></li>
					</ul>
				</div>
			</div>
		</div>
                    <? } ?>
		


	</div>
 <div class="page"><?=$page;?></div>
</body>
</html>
