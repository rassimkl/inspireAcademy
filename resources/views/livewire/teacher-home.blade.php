<div>
  
    {{-- message --}}
    {!! Toastr::message() !!}
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-sub-header">
                            <h3 class="page-title">Welcome {{$teacher->first_name}} {{$teacher->last_name}}</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                                <li class="breadcrumb-item active">Teacher</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-3 col-sm-6 col-12 d-flex   ">
                    <div class="card bg-comman w-100">
                        <div class="card-body">
                            <div class="db-widgets d-flex justify-content-between align-items-center">
                                <div class="db-info">
                                    <h6>Total Courses</h6>
                                    <h3>{{$teacher->coursesAsTeacher->count()-$courses->count()}}/{{$teacher->coursesAsTeacher->count()}} </h3>
                                </div>
                                <div class="db-icon">
                                    <img src="{{ URL::to('assets/img/icons/teacher-icon-01.svg') }}" alt="Dashboard Icon">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class=" col-xl-3 col-sm-6 col-12 d-flex">
                    <div class="card bg-comman w-100">
                        <div class="card-body">
                            <div class="db-widgets d-flex justify-content-between align-items-center">
                                <div class="db-info">
                                    <h6>Total Students</h6>
                                    <h3> {{$totalStudents}}</h3>
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
                                    <h6>Total Classes</h6>
                                    <h3>{{$totalClasses}}</h3>
                                </div>
                                <div class="db-icon">
                                    <img src="{{ URL::to('assets/img/icons/teacher-icon-02.svg') }}" alt="Dashboard Icon">
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
                                    <h6>Total Hours</h6>


   

                                    <h3>                                                                                           
    @php
        // Extract hours and minutes
        $hours = floor($totalHours);
        $minutes = ($totalHours - $hours) * 60;

        // Format minutes to two digits
        $formatted_minutes = str_pad($minutes, 2, '0', STR_PAD_LEFT);

 if ($hours == 0 && $minutes == 0) {
        echo '0';
    } else {
        // Output the time format
        $formattedHours = ($hours > 0 ? $hours . ' hr ' : '') . ($minutes > 0 ? $formatted_minutes . ' min' : '');
        echo "$formattedHours";
    }
    @endphp</h3>
                                </div>
                                <div class="db-icon">
                                    <img src="{{ URL::to('assets/img/icons/teacher-icon-03.svg') }}" alt="Dashboard Icon">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div >
                <div >
                    <div class="row">
                        <div class="col-12 col-lg-8 col-xl-5 d-flex">
                            <div class="card flex-fill comman-shadow">
                                <div class="card-header">
                                    <div class="row align-items-center">
                                        <div class="col-6">
                                            <h5 class="card-title">Today Lessons</h5>
                                        </div>
                                        <div class="col-6">
                                     <span class="float-end view-link"><a href="{{ route('course/list') }}">View All Courses</a></span>

                                        </div>
                                    </div>
                                </div>
                                <div class="pt-3 pb-3">
                                    <div class="table-responsive lesson">
                                    
                                        <table class="table table-center">
                                            <tbody>
                                        @if($upcomingClasses->isEmpty())
                                            <h5 class='text-center'>No classes for today!</h5>
@endif
                                        
                                            @foreach($upcomingClasses as $class)
                                         
                                                <tr>
                                             
                                                    <td>
                                                        <div class="date">
                                                            <b>{{$class->course->name}} {{$class->room->name}}</b>
                                                            <p></p>
                                                            <ul class="teacher-date-list">
                                                                <li><i class="fas fa-calendar-alt me-2"></i>{{   Carbon\Carbon::parse($class->date)->format('M j, Y')}}</li>
                                                                <li>|</li>
                                                                <li><i class="fas fa-clock me-2"></i>{{Carbon\Carbon::parse($class->start_time)->format('H:i')}} - {{Carbon\Carbon::parse($class->end_time)->format('H:i')}} 
                                                                    </li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                    <td>
                                                       <div class="lesson-confirm">
    @if($class->status == 2)
  <a>Submitted</a>
    @else
        <a href="{{ route('class/submit', ['classsession' => $class->id]) }}">Submit</a>
    @endif
