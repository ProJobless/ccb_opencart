<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<?php if ($success) { ?>
<div class="success"><?php echo $success; ?></div>
<?php } ?>
<center>
<table class="list" style="width: 70% !important;">
  <thead>
    <tr>
      <td class="left"><?php echo $column_date_added; ?></td>
      <td class="left"><?php echo $column_description; ?></td>
      <td class="right"><?php echo $column_cuenta; ?></td>
      <td class="right"><?php echo $column_amount; ?></td>
    </tr>
  </thead>
  <tbody>
    <?php if ($transactions) { ?>
	    <?php foreach ($transactions as $transaction) { ?>
	    <tr>
	      <td class="left"><?php echo $transaction['date_added']; ?></td>
	      <td class="left"><?php echo $transaction['description']; ?></td>
	      <td class="right">
	      	<?php if($transaction['tipo_cuenta']=='0') {?>
	      		<?php echo $text_cuenta_pedidos; ?>
	      	<?php } else if($transaction['tipo_cuenta']=='1') {?>
	      		<?php echo $text_cuenta_gastos; ?>
	      	<?php } else if($transaction['tipo_cuenta']=='2') {?>
	      		<?php echo $text_comentario; ?>
	      	<?php }?>
	      </td>
	      <td class="right"><?php echo $transaction['amount']; ?></td>
	    </tr>
	    <?php } ?>
	    <tr>
	      <td>&nbsp;</td>
	      <td>&nbsp;</td>
	      <td class="right"><b><?php echo $text_balance_pedidos; ?></b></td>
	      <td class="right"><?php echo $balance_pedidos; ?></td>
	    </tr>
	    <tr>
	      <td>&nbsp;</td>
	      <td>&nbsp;</td>
	      <td class="right"><b><?php echo $text_balance_gastos; ?></b></td>
	      <td class="right"><?php echo $balance_gastos; ?></td>
	    </tr>
    <?php } else { ?>
    <tr>
      <td class="center" colspan="4"><?php echo $text_no_results; ?></td>
    </tr>
    <?php } ?>
  </tbody>
</table>
<div class="pagination"><?php echo $pagination; ?></div>
</center>
