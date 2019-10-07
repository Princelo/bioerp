<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>密码修改</title>
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
    <script type="text/javascript" src="http://erp.gzybsw.cn/assets/js/jquery.js"></script>


    <!-- ********** PHPJS ********** -->
    <!--<script type="text/javascript" src="http://erp.gzybsw.cn/assets/js/php.default.namespaced.min.js"></script>


    <!-- ********** Custom JS ********** -->
    <script type="text/javascript" src="http://erp.gzybsw.cn/assets/js/general.js"></script>




    <!-- Css -->
    <!--
    -->
    <link rel="stylesheet" href="http://erp.gzybsw.cn/assets/general.css" type="text/css">




    <script src="http://erp.gzybsw.cn/assets/js/jquery-ui.js"></script>
    <script src="http://erp.gzybsw.cn/assets/js/jquery-birthday-picker.js"></script>
    <link rel="stylesheet" href="http://erp.gzybsw.cn/assets/css/jquery-ui.css"/>

  
    <script type="text/javascript" src="http://erp.gzybsw.cn/assets/js/menu.js"></script>
    <link type="text/css" rel="stylesheet" href="http://erp.gzybsw.cn/assets/menu.css" />

    <script src="http://erp.gzybsw.cn/assets/js/verify.notify.js"></script>

<script>

   
   
    

    $(document).ready(function(){
        $(".timepicker").keydown(false);
        $.verify.addRules({
 
            mypassword: function(r){
                if(r.val().length<8)
                    return "密码长度不得小于8个字符";
                if($('input[name="password"]').val()!=""&&$('input[name="password2"]').val()!="")
                    if($('input[name="password"]').val() != $('input[name="password2"]').val())
                        return "两次输入密码不相同";
                return true;
            },
            myconfirm: function(r){
                if($('input[name="password"]').val()!=""&&$('input[name="password2"]').val()!="")
                    if($('input[name="password"]').val() != $('input[name="password2"]').val())
                        return "两次输入密码不相同";
                return true;
            },
            chinese_idcard: function(r){
                var idcard_error = checkIdcard(r.val());
                if(idcard_error != 'SUCCESS')
                {
                    return idcard_error;
                }else{
                    return true;
                }
            },
        });
        
        $("form").verify();
        $('form').each(function()
            {
                $(this).attr('novalidate', 'novalidate');
            }
        );
       
    });
</script>

<style type="text/css">
html, body{  margin: 0; padding: 0; height:100%; width:100%;min-width:320px;}
</style>
</head>
<body >
	<!--主体-->
	<header class="wy-header">
		<div class="wy-header-icon-back" onclick="javascript:window.history.go(-1)">
			<span></span>
		</div>
		<div class="wy-header-titlenew" style="">密码修改</div>
	</header>

	<script>
  if("<?=$this->session->flashdata('flashdata', 'value');?>"!="")
                        alert("<?=$this->session->flashdata('flashdata', 'value');?>");
                    </script>

	<form action="<?=base_url()?>user/passwordupdate" method="post">
		<div class="weui-content">
			<div class="weui-cells weui-cells_form wy-address-edit">
				<div class="weui-cell">
					<div class="weui-cell__hd">
						<label class="weui-label wy-lab">原密码</label>
					</div>
					<div class="weui-cell__bd">
						<input class="weui-input" name="password-original" value=""
							type="password" data-validate="required">
					</div>
				</div>
				<div class="weui-cell">
					<div class="weui-cell__hd">
						<label class="weui-label wy-lab">新密码</label>
					</div>
					<div class="weui-cell__bd">
						<input class="weui-input" name="password" value="" type="password"
							data-validate="required,mypassword,max(30)">
					</div>
				</div>
				<div class="weui-cell">
					<div class="weui-cell__hd">
						<label class="weui-label wy-lab">再次确认</label>
					</div>
					<div class="weui-cell__bd">
						<input class="weui-input" name="password2" value=""
							type="password" data-validate="required,myconfirm,max(30)">
					</div>
				</div>
				<div class="weui-cell">
					<input type="submit" name="btnSubmit" value="确认修改 " />
				</div>
				
			</div>
			
		</div>
	</form>




</body>
</html>
