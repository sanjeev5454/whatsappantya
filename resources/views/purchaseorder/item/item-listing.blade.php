@extends('purchaseorder.layout.app')
@section('title', 'Item Listing')
@section('content')
@include('purchaseorder.layout.partials.sidebar')
<!-- Page -->
<div class="page fix-table">
      <div class="page-content container-fluid">      
        <!-- Panel Table Add Row -->
        <div class="panel">
          <header class="panel-heading page-heading">
            <h3 class="panel-title">Item Management</h3>
            <div class="page-header-actions"><a title="Add Item" class="btn btn-primary" href="{{ url('purchaseorder/add-item') }}"><i class="icon md-plus" aria-hidden="true"></i>Add Item</a></div>
          </header>
          <div class="panel">            
			<?php if(@Session::get('success')!=''){?>			
			<div class="alert alert-success">			
			<a href="javascript:void(0);" class="close" data-dismiss="alert">&times;</a>			
			<?php echo Session::get('success');?>			
			</div>			
			<?php } ?>
           <div class="itemlist-box table-layout-fixed"> 
            <table class="table responsive-table" cellspacing="0" id="exampleAddRow">
              <thead>
                <tr>
                  <th class="th-no">#</th>
                  <th class="th-item-name">Item Name</th>
                  <th class="th-item-sku">Item SKU</th>
				  <th class="th-description">Description</th>
				  <th class="th-unit">Unit</th>
				  <th class="th-price-unit">Price/Unit</th>
				  <th class="th-vendor-name">Vendor Name</th>
				  <th class="th-gst">GST (in %)</th>
                  <th class="th-actions">Actions</th>
                </tr>
              </thead>
              <tbody>
			  @if(!empty($item_data) && $item_data->count())
			  @foreach($item_data as $key=>$data)
			    
                <tr class="gradeA">
                  <td data-table="No.">{{ $key+1 }}</td>
                  <td data-table="Item Name">{{ $data->item_name }}</td>
                  <td data-table="Item SKU">{{ $data->item_sku }}</td>
				  <td data-table="Description">{{ $data->description }}</td>
				  <td data-table="Unit">{{ $data->unit }}</td>
				  <td data-table="Price/Unit">{{ number_format($data->price,2) }}</td>
				  <td data-table="Vendor Name">{{ getVendorName($data->vendor_id) }}</td>
				  <td data-table="GST (in %)">{{ $data->gst }}</td>
                  <td data-table="Actions" class="actions">
                    <a href="{{ url('purchaseorder/edit-item/'.$data->id) }}" class="btn btn-sm btn-icon btn-pure btn-default on-default edit-row"
                      data-toggle="tooltip" data-original-title="Edit"><i class="icon md-edit" aria-hidden="true"></i></a>
                      @if(itemCountPO($data->id)>0)
                      <a href="{{ url('purchaseorder/itemDelete/'.$data->id) }}" onclick="return confirm('This item cannot be deleted as it is a part of one or more Purchase Orders.');" class="btn btn-sm btn-icon btn-pure btn-default on-default remove-row"
                      data-toggle="tooltip" data-original-title="Remove"><i class="icon md-delete" aria-hidden="true"></i></a>
                      @else
                    <a href="{{ url('purchaseorder/itemDelete/'.$data->id) }}" onclick="return confirm('Are you sure to delete the row?');" class="btn btn-sm btn-icon btn-pure btn-default on-default remove-row"
                      data-toggle="tooltip" data-original-title="Remove"><i class="icon md-delete" aria-hidden="true"></i></a>
					  @endif
                  </td>
                </tr>
               @endforeach
				@else
				<tr>
				<td colspan="10">There are no data.</td>
				</tr>
				@endif
              </tbody>
            </table>
		   </div>	
          </div>
        </div>
        <!-- End Panel Table Add Row -->
      </div>
    </div>
<!-- End Page -->
@endsection 

