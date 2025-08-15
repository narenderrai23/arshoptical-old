
@extends('admin.layouts.app')
@section('panel')
<form class="forms-sample" method="post" enctype="multipart/form-data" action="{{route('admin.subcategory.updateorder')}}">
                    @csrf
<div class="row">
    <div class="col-lg-12">
        <div class="card b-radius--10 ">
            <div class="card-body p-0">
                <div class="table-responsive--sm table-responsive">
                    <button id="up" type="submit" class="btn btn-sm btn--primary mr-2 d-flex align-items-center add-new-btn">Update Order</button>
                <span>drag and drop items for new orderno and update</span>
                    <table class="table table--light style--two" id="dataTableExample">
                        <thead>
                            <tr>
                                <th>@lang('S.N.')</th>
				<th>@lang('CatID')</th>
                                <th> @lang('Name')</th>
                <th> @lang('Banner')</th>
                                <th> @lang('Price')</th>
                                <th>@lang('Category')</th>
                                <th>@lang('OrderNo')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('SpecialOffer')</th>
                                <th>@lang('BestSeller')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($subcategories as $subcategory)
                            <tr>
                                <td data-label="@lang('S.N.')">{{ $loop->index + $subcategories->firstItem() }}</td>
				<td >{{ $subcategory->category_id.','.$subcategory->id }}</td>
                                <td data-label="@lang('Name')">
                                    <div class="thumb">
                                        <div class="thumb">
                                            <img style='max-width: 100px;' src="{{ getImage(imagePath()['category']['path'] . '/' . $subcategory->image, imagePath()['category']['size']) }}" alt="@lang('image')">
                                        </div>
                    

                                        <span class="name"><input type="hidden" value="{{__($subcategory->id)}}" name="order[]"/>{{ __($subcategory->name) }}</span>
                                    </div>
                                </td>
                <td data-label="@lang('Banner')">
                                    <div class="thumb">
                                        <div class="thumb">
                                            <img style='max-width: 100px;' src="{{ getImage(imagePath()['categorybanner']['path'] . '/' . $subcategory->banner, imagePath()['categorybanner']['size']) }}" alt="@lang('image')">
                                        </div>
                    

                                        
                                    </div>
                                </td>
                                <td data-label="@lang('Price')">
                                    <div class="thumb">
                                        <span class="name">{{ __($subcategory->price) }}</span>
                                    </div>
                                </td>
                                <td data-label="@lang('Category')">
                                    <div class="thumb">
                                        <span class="name">{{ __($subcategory->category->name ?? '') }}</span>
                                    </div>
                                </td>

                                 <td data-label="@lang('OrderNo')">
                                
                                    <span class="text--small badge font-weight-normal badge--danger">
                                       {{ __($subcategory->orderno) }}
                                    </span>
                               

                                </td>

                                <td data-label="@lang('Status')">
                                    @if ($subcategory->status == 1)
                                    <span class="text--small badge font-weight-normal badge--success">
                                        @lang('Enabled')
                                    </span>
                                    @else
                                    <span class="text--small badge font-weight-normal badge--danger">
                                        @lang('Disabled')
                                    </span>
                                    @endif
                                </td>

                                <td data-label="@lang('Special Offer')">
                                    @if ($subcategory->special_offer == 1)
                                    <span class="text--small badge font-weight-normal badge--primary">
                                        @lang('Yes')
                                    </span>
                                    @else
                                    <span class="text--small badge font-weight-normal badge--danger">
                                        @lang('No')
                                    </span>
                                    @endif

                                </td>
                                <td data-label="@lang('Best Seller')">
                                    @if ($subcategory->best_seller == 1)
                                    <span class="text--small badge font-weight-normal badge--primary">
                                        @lang('Yes')
                                    </span>
                                    @else
                                    <span class="text--small badge font-weight-normal badge--danger">
                                        @lang('No')
                                    </span>
                                    @endif

                                </td>
                                <td data-label="@lang('Action')">
                                    <button class="icon-btn editButton" type="button" data-toggle="modal"
                                        data-id="{{ $subcategory->id }}" data-name="{{ __($subcategory->name) }}"
                                        data-category="{{ __($subcategory->category_id) }}"
                                        data-price="{{ __($subcategory->price) }}"
                                        data-metatitle="{{ __($subcategory->metatitle) }}"
                                        data-metadescription="{{ __($subcategory->metadescription) }}"
                                        data-metakeywords="{{ __($subcategory->metakeywords) }}"
                                        data-status="{{ __($subcategory->status) }}"
                                        data-featured="{{ __($subcategory->featured) }}"
                                        data-special_offer="{{ __($subcategory->special_offer) }}"
                                        data-best_seller="{{ __($subcategory->best_seller) }}"
                                        data-image="{{ __($subcategory->image) }}"
                                        data-banner="{{ __($subcategory->banner) }}"
                                        data-pdf="{{ __($subcategory->pdf) }}"
                                        data-target="#editSubcategory"
                                        data-original-title="@lang('Edit')">
                                        <i class="la la-pencil"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                            </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>
            @if ($subcategories->hasPages())
            <div class="card-footer py-4">
                {{ paginateLinks($subcategories) }}
            </div>
            @endif
        </div>
    </div>
