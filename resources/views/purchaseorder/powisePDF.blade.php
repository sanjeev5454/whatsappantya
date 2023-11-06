<!DOCTYPE html>

<html>
<head>
<style>
* {
	margin:0;
	padding:0;
}
body * {
	font-size:9px;
	padding:0;
	margin:0;
	font-family:Arial, Helvetica, sans-serif;
}
h2.first {
	color: #000000;
	font-size: 12pt;
	text-align: center;
}
.lowercase {
	text-transform: lowercase;
}
.uppercase {
	text-transform: uppercase;
}
.capitalize {
	text-transform: capitalize;
}
/*table {
	width: 100%;
	font-size:9px;
	font-family:Arial, Helvetica, sans-serif;
	margin-bottom:20px;
	border-collapse:collapse;
}
table, th, td {
	padding:2px 5px;
	text-align: center;
	font-family:Arial, Helvetica, sans-serif;
	font-size:9px;
	border-collapse:collapse;
}
table th {
	white-space:nowrap;
}*/
table.border-table {
	border-collapse:collapse;
}
table.border-table th, table.border-table td {
	border:.2px solid #000;
	border-collapse:collapse;
	vertical-align:middle;
}
table.test-table{ border:0px solid #000; border-collapse:separate; }
table.test-table tr td { border-bottom:1px solid #000; border-top:0 none; border-left:0 none; border-right:0 none; }

table.new-test-table{ border:0px solid #000; border-collapse:separate; }
table.new-test-table tr td { border-bottom:1px solid #000; border-top:0 none; border-left:1px solid #000; border-right:0 none; }


</style>
</head>

<body>
<table width="100%" border="0" cellpadding="3" cellspacing="0">
  <tr>
    <td align="center" valign="middle" style="font-size:20px;"><img src="https://themesofwp.com/wpxproduct/assets/images/logo.png" alt="Antya" style="width:100px; height:30px" />
      <div style="font-size:9px;">A-14/2, Block A,  Nariana Industrial<br> Area Phase-2,  New Delhi,  Delhi 110028</div></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="5" cellspacing="0" >
        <tr>
          <th style="text-align:center;"><strong>Vendor: </strong> {{ $vendor }}</th>
        </tr>        
      </table></td>
  </tr>
 <tr>
     <td>
         <table class="table responsive-table dataTable center-table po-view border-table" id="editableTable1" cellspacing="0" cellpadding="5" width="100%" bordercolor="#e5e5e5" style=" border-collapse:collapse; ">
        <thead>
        <tr class="white-space-tr" style="background-color: #e5e5e5;">
        <th class="po-th" width="85">PO#</th>
        <th class="Item-th" width="135">Item</th>
        <th class="Item-th" width="135">Item SKU</th>
        <th class="Item-th" width="135">Notes</th>
        <th class="pending-quantity-th" width="85">Pending Quantity</th>
        </tr>
        </thead>
        <tbody id="result-data">
        <?php
        $total = 0;
        foreach($purchase_data_val as $data){
        if($data['order_number']!='' && purchaseOrderDetails($data['order_number'])->contact==$vendor){
         $data_update_val = purchaseDataUpdateDetails($data['order_number']);
         $w=0;
         foreach($data_update_val as $key=>$data_v){
         if(($data_v['quantity']-$data_v['qty_received'])>0 && purchase_details($data_v['purchase_order_id'])==1){
         $c = selectPDFRecord($data['order_number'],$vendor);
        ?>
        <tr <?php if($w==0){?> class="po-show" <?php }?>>
        <?php if($w==0){?>
        <td <?php if($w==0){?> rowspan="<?php echo count($c);?>" class="po-show" <?php }else{ ?> class="po-hide" <?php } ?> data-table="PO#"><?php if($w==0){?>PO-<?php echo $data['order_number'];?><?php } ?></td>
        <?php } ?>
        <td data-table="Item"><?php echo ItemDetails($data_v['item']);?></td>
        <td data-table="Item SKU"><?php echo ItemSKU($data_v['item']);?></td>
        <td data-table="Notes"><?php echo purchaseOrderDetails($data['order_number'])->address['instruction'];?></td>
        <td data-table="Pending Quantity" style="text-align:center;"><?php echo $data_v['quantity']-$data_v['qty_received'];?></td>
        </tr>
        <?php $total += $data_v['quantity']-$data_v['qty_received'];$w++;}}}} ?> 
        <?php if($total>0){?>
        <tr>
        <td colspan="4" class="right" style="text-align:right">Total : </td>
        <td data-table="Total :" style="text-align:center"><strong><?php echo $total;?></strong></td>
        </tr>
        <?php }else{?>
        <tr>
        <td colspan="5" class="no-data-table" align="center">There are no purchase orders to display.</td>
        </tr>
        <?php } ?>
        </tbody>
        </table>
     </td>
     </tr>
</table>
</body>
</html>
