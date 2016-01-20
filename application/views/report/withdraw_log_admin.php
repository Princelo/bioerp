<div id="container">



    <!-- begin: #col1 - first float column -->
    <div id="col1" role="complementary" style="display: block;">
        <div id="col1_content" class="clearfix">

            <ul id="left_menu">
                <li>
                    <a href='<?=base_url()?>report/index_admin' ><div>代理报表查询 </div></a>
                </li>
                <li><a href='<?=base_url();?>report/index_zents' ><div>ERP总报表查询 </div></a></li>
                <li>
                    <a href='<?=base_url()?>report/listpage_withdraw_admin' ><div>结算查询 </div></a>
                </li>
            </ul>
        </div>
    </div>
    <!-- end: #col1 -->
    <!-- begin: #col3 static column -->
    <div id="col3" role="main" class="one_column">
        <div id="col3_content" class="clearfix">


            <div class="info view_form">
                <h2>结算报表</h2>
                <script>
                    if("<?=$this->session->flashdata('flashdata', 'value');?>"!="")
                        alert("<?=$this->session->flashdata('flashdata', 'value');?>");
                </script>
                <div>
                    <form action="<?=base_url()?>report/listpage_withdraw_admin" method="get">
                        <table>
                            <tr>
                                <th>搜索</th>
                                <th>
                                    登录名/姓名
                                    <input value="<?=@$_GET['search']?>" name="search" />
                                </th>
                                <th>筛选开始日期
                                    <input class="datepicker" value="<?=@$_GET['date_from']?>" name="date_from"/>
                                </th>
                                <th>筛选结束日期
                                    <input class="datepicker" value="<?=@$_GET['date_to']?>" name="date_to"/>
                                </th>
                                <th>
                                    <input type="submit" value="提交"/>
                                </th>
                            </tr>
                        </table>
                    </form>
                </div>
                <table width="100%">
                    <!--<col width="50%">
                    <col width="50%">-->
                    <tr>
                        <th>编码</th>
                        <th>结算代理</th>
                        <th>结算金额</th>
                        <th>结算前余额</th>
                        <th>结算后余额</th>
                        <th>现余额</th>
                        <th>现收益</th>
                        <th>结算时间</th>
                    </tr>
                    <? $n = 0; ?>
                    <? if (!empty($logs)) {?>
                    <? foreach($logs as $k => $v){ ?>
                        <? $n ++; ?>
                        <tr class="<?=$n%2==0?"even":"odd";?>">
                            <td><?=$v->wid?></td>
                            <td><a href="<?=base_url()?>user/details_admin/<?=$v->uid?>"><?=$v->name?>(id: <?=$v->uid?>)</a></td>
                            <td><?=cny($v->volume)?></td>
                            <td><?=cny($v->balance_before);?></td>
                            <td>￥<?=bcsub(money($v->balance_before), money($v->volume));?></td>
                            <td><?=cny($v->balance);?></td>
                            <td><?=cny($v->profit);?></td>
                            <td><?=$v->create_time?></td>
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