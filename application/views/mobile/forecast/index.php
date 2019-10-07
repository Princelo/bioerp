<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>会员直销系统</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
<meta name="description" content="Write an awesome description for your new site here. You can edit this line in _config.yml. It will appear in your document head meta (for Google search results) and in your feed.xml site description.
">
<link rel="stylesheet" href="<?=base_url();?>assets/Mobilecss/lib/weui.min.css">
<link rel="stylesheet" href="<?=base_url();?>assets/Mobilecss/css/jquery-weui.css">
<link rel="stylesheet" href="<?=base_url();?>assets/Mobilecss/css/style.css">
</head>
<body ontouchstart>
<!--主体-->
<header class="wy-header">
  <div class="wy-header-title">会员直销系统</div>
</header>
<div class="weui-content">
  <form action="<?=base_url()?>forecast/index" method="post">
  <div class="weui-cells weui-cells_form wy-address-edit">
     <div class="weui-cell">
      <div class="weui-cell__hd"><label class="weui-label wy-lab">公告：</label></div>
      <div class="weui-cell__bd">
        <?=$forecast?>
      </div>
    </div>
    <div class="weui-cell">
      <div class="weui-cell__hd"><label class="weui-label wy-lab">代理ID</label></div>
      <div class="weui-cell__bd"><input class="weui-input" value="<?=$v->id?>" disabled="disabled" /></div>
    </div>
    <div class="weui-cell">
      <div class="weui-cell__hd"><label class="weui-label wy-lab">代理账号</label></div>
      <div class="weui-cell__bd"><input class="weui-input" type="text" name="" data-validate="required,size(5,20)" disabled="disabled"  maxlength="20" value="<?=$v->username?>" /></div>
    </div>
    <div class="weui-cell">
      <div class="weui-cell__hd"><label for="name" class="weui-label wy-lab">姓名</label></div>
      <div class="weui-cell__bd"><input class="weui-input" type="text" name="name" data-validate="required,size(2,10)" disabled maxlength="10" value="<?=$v->name?>" /></div>
   <div class="weui-cell">
      <div class="weui-cell__hd"><label for="name" class="weui-label wy-lab">身份证号码 </label></div>
      <div class="weui-cell__bd"><input class="weui-input"  type="text" name="citizen_id" data-validate="required,citizen_id" disabled
                                           maxlength="18" value="<?=$v->citizen_id?>" /></div>
    </div>
    <div class="weui-cell">
      <div class="weui-cell__hd"><label for="name" class="weui-label wy-lab">移动电话 </label></div>
      <div class="weui-cell__bd"><input class="weui-input"  type="text" name="mobile_no" data-validate="required,size(11,11)"
                                           maxlength="11" size="11" value="<?=$v->mobile_no?>" /></div>
    </div>
     <div class="weui-cell">
      <div class="weui-cell__hd"><label for="name" class="weui-label wy-lab">微信号 </label></div>
      <div class="weui-cell__bd"><input class="weui-input"  type="text" name="wechat_id" data-validate="size(2,30)"
                                           maxlength="30" value="<?=$v->wechat_id?>" /></div>
    </div>
     <div class="weui-cell">
      <div class="weui-cell__hd"><label for="name" class="weui-label wy-lab">QQ号 </label></div>
      <div class="weui-cell__bd"><input class="weui-input"  type="text" name="qq_no" data-validate="required,numeric,qq"
                                           maxlength="11" value="<?=$v->qq_no?>" /></div>
    </div>
     <div class="weui-cell">
      <div class="weui-cell__hd"><label for="name" class="weui-label wy-lab">你的业绩 </label></div>
      <div class="weui-cell__bd"><input class="weui-input"  type="text" value="<?=cny($v->turnover)?>" disabled="disabled" /></div>
    </div>
     <div class="weui-cell">
      <div class="weui-cell__hd"><label for="name" class="weui-label wy-lab">你的收益 </label></div>
      <div class="weui-cell__bd"><input class="weui-input"  type="text" value="<?=cny($v->profit)?>" disabled="disabled"  /></div>
    </div>
      <div class="weui-cell">
      <div class="weui-cell__hd"><label for="name" class="weui-label wy-lab">提现总额</label></div>
      <div class="weui-cell__bd"><input class="weui-input"  type="text" value="<?=cny($v->withdraw_volume)?>" disabled="disabled" /></div>
    </div>
      <div class="weui-cell">
      <div class="weui-cell__hd"><label for="name" class="weui-label wy-lab">提现余额 </label></div>
      <div class="weui-cell__bd"><input class="weui-input"  type="text" value="<?=cny($v->real_balance)?>" disabled="disabled" style="color:#f60;" /></div>
    </div>
      <div class="weui-cell">
      <div class="weui-cell__hd"><label for="name" class="weui-label wy-lab">已生效现金卷 </label></div>
      <div class="weui-cell__bd"><input class="weui-input"  type="text" value="<?=cny($v->active_coupon)?>" disabled="disabled" style="color:#f60;" /></div>
    </div>
      <div class="weui-cell">
      <div class="weui-cell__hd"><label for="name" class="weui-label wy-lab">未生效现金卷 </label></div>
      <div class="weui-cell__bd"><input class="weui-input"  type="text" value="<?=cny($v->inactivated_coupon)?>" disabled="disabled" style="color:#f60;" /></div>
    </div>
      <div class="weui-cell">
      <div class="weui-cell__hd"><label for="name" class="weui-label wy-lab">帐号状态 </label></div>
      <div class="weui-cell__bd"><input class="weui-input"  type="text" value="<? if($this->session->userdata('initiation')){echo "代理会员";}else{echo "普通会员";}?>" disabled="disabled" style="" /></div>
    </div>
    
   
   

  </div> 
  <div class="weui-btn-area">
  <inpu class="weui-btn weui-btn_primary"t type="submit" name="btnSubmit" value="修改 "  />
  </div>
   <div id="ie_clearing">&nbsp;</div>
  </form>
</div>

<script src="<?=base_url();?>assets/Mobilecss/lib/jquery-2.1.4.js"></script> 
<script src="<?=base_url();?>assets/Mobilecss/lib/fastclick.js"></script> 
<script type="text/javascript" src="js/jquery.Spinner.js"></script>
<script>
  $(function() {
    FastClick.attach(document.body);
  });
</script>

<script src="<?=base_url();?>assets/Mobilecss/js/jquery-weui.js"></script>
<script src="<?=base_url();?>assets/Mobilecss/js/city-picker.js"></script>

</body>
</html>
