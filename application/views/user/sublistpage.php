<div id="container">



    <!-- begin: #col1 - first float column -->
    <div id="col1" role="complementary" style="display: block;">
        <div id="col1_content" class="clearfix">

            <ul id="left_menu">
                <li>
                    <a href='<?=base_url()?>user/listpage_admin' ><div>表格式代理列表 </div></a>
                </li>
                <li><a href='<?=base_url();?>user/treepage_admin' ><div>树状图代理列表 </div></a></li>
            </ul>
        </div>
    </div>
    <!-- end: #col1 -->



    <!-- begin: #col3 static column -->
    <div id="col3" role="main" class="one_column">
        <div id="col3_content" class="clearfix">


            <div class="info view_form">
                <h2>代理列表</h2>
                <script>
                    if("<?=$this->session->flashdata('flashdata', 'value');?>"!="")
                        alert("<?=$this->session->flashdata('flashdata', 'value');?>");
                </script>
                <form action="">
                    <input type="submit" onclick="history.go(-1);return false;" value="&#171;返回">
                </form>
                <table width="100%">
                    <!--<col width="50%">
                    <col width="50%">-->
                    <tr>
                        <th>代理ID</th>
                        <th>用戶名</th>
                        <th>姓名</th>
                        <th>电话</th>
                        <!--<th>他的业绩</th>-->
                        <th>他的收益</th>
                        <th>已提现金额</th>
                        <th>帐户余额</th>
                        <!--<th>已生效代金券</th>
                        <th>未生效代金券</th>-->
                        <th>是否生效</th>
                        <th></th>
                        <th></th>
                    </tr>
                    <? $n = 0; ?>
                    <? if(!empty($users)) {?>
                        <? foreach($users as $k => $v){ ?>
                            <? $n ++; ?>
                            <tr class="<?=$n%2==0?"even":"odd";?>">
                                <td><?=$v->id?></td>
                                <td><?=$v->username;?></td>
                                <td><?=$v->name;?></td>
                                <td><?=$v->mobile_no;?></td>
                                <!--<td><?=cny($v->turnover)?></td>-->
                                <td><?=cny($v->profit)?></td>
                                <td><?=cny($v->withdraw_volume)?></td>
                                <td><?=cny($v->real_balance)?></td>
                                <!--<td><?=cny($v->active_coupon)?></td>
                                <td><?=cny($v->inactivated_coupon)?></td>-->
                                <td><?=$v->is_valid==true?'是':'否'?></td>
                                <td><a href="<?=base_url()?>user/sublistpage/<?=$v->id?>">他的下级</a></td>
                                <td><a bhref="<?=base_url()?>user/details_admin/<?=$v->id?>" onclick="window.open('<?=base_url()?>user/details_admin/<?=$v->id?>','Edit','width=600,height=600,0,status=0,')">编辑</a></td>
                            </tr>
                        <? } ?>
                    <? } ?>
                </table>
                <div class="page"><?=$page;?></div>
                <script>
                    /*function myconfirm(id){
                     if (confirm("are you sure?")){
                     window.location.href = "<?=base_url()?>index.php/unvadmin/singerdelete/"+id;
                     } else {

                     }
                     }*/
                </script>


            </div>



            <div class="">
                <h2></h2>


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