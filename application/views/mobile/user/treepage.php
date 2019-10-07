<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>代理关系图</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport"
	content="width=device-width, initial-scale=1, user-scalable=no">
<meta name="description"
	content="Write an awesome description for your new site here. You can edit this line in _config.yml. It will appear in your document head meta (for Google search results) and in your feed.xml site description.
">
<link rel="stylesheet"
	href="<?=base_url();?>assets/Mobilecss/lib/weui.min.css">
<link rel="stylesheet"
	href="<?=base_url();?>assets/Mobilecss/css/jquery-weui.css">
<link rel="stylesheet"
	href="<?=base_url();?>assets/Mobilecss/css/style.css">

<link rel="stylesheet"
	href="<?=base_url();?>assets/dist/themes/custom/style.css" />
</head>
<body ontouchstart>
	<!--主体-->
	<header class="wy-header">
		<div class="wy-header-icon-back" onclick="javascript:window.history.go(-1)">
			<span></span>
		</div>
		<div class="wy-header-title">代理关系图</div>
	</header>
	<div class="weui-content">
		<div class="weui-cells weui-cells_form wy-address-edit">
			<form action="<?=base_url()?>user/listpage" method="get"
				target="_blank">

				<div class="weui-cell weui-cell_vcode">
					<div class="weui-cell__hd">
						搜索：
					</div>
					<div class="weui-cell__bd">
						<input type="text" name="search" value="<?=set_value('search')?>" />
					</div>
					<div class="weui-cell__ft">
						<input class="weui-vcode-btn  classinput" type="submit"   />
					</div>
				</div>
			</form>
		</div>
		<div id="jstree" style="background: #ececec"></div>
	</div>
	<script src="<?=base_url();?>assets/js/jquery.1.9.0.min.js"></script>
	<script src="<?=base_url();?>assets/dist/jstree.min.js"></script>
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
                                var inst = $.jstree.reference(data.reference),
                                    obj = inst.get_node(data.reference);
                                window.open('<?=site_url('report/query_sub');?>/'+obj.id,"_blank");
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



</body>
</html>
