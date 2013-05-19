<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  
  <?php if ($success) { ?>
  <div class="success"><?php echo $success; ?></div>
  <?php } ?>
  
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/information.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
      	<!--
      	<a onclick="location = '<?php echo $insert; ?>'" class="button"><?php echo $button_insert; ?></a>
      	<a onclick="$('form').submit();" class="button"><?php echo $button_delete; ?></a>
      	-->
      </div>
    </div>

    <div class="content">
     	<center>
    	El saldo total para gastos es : <h3><?php echo $balance_total; ?></h3>
    	<br/>
      <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="list" style="width: 40% !important; text-align: center;">
          <thead>
            <tr>
              <!--td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td-->
              <td class="left"><a href<?php echo $cliente; ?></td>
              <td class="right"><?php echo $saldo; ?></td>
            </tr>
          </thead>
          <tbody>
            <?php if ($saldos) { ?>
	            <?php foreach ($saldos as $saldo) { ?>
	               	<?php $action = $saldo['action']; 
                          $signo = substr($saldo['saldo'],0,1);
                          $color = ($signo=="-")? "red":"blue";
                          ?>
			            <tr>
			              <!--td style="text-align: center;"><input type="checkbox" name="selected[]" value="<?php echo $saldo['id']; ?>" /></td-->
			              <td class="left">
			              	<a href="<?php echo $action['href']; ?>"><?php echo $saldo['firstname']; ?> <?php echo $saldo['lastname']; ?></a> 
										</td>
			              <td class="right"><font color="<?php echo $color;?>"><?php echo $saldo['saldo']; ?></font></td>
			            </tr>
	            <?php } ?>
            <?php } else { ?>
            <tr>
              <td class="center" colspan="4"><?php echo $text_no_results; ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </center>
      </form>
      <!--div class="pagination"><?php echo $pagination; ?></div-->
    </div>
  </div>
</div>
<?php echo $footer; ?>