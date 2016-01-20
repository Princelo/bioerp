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
                <th><label for="name">姓名 <span>*</span></label></th>
                <td>
                    <input type="text" name="name" data-validate="required,size(2,10)"
                           maxlength="10" value="<?=$v->name?>" disabled/>
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
                <th><label for="qq_no">QQ号 <span>*</span></label></th>
                <td>
                    <input type="text" name="qq_no" data-validate="required,numeric,qq"
                           maxlength="11" value="<?=$v->qq_no?>" disabled/>
                </td>
            </tr>
        </table>

    </fieldset>



</div>
<!-- IE Column Clearing -->
<div id="ie_clearing">&nbsp;</div>
