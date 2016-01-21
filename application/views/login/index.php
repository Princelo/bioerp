<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>广州洋宝生物科技有限公司 - 会员直销系统</title>
    <!--<link href="includes/css/style_login.css" rel="stylesheet" type="text/css"/>-->
    <link rel="stylesheet" href="<?=base_url();?>assets/login.css">

    <script type="text/javascript" src="<?=base_url()?>assets/js/jquery.1.8.0.min.js"></script>
    <!--
    <script type="text/javascript" src="http://202.155.230.91:4280/includes/js/jquery-ui-1.10.2/ui/jquery-ui.js"></script>
    <link type="text/css" rel="stylesheet" href="http://202.155.230.91:4280/includes/js/jquery-ui-1.10.2/themes/base/jquery.ui.all.css" />

    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script language="javascript">google.load("jquery", "1.7.1"); </script>
    -->
    <style>
        body{font-family: "Microsoft Yahei" !important;}
        .google_textfield{
            -webkit-appearance: none;
            appearance: none;
            display: inline-block;
            height: 36px;
            padding: 0 8px;
            margin: 0;
            background: #fff;
            border: 1px solid #d9d9d9;
            border-top: 1px solid #c0c0c0;
            -moz-box-sizing: border-box;
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
            -moz-border-radius: 1px;
            -webkit-border-radius: 1px;
            border-radius: 1px;
            font-size: 15px;
            color: #404040;
            width: 100%;
            display: block;
            margin-bottom: 10px;
            z-index: 1;
            position: relative;
            -moz-box-sizing: border-box;
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
            direction: ltr;
            height: 44px;
            font-size: 16px;
            width:274px;
        }
        .google_email{
            margin-bottom:0;
        }
        .yform{
            width:274px;
        }
        .captcha{width:110px; display:inline-block;}
        .div-captcha img{float:right;}
        .type-button{padding-top: 0;}
        table{border-spacing: 0;}
        h1{color:#555; font-family: "Microsoft Yahei"; margin-bottom:15px; font-weight: normal !important; font-size: 38px !important;}
        h2{color:#555; font-family: "Microsoft Yahei"; margin-bottom:15px; font-weight: normal !important; font-size: 18px !important;}
    </style>
</head>
<body>

<script type="text/javascript" charset="utf-8">
</script>
<div class="page_margins">
    <div class="page">


        <!-- begin: main content area #main -->
        <div id="main">

            <!-- begin: #col5 static column -->
            <div id="col5" role="main" class="one_column">
                <div id="col5_content" class="clearfix"  align="center">


                    <!--<div style="background:url('includes/images/login_interface.jpg'); width:500px; height:300px;border:6px solid #fff">-->
                    <div>
                        <h1 class="title">广州洋宝生物科技有限公司 - 会员直销系统</h1>
                        <h2 class="">使用您的帐号登陆</h2>
                        <p style="width:100%; text-align:center; color:#f00;"><?=$error;?></p>
                        <div class="choose-block" style="display:none;">
                            <div class="choose">
                                <div id="drpro" onClick="$('#bal').removeClass();$('#onespine').removeClass();this.className='selected'"><span>Dr Pro</span></div>
                                <div id="bal" onClick="$('#drpro').removeClass();$('#onespine').removeClass();this.className='selected'"><span>Bealady</span></div>
                                <div id="onespine" onClick="$('#bal').removeClass();$('#drpro').removeClass();this.className='selected'"><span>Onespine</span></div>
                            </div>
                        </div>


                        <!-- begin: Login Form -->
                        <!--<div class="center" style="width:400px;padding-top:80px;">-->
                        <div class="center">



                            <div align="left" style="min-width: 276px;">
                                <form action="<?=base_url()?>login/check" method="post" class="yform columnar" id="frm" style="min-width: 274px;">


                                    <div style="width:113px; margin:0 auto; margin-bottom: 10px;">
                                        <img src="<?=base_url()?>assets/images/photo.png" style="width:113px; margin:0 auto"/>
                                    </div>
                                    <input type="text" name="login_id" value="" id="login_id" class="google_textfield google_email" placeholder="登入帐号 "  />
                                    <input type="password" name="password" value="" id="password" class="google_textfield google_email" placeholder="密码 "  />
                                    <div style="padding-top:5px; padding-bottom:5px; min-width: 274px;" class="div-captcha">
                                        <input type="text" name="captcha" class="google_textfield captcha" placeholder="验证码" value="" style=""/>
                                        <?=$captcha;?>
                                    </div>

                                    <div class="info_msg">
                                    </div>

                                    <div class="type-button" align="right" style="min-width: 274px;">

                                        <input type="submit" name="btnSubmit" value="登入 " style="min-width: 274px;" />										<input type="reset" value="重设 " class="reset" id="btnReset" name="btnReset" style="min-width: 274px;"/>
                                    </div>

                                </form>								</div>
                            <div align="" style="color:red;font-weight:bold">
                            </div>
                        </div>
                        <!-- end: Login Form -->



                    </div>


                </div>
                <!-- IE Column Clearing -->
                <div id="ie_clearing">&nbsp;</div>
            </div>
            <!-- end: #col5 -->

        </div>
        <!-- end: #main -->
    </div>
</div>
</body>
</html>
