<div id="container">



    <!-- begin: #col1 - first float column -->
    <div id="col1" role="complementary" style="display: block;">
        <div id="col1_content" class="clearfix">

            <ul id="left_menu">
                <!--<li>
                    <a href='<?=base_url()?>report/index_admin' ><div>代理报表查询 </div></a>
                </li>
                <li><a href='<?=base_url();?>report/index_zents' ><div>总报表查询 </div></a></li>-->
                <li><a href='<?=base_url();?>report/listpage_withdraw_admin' ><div>结算查询 </div></a></li>
            </ul>
        </div>
    </div>
    <!-- end: #col1 -->
    <!-- begin: #col3 static column -->
    <div id="col3" role="main" class="one_column">
        <div id="col3_content" class="clearfix">


            <div class="info view_form">
                <h2>报表查询系统</h2>
                <script>
                    if("<?=$this->session->flashdata('flashdata', 'value');?>"!="")
                        alert("<?=$this->session->flashdata('flashdata', 'value');?>");
                </script>
                <form action="<?=base_url()?>report/listpage_user" method="get">
                    <fieldset>
                        <legend>代理报表查询 </legend>
                        <table width="70%">
                            <!--<col width="50%">
                            <col width="50%">-->
                            <tr>
                                <th>代理ID</th>
                                <td><input name="user" value="<?=$_GET['user']?>" date-validate="required,numeric" /></td>
                            </tr>
                            <tr>
                                <th>查询类型</th>
                                <td>
                                    <select name="report_type">
                                        <option value="day">日报表</option>
                                        <option value="month">月报表</option>
                                    </select>
                                </td>
                            </tr>
                            <tr class="select-date">
                                <th>起始日期</th>
                                <td><input name="date_from" class="datepicker" /></td>
                            </tr>
                            <tr class="select-date">
                                <th>结束日期</th>
                                <td><input name="date_to" class="datepicker" /></td>
                            </tr>
                            <tr class="select-month">
                                <th>起始年月</th>
                                <td><div class="monthpicker" name="month-date-from"></div></td>
                            </tr>
                            <tr class="select-month">
                                <th>结束年月</th>
                                <td><div class="monthpicker" name="month-date-to"></div></td>
                            </tr>
                            <input type="hidden" value="day" id="date-type" name="date-type">
                        </table>
                    </fieldset>
                    <div class="toolbar type-button">
                        <div class="c50l">
                            <input type="submit" name="" value="提交 "  />			</div>
                        <div class="c50r right">
                        </div>
                    </div>
                </form>
                <script>
                    if($('select[name="report_type"]').val() == 'day') {
                        $('.select-month').hide();
                        $('#date-type').val('day');
                        $('.select-date').show();
                    } else {
                        $('.select-date').hide();
                        $('#date-type').val('month');
                        $('.select-month').show();
                    }
                    $( ".datepicker" ).datepicker({
                        'dateFormat': 'yy-m-d',
                        'changeYear' : true
                    });
                    $('.monthpicker[name="month-date-from"]').birthdayPicker();
                    $('.monthpicker[name="month-date-to"]').birthdayPicker();
                    $('select[name="report_type"]').change(
                        function(){
                            if($(this).val() == 'day') {
                                $('.select-month').hide();
                                $('#date-type').val('day');
                                $('.select-date').show();
                            } else {
                                $('.select-date').hide();
                                $('#date-type').val('month');
                                $('.select-month').show();
                            }
                        }
                    );

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