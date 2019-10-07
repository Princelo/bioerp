<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>产品列表</title>
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
		<div class="wy-header-title">产品列表</div>
	</header>
	<div class="weui-content">
<? $n = 0; ?>
                <? if(!empty($products)) {?>
                <? foreach($products as $k => $v){ ?>
                    <? $n ++; ?>
                    <div class="weui-panel weui-panel_access">
			<div class="weui-panel__hd">
				<span><a href="<?=base_url()?>product/details/<?=$v->id;?>"><?=getCategoryName($v->category)?></a></span><a
					href="javascript:void(0);" onclick="addtocart(<?=$v->id?>)"
					class="wy-addcart">加入购物车</a>
			</div>
			<div class="weui-panel__bd">
				<div class="weui-media-box_appmsg pd-10">
					<div class="weui-media-box__hd">
						<a href="<?=base_url()?>product/details/<?=$v->id;?>"><img class="weui-media-box__thumb"
							src="<?=$v->thumb?>" alt=""></a>
					</div>
					<div class="weui-media-box__bd">
						<h1 class="weui-media-box__desc">
							<a href="pro_info.html" class="ord-pro-link"><?=$v->title?></a>
						</h1>
						<p class="weui-media-box__desc">
							规格：<span><?=$v->properties;?></span>
						</p>
						<div class="clear mg-t-10">
							<div class="wy-pro-pri fl">
								<span style="text-decoration: line-through;"><?=cny($v->price)?></span>
								<em class="num font-15"><?=cny($v->discount_price)?></em>
							</div>
							<div class="pro-amount fr">
								<div class="Spinnernew">
									<a class="DisDe" href="javascript:void(0);" class="decrease"
										onclick="decrease(<?=$v->id?>)"><i>-</i></a> <input
										class="Amount classinput" value="1" name="product<?=$v->id?>"
										id="quantity-<?=$v->id?>"> <a class="Increase"
										href="javascript:void(0);" class="increase"
										onclick="increase(<?=$v->id?>)"><i>+</i></a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>               
                <? } ?>
                <? } ?>
 
  
</div>
	<script>
                var addtocart = function(id){
                    if(parseInt($("input[name=\"product"+id+"\"]").val()) <= 0)
                    {
                        alert('入货数量必须大于零');
                        return false;
                    }
                    $.post("<?=base_url()?>order/addtocart", { "product_id": id + "", "is_trial": "false", "quantity": $("input[name=\"product"+id+"\"]").val()  },
                        function(data){
                            alert(data.info);
                        }, "json");
                    return false;
                }
                var increase = function(id)
                {
                    $("#quantity-"+id).val(parseInt($("#quantity-" + id).val()) + 1);
                    return false;
                }
                var decrease = function(id)
                {
                    if($("#quantity-" + id).val() > 1)
                        $("#quantity-"+id).val(parseInt($("#quantity-" + id).val()) - 1);
                    return false;
                }
            </script>
	<!--底部导航-->
	<div class="foot-black"></div>
	<div class="weui-tabbar wy-foot-menu">

		<div class="weui-tabbar__item  npd"></div>
		<a href="<?=base_url()?>order/cart" class="red-color npd w-90 t-c">
			<p class="promotion-foot-menu-label">去结算</p>
		</a>
	</div>

	<script src="<?=base_url();?>assets/Mobilecss/lib/jquery-2.1.4.js"></script>
	<script src="<?=base_url();?>assets/Mobilecss/lib/fastclick.js"></script>
	<script type="text/javascript"
		src="<?=base_url();?>assets/Mobilecss/js/jquery.Spinner.js"></script>
	<script>
  $(function() {
    FastClick.attach(document.body);
  });
</script>
	<script type="text/javascript">
$(function(){
	$(".Spinner").Spinner({value:1, len:3, max:999});
});
</script>
	<script src="<?=base_url();?>assets/Mobilecss/js/jquery-weui.js"></script>
	<!---全选按钮-->




</body>
</html>