</div>
</form>
<div id="createSubcategory" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Add New Subcategory')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.subcategory.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-control-label font-weight-bold">@lang('Category Name') <span class="text-danger">*</span></label>
                        <select name="category_id" class="form-control">
                            <option value="" selected disabled>@lang('Select One')</option>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ __($category->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label font-weight-bold">@lang('Name') <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" />
                    </div>
                        <div class="form-group">
                        <label class="form-control-label font-weight-bold">@lang('Price') <span class="text-danger">*</span></label>
                        <input type="text" name="price" class="form-control" value="{{ old('price') }}" />
                    </div>
                <div class="col-md-12 " id="fileSection">
                            <div class="form-group">
                                <label class="form-control-label font-weight-bold">@lang('Upload File') <span
                                        class="text-danger">*</span></label>
                                <div class="custom-file">
                                    <input type="file" name="digi_file" class="custom-file-input" id="inputGroupFile01"
                                        aria-describedby="inputGroupFileAddon01">
                                    <label class="custom-file-label" for="inputGroupFile01">@lang('Choose file')</label>
                                </div>
                                <small class="mt-2 text-facebook">@lang('Supported files'): <b>@lang('pdf') </b></small>
                            </div>
                        </div>

                    <div class="form-group">
                        <label class="form-control-label font-weight-bold">
                            @lang('MetaTitle') <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="metatitle" class="form-control" value="{{ old('metatitle') }}" />
                    </div>

                     <div class="form-group">
                        <label class="form-control-label font-weight-bold">
                            @lang('MetaDescription') <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="metadescription" class="form-control" value="{{ old('metadescription') }}" />
                    </div>

                     <div class="form-group">
                        <label class="form-control-label font-weight-bold">
                            @lang('MetaKeywords') <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="metakeywords" class="form-control" value="{{ old('metakeywords') }}" />
                    </div>


                     <div class="form-group">
                        <label class="form-control-label font-weight-bold">@lang('Image') <span
                                class="text-danger">*</span></label>
                        <div class="image-upload">
                            <div class="thumb">
                                <div class="avatar-preview">
                                    <div class="profilePicPreview"
                                        style="background-image: url({{ getImage('/', imagePath()['category']['size']) }})">
                                        <button type="button" class="remove-image">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="avatar-edit">
                                    <input type="file" class="profilePicUpload" name="image" id="profilePicUpload1"
                                        accept=".png, .jpg, .jpeg">
                                    <label for="profilePicUpload1" class="bg--primary">@lang('Upload Image')</label>
                                    <small class="mt-2 text-facebook">@lang('Supported files'):
                                        <b>@lang('jpeg'), @lang('jpg'), @lang('png').</b>
                                        @lang('Image will be resized into 1080x1080')
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>


          <div class="form-group">
                        <label class="form-control-label font-weight-bold">@lang('Banner') <span
                                class="text-danger">*</span></label>
                        <div class="image-upload">
                            <div class="thumb">
                                <div class="avatar-preview">
                                    <div class="profilePicPreview"
                                        style="background-image: url({{ getImage('/', imagePath()['categorybanner']['size']) }})">
                                        <button type="button" class="remove-image">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="avatar-edit">
                                    <input type="file" class="profilePicUpload" name="banner" id="profilePicUpload"
                                        accept=".png, .jpg, .jpeg">
                                    <label for="profilePicUpload" class="bg--primary">@lang('Upload Banner')</label>
                                    <small class="mt-2 text-facebook">@lang('Supported files'):
                                        <b>@lang('jpeg'), @lang('jpg'), @lang('png').</b>
                                        @lang('Image will be resized into 1920x500')
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                      <div class="form-group">
                        <label class="form-control-label font-weight-bold">
                            @lang('SpecialOffer')
                        </label>
                        <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger"
                            data-toggle="toggle" data-on="@lang('Yes')" data-off="@lang('No')" name="special_offer">
                    </div>
                     <div class="form-group">
                        <label class="form-control-label font-weight-bold">
                            @lang('BestSeller')
                        </label>
                        <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger"
                            data-toggle="toggle" data-on="@lang('Yes')" data-off="@lang('No')" name="best_seller">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn--primary w-100">@lang('Submit')</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="editSubcategory" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Update Subcategory')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-control-label font-weight-bold">@lang('Category Name') <span class="text-danger">*</span></label>
                        <select name="category_id" id="edit_category_id" class="form-control">
                            <option value="" selected disabled>@lang('Select one')</option>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ __($category->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label font-weight-bold">@lang('Name')<span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="" />
                    </div>
                    <div class="form-group">
                        <label class="form-control-label font-weight-bold">@lang('price')<span class="text-danger">*</span></label>
                        <input type="text" name="price" class="form-control" value="" />
                    </div>
                <div class="col-md-12 " id="fileSection">
                            <div class="form-group">
                                <label class="form-control-label font-weight-bold">@lang('Upload File') <span
                                        class="text-danger">* OLD File<input type="text" name="pdf" disabled="disabled" class="form-control" value="{{ old('pdf') }}" /></span></label>
                                <div class="custom-file">
                                
                                    <input type="file" name="digi_file" class="custom-file-input" id="inputGroupFile01"
                                        aria-describedby="inputGroupFileAddon01">
                                    <label class="custom-file-label" for="inputGroupFile01">@lang('Choose file')</label>
                                </div>
                                <small class="mt-2 text-facebook">@lang('Supported files'): <b>@lang('pdf') </b></small>
                            </div>
                        </div>

                      <div class="form-group">
                        <label class="form-control-label font-weight-bold">
                            @lang('MetaTitle') <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="metatitle" class="form-control" value="{{ old('metatitle') }}" />
                    </div>

                     <div class="form-group">
                        <label class="form-control-label font-weight-bold">
                            @lang('MetaDescription') <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="metadescription" class="form-control" value="{{ old('metadescription') }}" />
                    </div>

                     <div class="form-group">
                        <label class="form-control-label font-weight-bold">
                            @lang('MetaKeywords') <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="metakeywords" class="form-control" value="{{ old('metakeywords') }}" />
                    </div>
                          <div class="form-group">
                        <label class="form-control-label font-weight-bold">@lang('Image') <span
                                class="text-danger">*</span></label>
                        <div class="image-upload">
                            <div class="thumb">
                                <div class="avatar-preview">
                                    <div class="profilePicPreview"
                                        style="background-image: url({{ getImage('/', imagePath()['category']['size']) }})">
                                        <button type="button" class="remove-image">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="avatar-edit">
                                    <input type="file" class="profilePicUpload" name="image" id="profilePicUpload2"
                                        accept=".png, .jpg, .jpeg">
                                    <label for="profilePicUpload2" class="bg--primary">@lang('Upload
                                        Image')</label>
                                    <small class="mt-2 text-facebook">@lang('Supported files'):
                                        <b>@lang('jpeg'), @lang('jpg').</b> @lang('Image will be resized into
                                        1080x1080') </small>
                                </div>
                            </div>
                        </div>
                    </div>

                   <div class="form-group">
                        <label class="form-control-label font-weight-bold">@lang('Banner') <span
                                class="text-danger">*</span></label>
                        <div class="image-upload">
                            <div class="thumb">
                                <div class="avatar-preview">
                                    <div class="profilePicPreview" id="profilePicPreview2"
                                        style="background-image: url({{ getImage('/', imagePath()['categorybanner']['size']) }})">
                                        <button type="button" class="remove-image">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="avatar-edit">
                                    <input type="file" class="profilePicUpload" name="banner" id="profilePicUpload3"
                                        accept=".png, .jpg, .jpeg">
                                    <label for="profilePicUpload3" class="bg--primary">@lang('Upload
                                        Banner')</label>
                                    <small class="mt-2 text-facebook">@lang('Supported files'):
                                        <b>@lang('jpeg'), @lang('jpg').</b> @lang('Banner will be resized into
                                        1920x500') </small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-control-label font-weight-bold"> @lang('Status')</label>
                        <input type="checkbox" id="status" data-width="100%" data-onstyle="-success"
                            data-offstyle="-danger" data-toggle="toggle" data-on="@lang('Enable')"
                            data-off="@lang('Disabled')" name="status">
                    </div>

                      <div class="form-group">
                        <label class="form-control-label font-weight-bold">
                            @lang('SpecialOffer')
                        </label>
                        <input type="checkbox" id="header" data-width="100%" data-onstyle="-success"
                            data-offstyle="-danger" data-toggle="toggle" data-on="@lang('Yes')" data-off="@lang('No')"
                            name="special_offer">
                    </div>
                    <div class="form-group">
                        <label class="form-control-label font-weight-bold">
                            @lang('BestSeller')
                        </label>
                        <input type="checkbox" id="header" data-width="100%" data-onstyle="-success"
                            data-offstyle="-danger" data-toggle="toggle" data-on="@lang('Yes')" data-off="@lang('No')"
                            name="best_seller">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn--primary w-100">@lang('Submit')</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('breadcrumb-plugins')
<a data-toggle="modal" href="#createSubcategory" class="btn btn-sm btn--primary mr-2 d-flex align-items-center add-new-btn">
    <i class="las la-plus"></i> @lang('Add new')
</a>

<form method="GET" class="form-inline float-sm-right bg--white search-form">
    <div class="input-group has_append">
        <input type="text" name="search" id="mySearch" class="form-control" placeholder="@lang('Search here')"
            value="{{ request()->search }}">
        <div class="input-group-append">
            <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
        </div>
    </div>
</form>
@endpush
@push('script')
<script>
    (function($) {
        "use strict"
        $('.editButton').on('click', function() {

            var modal = $('#editSubcategory');
            var featured = $(this).data('featured');
            var status = $(this).data('status');
            modal.find('form').attr('action', `{{ route('admin.subcategory.store','') }}/${$(this).data('id')}`);
            modal.find('input[name=name]').val($(this).data('name'));
            modal.find('input[name=price]').val($(this).data('price'));
            modal.find('input[name=name]').val($(this).data('name'));
                modal.find('input[name=metatitle]').val($(this).data('metatitle'));
                modal.find('input[name=metadescription]').val($(this).data('metadescription'));
                modal.find('input[name=metakeywords]').val($(this).data('metakeywords'));
            modal.find('input[name=pdf]').val($(this).data('pdf'));
            modal.find('select[name=category_id]').val($(this).data('category'));
           
            if ($(this).data('status') == 1) {
                modal.find('input[name=status]').bootstrapToggle('on');
            } else {
                modal.find('input[name=status]').bootstrapToggle('off');
            }
            if ($(this).data('special_offer') == 1) {
                    modal.find('input[name=special_offer]').bootstrapToggle('on');
            } else {
                    modal.find('input[name=special_offer]').bootstrapToggle('off');
            }
            if ($(this).data('best_seller') == 1) {
                    modal.find('input[name=best_seller]').bootstrapToggle('on');
            } else {
                    modal.find('input[name=best_seller]').bootstrapToggle('off');
            }
             var x = $(this).data('image');
                $(".profilePicPreview").css("background-image", `url({{ asset('assets/images/category/${x}') }})`);

        var y = $(this).data('banner');
                $("#profilePicPreview2").css("background-image", `url({{ asset('assets/images/categorybanner/${y}') }})`);

        });

    })(jQuery);
</script>
 <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript"  src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.24/jquery-ui.min.js">
      </script>
    <script>
        $(function () {
            $("#dataTableExample").sortable({
                items: 'tr',
                dropOnEmpty: true,
                start: function (G, ui) {
                    ui.item.addClass("select");
                },
                stop: function (G, ui) {
                    ui.item.removeClass("select");
                    $(this).find("tr").each(function (GFG) {
                        if (GFG >= 0) {
                            $(this).find("td").eq(0).html(GFG);
                        }
                    });
                }
            });
        });
    </script>
@endpush