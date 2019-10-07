<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>购物车</title>
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

<script type="text/javascript" src="<?=base_url();?>assets/js/jquery.js"></script>

<!-- ********** Custom JS ********** -->
<script type="text/javascript"
	src="<?=base_url();?>assets/js/general.js"></script>
</head>
<body ontouchstart>
	<!--主体-->
	<header class="wy-header">
		<div class="wy-header-icon-back">
			<span></span>
		</div>
		<div class="wy-header-title">购物车</div>
	</header>
	<div class="weui-content">
 <? $n = 0; ?>
            <? $total = 0; ?>
            <? $item = ""; ?>
            <? if(!empty($products)) {?>
                <? foreach($products as $k => $v){ ?>
                    <? $n ++; ?>
<div class="weui-panel weui-panel_access">
			<div class="weui-panel__hd"><?=$v->title;?><span></span><a
					href="<?=base_url()?>order/remove_from_cart/<?=$v->pid?>"
					class="wy-dele"></a>
			</div>
			<div class="weui-panel__bd">
				<div class="weui-media-box_appmsg pd-10">
					<div class="weui-media-box__hd check-w weui-cells_checkbox">

						<div class="weui-cell__hd cat-check">
							<input type="checkbox" class="product-item"
								id="product-<?=$v->pid?>" pid="<?=$v->pid?>" checked="checked">
						</div>

					</div>
					
					<div class="weui-media-box__bd">
						<h1 class="weui-media-box__desc">
							单价：<span><input type="hidden" value="<?=money($v->unit_price)?>"
								class="unit-price" id="price-<?=$v->pid?>"><?="￥".money($v->unit_price);?></span>
						</h1>
						<p class="weui-media-box__desc">
							<div class="wy-pro-pri fl">
								合计： ¥<em class="num font-15"><span class="total"
									pid="<?=$v->pid?>" id="total-<?=$v->pid?>"><?=bcmul($v->quantity, money($v->unit_price), 2)?></span>
								</em>
             <? $total = bcadd($total, bcmul($v->quantity, money($v->unit_price), 2), 2); ?>
            <? $item .= "|" . $v->pid . "," . $v->quantity; ?>
            </div>
						</p>
						<div class="clear mg-t-10">
							
							<div class="pro-amount fr">
								<div class="Spinnernew">
									<a class="DisDe" href="javascript:void(0);"
										onclick="decrease(<?=$v->pid?>)" pid="<?=$v->pid?>"><i>-</i></a>
									<input class="Amount quantity classinput" value="<?=$v->quantity;?>"
										pid="<?=$v->pid?>" id="quantity-<?=$v->pid?>"> <a
										class="Increase" href="javascript:void(0);"
										onclick="increase(<?=$v->pid?>)" pid="<?=$v->pid?>"><i>+</i></a>

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
                    
                <? } ?>
            <? } ?>
  