</div>
                                                            @if($class->status == 2)
                                                
                                                        @else
  <a href="{{ route('class/edit', ['classsession' => $class->id]) }}" class="btn btn-info">Reschedule</a>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endforeach

                                            
                                               
                                            </tbody>
                                        </table>
                                    </div>
                             
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4 col-xl-2 d-flex">
                            <div class="card flex-fill comman-shadow">
                                <div class="card-header">
                                    <div class="row align-items-center">
                                        <div class="col-12">
                                            <h5 class="text-center card-title">Hours This Month</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="dash-widget">
                                    <div class="circle-bar circle-bar1">

  
                                        <div >
                       <h2>                                                          
   @php
    // Extract hours and minutes
    $hours = floor($totalHoursThisMonth);
    $minutes = ($totalHoursThisMonth - $hours) * 60;

    // Round the minutes to the nearest whole number
    $minutes = round($minutes);

    // Format minutes to two digits if needed
    $formatted_minutes = str_pad($minutes, 2, '0', STR_PAD_LEFT);

    // Output the time format
    if ($hours == 0 && $minutes == 0) {
        echo '0';
    } else {
        $formattedHours = ($hours > 0 ? $hours . ' hr<br>' : '') . ($minutes > 0 ? $formatted_minutes . ' min' : '');
        echo "$formattedHours";
    }
@endphp

</h2>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                          <div class="col-12 col-lg-12 col-xl-5 d-flex">
                    <div class="card flex-fill comman-shadow">
                        <div class="card-body">
                            <div id="teacher-calendar" class="calendar-container"></div>
                          
                        </div>
                    </div>
                </div>
                    </div>
                    <div class="row ">
                        <div class=" col-12 col-lg-12 col-xl-12 d-flex">
                            <div class="card flex-fill comman-shadow">
                                <div class="card-header">
                                    <div class="row align-items-center">
                                        <div class="col-6">
                                            <h5 class="card-title">Pending Courses</h5>
                                        </div>
                                        <div class="col-6">
                                              {{-- <span class="float-end view-link"><a href="{{ route('course/list') }}">Add Class</a></span> --}}
                                        </div>
                                    </div>
                                </div>
                                <div class="">
                                
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
                                            <th>Charge/Hour</th>
                                         
                                              <th>Status</th>
                                               <th class="text-center">Students</th>
                                         
                                            <th class="text-end">Add Class</th>
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
                                                      <a href="{{ route('course/deails', ['course' => $course]) }}">{{$course->name }}</a>
                                                </h2>
                                            </td>
                                         
                                                      <td>
    @php
        $classesSumHours = $course->classes_sum_hours ?? 0;
        $totalHours = $course->total_hours;

        // Calculate hours and minutes for classes_sum_hours
        $classesHours = floor($classesSumHours);
        $classesMinutes = ($classesSumHours - $classesHours) * 60;

        // Calculate hours and minutes for total_hours
        $totalHoursWhole = floor($totalHours);
        $totalMinutes = ($totalHours - $totalHoursWhole) * 60;

        // Calculate the difference
        $difference = $totalHours - $classesSumHours;
        $differenceHours = floor($difference);
        $differenceMinutes = ($difference - $differenceHours) * 60;
    @endphp

    {{ sprintf('%02d:%02d', $classesHours, $classesMinutes) }} / {{ sprintf('%02d:%02d', $totalHoursWhole, $totalMinutes) }} H (Rem: {{ sprintf('%02d:%02d', $differenceHours, $differenceMinutes) }})
</td>
                                            <td>{{ $course->charge_per_hour }} €</td>
                                    
                                               <td>
    @php
        $statusClass = '';
        switch ($course->status_id) {
            case 1:
                $statusClass = 'text-danger';
                break;
            case 2:
                $statusClass = 'text-success';
                break;
            case 3:
                $statusClass = 'text-primary';
                break;
            case 4:
                $statusClass = 'text-decoration-line-through';
                break;
        }
    @endphp
    <span class="{{ $statusClass }}">{{ $course->status->name }}</span>
</td>
                                             <td class='text-center'>{{$course->students->count()}}</td>
                            

                                           
                                            <td class="text-end">
                                                <div class="actions">
                                         
                                                    <a        href="{{ route('class/add', ['course' => $course->id]) }}" class="btn btn-sm bg-danger-light">
