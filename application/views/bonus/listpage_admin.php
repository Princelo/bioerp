<div id="container">



    <!-- begin: #col1 - first float column -->
    <div id="col1" role="complementary" style="display: block;">
        <div id="col1_content" class="clearfix">

            <ul id="left_menu">
                <li>
                    <a href='<?=base_url()?>bonus/listpage_admin' ><div>奖品列表</div></a>
                </li>
            </ul>
        </div>
    </div>
    <!-- end: #col1 -->



    <!-- begin: #col3 static column -->
    <div id="col3" role="main" class="one_column">
        <div id="col3_content" class="clearfix">


            <div class="info view_form">
                <h2>奖品列表</h2>
                <script>
                    if("<?=$this->session->flashdata('flashdata', 'value');?>"!="")
                        alert("<?=$this->session->flashdata('flashdata', 'value');?>");
                </script>
                <div>
                    <form action="<?=base_url()?>bonus/listpage_admin" method="get">
                        <table>
                            <tr>
                                <th>搜索</th>
                                <th>年&nbsp;&nbsp;
                                    <select name="year">
                                        <?php foreach (getYears() as $y ) { ?>
                                            <option value="<?=$y?>" <?php if ($year == $y) { echo "selected"; }?>><?=$y?></option>
                                        <?php } ?>
                                    </select>
                                </th>
                                <th>月&nbsp;&nbsp;
                                    <select name="month">
                                        <?php foreach (getMonths() as $m ) { ?>
                                            <option value="<?=$m?>" <?php if ($month == $m) { echo "selected"; }?>><?=$m?></option>
                                        <?php } ?>
                                    </select>
                                </th>
                                <th>激活状态&nbsp;&nbsp;
                                    <select name="actived">
                                        <option value="0" <?php if ($actived == "0") { echo "selected"; }?>>不限</option>
                                        <option value="1" <?php if ($actived == "1") { echo "selected"; }?>>是</option>
                                        <option value="2" <?php if ($actived == "2") { echo "selected"; }?>>否</option>
                                    </select>
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
                        <th>ID</th>
                        <th>奖品名称</th>
                        <th>奖品价值</th>
                        <th>用户</th>
                        <th>用户姓名</th>
                        <th>激活时间</th>
                        <th>发货时间</th>
                        <th>是否激活</th>
                        <th>是否发货</th>
                        <th></th>
                    </tr>
                    <? $n = 0; ?>
                    <? if(!empty($bonus)) { ?>
                        <? foreach($bonus as $k => $v){ ?>
                            <? $n ++; ?>
                            <tr class="<?=$n%2==0?"even":"odd";?>">
                                <td><?=$v->id?></td>
                                <td><span id="title<?=$v->id?>"><?=$v->title?></span></td>
                                <td><?=cny($v->price)?></td>
                                <td><?=$v->username;?></td>
                                <td><?=$v->name;?></td>
                                <td><?=$v->active_at;?></td>
                                <td><?=$v->delivered_at;?></td>
                                <td><span class="<?=$v->is_active==true?"accept":"cross";?>"></span></td>
                                <td><span id="delivery<?=$v->id?>" class="<?=$v->is_delivered==true?"accept":"cross";?>" id=""></span></td>
                                <td><?php if ($v->is_active == true) {?><a href="javascript:void(0);" onclick="delivery(<?=$v->id?>)">发货</a><?php } ?></td>
                            </tr>
                        <? } ?>
                    <? } ?>
                </table>
                <div class="page"><?=$page;?></div>

            </div>



            <div class="">
                <h2></h2>


            </div>



        </div>
        <script>
            var delivery = function(id) {
                var title = prompt("发放奖品名称");

                var ajaxurl = '<?=site_url('bonus/delivery/');?>';

                $.ajax({
                    url: ajaxurl,
                    dataType: "json",
                    data: {"id": id, "title": title},
                    type: "POST",
                    success: function (ajaxobj) {
                        alert(ajaxobj.message);
                        if (ajaxobj.state == 'success') {
                            $("#delivery" + id).removeClass("cross");
                            $("#delivery" + id).addClass("accept");
                            $("#title" + id).html(title);
                        }
                    }
                });
            }
        </script>
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