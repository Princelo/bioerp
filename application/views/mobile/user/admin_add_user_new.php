<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>广州洋宝生物科技-代理注册</title>
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

<!-- ********** jQuery ********** -->

<!--<script type="text/javascript" src="http://erp.gzybsw.cn/assets/js/jquery.1.8.0.min.js"></script>-->
<script type="text/javascript"
	src="http://erp.gzybsw.cn/assets/js/jquery.js"></script>


<!-- ********** PHPJS ********** -->
<!--<script type="text/javascript" src="http://erp.gzybsw.cn/assets/js/php.default.namespaced.min.js"></script>


    <!-- ********** Custom JS ********** -->
<script type="text/javascript"
	src="http://erp.gzybsw.cn/assets/js/general.js"></script>




<!-- Css -->
<!--
    -->
<link rel="stylesheet" href="http://erp.gzybsw.cn/assets/general.css"
	type="text/css">

<script src="http://erp.gzybsw.cn/assets/js/jquery-ui.js"></script>
<script src="http://erp.gzybsw.cn/assets/js/jquery-birthday-picker.js"></script>
<link rel="stylesheet"
	href="http://erp.gzybsw.cn/assets/css/jquery-ui.css" />


<script type="text/javascript"
	src="http://erp.gzybsw.cn/assets/js/menu.js"></script>
<link type="text/css" rel="stylesheet"
	href="http://erp.gzybsw.cn/assets/menu.css" />

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
		<div class="wy-header-icon-back"  onclick="javascript:window.history.go(-1)">
			<span></span>
		</div>
		<div class="wy-header-titlenew" style="">广州洋宝生物科技-代理注册</div>
	</header>
	<script>
                    if("<?=$this->session->flashdata('flashdata', 'value');?>"!="")
                        alert("<?=$this->session->flashdata('flashdata', 'value');?>");
    </script>

	<form
		action="<?=base_url()?>user/admin_add_user_new?id=<?=$user->id;?>"
		method="post">
		<div class="weui-content">
			<div class="weui-cells weui-cells_form wy-address-edit">

				<div class="weui-cell">
					<div class="weui-cell__hd">
						<label class="weui-label wy-lab">代理帐号</label>
					</div>
					<div class="weui-cell__bd">
						<input class="weui-input" type="text" name="username"
							data-validate="required,size(5,16)" maxlength="20"
							value="<?=set_value('username')?>" placeholder="请输入代理帐号">
					</div>
				</div>
				<div class="weui-cell">
					<div class="weui-cell__hd">
						<label class="weui-label wy-lab">代理密码</label>
					</div>
					<div class="weui-cell__bd">
						<input class="weui-input" type="password" name="password"
							data-validate="required,mypassword" maxlength="30"
							value="<?=set_value('password')?>" placeholder="代理密码">
					</div>
				</div>
				<div class="weui-cell">
					<div class="weui-cell__hd">
						<label class="weui-label wy-lab">代理密码确认</label>
					</div>
					<div class="weui-cell__bd">
						<input class="weui-input" type="password" name="password2"
							data-validate="required,myconfirm" maxlength="30"
							value="<?//=set_value('password')?>" placeholder="代理密码确认">
					</div>
				</div>
				<div class="weui-cell">
					<div class="weui-cell__hd">
						<label class="weui-label wy-lab">姓名</label>
					</div>
					<div class="weui-cell__bd">
						<input class="weui-input" type="text" name="name"
							data-validate="required,size(2,10)" maxlength="10"
							value="<?=set_value('name')?>" placeholder="请输入姓名">
					</div>
				</div>
				<div class="weui-cell">
					<div class="weui-cell__hd">
						<label class="weui-label wy-lab">身份证号码</label>
					</div>
					<div class="weui-cell__bd">
						<input class="weui-input" type="text" name="citizen_id"
							data-validate="required,chinese_idcard" maxlength="18"
							value="<?=set_value('citizen_id')?>" placeholder="请输入身份证号码">
					</div>
				</div>
				<div class="weui-cell">
					<div class="weui-cell__hd">
						<label class="weui-label wy-lab">移动电话</label>
					</div>
					<div class="weui-cell__bd">
						<input class="weui-input" type="text" name="mobile_no"
							data-validate="required,phone" maxlength="11" size="11"
							value="<?=set_value('mobile_no')?>" placeholder="请输入移动电话">
					</div>
				</div>
				<div class="weui-cell">
					<div class="weui-cell__hd">
						<label class="weui-label wy-lab">微信号</label>
					</div>
					<div class="weui-cell__bd">
						<input class="weui-input" type="text" name="wechat_id"
							data-validate="size(2,30)" maxlength="30"
							value="<?=set_value('wechat_id')?>" placeholder="请输入微信号">
					</div>
				</div>
				<div class="weui-cell">
					<div class="weui-cell__hd">
						<label class="weui-label wy-lab">QQ号</label>
					</div>
					<div class="weui-cell__bd">
						<input class="weui-input" type="text" name="qq_no"
							data-validate="required,number,qq,size(5,11)" maxlength="11"
							value="<?=set_value('qq_no')?>" placeholder="请输入QQ号">
					</div>
				</div>
				<div class="weui-cell">
					<div class="weui-cell__hd">
						<label class="weui-label wy-lab">银行卡信息</label>
					</div>
					<div class="weui-cell__bd">
						<input class="weui-input" type="text" name="bank_info"
							data-validate="required" value="<?=set_value('bank_info')?>"
							placeholder="请输入银行卡信息">
					</div>
				</div>
				<div class="weui-cell">
					<div class="weui-cell__hd">
						<label class="weui-label wy-lab">是否生效</label>
					</div>
					<div class="weui-cell__bd">
						<select name="is_valid" class="weui-input">
							<option value="1">是</option>
							<option value="0">否</option>
						</select>
					</div>
				</div>

			</div>
			<div class="login-form">
				<input type="submit" name="btnSubmit" value="注册提交 " class="login-btn common-div" style="line-height: 0px;" /> 
				<a href="<?=base_url()?>login" class="login-oth-btn common-div">马上登陆</a>
			</div>
			


		</div>
	</form>
	<script>
                $(document).ready(function(){
              	  $("input[type='submit']").click(function(){

                        var ajaxurl = '<?=site_url('user/admin_add_user_new/');?>?id=<?=$user->id;?>';
                        var query = $("form").serialize() ;

                        $.ajax({
                            url: ajaxurl,
                            dataType: "json",
                            data:query,
                            type: "POST",
                            success: function(ajaxobj){
                                if(ajaxobj.state=='success')
                                {
                                    alert(ajaxobj.message);
                                    opener.open_node(<?=$user->id;?>);
                                    opener.refresh_node(<?=$user->id;?>);
                                    window.close();
                                }
                                else
                                {
                                    alert(ajaxobj.message);
                                }
                            }
                        });

                        return false;

                    });
                    $("input[type='botton']").click(function(){
                        window.laction="<?=base_url()?>login"
                    });
                });


            </script>

</body>
</html>
