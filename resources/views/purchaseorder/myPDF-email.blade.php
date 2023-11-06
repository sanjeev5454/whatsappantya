<!DOCTYPE html>

<html>
<head>
<style>
* {
	margin:0;
	padding:0;
}
body * {
	font-size:10px;
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
table {
	width: 100%;
	font-size:9px;
	font-family:Arial, Helvetica, sans-serif;
	margin-bottom:20px;
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
}
table.border-table {
	border-collapse:collapse;
}
table.border-table th, table.border-table td {
	border:.2px solid #000;
	border-collapse:collapse;
	vertical-align:middle;
}
</style>
</head>

<body>
<table width="100%" border="0" cellpadding="3" cellspacing="0">
  <tr>
    <td align="center" valign="middle" style="font-size:20px;"><img src="https://themesofwp.com/wpxproduct/assets/images/logo.png" alt="Antya" style="width:100px; height:30px" />
      <div style="font-size:9px;">A-14/2, Block A,  Nariana Industrial<br> Area Phase-2,  New Delhi,  Delhi 110028</div></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="5" cellspacing="0" class="border-table">
        <tr style="background-color: #e5e5e5;">
          <th><strong>P.O NUMBER</strong></th>
          <th><strong>P.O DATE</strong></th>
          <th><strong>DELIVERY DATE</strong></th>
        </tr>
        <tr>
          <td>{{ 'PO-'.$purchase_data->order_number }}</td>
          <td>{{ $purchase_data->date }}</td>
          <td>{{ $purchase_data->delivery_date }}</td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="5" cellspacing="0" class="border-table">
        <tr style="background-color: #e5e5e5;">
          <th><strong>VENDOR DETAILS</strong></th>
          <th><strong>VENDOR ADDRESS</strong></th>
           @if($purchase_data->address['attention']!='')
          <th><strong>KIND ATTENTION</strong></th>
          @endif
        </tr>
        <tr>
        <td>{{ vendorDetails($purchase_data->contact)['vendor_name'] }}  <br>Mobile No.:{{ vendorDetails($purchase_data->contact)['mobile_number'] }} </td>
          <td>{{ vendorDetails($purchase_data->contact)['address'] }}</td>
          @if($purchase_data->address['attention']!='')
            <td>{{ $purchase_data->address['attention'] }}</td> 
            @endif
        </tr>
      </table></td>
  </tr>
  @for($i=1;$i<=count($purchase_data->row);$i++)
  <tr>
    <td><table  width="100%" border="0" cellpadding="5" cellspacing="0" class="border-table">
  <tr>
    <th style="background-color: #e5e5e5; border-right:1px solid #cdcdcd; border-bottom:1px solid #cdcdcd" width="35px">Item</th>
    <td colspan="7" width="471px" style="border-right:1px solid #cdcdcd; border-left:1px solid #cdcdcd; border-bottom:1px solid #cdcdcd; text-align:left">{{ ItemDetails($purchase_data->row[$i]['item']) }}</td>
    <td rowspan="3" valign="center" width="74px"  style="border-left:1px solid #cdcdcd;"><br>
      <p>{{ $purchase_data->row[$i]['amount'] }}</p></td>
  </tr>
  <tr>
    <th style="background-color: #e5e5e5; border-right:1px solid #cdcdcd; border-top:1px solid #cdcdcd; border-bottom:1px solid #cdcdcd;">SKU</th>
    <td colspan="7" width="471px" style="border-right:1px solid #cdcdcd; border-left:1px solid #cdcdcd; border-top:1px solid #cdcdcd; border-bottom:1px solid #cdcdcd; text-align:left">{{ ItemSKU($purchase_data->row[$i]['item']) }}</td>
  </tr>
  <tr>
    <th style="background-color: #e5e5e5; border-right:1px solid #cdcdcd; border-top:1px solid #cdcdcd;">Unit</th>
    <td style="border-right:1px solid #cdcdcd; border-top:1px solid #cdcdcd; border-left:1px solid #cdcdcd;">{{ $purchase_data->row[$i]['unit'] }}</td>
    <th style="background-color: #e5e5e5; border-right:1px solid #cdcdcd; border-top:1px solid #cdcdcd; border-left:1px solid #cdcdcd;" width="47px">Qty</th>
    <td style="border-right:1px solid #cdcdcd; border-top:1px solid #cdcdcd; border-left:1px solid #cdcdcd;" width="47px">{{ $purchase_data->row[$i]['quantity'] }}</td>
    <th style="background-color: #e5e5e5; border-right:1px solid #cdcdcd; border-top:1px solid #cdcdcd; border-left:1px solid #cdcdcd;" width="45px">Size</th>
    <td style="border-right:1px solid #cdcdcd; border-top:1px solid #cdcdcd; border-left:1px solid #cdcdcd;" width="45px">{{ $purchase_data->row[$i]['size'] }}</td>
    <th style="background-color: #e5e5e5; border-right:1px solid #cdcdcd; border-top:1px solid #cdcdcd; border-left:1px solid #cdcdcd;"  width="50px">Price</th>
    <td style="border-right:1px solid #cdcdcd; border-top:1px solid #cdcdcd; border-left:1px solid #cdcdcd;" width="60px">{{ number_format($purchase_data->row[$i]['price'],2) }}</td>
    <th style="background-color: #e5e5e5;border-right:1px solid #cdcdcd; border-top:1px solid #cdcdcd; border-left:1px solid #cdcdcd;" width="55px">Disc.%</th>
    <td style="border-right:1px solid #fff; border-top:1px solid #cdcdcd; border-left:1px solid #cdcdcd;" width="55px">{{ $purchase_data->row[$i]['disc'] }}</td>
  </tr>
</table></td>
  </tr>
  @endfor
  <tr>
    <td><table width="100%" border="0" cellpadding="5" cellspacing="0" class="border-table">
        <tr>
          <td align="right" style="font-weight:bold; background-color: #e5e5e5;" width="506px">Subtotal</td>
          <td align="right" width="74px">{{ $purchase_data->subtotal }}</td>
        </tr>
        <tr>
          <td align="right" style="font-weight:bold; background-color: #e5e5e5;">GST</td>
          <td align="right">{{ $purchase_data->gst_total }}</td>
        </tr>
        <tr>
          <td align="right" style="font-weight:bold; background-color: #e5e5e5;">Total</td>
          <td align="right"><strong>{{ $purchase_data->total }}</strong></td>
        </tr>
      </table></td>
  </tr>
  @if($purchase_data->address['instruction']!='')
  <tr>
    <td><table width="100%" border="0" cellpadding="5" cellspacing="0" class="border-table">
        <tr style="background-color: #e5e5e5;">
          <th><strong>NOTES</strong></th>
        </tr>
        <tr>
          <td>{{stripslashes($purchase_data->address['instruction'])}}</td>
        </tr>
      </table></td>
  </tr>
  @endif
  <tr>
    <td><table width="100%" border="0" cellpadding="5" cellspacing="0" class="border-table">
        <tr style="background-color: #e5e5e5;">
          <th><strong>DELIVERY ADDRESS</strong></th>
        </tr>
        <tr>
          <td>{{$purchase_data->address['delivery_address_street_address']}},
            
            {{$purchase_data->address['delivery_address_town_city']}}<br>
            {{$purchase_data->address['delivery_address_state_region']}},
            
            {{$purchase_data->address['delivery_address_zip_code']}}
            
            {{$purchase_data->address['delivery_address_country']}} </td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="5" cellspacing="0" class="border-table">
        <tr style="background-color: #e5e5e5;">
          <th><strong>ISSUED BY</strong></th>
        </tr>
        <tr>
          <td><strong>M/S ANTYA</strong><br>
            Computer generated Purchase Orders need not be signed
            <div style="height:200px; width:100%; font-size:7px;"><br>
              <br>
              <br>
              <br>
            </div></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
