<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>登陆</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
<meta name="description" content="Write an awesome description for your new site here. You can edit this line in _config.yml. It will appear in your document head meta (for Google search results) and in your feed.xml site description.
">
<link rel="stylesheet" href="<?=base_url();?>assets/Mobilecss/lib/weui.min.css">
<link rel="stylesheet" href="<?=base_url();?>assets/Mobilecss/css/jquery-weui.css">
<link rel="stylesheet" href="<?=base_url();?>assets/Mobilecss/css/style.css">
</head>
<body ontouchstart style="background:#323542;">
<!--主体-->
<div class="login-box">
  	<div class="lg-title">广州洋宝生物科技有限公司 </div>
   <p style="width:100%; text-align:center; color:#f00;"><?=$error;?></p>
    <div class="login-form">
    	 <form action="http://erp.gzybsw.cn/login/check" method="post" class="yform columnar" id="frm" >
        	<div class="login-user-name common-div">
            	<span class="eamil-icon common-icon">
                	<img src="<?=base_url();?>assets/Mobilecss/images/eamil.png" />
                </span>
                <input type="text" name="login_id" value="" id="login_id" placeholder="登录账户" />        
            </div>
            <div class="login-user-pasw common-div">
            	<span class="pasw-icon common-icon">
                	<img src="<?=base_url();?>assets/Mobilecss/images/password.png" />
                </span>
                <input type="password" name="password" value="" id="password" placeholder="请输入您的密码" />  
            </div>
           <div class="login-user-pasw common-div">
            	<span class="pasw-icon common-icon">
                	<img src="<?=base_url();?>assets/Mobilecss/images/password.png" />
                </span>
                <input type="text" name="captcha" value="" placeholder="验证码" value="" /><span style="float: right" > <?=$captcha;?>  </span>         
            </div>
            
           <input type="submit" name="btnSubmit" value="登入 " class="login-btn common-div">
           <input type="reset" value="重设 "  id="btnReset" name="btnReset" class="login-oth-btn common-div">
        </form>
    </div>
   
</div>
<script src="<?=base_url();?>assets/Mobilecss/lib/jquery-2.1.4.js"></script> 
<script src="<?=base_url();?>assets/Mobilecss/lib/fastclick.js"></script> 
<script type="text/javascript" src="<?=base_url();?>assets/Mobilecss/js/jquery.Spinner.js"></script>
<script>
  $(function() {
    FastClick.attach(document.body);
  });
</script>

<script src="<?=base_url();?>assets/Mobilecss/js/jquery-weui.js"></script>

</body>
</html>
