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
                <div class="col-xl-3 col-sm-6 col-12 d-flex">
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
                <div class="col-xl-3 col-sm-6 col-12 d-flex">
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
                                    <h3>{{$totalHours}}</h3>
                                </div>
                                <div class="db-icon">
                                    <img src="{{ URL::to('assets/img/icons/teacher-icon-03.svg') }}" alt="Dashboard Icon">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-12 col-lg-12 col-xl-8">
                    <div class="row">
                        <div class="col-12 col-lg-8 col-xl-8 d-flex">
                            <div class="card flex-fill comman-shadow">
                                <div class="card-header">
                                    <div class="row align-items-center">
                                        <div class="col-6">
                                            <h5 class="card-title">Upcoming Lesson</h5>
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
                                            @foreach($upcomingClasses as $class)
                                         
                                                <tr>
                                                    <td>
                                                        <div class="date">
                                                            <b>Class-{{$class->id}}</b>
                                                            <p>Course:{{$class->course->name}} {{$class->room->name}}</p>
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
                                                            <a href="#">Confirmed</a>
                                                        </div>
                                                        <button type="submit"
                                                            class="btn btn-info">Reschedule</button>
                                                    </td>
                                                </tr>
                                                @endforeach

                                            
                                               
                                            </tbody>
                                        </table>
                                    </div>
                             
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4 col-xl-4 d-flex">
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
                                            <h1>{{$totalHoursThisMonth}}</h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-12 col-xl-12 d-flex">
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
                                         
                                            <th class="text-end">Class</th>
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
                                                 
                                                    <a href="{{ url('student/profile/'.$course->id) }}"> {{ $course->name }}</a>
                                                </h2>
                                            </td>
                                         
                                            <td class="text-center">{{$course->classes_sum_hours??0}}/{{ $course->total_hours }} H</td>
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
                                <div class="card-header d-flex align-items-center">
                                    <h5 class="card-title">Teaching History</h5>
                                    <ul class="chart-list-out student-ellips">
                                        <li class="star-menus"><a href="javascript:;"><i
                                                    class="fas fa-ellipsis-v"></i></a></li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="teaching-card">
                                        <ul class="steps-history">
                                            <li>Sep22</li>
                                            <li>Sep23</li>
                                            <li>Sep24</li>
                                        </ul>
                                        <ul class="activity-feed">
                                            <li class="feed-item d-flex align-items-center">
                                                <div class="dolor-activity">
                                                    <span class="feed-text1"><a>Mathematics</a></span>
                                                    <ul class="teacher-date-list">
                                                        <li><i class="fas fa-calendar-alt me-2"></i>September 5,
                                                            2022</li>
                                                        <li>|</li>
                                                        <li><i class="fas fa-clock me-2"></i>09:00 am - 10:00 am (60
                                                            Minutes)</li>
                                                    </ul>
                                                </div>
                                                <div class="activity-btns ms-auto">
                                                    <button type="submit" class="btn btn-info">In Progress</button>
                                                </div>
                                            </li>
                                            <li class="feed-item d-flex align-items-center">
                                                <div class="dolor-activity">
                                                    <span class="feed-text1"><a>Geography </a></span>
                                                    <ul class="teacher-date-list">
                                                        <li><i class="fas fa-calendar-alt me-2"></i>September 5,
                                                            2022</li>
                                                        <li>|</li>
                                                        <li><i class="fas fa-clock me-2"></i>09:00 am - 10:00 am (60
                                                            Minutes)</li>
                                                    </ul>
                                                </div>
                                                <div class="activity-btns ms-auto">
                                                    <button type="submit" class="btn btn-info">Completed</button>
                                                </div>
                                            </li>
                                            <li class="feed-item d-flex align-items-center">
                                                <div class="dolor-activity">
                                                    <span class="feed-text1"><a>Botony</a></span>
                                                    <ul class="teacher-date-list">
                                                        <li><i class="fas fa-calendar-alt me-2"></i>September 5,
                                                            2022</li>
                                                        <li>|</li>
                                                        <li><i class="fas fa-clock me-2"></i>09:00 am - 10:00 am (60
                                                            Minutes)</li>
                                                    </ul>
                                                </div>
                                                <div class="activity-btns ms-auto">
                                                    <button type="submit" class="btn btn-info">In Progress</button>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-12 col-xl-4 d-flex">
                    <div class="card flex-fill comman-shadow">
                        <div class="card-body">
                            <div id="teacher-calendar" class="calendar-container"></div>
                            <div class="calendar-info calendar-info1">
                                <div class="up-come-header">
                                    <h2>Upcoming Events</h2>
                                    <span><a href="javascript:;"><i class="feather-plus"></i></a></span>
                                </div>
                                <div class="upcome-event-date">
                                    <h3>10 Jan</h3>
                                    <span><i class="fas fa-ellipsis-h"></i></span>
                                </div>
                                <div class="calendar-details">
                                    <p>08:00 am</p>
                                    <div class="calendar-box normal-bg">
                                        <div class="calandar-event-name">
                                            <h4>Botony</h4>
                                            <h5>Lorem ipsum sit amet</h5>
                                        </div>
                                        <span>08:00 - 09:00 am</span>
                                    </div>
                                </div>
                                <div class="calendar-details">
                                    <p>09:00 am</p>
                                    <div class="calendar-box normal-bg">
                                        <div class="calandar-event-name">
                                            <h4>Botony</h4>
                                            <h5>Lorem ipsum sit amet</h5>
                                        </div>
                                        <span>09:00 - 10:00 am</span>
                                    </div>
                                </div>
                                <div class="calendar-details">
                                    <p>10:00 am</p>
                                    <div class="calendar-box normal-bg">
                                        <div class="calandar-event-name">
                                            <h4>Botony</h4>
                                            <h5>Lorem ipsum sit amet</h5>
                                        </div>
                                        <span>10:00 - 11:00 am</span>
                                    </div>
                                </div>
                                <div class="upcome-event-date">
                                    <h3>10 Jan</h3>
                                    <span><i class="fas fa-ellipsis-h"></i></span>
                                </div>
                                <div class="calendar-details">
                                    <p>08:00 am</p>
                                    <div class="calendar-box normal-bg">
                                        <div class="calandar-event-name">
                                            <h4>English</h4>
                                            <h5>Lorem ipsum sit amet</h5>
                                        </div>
                                        <span>08:00 - 09:00 am</span>
                                    </div>
                                </div>
                                <div class="calendar-details">
                                    <p>09:00 am</p>
                                    <div class="calendar-box normal-bg">
                                        <div class="calandar-event-name">
                                            <h4>Mathematics </h4>
                                            <h5>Lorem ipsum sit amet</h5>
                                        </div>
                                        <span>09:00 - 10:00 am</span>
                                    </div>
                                </div>
                                <div class="calendar-details">
                                    <p>10:00 am</p>
                                    <div class="calendar-box normal-bg">
                                        <div class="calandar-event-name">
                                            <h4>History</h4>
                                            <h5>Lorem ipsum sit amet</h5>
                                        </div>
                                        <span>10:00 - 11:00 am</span>
                                    </div>
                                </div>
                                <div class="calendar-details">
                                    <p>11:00 am</p>
                                    <div class="calendar-box break-bg">
                                        <div class="calandar-event-name">
                                            <h4>Break</h4>
                                            <h5>Lorem ipsum sit amet</h5>
                                        </div>
                                        <span>11:00 - 12:00 am</span>
                                    </div>
                                </div>
                                <div class="calendar-details">
                                    <p>11:30 am</p>
                                    <div class="calendar-box normal-bg">
                                        <div class="calandar-event-name">
                                            <h4>History</h4>
                                            <h5>Lorem ipsum sit amet</h5>
                                        </div>
                                        <span>11:30 - 12:00 am</span>
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
