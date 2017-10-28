<!-- begin: #col3 static column -->
<div id="col3_content" class="clearfix" style="width: 500px;">



    <div class="toolbar type-button">
        <h4><?php echo validation_errors(); ?></h4>
        <script>
            if("<?=$this->session->flashdata('flashdata', 'value');?>"!="")
                alert("<?=$this->session->flashdata('flashdata', 'value');?>");
        </script>
        <div class="c50l">
            <h3>代理详情</h3>
        </div>
    </div>


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
                               maxlength="10" value="<?=$v->name?>" disabled/>
                    </td>
                </tr>
                <tr>
                    <th><label for="citizen_id">身份证号码 <span>*</span></label></th>
                    <td>
                        <input type="text" name="citizen_id" data-validate="required,citizen_id"
                               maxlength="18" value="<?=$v->citizen_id?>" disabled/>
                    </td>
                </tr>
                <tr>
                    <th><label for="mobile_no">移动电话 <span>*</span></label></th>
                    <td>
                        <input type="text" name="mobile_no" data-validate="required,phone"
                               maxlength="11" size="11" value="<?=$v->mobile_no?>" disabled/>
                    </td>
                </tr>
                <tr>
                    <th><label for="wechat_id">微信号 </label></th>
                    <td>
                        <input type="text" name="wechat_id" data-validate="size(2,30)"
                               maxlength="30" value="<?=$v->wechat_id?>" disabled/>
                    </td>
                </tr>
                <tr>
                    <th><label for="qq_no">QQ号 <span>*</span></label></th>
                    <td>
                        <input type="text" name="qq_no" data-validate="required,numeric,qq"
                               maxlength="11" value="<?=$v->qq_no?>" disabled/>
                    </td>
                </tr>
                <!--<tr>
                    <th>他的业绩</th>
                    <td>
                        <input type="text" value="<?=cny($v->turnover)?>" disabled="disabled" />
                    </td>
                </tr>-->
                <tr>
                    <th>他的收益</th>
                    <td>
                        <input type="text" value="<?=cny($v->profit)?>" disabled="disabled" />
                    </td>
                </tr>
                <tr>
                    <th><label>是否生效 <span>*</span></label></th>
                    <td>
                        <select name="is_valid" disabled>
                            <option value="1" <?=$v->is_valid==true?'selected="selected"':'';?>>是</option>
                            <option value="0" <?=$v->is_valid==false?'selected="selected"':'';?>>否</option>
                        </select>
                    </td>
                </tr>
            </table>

        </fieldset>



</div>
<!-- IE Column Clearing -->
<div id="ie_clearing">&nbsp;</div>
