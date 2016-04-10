<div id="container">
    <div id="col3" role="main" class="one_column">
        <div id="col3_content" class="clearfix">



            <div class="toolbar type-button">
            <span class="red">
                <?=$this->session->flashdata('flashdata', 'value');?>
            </span>
                <script>
                    if("<?=$this->session->flashdata('flashdata', 'value');?>"!="")
                        alert("<?=$this->session->flashdata('flashdata', 'value');?>");
                </script>
                <div class="c50l" style="float: left; width: 100%; height: 100px;">
                    <h3>
                        本次交易额为<span style="color:#f60;">￥<?=cny($total)?></span>
                        <br>
                        您当前帐号已生效代金卷共有<span style="color:#f60;"><?=cny($user_info->active_coupon)?></span>
                        <br>是否用于本次交易?
                    </h3>
                    <? $max = floatval(money($total)) > floatval(money($user_info->active_coupon))?money($user_info->active_coupon):money($total); ?>
                </div>
            </div>



            <fieldset>
                <legend> 使用代金卷</legend>
                <div class="price_tip">
                    本次交易总额为<span class="red">￥<?=cny(bcadd($pay_amt_without_post_fee, $post_fee, 2))?></span>，
                    其中产品价格<span class="red">￥<?=cny($pay_amt_without_post_fee)?></span>，
                    运费共<span class="red">￥<?=cny($post_fee)?></span>
                </div>
                <div style="float:left;">
                    <form id="pay" action="<?=base_url()?>order/modify_payment/<?=$order_info->id?>" method="post">
                        <div class="form-group">
                            <label>使用代金卷金额</label>
                            <input type="text" value="<?=$max?>" data-validate="required,currency,minVal(0.01),maxVal(<?=$max?>)" name="volume">
                        </div>
                        <input type="submit" style="" value="确认使用" />
                        <input type="button" value="不使用代金卷" onclick="window.location.href='<?=base_url();?>/order/modify_payment/<?=$order_info->id?>?confirm=1'" style="    background: #536474;
    border: 1px solid #999;
    padding: 10px 20px;
    color: #fff;
    margin-top: 0;"/>
                    </form>
                </div>

            </fieldset>
        </div>
        <!-- IE Column Clearing -->
        <div id="ie_clearing">&nbsp;</div>
    </div>
