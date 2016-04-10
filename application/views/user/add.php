
<div id="container">



    <!-- begin: #col1 - first float column -->
    <div id="col1" role="complementary" style="display: block;">
        <div id="col1_content" class="clearfix">

            <ul id="left_menu">
                <li>
                    <a href='<?=base_url()?>user/treepage' ><div>代理关系图 </div></a>
                </li>
                <li><a href='<?=base_url();?>user/add' ><div>新增代理 </div></a></li>
            </ul>
        </div>
    </div>
    <!-- end: #col1 -->
<!-- begin: #col3 static column -->
<div id="col3" role="main" class="one_column">
    <div id="col3_content" class="clearfix">



        <div class="toolbar type-button">
            <h4><?php echo validation_errors(); ?></h4>
            <script>
                if("<?=$this->session->flashdata('flashdata', 'value');?>"!="")
                    alert("<?=$this->session->flashdata('flashdata', 'value');?>");
            </script>
            <div class="c50l">
                <h3><?=($error!="")?"<span style=\"color:red\">".$error."</span>":"添加代理";?> </h3>
            </div>
        </div>


        <form action="<?=base_url()?>user/add" method="post">

            <fieldset>
                <legend>添加代理 </legend>

                <table>
                    <col width="150">

                    <tr>
                        <th><label for="username">代理账号 <span>*</span></label></th>
                        <td><input type="text" name="username" data-validate="required,size(5,16)"
                                   maxlength="16" value="<?=set_value('username')?>"/>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="password">代理密码 <span>*</span></label></th>
                        <td>
                            <input type="password" name="password" data-validate="required,mypassword"
                                   maxlength="30" value="<?=set_value('password')?>"/>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="password">代理密码确认 <span>*</span></label></th>
                        <td>
                            <input type="password" name="password2" data-validate="required,myconfirm"
                                   maxlength="30" value=""/>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="name">姓名 <span>*</span></label></th>
                        <td>
                            <input type="text" name="name" data-validate="required,size(2,10)"
                                   maxlength="10" value="<?=set_value('name')?>"/>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="citizen_id">身份证号码 <span>*</span></label></th>
                        <td>
                            <input type="text" name="citizen_id" data-validate="required,chinese_idcard"
                                   maxlength="18" value="<?=set_value('citizen_id')?>"/>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="mobile_no">移动电话 <span>*</span></label></th>
                        <td>
                            <input type="text" name="mobile_no" data-validate="required,phone"
                                   maxlength="11" size="11" value="<?=set_value('mobile_no')?>"/>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="wechat_id">微信号 </label></th>
                        <td>
                            <input type="text" name="wechat_id" data-validate="size(2,30)"
                                   maxlength="30" value="<?=set_value('wechat_id')?>"/>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="qq_no">QQ号 <span>*</span></label></th>
                        <td>
                            <input type="text" name="qq_no" data-validate="required,number,qq,size(5,11)"
                                   maxlength="11" value="<?=set_value('qq_no')?>"/>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="bank_info">银行卡信息 <span>*</span></label></th>
                        <td>
                            <input type="text" name="bank_info" data-validate="required"
                                    value="<?=set_value('bank_info')?>"/>
                        </td>
                    </tr>
                </table>

            </fieldset>


            <div class="toolbar type-button">
                <div class="c50l">
                    <input type="submit" name="btnSubmit" value="提交 "  />			</div>
                <div class="c50r right">
                </div>
            </div>


        </form>

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
