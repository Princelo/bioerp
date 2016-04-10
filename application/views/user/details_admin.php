    <!-- begin: #col3 static column -->
        <div id="col3_content" class="clearfix" style="width: 500px;">



            <div class="toolbar type-button">
                <h4><?php echo validation_errors(); ?></h4>
                <script>
                    if("<?=$this->session->flashdata('flashdata', 'value');?>"!="")
                        alert("<?=$this->session->flashdata('flashdata', 'value');?>");
                </script>
                <div class="c50l">
                    <h3>编辑代理</h3>
                </div>
            </div>


            <form action="<?=base_url()?>user/details_admin/<?=$id?>" method="post" id="form1">

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
                            <td><input type="text" name="username" data-validate="required,size(5,20)"
                                       maxlength="20" value="<?=$v->username?>" disabled/>
                            </td>
                        </tr>
                        <tr>
                            <th><label for="name">姓名 <span>*</span></label></th>
                            <td>
                                <input type="text" name="name" data-validate="required,size(2,10)"
                                       maxlength="10" value="<?=$v->name?>"/>
                            </td>
                        </tr>
                        <tr>
                            <th><label for="citizen_id">身份证号码 <span>*</span></label></th>
                            <td>
                                <input type="text" name="citizen_id" data-validate="required,citizen_id"
                                       maxlength="18" value="<?=$v->citizen_id?>"/>
                            </td>
                        </tr>
                        <tr>
                            <th><label for="mobile_no">移动电话 <span>*</span></label></th>
                            <td>
                                <input type="text" name="mobile_no" data-validate="required,phone"
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
                        <tr>
                            <th><label for="qq_no">银行卡信息 <span>*</span></label></th>
                            <td>
                                <input type="text" name="bank_info" data-validate="required"
                                       value="<?=$v->bank_info?>"/>
                            </td>
                        </tr>
                        <tr>
                            <th>他的业绩</th>
                            <td>
                                <input type="text" value="<?=cny($v->turnover)?>" disabled="disabled" />
                            </td>
                        </tr>
                        <tr>
                            <th>他的收益</th>
                            <td>
                                <input type="text" value="<?=cny($v->profit)?>" disabled="disabled" />
                            </td>
                        </tr>
                        <tr>
                            <th>已提现金额</th>
                            <td>
                                <input type="text" value="<?=cny($v->withdraw_volume)?>" disabled="disabled" />
                            </td>
                        </tr>
                        <tr>
                            <th>帐户余额</th>
                            <td>
                                <input type="text" value="<?=cny($v->real_balance)?>" disabled="disabled" style="color:#f60;"/>
                            </td>
                        </tr>
                        <tr>
                            <th>已生效代金券</th>
                            <td>
                                <input type="text" value="<?=cny($v->active_coupon)?>" disabled="disabled" style="color:#f60;"/>
                            </td>
                        </tr>
                        <tr>
                            <th>未生效代金券</th>
                            <td>
                                <input type="text" value="<?=cny($v->inactivated_coupon)?>" disabled="disabled" style="color:#f60;"/>
                            </td>
                        </tr>
                        <tr>
                            <th>帐号状态</th>
                            <td>
                                <input type="text" value="<? if($v->initiation) {echo "代理会员";}else{echo "普通会员";}?>">
                            </td>
                        </tr>
                        <tr>
                            <th><label>是否生效 <span>*</span></label></th>
                            <td>
                                <select name="is_valid">
                                    <option value="1" <?=$v->is_valid==true?'selected="selected"':'';?>>是</option>
                                    <option value="0" <?=$v->is_valid==false?'selected="selected"':'';?>>否</option>
                                </select>
                            </td>
                        </tr>
                    </table>

                </fieldset>


                <div class="toolbar type-button">
                    <div class="c50l">
                        <input type="submit" name="btnSubmit" value="提交 "  id="ajax_submit"/>			</div>
                    <div class="c50r right">
                    </div>
                </div>


            </form>
            <script>
                $(document).ready(function(){
                    $("#ajax_submit").click(function(){

                        var ajaxurl = '<?=site_url('user/details_admin/'.$v->id);?>';
                        var query = $("#form1").serialize() ;

                        $.ajax({
                            url: ajaxurl,
                            dataType: "json",
                            data:query,
                            type: "POST",
                            success: function(ajaxobj){
                                if(ajaxobj.state=='success')
                                {
                                    alert(ajaxobj.message);
                                    if (opener.refresh_node != undefined)
                                        opener.refresh_node(<?=$v->id;?>);
                                    window.close();
                                }
                                else
                                {
                                    alert(ajaxobj.message);
                                }
                            }
                        });

                        return false;

                    });

                    $("#withdraw_submit").click(function(){

                        var ajaxurl = '<?=site_url('user/withdraw/');?>';
                        var query = $("#form2").serialize() ;

                        $.ajax({
                            url: ajaxurl,
                            dataType: "json",
                            data:query,
                            type: "POST",
                            success: function(ajaxobj){
                                if(ajaxobj.state=='success')
                                {
                                    alert(ajaxobj.message);
                                    window.close();
                                }
                                else
                                {
                                    alert(ajaxobj.message);
                                }
                            }
                        });

                        return false;

                    });
                });


            </script>

        </div>
        <!-- IE Column Clearing -->
        <div id="ie_clearing">&nbsp;</div>
    <div class="info view_form">
        <h2>结算操作</h2>
        <div>
            <form action="<?=base_url()?>user/withdraw" method="post" id="form2">
                <table>
                    <tr>
                        <th>
                            <label>结算金额</label>
                            <input type="hidden" value="<?=$v->id?>" name="id" />
                            <input class="" type="text" name="volume" value="" data-validate="required,numeric"/>&nbsp;&nbsp;元
                        </th>
                        <th>
                            <input type="submit" value="结算" id="withdraw_submit"/>
                        </th>
                    </tr>
                </table>
            </form>
        </div>
    </div>