</div>

		<!--底部导航-->
		<div class="foot-black" style="background-color: #ffffff;">
			<div
				style="color: red; font-weight: bold; font-size: 12px; line-height: 25px; padding-left: 10px; padding-right: 10px; display: none;"
				id="tips">您尚未完成首次交易, 购物车金额需满￥5000(折后￥3000)才能完成交易</div>
		</div>
		<div class="weui-tabbar wy-foot-menu">
			<div class="npd cart-foot-check-item weui-cells_checkbox allselect">
				<label class="weui-cell allsec-well weui-check__label">
					<div class="weui-cell__hd">
						<input type="checkbox" id="selectAll" onclick="" checked="checked">
					</div>
					<div class="weui-cell__bd">
						<p class="font-14">全选</p>
					</div>
				</label>
			</div>
			<div class="weui-tabbar__item  npd">
				<p class="cart-total-txt">
					合计：<i>￥</i><em class="num font-16" id="zong1"><span
						id="global-total"><?=money($total)?></span></em>



				</p>
			</div>
			<form action="<?=base_url()?>order/add_by_cart" method="post">


				<input value="<?=substr($item, 1)?>" id="select-items" type="hidden"
					name="items" /> <a class="red-color npd w-90 t-c"> <input
					class="promotion-foot-menu-labels classinput" type="submit" name="btnSubmit"
					id="btnS" value="下一步 " />
				</a>
		
		</div>
		</form>
	</div>
	<script>
        Array.prototype.contains = function(obj) {
            var i = this.length;
            while (i--) {
                if (this[i] == obj) {
                    return true;
                }
            }
            return false;
        }
        var addSelectedItems = function(id, value){
            value_arr = value.split('|');
            value_arr_without_quantity = [];
            for(var i = value_arr.length - 1; i >= 0; i --)
            {
                value_arr_without_quantity[i] = value_arr[i].substring(value_arr[i], value_arr[i].indexOf(','));
            }
            if(value_arr_without_quantity.contains(id))
                return value;
            else if(value == "")
                return id + "," + $("#quantity-"+id).val();
            else
                return value + "|" + id + "," + $("#quantity-"+id).val();
        }
        var addSelectedItemsForCalc = function(id, value){
            value_arr = value.split('|');
            value_arr_without_quantity = [];
            for(var i = value_arr.length - 1; i >= 0; i --)
            {
                value_arr_without_quantity[i] = value_arr[i].substring(value_arr[i], value_arr[i].indexOf(','));
            }
            if(value_arr_without_quantity.contains(id))
                return value;
            else if(value == "")
                return id + "," + $("#quantity-"+id).val();
            else
                return value + "|" + id + "," + $("#quantity-"+id).val();
        }
        var removeSelectedItems = function(id, value){
            value_arr = value.split('|');
            for(var i = value_arr.length - 1; i >= 0; i--) {
                if(value_arr[i].substring(value_arr[i], value_arr[i].indexOf(',')) == id) {
                    value_arr.splice(i, 1);
                }
            }
            $("#selectAll").prop('checked', false);
            return value_arr.join("|");
        }
        var removeSelectedItemsForCalc = function(id, value){
            value_arr = value.split('|');
            for(var i = value_arr.length - 1; i >= 0; i--) {
                if(value_arr[i].substring(value_arr[i], value_arr[i].indexOf(',')) == id) {
                    value_arr.splice(i, 1);
                }
            }
            return value_arr.join("|");
        }
        var updateTotal = function(){
            value_arr = $('#select-items').val().split("|");
            value_arr_without_quantity = [];
            for(var i = value_arr.length - 1; i >= 0; i --)
            {
                value_arr_without_quantity[i] = value_arr[i].substring(value_arr[i], value_arr[i].indexOf(','));
            }
            var total = 0;
            $('.total').each(function(){
               if(value_arr_without_quantity.contains($(this).attr('pid')))
               {
                   total += parseFloat($(this).html());
                   total.toFixed(2);
               }
            });
            $("#global-total").html(total.toFixed(2) + "");
        }
        $("#selectAll").change(function(){
            if(this.checked)
            {
                $('input[type="checkbox"]').each(function(){
                    this.checked = true;
                    if($(this).attr('pid') != undefined)
                        $("#select-items").val(addSelectedItems($(this).attr('pid'), $("#select-items").val()));
                    check();
                });
            }else{
                $('input[type="checkbox"]').each(function(){
                    this.checked = false;
                    if($(this).attr('pid') != undefined)
                        $("#select-items").val(removeSelectedItems($(this).attr('pid'), $("#select-items").val()));
                    check();
                });
            }
            updateTotal();
            check();
        });
        $(".product-item").each(function(){
            $(this).change(
                function(){
                    if(this.checked){
                        $("#select-items").val(addSelectedItems($(this).attr('pid'), $("#select-items").val()));
                        updateTotal();
                        check();
                    }else{
                        $("#select-items").val(removeSelectedItems($(this).attr('pid'), $("#select-items").val()));
                        updateTotal();
                        check();
                    }
                }
            );
        });
        $(".quantity").each(function(){
            $(this).val($(this).val());
            $(this).change(function(){
                $("#select-items").val(removeSelectedItems($(this).attr('pid'), $("#select-items").val()));
                $("#select-items").val(addSelectedItems($(this).attr('pid'), $("#select-items").val()));
                pid = $(this).attr('pid');
                $("#total-"+pid).html( (parseFloat($('#price-'+pid).val()) * parseInt($(this).val())).toFixed(2) );
                updateTotal();
                check();
            });
        });
        function finishConfirm()
        {
            if (confirm("确认执行？")){
                $("form").submit();
            } else {

            }
        }
        var increase = function(id)
        {
            $("#quantity-"+id).val(parseInt($("#quantity-" + id).val()) + 1);
            $("#total-"+id).html( (parseFloat($('#price-'+id).val()) * parseInt($("#quantity-"+id).val())).toFixed(2) );
            $("#select-items").val(removeSelectedItemsForCalc(id, $("#select-items").val()));
            if($("#product-"+id).is(':checked'))
                $("#select-items").val(addSelectedItemsForCalc(id, $("#select-items").val()));
            updateTotal();
            check();
            return false;
        }
        var decrease = function(id)
        {
            if($("#quantity-" + id).val() > 1){
                $("#quantity-"+id).val(parseInt($("#quantity-" + id).val()) - 1);
                $("#total-"+id).html( (parseFloat($('#price-'+id).val()) * parseInt($("#quantity-"+id).val())).toFixed(2) );
                $("#select-items").val(removeSelectedItemsForCalc(id, $("#select-items").val()));
                if($("#product-"+id).is(':checked'))
                    $("#select-items").val(addSelectedItemsForCalc(id, $("#select-items").val()));
            }
            updateTotal();
            check();
            return false;
        }
        
        var check = function()
        {
            if('<?=$initiation;?>' == '')
            {
                console.log(parseFloat($('#global-total').html()));
                if(parseFloat($('#global-total').html()) < 3000){
                    $('#tips').show();
                    $('#btnS').hide();
                }else{
                    $('#tips').hide();
                    $('#btnS').show();
                }
            }
        }
        
        $(".increase").each(function(){$(this).click()});
        $(".decrease").each(function(){$(this).click()});
        updateTotal();
        check();
        //$('#btnS').show();
    </script>


</body>
</html>