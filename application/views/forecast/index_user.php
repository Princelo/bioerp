
<div id="container">
    <!-- begin: #col3 static column -->
    <div id="col3" role="main" class="one_column">
        <div id="col3_content" class="clearfix">


            <div class="info view_form">
                <h2>广州洋宝生物科技有限公司 - 会员直销系统</h2>
                <h4><?php echo validation_errors(); ?>
                    <script>
                        if("<?=$this->session->flashdata('flashdata', 'value');?>"!="")
                            alert("<?=$this->session->flashdata('flashdata', 'value');?>");
                    </script>
                </h4>
                <h4>公告:</h4>
                <div class="font-size:16px;">
                    <?=$forecast?>
                </div>

            </div>



            <div class="">
                <h2>你的信息:</h2>
                <?php if (!$this->session->userdata('initiation')) { ?>
                <div style="color:#992222">你尚未成为正式代理 <a href="<?=base_url()?>user/initialize" target="_blank">马上成为正式代理</a>
                    <br> 如果你已完成付款，请等待井刷新浏览器
                </div>
                <?php } ?>
                <form action="<?=base_url()?>forecast/index" method="post">

                    <fieldset>
                        <legend>代理编辑 </legend>

                        <table>
                            <col width="150">

                            <tr>
                                <th><label>代理ID</label></th>
                                <td><input type="text" value="<?=$v->id?>" disabled="disabled"/></td>
                            </tr>
                            <tr>
                                <th><label for="username">代理账号 <span>*</span></label></th>
                                <td><input type="text" name="" data-validate="required,size(5,20)" disabled="disabled"
                                           maxlength="20" value="<?=$v->username?>"/>
                                </td>
                            </tr>
                            <tr>
                                <th><label for="name">姓名 <span>*</span></label></th>
                                <td>
                                    <input type="text" name="name" data-validate="required,size(2,10)" disabled
                                           maxlength="10" value="<?=$v->name?>"/>
                                </td>
                            </tr>
                            <tr>
                                <th><label for="citizen_id">身份证号码 <span>*</span></label></th>
                                <td>
                                    <input type="text" name="citizen_id" data-validate="required,citizen_id" disabled
                                           maxlength="18" value="<?=$v->citizen_id?>"/>
                                </td>
                            </tr>
                            <tr>
                                <th><label for="mobile_no">移动电话 <span>*</span></label></th>
                                <td>
                                    <input type="text" name="mobile_no" data-validate="required,size(11,11)"
                                           maxlength="11" size="11" value="<?=$v->mobile_no?>"/>
                                </td>
                            </tr>
                            <tr>
                                <th><label for="wechat_id">微信号 </label></th>
                                <td>
                                    <input type="text" name="wechat_id" data-validate="size(2,30)"
                                           maxlength="30" value="<?=$v->wechat_id?>"/>
                                </td>
                            </tr>
                            <tr>
                                <th><label for="qq_no">QQ号 <span>*</span></label></th>
                                <td>
                                    <input type="text" name="qq_no" data-validate="required,numeric,qq"
                                           maxlength="11" value="<?=$v->qq_no?>"/>
                                </td>
                            </tr>
                            <!--<tr>
                                <th>你的业绩</th>
                                <td>
                                    <input type="text" value="<?=cny($v->turnover)?>" disabled="disabled" />
                                </td>
                            </tr>-->
                            <tr>
                                <th>你的收益</th>
                                <td>
                                    <input type="text" value="<?=cny($v->profit)?>" disabled="disabled" />
                                </td>
                            </tr>
                            <tr>
                                <th>提现总额</th>
                                <td>
                                    <input type="text" value="<?=cny($v->withdraw_volume)?>" disabled="disabled" />
                                </td>
                            </tr>
                            <tr>
                                <th>提现余额</th>
                                <td>
                                    <input type="text" value="<?=cny($v->real_balance)?>" disabled="disabled" style="color:#f60;"/>
                                </td>
                            </tr>
                            <!--<tr>
                                <th>已生效现金卷</th>
                                <td>
                                    <input type="text" value="<?=cny($v->active_coupon)?>" disabled="disabled" style="color:#f60;">
                                </td>
                            </tr>
                            <tr>
                                <th>未生效现金卷</th>
                                <td>
                                    <input type="text" value="<?=cny($v->inactivated_coupon)?>" disabled="disabled" style="color:#f60;">
                                </td>
                            </tr>
                            <tr>
                                <th>未兑换产品券</th>
                                <td>
                                    <input type="text" value="<?=cny($v->bonus_product)?>" disabled="disabled" style="color:#f60;">
                                </td>
                            </tr>-->
                            <tr>
                                <th>帐号状态</th>
                                <td>
                                    <input type="text" value="<? if($this->session->userdata('initiation')){echo "代理会员";}else{echo "普通会员";}?>" disabled="disabled" style="">
                                </td>
                            </tr>
                        </table>

                    </fieldset>


                    <div class="toolbar type-button">
                        <div class="c50l">
                            <input type="submit" name="btnSubmit" value="修改 "  />			</div>
                        <div class="c50r right">
                        </div>
                    </div>


                </form>

            </div>



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
    <!-- end: #col4 -->	</div>

<div id="footer">
    Copyright &copy; <?=date('Y');?> by GEOMETRY<br/>
    All Rights Reserved.<br/>
</div><!-- footer -->
</body>
</html>