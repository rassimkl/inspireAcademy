<div>

{!! Toastr::message() !!}
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-sub-header">
                        <h3 class="page-title">Welcome!</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">{{auth()->user()->first_name }} {{auth()->user()->last_name }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-3 col-sm-6 col-12 d-flex">
                <div class="card bg-comman w-100">
                    <div class="card-body">
                        <div class="db-widgets d-flex justify-content-between align-items-center">
                            <div class="db-info">
                                <h6>Students</h6>
                                <h3>{{$studentCount}}</h3>
                            </div>
                            <div class="db-icon">
                                <img src="{{ URL::to('assets/img/icons/dash-icon-01.svg') }}" alt="Dashboard Icon">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12 d-flex">
                <div class="card bg-comman w-100">
                    <div class="card-body">
                        <div class="db-widgets d-flex justify-content-between align-items-center">
                            <div class="db-info">
                                <h6>Courses In Progress / Didnt Start</h6>
                                 
                                <h3>{{$coursesCount}} / {{$coursesCountdstart}}</h3>
                                 
                            </div>
                            <div class="db-icon">
                                <img src="{{ URL::to('assets/img/icons/dash-icon-02.svg') }}" alt="Dashboard Icon">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12 d-flex">
                <div class="card bg-comman w-100">
                    <div class="card-body">
                        <div class="db-widgets d-flex justify-content-between align-items-center">
                            <div class="db-info">
                                <h6>Classes Submitted This Month</h6>
                                <h3>{{$currentMonthClasses}}</h3>
                            </div>
                            <div class="db-icon">
                                <img src="{{ URL::to('assets/img/icons/dash-icon-03.svg') }}" alt="Dashboard Icon">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12 d-flex">
                <div class="card bg-comman w-100">
                    <div class="card-body">
                        <div class="db-widgets d-flex justify-content-between align-items-center">
                            <div class="db-info">
                                <h6>Payments</h6>
                                <h3>€{{$totalPayment}}</h3>
                            </div>
                            <div class="db-icon">
                                <img src="{{ URL::to('assets/img/icons/dash-icon-04.svg') }}" alt="Dashboard Icon">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="row">
            <div class="col-xl-6 d-flex">

                <div class="card flex-fill student-space comman-shadow">
                    <div class="card-header d-flex align-items-center">
                        <h5 class="card-title">Classes Today</h5>
                        <ul class="chart-list-out student-ellips">
                            <li class="star-menus"><a href="javascript:;"><i class="fas fa-ellipsis-v"></i></a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table
                                class="table star-student table-hover table-center table-borderless table-striped">
                                <thead class="thead-light">
                                    @if(!$classesForToday->isEmpty())
                                    <tr>
                                        <th>Class</th>
                                        <th>Course</th>
                                        <th class="text-center">Teacher</th>
                                        <th class="text-center">Time</th>
                                        <th class="text-end">Room</th>
                                    </tr>
@endif
                                </thead>
                                <tbody>
                                @if($classesForToday->isEmpty())
                                         <h4 class='text-center'>No classes for Today!</h4>
                                         @endif
                                @foreach($classesForToday as $tclass)
                                    <tr>
                                        <td class="text-nowrap">
                                        <a href="{{ route('class/details', ['classId' => $tclass->id]) }}">CLS{{$tclass->id}}</a>
                                           
                                        </td>
                                        <td class="text-nowrap">
                                             <a href="{{ route('course/deails', ['course' =>$tclass->course]) }}">{{$tclass->course->name}}</a>
                                    
                                           
                                        </td>
                                        
                                        <td class="text-center"> <a href="{{ route('user/details', ['user' => $tclass->course->teacher->id]) }}">{{ $tclass->course->teacher->first_name }} {{$tclass->course->teacher->last_name }}</a></td>
                                        <td class="text-center">{{Carbon\Carbon::parse($tclass->start_time)->format('H:i')}}/{{Carbon\Carbon::parse($tclass->end_time)->format('H:i')}}</td>
                                        <td class="text-end">
                                            <div>{{$tclass->room->name}}</div>
                                        </td>
                                    </tr>
                              @endforeach
                                
                                   
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-xl-6 d-flex">

                <div class="card flex-fill comman-shadow">
                    <div class="card-header d-flex align-items-center">
                        <h5 class="card-title ">Latest Submit</h5>
                        <ul class="chart-list-out student-ellips">
                            <li class="star-menus"><a href="javascript:;"><i class="fas fa-ellipsis-v"></i></a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="activity-groups">
                          @foreach($classSubmitted as $class)
                            <div class="activity-awards">
                        
                                <div class="award-boxs">
                                    <img src="assets/img/icons/award-icon-01.svg" alt="Award">
                                </div>
                               
                                <div class="award-list-outs">

                               <a href="{{ route('user/details', ['user' => $class->course->teacher->id]) }}">
    <h4>{{ $class->course->teacher->first_name }} {{ $class->course->teacher->last_name }} Submitted</h4>
</a>
                                   
                                   
                                    <a href="{{ route('course/deails', ['course' =>$class->course]) }}">     <h5>{{$class->course->name}}</h5></a>
                               
                                </div>
                            
                                <div class="award-time-list">

                                 <span>{{ $class->updated_at->diffForHumans() }}                                  <a href="{{ route('class/details', ['classId' => $class->id]) }}">(View Report)</a>
</span>

                                </div>
                                
                            </div>
@endforeach
                            
                       
                        </div>
                    </div>
                </div>

            </div>
        </div>

         <div class="container">
        <div id="calendar"></div>
    </div>

      
    </div>
</div>


    <script>
    document.addEventListener('livewire:initialized', () => {
  var calendarEl = document.getElementById('calendar');
 var classes = @this.get('formattedEvents');
  var calendar = new FullCalendar.Calendar(calendarEl, {
        headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
            initialView: 'dayGridMonth',
            events: classes,
                    slotEventOverlap:false,
                    
            eventDidMount: function(arg) {
                    // Change background color to blue for all events
                    arg.el.style.backgroundColor = 'blue';
                }, // an option!
            // Add any other FullCalendar options here
        });
        calendar.render();

    });

    </script>

</div>