<i class="feather-plus"></i></a></span>
                                                    </a>
                                                   
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                        
                                    </tbody>

                                </table>
                                       @if ($courses->isEmpty())
    <p class="text-center">No courses available.</p>
    @endif
                            
                            </div>
                                </div>
                            </div>
                        </div>
                          <div class="col-12 col-lg-12 col-xl-12 d-flex">
                            <div class="card flex-fill comman-shadow">
                                <div class="card-header">
                                    <div class="row align-items-center">
                                        <div class="col-6">
                                            <h5 class="card-title">Pending Classes</h5>
                                            
                                        </div>
                                        <div class="col-6">
    <span class="float-end view-link"><a href="{{ route('teacher/classes') }}">View All Classes</a></span>                                        </div>
                                    </div>
                                </div>
                                <div class="">
                                
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
                                            <th>Date</th>
                                         
                                            
                                               <th class="text-center">Time</th>
                                         
                                            <th class="text-center">Place</th>
                                            <th class="text-end">Edit/Submit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                         
                                  
                                        @foreach ($unfinishedClasses as $uclass )
                                        <tr>
                                            <td>
                                              
                                            </td>
                                            <td>CLS{{ $uclass->id }}</td>
                                           
                                            <td hidden class="avatar">{{ $uclass->id }}</td>
                                            <td>
                                                <h2 class="table-avatar">
                                                  <a href="{{ route('course/deails', ['course' => $uclass->course]) }}">{{$uclass->course->name }}</a>
                             
                                                </h2>
                                            </td>
                                         
                                                                  <td >
    @php
        // Extract hours and minutes
        $hours = floor($uclass->hours);
        $minutes = ($uclass->hours - $hours) * 60;

        // Format minutes to two digits
        $formatted_minutes = str_pad($minutes, 2, '0', STR_PAD_LEFT);

        // Output the time format
        $formattedHours = ($hours > 0 ? $hours . ' hr ' : '') . ($minutes > 0 ? $formatted_minutes . ' min' : '');
        echo "$formattedHours";
    @endphp
</td>
<td>
    @php
        $date = strtotime($uclass->date);
        $formattedDate = date('d-m-Y', $date);
        $today = date('d-m-Y');
        $tomorrow = date('d-m-Y', strtotime('+1 day'));
        $yesterday = date('d-m-Y', strtotime('-1 day'));
        $isPast = true;
    @endphp
    
    @if ($formattedDate == $today)
        Today
    @elseif ($formattedDate == $tomorrow)
        Tomorrow
    @elseif ($formattedDate == $yesterday)
        Yesterday
    @else
        {{ $formattedDate }}
    @endif

    @if ($isPast)
        <span class="text-danger">
            <i class="fas fa-exclamation-triangle"></i>
            <!-- Or use an image icon -->
            <!-- <img src="path/to/danger-icon.png" alt="Danger Icon"> -->
        </span>
    @endif
</td>

                                    
                                        <td class='text-center'>{{ date('H:i', strtotime($uclass->start_time)) }}/{{ date('H:i', strtotime($uclass->end_time)) }}</td>


                                              <td class="text-center">{{$uclass->room->name }}</td>
                                              <td class="text-end">
                                                <div class="actions">
                                         
                                                    <a        href="{{ route('class/edit', ['classsession' => $uclass->id]) }}" class="btn btn-sm bg-danger-light">
                                                        <i class="far fa-edit me-2"></i>
                                                    </a>
                                                    <a  href="{{ route('class/submit', ['classsession' => $uclass->id]) }}" class="btn btn-sm bg-danger-light student_delete" >
                                                     <i class="fa fa-check" aria-hidden="true"></i>

                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                        
                                    </tbody>

                                </table>
                                       @if ($courses->isEmpty())
    <p class="text-center">No courses available.</p>
    @endif
                            
                            </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                
               
            </div>
        </div>

        
    </div>


<script>

    document.addEventListener('livewire:initialized', () => {
        
    var events = @json($calendarClasses); // Encode events to JSON





   var calendarevents =events.map(function(event) {

     var startTime = event.start_time.split(':').slice(0, 2).join(':'); // Remove seconds
            var endTime = event.end_time.split(':').slice(0, 2).join(':'); // Remove seconds
            var status = event.status==1?'Pending':'Completed';
            var summary = `From ${startTime} Till ${endTime} ${status}`;

                return {
                    startDate: event.date,
                    endDate: event.date,
                    summary: summary
                };
            });


  $("#teacher-calendar").simpleCalendar({
    fixedStartDay: 0,
    disableEmptyDetails: true,
    events: calendarevents,
   
  });

      
    });
</script>

</div>
