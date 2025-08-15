@extends('admin.layouts.app')
@section('panel')

<div class="row">
    <div class="col-lg-12">
        <div class="card b-radius--10 ">
            <div class="card-body p-0">
                <div class="table-responsive--sm table-responsive">
                    <table class="table table--light style--two" style="max-width:100%">
                         <th>Sl No</th>
                                <th style="width: 2%;" >Title</th>
                                <th style="width: 50%;">Desciption</th>
                                <th style="width: 24%;">Image</th>
                                
                                <th style="width: 5%;">Action</th>
                            </tr>
                            
                        </thead>
                        <tbody>
                            @php
                            $i=1;
                            @endphp
                            @forelse($blogs as $blog)
                            <tr>
                                <td >{{ $loop->iteration }}</td>
                                <td > {{ substr($blog->title, 0, 30) }}... </td>
                                 <td >{{ substr($blog->desciption, 0, 30) }}...</td>
                               <td data-label="@lang('Banner')">
                                    <div class="thumb">
                                        <div class="thumb">
                                            <img style='max-width: 80px;' src="{{ getImage(imagePath()['blogs']['path'] . '/' . $blog->image, imagePath()['categorybanner']['size']) }}" alt="@lang('image')">
                                        </div>
                                    </div>
                                </td>
                                <td data-label="@lang('Action')">
                                    <a href="{{ route('admin.blogs.edit',$blog->id) }}" class="icon-btn"> <i class="la la-pencil"></i></a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                            </tr>
                            @endforelse

                        </tbody>
                    </table><!-- table end -->
                </div>
            </div>
            @if ($blogs->hasPages())
            <div class="card-footer py-4">
                {{ paginateLinks($blogs) }}
            </div>
            @endif
        </div><!-- card end -->
    </div>
</div>

@endsection

@push('breadcrumb-plugins')

<a href="{{ route('admin.blogs.create') }}" class="btn btn-sm btn--primary mr-2 d-flex align-items-center">
    <i class="las la-plus"></i>
    @lang('Add new')
</a>

<form method="GET" class="form-inline float-sm-right bg--white search-form">
    <div class="input-group has_append">
        <input type="text" name="search" id="mySearch" class="form-control" placeholder="@lang('Blog Title')"
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
                var modal = $('#editBrand');
                var featured = $(this).data('featured');
                var status = $(this).data('status');
                modal.find('form').attr('action', `{{ route('admin.blogs.store','') }}/${$(this).data('id')}`);
                modal.find('input[name=name]').val($(this).data('name'));

                if ($(this).data('status') == 1) {
                    modal.find('input[name=status]').bootstrapToggle('on');
                } else {
                    modal.find('input[name=status]').bootstrapToggle('off');
                }

               
                var x = $(this).data('image');
                $(".profilePicPreview").css("background-image",
                    `url({{ asset('assets/images/blog/${x}') }})`);

            });
            $('.deleteButton').on('click', function() {
                var modal = $('#deletebrand');
                modal.find('input[name=id]').val($(this).data('id'));
                modal.find('input[name=status]').val($(this).data('status'));
                modal.find('.modal-detail').text(`@lang('Are you sure to delete this bog?')`);
            });
            $('.restoreButton').on('click', function() {
                var modal = $('#restorebrand');
                modal.find('input[name=id]').val($(this).data('id'));
                modal.find('input[name=status]').val($(this).data('status'));
                modal.find('.modal-detail').text(`@lang('Are you sure to restore this blog?')`);
            });
        })(jQuery);
</script>
@endpush