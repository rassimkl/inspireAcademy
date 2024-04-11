<div>
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-sub-header">
                            <h3 class="page-title">Classes</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('student/list') }}">Student</a></li>
                                <li class="breadcrumb-item active">All Classes</li>
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
                         <label for="exampleInputEmail1" class="form-label">Status</label>
    <select wire:model.live="status" class="form-select">
        <option value="0">All</option>
        <option value="1">Not Completed</option>
        <option value="2">Completed</option>
    </select>
    
</div>
                    </div>
                    <div class="col-lg-2">
                        <div class="search-student-btn">
                           
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
                                        <h3 class="page-title">Classes</h3>
                                    </div>
                                    <div class="col-auto text-end float-end ms-auto download-grp">
                                        
                                      
                                        
                                  
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
                                    class="table border-0 star-student table-hover table-center mb-0  table-striped">
                                    <thead class="student-thread">
                                        <tr>
                                            <th>
                                             
                                            </th>
                                            <th>ID</th>
                                            <th>Course</th>
                                            <th>Hours</th>
                                            <th>Students</th>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Room</th>
                                              <th>Status</th>
                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                  
                                        @foreach ($classes as $class )
                                        <tr>
                                            <td>
                                              
                                            </td>
                                            <td>CLS{{ $class->id }}</td>
                                           
                                       
                                            <td>
                                                <h2 class="table-avatar">
                                                    
                                                    <a href="{{ url('student/profile/'.$class->id) }}">{{ $class->course->name }} </a>
                                                </h2>
                                            </td>
                                            <td>{{ $class->hours }} </td>
                                            <td>{{ $class->course->students->count() }}</td>
                                            <td>{{ $class->date }}</td>
                                           <td class='text-center'>{{ date('H:i', strtotime($class->start_time)) }}/{{ date('H:i', strtotime($class->end_time)) }}</td>
                                          

                                            <td>{{$class->room->name}}</td>
                                        <td class="{{ $class->status == 2 ? 'text-success' : '' }}">
    {{ $class->status == 1 ? 'Not Completed' : 'Completed' }}
</td>
                                         <td class="text-end">
    @if($class->status != 2)
        <div class="actions">
            <a href="{{ route('class/edit', ['classsession' => $class->id]) }}" class="btn btn-sm bg-danger-light">
                <i class="far fa-edit me-2"></i>
            </a>
            <a href="{{ route('class/submit', ['classsession' => $class->id]) }}" class="btn btn-sm bg-danger-light student_delete">
                <i class="fa fa-check" aria-hidden="true"></i>
            </a>
        </div>
        @else
           <div class="actions">
          <button class="btn btn-sm bg-danger-light disabled" disabled>
                <i class="far fa-edit me-2"></i>
            </button>
            <button class="btn btn-sm bg-danger-light disabled" disabled>
                <i class="fa fa-check" aria-hidden="true"></i>
            </button>
        </div>
    @endif
</td>

                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
   
                                {{ $classes->links() }}
                            </div>
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
