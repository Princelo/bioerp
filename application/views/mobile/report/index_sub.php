<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>下级报表</title>
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

<link rel="stylesheet"
	href="<?=base_url();?>assets/dist/themes/custom/style.css" />
</head>
<body ontouchstart>
	<!--主体-->
	<header class="wy-header">
		<div class="wy-header-icon-back">
			<span></span>
		</div>
		<div class="wy-header-title">下级报表</div>
	</header>
	<div class="weui-content">
		<div class="weui-cells weui-cells_form wy-address-edit">
			<form action="<?=base_url()?>report/index_sub" method="get">

				<div class="weui-cell weui-cell_vcode">
					<div class="weui-cell__hd">搜索：</div>
					<div class="weui-cell__bd">
						<input type="text" name="search" value="<?=set_value('search')?>" />
					</div>
					<div class="weui-cell__ft">
						<input class="weui-vcode-btn  classinput" type="submit" />
					</div>
				</div>
			</form>
		</div>

	</div>
	<div class="weui-content">
	 <? $n = 0; ?>
                    <? if(!empty($users)) {?>
                        <? foreach($users as $k => $v){ ?>
                            <? $n ++; ?>
                        <div class="weui-panel">
			<div class="weui-panel__hd">用戶名：<?=$v->username;?></div>
			<div class="weui-panel__bd">
				<div class="weui-media-box weui-media-box_text">

					<ul class="weui-media-box__info">
						<li class="weui-media-box__info__meta">业绩支出：<em class="num"><?=cny($v->turnover)?></em></li>

					</ul>
					<ul class="weui-media-box__info">
						<li class="weui-media-box__info__meta">他的收益：<em class="num"><?=cny($v->profit)?></em></li>
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