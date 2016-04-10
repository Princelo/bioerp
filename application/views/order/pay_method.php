<div id="container">
    <div id="col3" role="main" class="one_column">
        <div id="col3_content" class="clearfix">



            <div class="toolbar type-button">
            <span class="red">
                <?//=$this->session->flashdata('flashdata', 'value');?>
            </span>
                <div class="c50l">
                    <h3>是否马上付款(使用支付宝)</h3>
                </div>
            </div>



            <fieldset>
                <legend> 是否马上付款</legend>
                <div class="price_tip">
                    <h3>
                        本次交易总额为<span class="red">￥<?=cny(bcadd($pay_amt_without_post_fee, $post_fee, 2))?></span>，<br>
                        其中产品价格<span class="red">￥<?=cny($pay_amt_without_post_fee)?></span>，<br>
                        运费共<span class="red">￥<?=cny($post_fee)?></span>,<br>
                        使用代金券共<span class="red"><?=cny($coupon_volume)?></span>,<br>
                        还需付款: <span style="color:#f60; font-weight:bold">￥<?=bcsub(bcadd($pay_amt_without_post_fee, $post_fee, 2), money($coupon_volume), 2)?></span>
                    </h3>
                </div>
                <form id="pay" action="<?=base_url()?>order/pay/<?=$order_id?>" method="post">
                    <input type="hidden" name="token" value="<?=$token?>" />
                    <input type="submit" style="" value="马上付款"/>
                </form>
                <!--<a class="btn btn-primary" href="javascript:;" onclick="$('#pay').submit();">马上付款</a>-->
                <!--<a class="btn btn-primary" href="">以后付款或选择线下付款方式</a>-->

            </fieldset>
        </div>
        <!-- IE Column Clearing -->
        <div id="ie_clearing">&nbsp;</div>
        <!--
                <script>
                    $(document).ready(function(){
                        Calendar.setup({
                            weekNumbers   : true,
                            fdow		: 0,
                            inputField : 'end_time',
                            trigger    : 'end_time-trigger',
                            onSelect   : function() { this.hide() }
                        });

                    });

                </script>

            : IE Column Clearing -->
    </div>
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
