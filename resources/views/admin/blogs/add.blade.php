@extends('admin.layouts.app')
@section('panel')

        <div class="row">
            <div class="col-lg-12 col-xs-12 col-sm-12">
                <form class="forms-sample" method="post" enctype="multipart/form-data" action="{{route('admin.blogs.store')}}">
					@csrf
                    <div class="form-group row">
                        <div class="col-lg-3">
                            <label class="col-form-label">Title</label>
                        </div>
                        <div class="col-lg-8">
                            <input class="form-control" name="title" type="text" placeholder="Enter title here" value="{{old('title')}}">
                            @if ($errors->has('title'))
                                <span class="help-block">
                                <strong>{{ $errors->first('title') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>


                    <div class="form-group row">
                        <div class="col-lg-3">
                            <label class="col-form-label">Date</label>
                        </div>
                        <div class="col-lg-8">
                            <input class="form-control" name="date" type="date">
                            @if ($errors->has('date'))
                                <span class="help-block">
                                <strong>{{ $errors->first('date') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-3">
                            <label class="col-form-label">Upload Image</label>
                        </div>
                        <div class="col-lg-8">
                            <input class="form-control" name="image" type="file">
                            @if ($errors->has('image'))
                                <span class="help-block">
                                <strong>{{ $errors->first('image') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div> 
                    
                    <div class="form-group row">
                        <div class="col-lg-3">
                            <label class="col-form-label">Description</label>
                        </div>
                        <div class="col-lg-8">
                            <textarea name="desciption" class="form-control border-radius-5 nicEdit" id="" cols="30" rows="10"></textarea>
                            @if ($errors->has('desciption'))
                                <span class="help-block">
                                <strong>{{ $errors->first('desciption') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>  
                   
						
                    <div class="form-group row">
                        <div class="col-lg-8 offset-lg-3">
                            <button type="submit" class="btn btn-primary mr-2"><i class="fa fa-plus me-2"></i> Add</button>
                            <button class="btn btn-light" type="reset">Reset</button>
                        </div>
                    </div>
				</form>
            </div>
        </div>
   
@endsection

@push('breadcrumb-plugins')
<a href="{{ route('admin.product.index') }}" class="btn btn-sm btn--primary box--shadow1 text--small">
    <i class="la la-fw la-backward"></i> @lang('Go Back')
</a>