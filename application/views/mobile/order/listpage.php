<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>我的订单</title>
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
	<header class="wy-header"
		style="position: fixed; top: 0; left: 0; right: 0; z-index: 200;">
		<div class="wy-header-icon-back">
			<span></span>
		</div>
		<div class="wy-header-title">订单列表</div>
	</header>
	<div class='weui-content'>
		<div class="weui-tab">
			<div class="weui-navbar"
				style="position: fixed; top: 44px; left: 0; right: 0; height: 44px; background: #fff; padding-left: 10px;">
				<form action="<?=base_url()?>order/listpage" method="get">
					<a class="weui-navbar__item proinfo-tab-tit font-14 "><select
						name="is_finish">
							<option value="">全部</option>
							<option value="1">已完成</option>
							<option value="0">未完成</option>
					</select> <input type="submit" value="查询" class="ords-btn-com" /></a>
				</form>
			</div>
			<div class="weui-tab__bd proinfo-tab-con" style="padding-top: 87px;">
				<div id="tab1" class="weui-tab__bd-item weui-tab__bd-item--active">
				 <? $n = 0; ?>
                <? if(!empty($orders)) {?>
                <? foreach($orders as $k => $v){ ?>
                    <? $n ++; ?>
                   <div class="weui-panel weui-panel_access">
						<div class="weui-panel__hd">
							<span>日期：<?=substr($v->stock_time, 0, 19);?></span><span
								class="ord-status-txt-ts fr"><?=$v->is_finished==true?"已完成":"未完成";?></span>
						</div>
						<div class="weui-media-box__bd  pd-10">
							<div class="weui-media-box_appmsg ord-pro-list">
								<div class="weui-media-box__bd">
									<h1 class="weui-media-box__desc">
										<a  class="ord-pro-link">联系用户：<?=$v->linkman?></a>
									</h1>
									<h1 class="weui-media-box__desc">
										<a  class="ord-pro-link">联系电话：<?=$v->mobile?></a>
									</h1>
									
									
								</div>
							</div>
						</div>
						<div class="ord-statistics">
							<span>共<em class="num"><?=$v->quantity;?></em>件，
							</span><span class="wy-pro-pri">总金额：<em class="num font-15"><?=cny($v->amount)?></em></span>
							<span>(不含运费<b><?=cny($v->post_fee)?></b>)
							</span>
						</div>
						<div class="weui-panel__ft">
							<div
								class="weui-cell weui-cell_access weui-cell_link oder-opt-btnbox">
								<a class="ords-btn-deles"
									href="<?=base_url()?>order/details/<?=$v->id;?>">查看详情</a>
								<? if($v->is_pay == false && $v->pay_method == 'alipay') {?>
                            <a class="ords-btn-com"
									href="<?=base_url()?>order/pay_method/<?=$v->id?>">付款</a>
                            <? } ?>
							</div>
						</div>
					</div>
                <? } ?>
                <? } ?>
					

				</div>



			</div>
		</div>
	</div>
	</div>

	<script src="<?=base_url();?>assets/Mobilecss/lib/jquery-2.1.4.js"></script>
	<script src="<?=base_url();?>assets/Mobilecss/lib/fastclick.js"></script>
	<script>
  $(function() {
    FastClick.attach(document.body);
  });
</script>
	<script src="<?=base_url();?>assets/Mobilecss/js/jquery-weui.js"></script>
	<script>

      $(document).on("click", ".ords-btn-dele", function() {
        $.confirm("您确定要删除此订单吗?", "确认删除?", function() {
          $.toast("订单已经删除!");
        }, function() {
          //取消操作
        });
      });
	  $(document).on("click", ".receipt", function() {
        $.alert("五星好评送蓝豆哦，赶快去评价吧！", "收货完成！");
      });

    </script>
</body>
</html>
