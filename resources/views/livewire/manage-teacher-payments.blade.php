<div>
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-sub-header">
                            <h3 class="page-title">Classes Payments</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('course/list') }}">Payments</a></li>
                                <li class="breadcrumb-item active">Classes</li>
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
               
                  
                     <div class=" mx-1 col-lg-2 col-md-3">
                        <div class="form-group">
                                <label for="teacherSelect" class="form-label">Select a Teacher :</label>

                               <select wire:model.live="Selectedteacher" class="form-select form-control">
                                <option value="">Select a Teacher</option>
                               @foreach($teachers as $teacher)
        <option value="{{$teacher->id}}">{{$teacher->first_name}} {{$teacher->last_name}}</option>
       
        @endforeach
    </select>
     @error('Selectedteacher')
                                                <span class="text-danger" >
                                                    <p>{{ $message }}</p>
                                                </span>
                                            @enderror
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
                                        
                                      
                                        
                                        {{-- <a href="{{ route('') }}" class="btn btn-primary">Create Course <i class="fas fa-plus"></i></a> --}}
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
                                            <th>Name</th>
                                            <th>Room</th>
                                            <th>Total Hours</th>
                                            <th>Charge</th>
                                          
                                         <th  class="text-center">Date</th>
                                        
                                         
                                        
                                        </tr>
                                    </thead>
                                    <tbody>
                         
                                  
                                        @foreach ($lessons as $lesson )
                                        <tr>
                                            <td>
                                              
                                            </td>
                                            <td>CLS{{ $lesson->id }}</td>
                                           
                                            <td hidden class="avatar">{{ $lesson->id }}</td>
                                            <td>
                                                <h2 class="table-avatar">
                                                 
                                                    <a href="{{ url('student/profile/'.$lesson->id) }}">{{ $lesson->course->name }}</a>
                                                </h2>
                                            </td>
                                            <td>{{$lesson->room->name}}</td>
                                            <td>{{ $lesson->hours}} {{Str::plural("Hour", $lesson->hours);}}</td>
                                            <td>€{{ ($lesson->hours)*$lesson->course->charge_per_hour }}</td>
                                          
                                          
                                           <td class='text-center'>    {{ date('F j, Y', strtotime($lesson->date)) }}
{{ date('H:i', strtotime($lesson->start_time)) }}</td>

                                           
                                           
                                        </tr>
                                        @endforeach
                                        
                                    </tbody>

                                </table>
                                {{-- {{ $courses->links() }} --}}
                            </div>
         @if (is_null($Selectedteacher) || is_null($selectedMonth))
    <p class="text-center">Please choose both a teacher and a date.</p>
@elseif (!$lessons)
    <p class="text-center">No lessons available.</p>
@endif

                        </div>
                         <div class="row">
        <div class="col-md-8">
            <!-- List of teachers and their classes -->
           
        </div>

        @if ($lessons)
        <div class="col-md-4">
            <!-- Total hours and total payment -->
            <div>
                <h2>Total Hours</h2>
                <p>{{$totalHours}}</p> <!-- Replace with actual total hours -->
            </div>
            <div>
                <h2>Total Payment</h2>
                <p>€{{$totalPayment}}</p> <!-- Replace with actual total payment -->
            </div>
                <div class="col-12">
                                        <div class="student-submit">
                                            <button type="submit" wire:click='updatePaymentStatus' class="btn btn-primary">Paid</button>
                                        </div>
                                        
                                    </div>
        </div>
        
        @endif
        

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
       document.addEventListener('livewire:initialized', () => {
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
