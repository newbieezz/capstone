<?php
   use App\Models\Notification; 
?>
<style>
    .myDropDown
{
   height: 400px;
   overflow: auto;
}
</style>
<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a  class="navbar-brand brand-logo mr-5" href="{{ url('admin/dashboard') }}"><img src="{{ asset('admin/images/logo.png') }}" class="mr-2" alt="logo"/><h4> Admin Panel</h4></a>
    </div> 
    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
        <span class="icon-menu"></span>
        </button>
        <ul class="navbar-nav mr-lg-2">
            <li class="nav-item nav-search d-none d-lg-block">
                {{-- <div class="input-group">
                    <div class="input-group-prepend hover-cursor" id="navbar-search-icon">
                        <span class="input-group-text" id="search">
                        <i class="icon-search"></i>
                        </span>
                    </div>
                    <input type="text" class="form-control" id="navbar-search-input" placeholder="Search now" aria-label="search" aria-describedby="search">
                </div> --}}
            </li>
        </ul>
        <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item nav-profile dropdown">
                <h4>{{ Auth::guard('admin')->user()->name }}</h4>
                <a class="nav-link dropdown-toggle" href="{{ url('admin/update-admin-details') }}" data-toggle="dropdown" id="profileDropdown">
                    @if(!empty(Auth::guard('admin')->user()->image))
                        <img src="{{ url('admin/images/photos/'.Auth::guard('admin')->user()->image) }}"
                        alt="profile">
                    @else
                        <img src="{{ url('admin/images/photos/noimage.gif') }}"
                        alt="profile">
                    @endif
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                    <a href="{{ url('admin/update-admin-details') }}" class="dropdown-item">
                    <i class="ti-settings text-primary"></i>
                    Settings
                    </a>
                    <a href="{{ url('admin/logout') }}" class="dropdown-item">
                    <i class="ti-power-off text-primary"></i>
                    Logout
                    </a>
                </div>
            </li>
            <li class="nav-item dropdown">
            <div >
                <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
                <i class="icon-bell mx-0"></i>
                <span class="count"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list  myDropDown" aria-labelledby="notificationDropdown">
                    <p class="mb-0 font-weight-normal float-left dropdown-header">Notifications</p>
                    @foreach(Notification::where('user_id', Auth::guard('admin')->user()->id)->orderByDesc('id')->get() as $key => $value)
                    @if($value->receiver == 'vendor')
                        @if ($value->module == 'order' && $value->receiver == 'vendor')
                        <a href="{{ url('admin/orders/'. $value->module_id)}}" class="dropdown-item preview-item">
                        @elseif ($value->module == 'product' && $value->receiver == 'vendor')
                        <a href="{{ url('admin/add-edit-product/'. $value->module_id)}}" class="dropdown-item preview-item"> 
                        @elseif ($value->module == 'paylaterpayment' && $value->receiver == 'vendor')
                        <a href="javascript:;" class="dropdown-item preview-item"> @endif
                            <div class="preview-item-content">
                                <h6 class="preview-subject font-weight-normal">{{ strtoupper($value->module) }}</h6>
                                <p class="font-weight-light small-text mb-0 text-muted">
                                    {{ $value->message }}
                                </p>
                            </div>
                        </a>
                    @endif
                    @endforeach
                    @foreach(Notification::where('user_id',Auth::guard('admin')->user()->id)->orderByDesc('id')->get() as $key => $value)
                    @if($value->receiver == 'admin')
                        @if ($value->module == 'walletRequest' && $value->receiver == 'admin')
                        <a href="{{ url('admin/update-vendor-wallet/'. $value->module_id)}}" class="dropdown-item preview-item">
                        @elseif ($value->module == 'vendorAccount' && $value->receiver == 'admin')
                        <a href="{{ url('admin/admins/vendor'. $value->module_id)}}" class="dropdown-item preview-item">
                        @endif
                            <div class="preview-item-content">
                                <h6 class="preview-subject font-weight-normal">{{ strtoupper($value->module) }}</h6>
                                <p class="font-weight-light small-text mb-0 text-muted">
                                    {{ $value->message }}
                                </p>
                            </div>
                        </a>
                    @endif
                    @endforeach
                </div>
            </div>
            </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
        <span class="icon-menu"></span>
        </button>
    </div>
</nav>