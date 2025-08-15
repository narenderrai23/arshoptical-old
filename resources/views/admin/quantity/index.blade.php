@extends('admin.layouts.app')
@section('panel')



<div > 
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="bugModalLabel">@lang('Download and Upload')</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{route('admin.quantity.download')}}" method="post">
        @csrf
       
        <div class="modal-footer">
          
          <button type="submit" class="btn btn--primary">@lang('Download')</button>
        </div>
      </form>
	<form action="{{route('admin.quantity.update')}}" method="post" enctype='multipart/form-data'>
        @csrf
       
        <div class="modal-footer">
	<input type="file" name="csv" >	
          <button type="submit" class="btn btn--primary">@lang('Upload')</button>
<div >{{@$msg}}
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
@push('breadcrumb-plugins')

@endpush