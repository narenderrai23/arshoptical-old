@extends('admin.layouts.app')
@section('panel')

<div class="row" style="padding:10px;">
    <div class="col-lg-12">
        <div class="card b-radius--10 ">
                <div class="card-body p-0">
                   <div class="d-flex flex-wrap justify-content-end text-sm-right right-part">
            
<a  href="https://www.arshoptical.com/admin/customer/export" class="btn btn-sm btn--primary mr-2 d-flex align-items-center add-new-btn">
    <i class="las la-plus"></i>
    Download All</a>



        </div>
                </div>
        </div>
    </div>
</div>


    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('User')</th>
                                    <th>@lang('Phone')</th>
				                    <th>@lang('Company')</th>
                                    <th>@lang('Discount')</th>
                                     <th>@lang('City')</th>
                                    <th>@lang('State')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!--discount-->
                                <!--city-->
                                @forelse($users as $user)
                              
                                    <tr>
                                        <td data-label="@lang('User')">
                                            <span class="font-weight-bold">{{ $user->fullname }}</span>
                                            <br>
                                            <span class="small">
                                                <a
                                                    href="{{ route('admin.users.detail', $user->id) }}"><span>@</span>{{ $user->username }}</a>
                                            </span>
                                        </td>
                                         <td data-label="@lang('Phone')">
                                            <span class="font-weight-bold" data-toggle="tooltip"
                                                data-original-title="{{ $user->mobile }}">{{ $user->mobile }}</span>
                                        </td>
					
					                    <td data-label="@lang('Company')">
                                            {{ $user->company}}
                                        </td>
                                        <td data-label="@lang('Discount')">
                                            {{ $user->discount }}
                                        </td>
                                       
                                          <td data-label="@lang('city')">
                                            <span class="font-weight-bold" data-toggle="tooltip"
                                                data-original-title="{{ $user->address->city }}">{{ $user->address->city }}</span>
                                        </td>



                                        <td data-label="@lang('state')">
                                          {{ @$user->address->state}}
                                        </td>


                                        <td data-label="@lang('Action')">
                                            <a href="{{ route('admin.users.detail', $user->id) }}" class="icon-btn"
                                                data-toggle="tooltip" title="" data-original-title="@lang('Details')">
                                                <i class="las la-desktop text--shadow"></i>
                                            </a>
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
                @if ($users->hasPages())
                <div class="card-footer py-4">
                    {{ paginateLinks($users) }}
                </div>
                @endif
            </div>
        </div>


    </div>
@endsection



@push('breadcrumb-plugins')
    <form
        action="{{ route(
            'admin.users.search',
            $scope ??
                str_replace(
                    'admin.users.',
                    '',
                    request()->route()->getName(),
                ),
        ) }}"
        method="GET" class="form-inline float-sm-right bg--white">
        <div class="input-group has_append">
            <input type="text" name="search" class="form-control" placeholder="@lang('Username or email')"
                value="{{ $search ?? '' }}">
            <div class="input-group-append">
                <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form>
@endpush