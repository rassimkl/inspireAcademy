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
                 
                    <div class="col-lg-2 col-md-4">
                        <div class="form-group">
                             <input wire:model.live.debounce.500ms="search"  type="text" class="form-control" placeholder="Search">
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="search-student-btn">
                            <button wire:click="clearSearch" type="btn" class="btn btn-primary">Clear</button>
                        </div>
                    </div>
                  
                     <div class=" mx-1 col-lg-2 col-md-3">
                        <div class="form-group">
                        
                  
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
                                        
                                      
                                        
                                     @if(auth()->user()->user_type_id==1) <a href="{{ route('courses.create') }}" class="btn btn-primary">Create Course <i class="fas fa-plus"></i></a>@endif
                                    </div>
                                </div>
                            </div>
<div class="per-page-container">
    <label class="my-1 mr-2" for="perPage">Show</label>
 <select wire:model.live="perPage" id="perPage" class=" custom-select-sm form form-control-sm">
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
                                   
                                            <th>Total Hours</th>
                                            <th>Latest class</th>
                                            <th>Type</th>
                                              <th>Status</th>
                                               <th class="text-center">Number of Students</th>
                                                  <th class="text-center" >Add CLass</th>
                                               
                                         
                                              @if(auth()->user()->user_type_id==1) <th class="text-end">Action</th>@endif
                                        </tr>
                                    </thead>
                                    <tbody>
                         
                                  
                                        @foreach ($courses as $course )
                                        <tr>
                                            <td>
                                              
                                            </td>

                                            
                                            <td>  <a href="{{ route('course/deails', ['course' => $course]) }}">CRS{{ $course->id }}</a></td>
                                           
                                            <td hidden class="avatar">{{ $course->id }}</td>
                                            <td>
                                                <h2 class="table-avatar">
                                            
                                                    <a href="{{ route('course/deails', ['course' => $course]) }}">{{ $course->name }} </a>
                                                </h2>
                                            </td>
                                            <td>{{$course->classes_sum_hours??0}}/{{ $course->total_hours }} H ({{ $course->charge_per_hour }}€/H)</td>
                                                                        <td>
            @if ($course->latestClassDate && $course->latestClassDate->date)
                {{ \Illuminate\Support\Carbon::parse($course->latestClassDate->date)->diffForHumans() }}
            @else
                No class given
            @endif
                                           <td>
    {{ $course->course_type == 1 ? 'Face To Face' : 'Online' }}
</td>
                                    <td>
    @if($course->status_id == 1)
        <span class="badge bg-danger">{{ $course->status->name }}</span>
    @elseif($course->status_id == 2)
        <span class="badge bg-success">{{ $course->status->name }}</span>
    @elseif($course->status_id == 3)
             <span class="badge bg-info">{{ $course->status->name }}</span>
    @elseif($course->status_id == 4)
        <span class="badge bg-light text-dark">{{ $course->status->name }}</span>
    @endif
</td>

                                             <td class='text-center'>{{$course->students_count}}</td>
                            
 <td class="text-center" >
                                                <div class="">
                                         
                                                    <a        href="{{ route('class/add', ['course' => $course->id]) }}" class="btn btn-sm bg-danger-light">
<i class="feather-plus"></i></a></span>
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
                        <form  method="POST">
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

    @endsection



</div>
