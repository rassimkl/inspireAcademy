<div>
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-sub-header">
                            <h3 class="page-title">Courses</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('course/list') }}">Course</a></li>
                                <li class="breadcrumb-item active">All Courses</li>
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
                                        <h3 class="page-title">Courses</h3>
                                    </div>
                                    <div class="col-auto text-end float-end ms-auto download-grp">
                                        
                                      
                                        
                                        <a href="{{ route('courses.create') }}" class="btn btn-primary">Create Course <i class="fas fa-plus"></i></a>
                                    </div>
                                </div>
                            </div>
<div class="per-page-container">
    <label class="my-1 mr-2" for="perPage">Show</label>
    <select wire:model.live="perPage" id="perPage" class="custom-select custom-select-sm my-1 mr-sm-2">
        <option value="10">10</option>
        <option value="25">25</option>
        <option value="50">50</option>
        <option value="100">100</option>
    </select>
    <label class="my-1" for="perPage">entries</label>
</div>
                            <div class="table-responsive">
                                <table
                                    class="table border-0 star-student table-hover table-center mb-0  table-striped">
                                    <thead class="student-thread">
                       
                                        <tr>
                                   
                                            <th>
                                             
                                            </th>
                                            <th>ID</th>
                                            <th>Name</th>
                                      <th>Teacher</th>
                                            <th>Total Hours</th>
                                            <th>Charge/Hour</th>
                                            <th>Info</th>
                                              <th>Status</th>
                                               <th class="text-center">Number of Students</th>
                                         
                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                         
                                  
                                        @foreach ($courses as $course )
                                        <tr>
                                            <td>
                                              
                                            </td>
                                            <td>CRS{{ $course->id }}</td>
                                           
                                            <td hidden class="avatar">{{ $course->id }}</td>
                                            <td>
                                                <h2 class="table-avatar">
                                                 
                                                    <a href="{{ url('student/profile/'.$course->id) }}">{{ $course->name }} {{ $course->name }}</a>
                                                </h2>
                                            </td>
                                            <td>{{ $course->teacher->first_name }} {{ $course->teacher->last_name }} </td>
                                            <td>{{ $course->total_hours }}</td>
                                            <td>{{ $course->charge_per_hour }}</td>
                                            <td>{{ $course->info }}</td>
                                               <td>{{ $course->status->name }}</td>
                                             <td class='text-center'>{{$course->students_count}}</td>
                            

                                           
                                            <td class="text-end">
                                                <div class="actions">
                                         
                                                    <a        href="{{ route('user/edit', ['userId' => $course->id]) }}" class="btn btn-sm bg-danger-light">
                                                        <i class="far fa-edit me-2"></i>
                                                    </a>
                                                    <a class="btn btn-sm bg-danger-light student_delete" data-bs-toggle="modal" data-bs-target="#studentUser">
                                                        <i class="far fa-trash-alt me-2"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                        
                                    </tbody>

                                </table>
                                {{ $courses->links() }}
                            </div>
                                                                           @if ($courses->isEmpty())
    <p class="text-center">No courses available.</p>
    @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- model student delete --}}
    <div class="modal custom-modal fade" id="studentUser" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h3>Delete Student</h3>
                        <p>Are you sure want to delete?</p>
                    </div>
                    <div class="modal-btn delete-action">
                        <form action="{{ route('student/delete') }}" method="POST">
                            @csrf
                            <div class="row">
                                <input type="hidden" name="id" class="e_id" value="">
                                <input type="hidden" name="avatar" class="e_avatar" value="">
                                <div class="col-6">
                                    <button type="submit" class="btn btn-primary continue-btn submit-btn" style="border-radius: 5px !important;">Delete</button>
                                </div>
                                <div class="col-6">
                                    <a href="#" data-bs-dismiss="modal"class="btn btn-primary paid-cancel-btn">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
