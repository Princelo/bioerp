<div id="container">



    <!-- begin: #col1 - first float column -->
    <div id="col1" role="complementary" style="display: block;">
        <div id="col1_content" class="clearfix">

            <ul id="left_menu">
                <li>
                    <a href='<?=base_url()?>report/index_admin' ><div>代理报表查询 </div></a>
                </li>
                <li><a href='<?=base_url();?>report/index_zents' ><div>ERP总报表查询 </div></a></li>
                <li><a href='<?=base_url();?>report/listpage_withdraw_admin' ><div>结算查询 </div></a></li>
            </ul>
        </div>
    </div>
    <!-- end: #col1 -->
    <!-- begin: #col3 static column -->
    <div id="col3" role="main" class="one_column">
        <div id="col3_content" class="clearfix">


            <div class="info view_form">
                <h2>代理交易统计报表(<?=$bills[0]->date_from?> - <?=$bills[0]->date_to?>)</h2>
                <script>
                    if("<?=$this->session->flashdata('flashdata', 'value');?>"!="")
                        alert("<?=$this->session->flashdata('flashdata', 'value');?>");
                </script>
                <table width="100%">
                    <!--<col width="50%">
                    <col width="50%">-->
                    <tr>
                        <th>代理</th>
                        <th>业绩增量</th>
                        <th>自下级(下下级)收益增量(不含推荐)</th>
                        <th>自下级推荐收益增量</th>
                        <th>自身延时收益增量</th>
                        <th>总收益增量</th>
                        <th>至推荐人收益</th>
                        <th>至推荐人推荐收益</th>
                        <th>至推荐人总收益</th>
                        <th>至跨界推荐人收益</th>
                        <th>推荐人代理</th>
                        <th>跨界推荐人代理</th>
                    </tr>
                    <? $n = 0; ?>
                    <? foreach($bills as $k => $v){ ?>
                        <? $n ++; ?>
                        <tr class="<?=$n%2==0?"even":"odd";?>">
                            <td><a href="<?=base_url()?>user/details_admin/<?=$v->id?>"><?=$v->name?>(<?=$v->username?>/<?=$v->id?>)</a></td>
                            <td><?=cny($v->turnover)?></td>
                            <td><?=cny($v->normal_return_profit_sub2self)?></td>
                            <td><?=cny($v->extra_return_profit_sub2self)?></td>
                            <td><?=cny($v->delay_return_profit)?></td>
                            <td>￥<?=bcadd(bcadd(money($v->normal_return_profit_sub2self), money($v->extra_return_profit_sub2self), 2 ),money($v->delay_return_profit),2)?></td>
                            <td><?=cny($v->normal_return_profit_self2parent);?></td>
                            <td><?=cny($v->extra_return_profit_self2parent);?></td>
                            <td>￥<?=bcadd(money($v->normal_return_profit_self2parent), money($v->extra_return_profit_self2parent), 2 )?></td>
                            <td><?=cny($v->normal_return_profit_self2gparent);?></td>
                            <? if(intval($v->pid) <= 0) {?>
                            <td>无推荐人</td>
                            <?} else {?>
                            <td><a href="<?=base_url()?>user/details_admin/<?=$v->pid?>"><?=$v->pname?>(<?=$v->pusername?>/<?=$v->pid?>)</a></td>
                            <? } ?>
                            <? if(intval($v->gpid) <= 0) {?>
                                <td>无跨界推荐人</td>
                            <?} else {?>
                                <td><a href="<?=base_url()?>user/details_admin/<?=$v->gpid?>"><?=$v->gpname?>(<?=$v->gpusername?>/<?=$v->gpid?>)</a></td>
                            <? } ?>
                        </tr>
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



            <div class="toolbar type-button">
                <form action="<?=base_url()?>report/download_xls" method="post">
                    <input name="report_type" value="<?=$report_type?>" type="hidden" />
                    <input name="date_from" value="<?=$date_from?>" type="hidden" />
                    <input name="date_to" value="<?=$date_to?>" type="hidden" />
                    <input value="下载本报表" type="submit" />
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