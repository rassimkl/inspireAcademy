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
                     <div class="col-lg-2 col-md-4">
                        <div class="form-group">
                            <label for="teacherSelect" class="form-label text-center">Select Date :</label>
                        <div wire:ignore>
                        <input id="datepickeru" wire:model.live='selectedMonth' class="form-control  @error('date') is-invalid @enderror" name="date" type="text" placeholder="MM-YYYY" >
</div>
 @error('selectedMonth')
                                                <span class="text-danger" >
                                                    <p>{{ $message }}</p>
                                                </span>
                                            @enderror
                        </div>
                    </div>
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
   @if (auth()->user()->user_type_id == 1)
                          <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                         <label for="exampleInputEmail1" class="form-label">Teachers</label>
  <div wire:ignore>
            <select  class="form-control js-example-responsive  @error('teacher') is-invalid @enderror" id="teacher" >
               <option value="">All</option>
            @foreach ($teachers as $teacher)
        <option value="{{ $teacher->id }}">{{ $teacher->first_name }} {{ $teacher->last_name }} </option>
    @endforeach
                <!-- Add more languages as needed -->
            </select>
            </div>
    
</div>


                    </div>
                    @endif
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





                            <div class="table-responsive pt-1">
                                <table
                                    class="table border-0 star-student table-hover table-center mb-0  table-striped">
                                    <thead class="student-thread">
                                        <tr>
                                            <th>
                                             
                                            </th>
                                            @if(auth()->user()->user_type_id==1)
                                            <th>ID</th>
                                            @endif
                                            <th>Course</th>
                                              @if (auth()->user()->user_type_id == 1)
<th>Teacher</th>
                                              @endif
                                            <th>Hours</th>
                                            <th>Students</th>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Room</th>
                                              <th>Status</th>
                                            <th class="text-end">Edit / Submit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                  
                                        @foreach ($classes as $class )
                                        <tr>
                                            <td>
                                              
                                            </td>
                                             @if(auth()->user()->user_type_id==1)
                                            <td> <a href="{{ route('class/details', ['classId' => $class->id]) }}">CLS{{ $class->id }}</a></td>
                                            
                                       @endif
                                            <td>
                                                <h2 class="table-avatar">
                                                                                              

                                                    <a href="{{ route('course/deails', ['course' =>$class->course]) }}">{{$class->course->name}}</a>
                                                </h2>
                                            </td>
                                               @if (auth()->user()->user_type_id == 1)
                                             <td> <a  href="{{ route('user/details', ['user' => $class->course->teacher->id]) }}">{{ $class->course->teacher->first_name }} {{ $class->course->teacher->last_name }}</a></td>
                                             @endif
                                            <td>{{ $class->hours }} </td>
                                            <td>{{ $class->course->students->count() }}</td>
                                            <td>{{ (new DateTime($class->date))->format('d-m-Y') }}</td>
                                           <td class='text-center'>{{ date('H:i', strtotime($class->start_time)) }}/{{ date('H:i', strtotime($class->end_time)) }}</td>
                                          

                                            <td>{{$class->room->name}}</td>
   <td>
    @if($class->status == 1)
        <span class="badge bg-danger">Not Completed</span>
    @else
        <span class="badge bg-success">Completed</span>
    @endif
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
    <script>
       document.addEventListener('livewire:initialized', () => {

            $('#teacher').select2({});

              $('#teacher').on('change', function() {
                var selectedteacher = $(this).val();

                  @this.set('selectedTeacher',selectedteacher,true);
                  });
 var datetimePicker = $('#datepickeru');
datetimePicker.datetimepicker({
    format: "MM/YYYY", // Display format for month and year
    viewMode: "months", // Initial view mode to show only months
});

        datetimePicker.on('dp.change', function(e) {
            @this.set('selectedMonth', e.date.format('MM-YYYY'), true);
        });

       });


    </script>
    @endsection

</div>
