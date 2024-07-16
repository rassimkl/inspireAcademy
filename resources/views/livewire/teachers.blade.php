<div>
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-sub-header">
                            <h3 class="page-title">Teachers</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('teacher/list') }}">Teacher</a></li>
                                <li class="breadcrumb-item active">All Teachers</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            {{-- message --}}
            {!! Toastr::message() !!}
         <div class="student-group-form">
                <div class="row">
                 
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                             <input wire:model.live.throttle.350ms="search"  type="text" class="form-control" placeholder="Search">
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="search-student-btn">
                            <button wire:click="clearSearch" type="btn" class="btn btn-primary">Clear</button>
                        </div>
                    </div>
                </div>
            </div>
            


            
            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-table comman-shadow">
                        <div class="card-body">
                            <div class="page-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h3 class="page-title">Teachers</h3>
                                    </div>
                                    <div class="col-auto text-end float-end ms-auto download-grp">
                                        
                                      
                                        
                                        <a href="{{ route('user/add/page', ['user_type_id' => 2]) }}" class="btn btn-primary">Add Teacher <i class="fas fa-plus"></i></a>
                                    </div>
                                </div>
                            </div>

<div class="per-page-container">
    <div class="row align-items-center">
        <div class="col-auto">
            <label class="my-1 mr-2" for="perPage">Show</label>
        </div>
        <div class="col-auto m-0 p-0">
            <select wire:model.live="perPage" id="perPage" class=" custom-select-sm form form-control-sm">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
            
        </div>
        <div class="col-auto">
            <label class="my-1" for="perPage">entries</label>
        </div>
    </div>
</div>




                            <div class="table-responsive">
                                <table
                                    class="table border-0 star-student table-hover table-center mb-0 datatable table-striped">
                                    <thead class="student-thread">
                                        <tr>
                                            <th>
                                                
                                            </th>
                                        
                                            <th>Name</th>
                                      <th>Gender</th>
                                            <th>Status</th>
                                            <th>Email</th>
                                            <th>Mobile Number</th>
                                               <th>Languages</th>
                                            <th>Courses</th>
                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                  
                                        @foreach ($teachers as $teacher )
                                        <tr>
                                            <td>
                                               
                                            </td>
                                         
                                           
                                            <td hidden class="avatar">{{ $teacher->id }}</td>
                                            <td>
                                                <h2 class="table-avatar">
                                                    <a href="{{ route('user/details', ['user' => $teacher->id]) }}" class="avatar avatar-sm me-2">
                                                        <img class="avatar-img rounded-circle" src="{{ $teacher->profile_picture ? Storage::url('student-photos/'.$teacher->profile_picture) :Storage::url('student-photos/default.png') }}" alt="User Image">
                                                    </a>
                                                    <a href="{{ route('user/details', ['user' => $teacher->id]) }}">{{ $teacher->first_name }} {{ $teacher->last_name }}</a>
                                                </h2>
                                            </td>
                                            <td>{{ $teacher->gender }} </td>
                                           <td>
                        @if ($teacher->active)
                            <span class="badge badge-success">Active</span>
                        @else
                            <span class="badge badge-danger">Inactive</span>
                        @endif
                    </td>
                                            <td>{{ $teacher->email }}</td>
                                            <td >{{ $teacher->phone_number }}</td>
                                      <td> @foreach(json_decode($teacher->languages) as $key => $language)
        {{ $language }}@if(!$loop->last),@endif
    @endforeach</td>
                                            <td class='text-center'>{{$teacher->courses_count}}</td>
                                            <td class="text-end">
                                                <div class="actions">
                                                      <a        href="{{ route('user/edit', ['userId' => $teacher->id]) }}" class="btn btn-sm bg-danger-light">
                                                        <i class="far fa-edit me-2"></i>
                                                    </a>
                                                    <a class="btn btn-sm bg-danger-light " wire:click="confirmDelete({{ $teacher->id }})" >
                                                        <i class="far fa-trash-alt me-2"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                           <div class="d-flex justify-content-between">
                <div id="total-count" class="text-muted">Total: {{ $teachers->total() }} entries</div>
                <nav>
                    {{ $teachers->links() }}
                </nav>
            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- model student delete --}}

    @section('script')

    {{-- delete js --}}
    <script>
        $(document).on('click','.student_delete',function()
        {
            var _this = $(this).parents('tr');
            $('.e_id').val(_this.find('.id').text());
            $('.e_avatar').val(_this.find('.avatar').text());
        });
    </script>
    @endsection



</div>
