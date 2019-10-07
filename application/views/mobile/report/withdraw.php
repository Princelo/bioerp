<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>查询结算纪录</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport"
	content="width=device-width, initial-scale=1, user-scalable=no">
<meta name="description"
	content="Write an awesome description for your new site here. You can edit this line in _config.yml. It will appear in your document head meta (for Google search results) and in your feed.xml site description.">
<link rel="stylesheet"
	href="<?=base_url();?>assets/Mobilecss/lib/weui.min.css">
<link rel="stylesheet"
	href="<?=base_url();?>assets/Mobilecss/css/jquery-weui.css">
<link rel="stylesheet"
	href="<?=base_url();?>assets/Mobilecss/css/style.css">

<!-- ********** jQuery ********** -->

    <!--<script type="text/javascript" src="http://erp.gzybsw.cn/assets/js/jquery.1.8.0.min.js"></script>-->
    <script type="text/javascript" src="<?=base_url();?>assets/js/jquery.js"></script>


    <!-- ********** PHPJS ********** -->
    <!--<script type="text/javascript" src="http://erp.gzybsw.cn/assets/js/php.default.namespaced.min.js"></script>


    <!-- ********** Custom JS ********** -->
    <script type="text/javascript" src="<?=base_url();?>assets/js/general.js"></script>




    <!-- Css -->
    <!--
    -->

    <link rel="stylesheet" href="<?=base_url();?>assets/layout.css" type="text/css">




    <!-- ********** JSCal2 ********** -->
    <!--<link type="text/css" rel="stylesheet" href="http://erp.gzybsw.cn/assets/jscal2.css" />
    <link type="text/css" rel="stylesheet" href="http://erp.gzybsw.cn/assets/border-radius.css" />
    <link type="text/css" rel="stylesheet" href="http://erp.gzybsw.cn/assets/reduce-spacing.css" />
    <!--<script type="text/javascript" src="http://erp.gzybsw.cn/assets/js/jscal2.js"></script>
    <script type="text/javascript" src="http://erp.gzybsw.cn/assets/js/en.js"></script>-->
    <!--<script type="text/javascript" src="http://erp.gzybsw.cn/assets/js/jquery.timepicker.js"></script>
    -->
    <script src="<?=base_url();?>assets/js/jquery-ui.js"></script>
    <script src="<?=base_url();?>assets/js/jquery-birthday-picker.js"></script>
    <link rel="stylesheet" href="<?=base_url();?>assets/css/jquery-ui.css"/>

    <!-- Clock Picker -->
    <!--<script type="text/javascript" src="http://erp.gzybsw.cn/assets/jquery.clockpick.1.2.7.js"></script>
    <link type="text/css" rel="stylesheet" href="http://erp.gzybsw.cn/assets/js/jquery.clockpick.1.2.7.css"/>

    <!-- ********** :: Animated jQuery Menu Style 08  ********** -->
    <script type="text/javascript" src="<?=base_url();?>assets/js/menu.js"></script>
    <link type="text/css" rel="stylesheet" href="<?=base_url();?>assets/menu.css" />

    <!-- ********** :: colorbox-master  ********** -->
    <!--<link rel="stylesheet" href="http://erp.gzybsw.cn/assets/colorbox.css" />
    <script type="text/javascript" src="http://erp.gzybsw.cn/assets/js/jquery.colorbox.js"></script>

    <!-- Freeze Header  ********** -->
    <!--<script type="text/javascript" src="http://erp.gzybsw.cn/assets/js/jquery.freezeheader.js"></script>

    <!-- Mobile Detector  ********** -->
    <!--<script type="text/javascript" src="http://erp.gzybsw.cn/assets/js/detectmobilebrowser.js"></script>-->
    <script src="<?=base_url();?>assets/js/verify.notify.js"></script>


<style type="text/css">
html, body {
	margin: 0;
	padding: 0;
	height: 100%;
	width: 100%;
	min-width: 320px;
}
</style>
</head>
<body>
	<!--主体-->
	<header class="wy-header">
		<div class="wy-header-icon-back" onclick="javascript:window.history.go(-1)">
			<span></span>
		</div>
		<div class="wy-header-titlenew" style="">查询结算纪录</div>
	</header>

	<script>
	 if("<?=$this->session->flashdata('flashdata', 'value');?>"!="")
         alert("<?=$this->session->flashdata('flashdata', 'value');?>");
                    </script>

            <form action="<?=base_url()?>report/listpage_withdraw" method="get">
		<div class="weui-content">
			<div class="weui-cells weui-cells_form wy-address-edit">
				
				<div class="weui-cell select-date">
					<div class="weui-cell__hd">
						<label class="weui-label wy-lab">起始日期</label>
					</div>
					<div class="weui-cell__bd">
						<input name="date_from" class="datepicker" />
					</div>
				</div>
				<div class="weui-cell select-date">
					<div class="weui-cell__hd">
						<label class="weui-label wy-lab">结束日期</label>
					</div>
					<div class="weui-cell__bd">
						<input name="date_to" class="datepicker" />
					</div>
				</div>
				
				 <input type="hidden" value="day" id="date-type" name="date-type">
				<div class="weui-cell">
					<input type="submit" class="weui-btn weui-btn_primary" name="btnSubmit" value="查询 " />
				</div>

			</div>

		</div>
	</form>

<script>

    $( ".datepicker" ).datepicker({
        'dateFormat': 'yy-m-d',
        'changeYear' : true
    });
   

</script>


</body>
</html>