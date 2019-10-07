<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>订单结算</title>
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


<!-- ********** PHPJS ********** -->
<!--<script type="text/javascript" src="http://erp.gzybsw.cn/assets/js/php.default.namespaced.min.js"></script>


    <!-- ********** Custom JS ********** -->
<script type="text/javascript"
	src="http://erp.gzybsw.cn/assets/js/general.js"></script>


<!-- Css -->
<!--
    -->

<link rel="stylesheet" href="<?=base_url();?>assets/layout.css"
	type="text/css">




<!-- ********** JSCal2 ********** -->
<!--<link type="text/css" rel="stylesheet" href="http://erp.gzybsw.cn/assets/jscal2.css" />
    <link type="text/css" rel="stylesheet" href="http://erp.gzybsw.cn/assets/border-radius.css" />
    <link type="text/css" rel="stylesheet" href="http://erp.gzybsw.cn/assets/reduce-spacing.css" />
    <!--<script type="text/javascript" src="http://erp.gzybsw.cn/assets/js/jscal2.js"></script>
    <script type="text/javascript" src="http://erp.gzybsw.cn/assets/js/en.js"></script>-->
<!--<script type="text/javascript" src="http://erp.gzybsw.cn/assets/js/jquery.timepicker.js"></script>
    -->
<script src="<?=base_url();?>assets/js/jquery-ui.js"></script>
<script src="<?=base_url();?>assets/js/jquery-birthday-picker.js"></script>
<link rel="stylesheet" href="<?=base_url();?>assets/css/jquery-ui.css" />

<!-- Clock Picker -->
<!--<script type="text/javascript" src="http://erp.gzybsw.cn/assets/jquery.clockpick.1.2.7.js"></script>
    <link type="text/css" rel="stylesheet" href="http://erp.gzybsw.cn/assets/js/jquery.clockpick.1.2.7.css"/>

    <!-- ********** :: Animated jQuery Menu Style 08  ********** -->


<!-- ********** :: colorbox-master  ********** -->
<!--<link rel="stylesheet" href="http://erp.gzybsw.cn/assets/colorbox.css" />
    <script type="text/javascript" src="http://erp.gzybsw.cn/assets/js/jquery.colorbox.js"></script>

    <!-- Freeze Header  ********** -->
<!--<script type="text/javascript" src="http://erp.gzybsw.cn/assets/js/jquery.freezeheader.js"></script>

    <!-- Mobile Detector  ********** -->
