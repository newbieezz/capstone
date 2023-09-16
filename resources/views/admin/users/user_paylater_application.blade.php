@extends('admin.layout.layout') 
@section('content')

        <div class="main-panel"> 
            <div class="content-wrapper"> 
                <div class="row">   
                    <div class="col-lg-12 grid-margin stretch-card"> 
                        <div class="card"> 
                            <div class="card-body"> 
                              <h4 class="card-title">List of PayLater Application</h4> 
                              <div class="table-responsive pt-3"> 
                              <table id="users" class="table table-bordered"> 
                              <thead> @csrf
                                <tr> 
                                    <th> User ID </th> 
                                    <th> Garantor Name </th> 
                                    <th> Job/Source of Income </th> 
                                    <th> Company </th> 
                                    <th> Income </th> 
                                    <th> Relationship </th> 
                                    <th> User Valid ID </th>
                                    <th> User Selfie </th>
                                    <th> Application Status </th>
                                </tr> 
                              </thead> 
                              <tbody> 
                              @foreach ($users as $user)
                                <tr> @csrf
                                     <td> {{ $user['user_id']}}  </td> 
                                     <td> {{ $user['emerCon_name']}}  </td> 
                                     <td> {{ $user['sof']}}  </td>
                                     <td> {{ $user['comp_name']}}  </td> 
                                     <td> {{ $user['income']}}  </td>
                                     <td> {{ $user['relationship']}}  </td>
                                     <td> @if($user['valid_id'] != "")
                                        <img src="{{ asset('front/images/users/'.$user['valid_id']) }}" />
                                        @else
                                            <img src="{{ asset('admin/images/photos/noimage.png') }}" />
                                        @endif
                                     </td>
                                     <td> @if($user['selfie'] != "")
                                        <img src="{{ asset('front/images/users/'.$user['selfie']) }}" />
                                        @else
                                            <img src="{{ asset('admin/images/photos/noimage.png') }}" />
                                        @endif
                                     </td>  
                                     <td> <form action="{{ url('admin/update-paylater-status') }}" method="post"> @csrf
                                            <input type="hidden" name="app_id" value="{{ $user['id'] }}">
                                            {{-- <input type="hidden" name="appstatus" value="Approved"> --}}
                                            <select name="appstatus" id="appstatus" required="">
                                                <option value="" selected="">Select</option>
                                                @foreach($statuses as $status)
                                                  <option value="{{ $status['name'] }}" 
                                                    @if(!empty($user['appstatus'] && $user['appstatus'] == $status['name'])) selected="" @endif>
                                                      {{ $status['name'] }}</option>
                                                @endforeach
                                            </select><button type="submit">Update</button>
                                        </form>
                                    </td>     
                                </tr> 
                                @endforeach
                              </tbody> 
                              </table> 
                              </div> 
                            </div> 
                        </div> 
                    </div> 
                </div> 
            </div> 
            <footer class="footer"> 
                <div class="d-sm-flex justify-content-center justify-content-sm-between"> <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2021. Premium <a href="https://www.bootstrapdash.com/" target="_blank">Bootstrap user template</a> from BootstrapDash. All rights reserved.</span> <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="ti-heart text-danger ml-1"></i></span> 
                </div> 
            </footer> 
        </div>
    </body>
</html>

@endsection