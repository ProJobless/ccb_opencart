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
    	<h3>Facturas de productores</h3>
    	<br/>
      <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="list" style="width: 40% !important; text-align: center;">
          <thead>
            <tr>
              <!--td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td-->
              <td class="left"><a href<?php echo $productor; ?></td>
              <td class="right"><?php echo $numero_factura; ?></td>
              <td class="right"><?php echo $importe_factura; ?></td>
              <td class="right"><?php echo $fecha_factura; ?></td>
            </tr>
          </thead>
          <tbody>
            <?php if ($facturas) { ?>
	            <?php foreach ($facturas as $factura) { 
	               	$action = $factura['action']; 
                        ?>
			            <tr>
			              <!--td style="text-align: center;"><input type="checkbox" name="selected[]" value="<?php echo $saldo['id']; ?>" /></td-->
			              <td class="left">
			              	<a href="<?php echo $action['href']; ?>"><?php echo $factura['manufacturer_name']; ?> </a> 
					</td>
			              <td class="right"><?php echo $factura['numero_factura']; ?></td>
			              <td class="right"><?php echo $factura['importe_factura']; ?></td>
			              <td class="right"><?php echo $factura['fecha_factura']; ?></td>
			            </tr>
	            <?php } ?>
            <?php } else { ?>
            <tr>
              <td class="center" colspan="4"><?php echo $text_no_results; ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>


    	<h3>Comentarios / Asuntos pendientes con productores</h3>
    	<br/>
      <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="list" style="width: 40% !important; text-align: center;">
          <thead>
            <tr>
              <!--td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td-->
              <td class="left"><a href<?php echo $productor; ?></td>
              <td class="right"><?php echo $comentario; ?></td>
              <td class="right"><?php echo $fecha_comentario; ?></td>
            </tr>
          </thead>
          <tbody>
            <?php if ($comentarios) { ?>
	            <?php foreach ($comentarios as $comentario) { 
	               	$action = $comentario['action']; 
                        ?>
			            <tr>
			              <!--td style="text-align: center;"><input type="checkbox" name="selected[]" value="<?php echo $saldo['id']; ?>" /></td-->
			              <td class="left">
			              	<a href="<?php echo $action['href']; ?>"><?php echo $comentario['manufacturer_name']; ?> </a> 
					</td>
			              <td class="right"><?php echo $comentario['comentario']; ?></td>
			              <td class="right"><?php echo $comentario['fecha_comentario']; ?></td>
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