<!--<script type="text/javascript" src="http://erp.gzybsw.cn/assets/js/detectmobilebrowser.js"></script>-->
<script src="<?=base_url();?>assets/js/verify.notify.js"></script>
</head>
<body ontouchstart>
	<!--主体-->
	<header class="wy-header">
		<div class="wy-header-icon-back">
			<span></span>
		</div>
		<div class="wy-header-title">订单详情</div>
	</header>
	   <?=form_open_multipart('order/add');?>
            <input name="token" value="<?=$token?>" type="hidden" />
	<div class="weui-content">
		<div class="weui-cells weui-cells_form wy-address-edit">
			<div class="weui-cell">
				<div class="weui-cell__hd">
					<label class="weui-label wy-lab">订单联系人 </label>
				</div>
				<div class="weui-cell__bd">
					<input class="weui-input" name="contact" data-validate="required"
						value="<?=set_value('contact')?>" />
				</div>
			</div>
			<div class="weui-cell">
				<div class="weui-cell__hd">
					<label class="weui-label wy-lab">联系电话</label>
				</div>
				<div class="weui-cell__bd">
					<input class="weui-input" name="mobile" data-validate="required"
						value="<?=set_value('mobile')?>" />
				</div>
			</div>
			<div class="weui-cell">
				<div class="weui-cell__hd">
					<label class="weui-label wy-lab">付款方式</label>
				</div>
				<div class="weui-cell__bd">
					<select name="pay_method" class="weui-input">
						<option value="alipay">线上付款</option>
						<option value="offline">线下付款</option>
					</select>
				</div>
			</div>

			<div class="weui-cell">
				<div class="weui-cell__hd">
					<label class="weui-label wy-lab">收货方式</label>
				</div>
				<div class="weui-cell__bd">
					<select name="is_post" id="is_post" class="weui-input">
						<option value="0"
							<?//=$is_post==false?"selected=\"selected\"":"";?>>自取</option>
						<option value="1"
							<?//=$is_post==true?"selected=\"selected\"":"";?>>快递</option>
					</select>
				</div>
			</div>
			<script>
                        $("#is_post").change(function(){
                            if($(this).val() == "1"){
                                $("#address").show();
                            }else{
                                $("#address").hide();
                            }
                        });
               </script>
			<div style="display: none;" id="address">
				<div class="weui-cell">
					<div class="weui-cell__hd">
						<label class="weui-label wy-lab">省份</label>
					 <?
    $provinces = getArrCity()->provinces;
    ?>
				</div>
					<div class="weui-cell__bd">
						<select name="province_id" class="provinceSelect weui-input">
                                <?foreach($provinces as $k => $v){?>
                                    <option value="<?=$v->id?>"><?=$v->name?></option>
                                <?}?>
                            </select>
					</div>
					<input value="<?=$str?>" name="cart_info" type="hidden" />
				</div>
				<div class="weui-cell">
					<div class="weui-cell__hd">
						<label class="weui-label wy-lab">市</label>

					</div>
					<div class="weui-cell__bd">
						<select name="city_id" class="citySelect weui-input">
							<option value="?">北京市</option>
						</select>
					</div>

				</div>
				<div class="weui-cell">
					<div class="weui-cell__hd">
						<label class="weui-label wy-lab">地址</label>

					</div>
					<div class="weui-cell__bd">

						<input class="weui-input" name="address_info"
							data-validate="required" value="<?=set_value('address_info')?>" />
					</div>

				</div>
			</div>
			<div class="weui-cell">
				<div class="weui-cell__hd">
					<label class="weui-label wy-lab">备注</label>
				</div>
				<div class="weui-cell__bd">
					<input class="weui-input" name="remark" data-validate="max(100)"
						value="<?=set_value('remark')?>" maxlength="100" size="30" />
				</div>
			</div>
		</div>
		<div class="wy-media-box weui-media-box_text">
			<div class="weui-media-box__bd">
				<div class="weui-media-box_appmsg ord-pro-list">
				 <? $total = 0;?>
                    <? $n = 0; ?>
                    <?foreach($products as $k => $v){?>
                        <? if(array_key_exists($v->pid, $products_quantity)):?>
                            <? $n ++; ?>
                            <?$total = bcadd($total, bcmul(money($v->unit_price), $products_quantity[$v->pid], 2), 2)?>
                       
                            <div class="weui-media-box__bd">
						<h1 class="weui-media-box__desc">
							<a href="pro_info.html" class="ord-pro-link"><?=$v->title?> (<?=cny($v->unit_price)?>)</a>
						</h1>

						<div class="clear mg-t-10">
							<div class="wy-pro-pri fl">
								<em class="num font-15">总价：￥<?=bcmul(money($v->unit_price), $products_quantity[$v->pid], 2)?></em>
							</div>
							<div class="pro-amount fr">
								<span class="font-13">数量×<em class="name"><?=$products_quantity[$v->pid]?></em></span>
							</div>
						</div>
					</div>
				</div>
                        <? endif ?>
                    <?}?>
					
			</div>
		</div>
		<div class="weui-panel">
			<div class="weui-panel__bd">
				<div class="weui-media-box weui-media-box_small-appmsg">
					<div class="weui-cells">

						<div class="weui-cell weui-cell_access" href="javascript:;">
							<div class="weui-cell__bd weui-cell_primary">
								<p class="font-14">
									<span class="mg-r-10">购物车总价(不含运费)</span><span
										class="fr txt-color-red">￥<em class="num">￥<?=$total?></em></span>
								</p>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
		<div class="wy-media-box weui-media-box_text">
			<div class="mg10-0">
				<input type="submit" name="btnSubmit" value="提交 "
					class="weui-btn weui-btn_primary" />
			</div>
		</div>
	</div>
	  <?=form_close();?>
	  
	   <script>
        $(".citySelect").html('<option value="2">北京市</option>');
        var city = <?=getJsonCity();?>;
        city = city.provinces;
        var optionhtml = "";
        $(".provinceSelect").change(function(){
            optionhtml = "";
            for(var key in city){
                if(city[key].id == $('.provinceSelect').val()){
                    for(var ikey in city[key].cities)
                        for(var iikey in city[key].cities[ikey])
                            optionhtml += "<option value=\""+iikey+"\">"+city[key].cities[ikey][iikey]+"</option>";
                }
            }
            $(".citySelect").html(optionhtml);
        });
    </script>

</body>
</html>
