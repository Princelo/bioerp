<div id="container">
    <link rel="stylesheet" href="/assets/dist/themes/custom/style.css" />
    <!--[if lt IE 8]>
    <script>
        alert('你的浏览器版本太老不支持本系统的某些功能,请升级或更换浏览器');
    </script>
    <![endif]-->
    <style>
        .id-remark{color:#ccc}
    </style>



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


            <div class="info view_form">
                <h2>代理关系图</h2>
                <script>
                    if("<?=$this->session->flashdata('flashdata', 'value');?>"!="")
                        alert("<?=$this->session->flashdata('flashdata', 'value');?>");
                </script>
                <div>
                    <form action="<?=base_url()?>user/listpage" method="get" target="_blank">
                        <table>
                            <tr>
                                <th>搜索下级代理</th>
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
                <div id="jstree" style="background:#ececec">
                </div>


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
<script src="/assets/js/jquery.1.9.0.min.js"></script>
<script src="/assets/dist/jstree.min.js"></script>
<script>
    $(function () {
        $("#jstree").jstree({
            "core" : {
                "multiple" : false,
                "themes" : {
                    "variant" : "large"
                },
                'data' : {
                    'url' : '<?=site_url('user/get_tree');?>',
                    'data' : function (node) {
                        return { 'id' : node.id };
                    }
                },
                'check_callback' : function(o, n, p, i, m) {
                    if(m && m.dnd && m.pos !== 'i') { return false; }
                    if(o === "move_node" || o === "copy_node") {
                        if(this.get_node(n).parent === this.get_node(p).id) { return false; }
                    }
                    return true;
                },
                'force_text' : false
            },
            'sort' : function(a, b) {
                return (parseInt(this.get_node(a).id.substring(4)) > parseInt(this.get_node(b).id.substring(4))? 1 : -1);
            },
            'contextmenu' : {
                'items' : function(node) {
                    var tmp = {
                        'details': {
                            "label": '详情',
                            "action": function (data) {
                                var inst = $.jstree.reference(data.reference),
                                    obj = inst.get_node(data.reference);
                                window.open('<?=site_url('user/details');?>/'+obj.id,"Edit","width=600,height=600,0,status=0,");
                            }
                        },
                        'order': {
                            "label": '订单',
                            "action": function (data) {
                                var inst = $.jstree.reference(data.reference),
                                    obj = inst.get_node(data.reference);
                                window.open('<?=site_url('order/query_sub');?>/'+obj.id,"_blank");
                            }
                        },
                        'report': {
                            "label": '报表',
                            "action": function (data) {
                            }
                        }
                    };
                    if (node.id <= <?=$this->session->userdata('current_user_id');?> || node.id == '#') {
                        delete tmp.report;
                        delete tmp.order;
                    }
                    if (node.id == <?=$this->session->userdata('current_user_id');?>) {
                        delete tmp.details;
                    }
                    //var tmp = $.jstree.defaults.contextmenu.items();
                    return tmp;
                }
            },
            'types' : {
                'valid' : { 'icon' : 'person32px' },
                'invalid' : { 'icon' : 'person32px-disable' }
            },
            //'plugins' : ['state','dnd','sort','types','contextmenu','unique']
            'plugins' : ['state','sort','types','contextmenu','unique', 'search']
        });
        // bind to events triggered on the tree
        $('#jstree').on("changed.jstree", function (e, data) {
            console.log(data.selected);
        })
        // interact with the tree - either way is OK
        $('button').on('click', function () {
            $('#jstree').jstree(true).select_node('child_node_1');
            $('#jstree').jstree('select_node', 'child_node_1');
            $.jstree.reference('#jstree').select_node('child_node_1');
        });

    });
    var refresh_node = function (id) {
        $.jstree.reference('#'+id).refresh();
    }
    var open_node = function (id) {
        $.jstree.reference('#jstree').open_node('#'+id);
    }
    var close_node = function (id) {
        $.jstree.reference('#jstree').close_node('#'+id);
    }
</script>
<div id="footer">
    Copyright &copy; <?=date('Y');?> by GEOMETRY<br/>
    All Rights Reserved.<br/>
</div><!-- footer -->
</body>
</html>