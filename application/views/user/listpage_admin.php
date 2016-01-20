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
                <div>
                    <form action="<?=base_url()?>user/listpage_admin" method="get">
                        <table>
                            <tr>
                                <th>搜索</th>
                                <th>
                                    姓名:<input type="text" name="search" value="<?=set_value('search')?>"  />
                                </th>
                                <th>
                                    <input type="submit" />
                                </th>

                            </tr>
                        </table>
                    </form>
                </div>
                <table width="100%">
                    <!--<col width="50%">
                    <col width="50%">-->
                    <tr>
                        <th>代理ID</th>
                        <th>用戶名</th>
                        <th>姓名</th>
                        <th>其它信息</th>
                        <th>他的业绩</th>
                        <th>他的收益</th>
                        <th>共提现</th>
                        <th>提现余额</th>
                        <th>是否生效</th>
                        <th>上级</th>
                        <th>上上级</th>
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
                            <td>身份证: <?=$v->citizen_id;?><br>
                                电话: <?=$v->mobile_no;?><br>
                                微信: <?=$v->wechat_id;?><br>
                                qq: <?=$v->qq_no?>
                            </td>
                            <td><?=cny($v->turnover)?></td>
                            <td><?=cny($v->profit)?></td>
                            <td><?=cny($v->withdraw_volume)?></td>
                            <td><?=cny($v->balance)?></td>
                            <td><?=$v->is_valid=='t'?'是':'否'?></td>
                            <? if($v->pid == '0' || $v->pid == '') { ?>
                                <td>无上级</td>
                                <? } else { ?>
                            <td><a href="<?=base_url()?>user/details_admin/<?=$v->pid?>"><?=$v->pname?>(id:<?=$v->pid?>)</a></td>
                                <? } ?>
                            <? if($v->ppid == '0' || $v->ppid == '') { ?>
                                <td>无上上级</td>
                            <? } else { ?>
                                <td><a href="<?=base_url()?>user/details_admin/<?=$v->ppid?>"><?=$v->ppname?>(id:<?=$v->ppid?>)</a></td>
                            <? } ?>
                            <td><a href="<?=base_url()?>user/sublistpage/<?=$v->id?>">他的下一级</a></td>
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
    Copyright &copy; <?=date('Y');?> by BIOERP<br/>
    All Rights Reserved.<br/>
</div><!-- footer -->
</body>
</html>