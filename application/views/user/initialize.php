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
                        加入代理费用<span class="red">￥<?=cny($pay_amt)?></span>，<br>
                    </h3>
                </div>
                <form id="pay" action="<?=base_url()?>user/pay/<?=$user_id?>" method="post">
                    <input type="hidden" name="token_initiation" value="<?=$token?>" />
                    <input type="submit" style="" value="马上付款"/>
                </form>

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
