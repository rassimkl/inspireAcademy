<div>


    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-sub-header">
                            <h3 class="page-title">Class Details</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="">Class</a></li>
                                <li class="breadcrumb-item active">Class Details</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="about-info">
                                <h4>Details <span><a href="javascript:;"><i class="feather-more-vertical"></i></a></span></h4>
                            </div>
                            <div class="student-profile-head">
                                <div class="profile-bg-img">
                                    <img src="{{ URL::to('assets/img/profile-bg.jpg') }}" alt="Profile">
                                </div>
                                <div class="row mt-4">
                                    <div class="col-lg-4 col-md-4">
                                        <div class="profile-user-box">
                                            <div class="profile-user-img">
                                                
                                              
                                            </div>
                                            <div class="names-profiles">
                                                <h4>{{$classSession->course->name}}</h4>
                                            <h5>Class for {{ $classSession->hours }} {{ Str::plural('Hour', $classSession->hours) }}</h5>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 d-flex align-items-center">
                                        <div class="follow-group">
                                            <div class="students-follows">
                                                <h5>Course Hours</h5>
                                                <h4>{{$classSession->course->total_hours}}</h4>
                                            </div>
                                            <div class="students-follows">
                                                <h5>Remaining</h5>
                                                 <h4>{{($classSession->course->total_hours)-($hoursGiven)}}</h4>
                                            </div>

                                            <div class="students-follows">
                                                <h5>Students</h5>
                                                 <h4>{{$classSession->course->students->count()}}</h4>
                                            </div>
                                       
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="student-personals-grp">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="heading-detail">
                                            <h4> Details :</h4>
                                        </div>
                                        <div class="personal-activity">
                                            <div class="personal-icons">
                                               <i class="fas fa-user"></i>
                                            </div>
                                            <div class="views-personal">
                                                <h4>Teacher</h4>
                                                <h5>{{$classSession->course->teacher->first_name}} {{$classSession->course->teacher->last_name}}</h5>
                                            </div>
                                        </div>
                                        <div class="personal-activity">
                                            <div class="personal-icons">
                                             <i class="fas fa-check-circle"></i> 
                                            </div>
                                            <div class="views-personal">
                                                <h4>Course Status </h4>
                                                @if($classSession->course->status_id == 1)
    <h5 style="color: red;">{{$classSession->course->status->name}}</h5>
@elseif($classSession->course->status_id == 2)
    <h5 style="color: green;">{{$classSession->course->status->name}}</h5>
@elseif($classSession->course->status_id == 3)
    <h5 style="color: blue;">{{$classSession->course->status->name}}</h5>
@else
    <h5>{{$classSession->course->status->name}}</h5>
@endif

                                            </div>
                                            
                                        </div>
                                        
 <div class="personal-activity">
                                            <div class="personal-icons">
                                              <i class="fas fa-book"></i>

                                            </div>
                                            <div class="views-personal">
                                                <h4>Class Status </h4>
                                                @if($classSession->status == 1)
    <h5 style="color: red;">Not Completed</h5>
@elseif($classSession->course->status_id == 2)
    <h5 style="color: blue;">Completed</h5>
@endif

                                            </div>
                                            
                                        </div>

                                        <div class="personal-activity">
                                            <div class="personal-icons">
                                                <i class="fas fa-phone"></i>
                                            </div>
                                            <div class="views-personal">
                                                <h4>Mobile</h4>
                                             <h5><a href="tel:{{$classSession->course->teacher->phone_number}}">{{$classSession->course->teacher->phone_number}}</a></h5>
                                            </div>
                                        </div>
                                        <div class="personal-activity">
                                            <div class="personal-icons">
                                                  <i class="fas fa-envelope"></i>
                                            </div>
                                           <div class="views-personal">
    <h4>Email</h4>
    <h5><a href="mailto:{{$classSession->course->teacher->email}}">{{$classSession->course->teacher->email}}</a></h5>
</div>

                                        </div>
                                  
                                        <div class="personal-activity">
                                            <div class="personal-icons">
                                           <i class="fas fa-calendar-alt"></i>
                                            </div>
                                            <div class="views-personal">
                                                <h4>Date</h4>
                                       <h5>{{ \Carbon\Carbon::parse($classSession->date)->format('F j, Y') }} - {{ $classSession->start_time }} to {{ $classSession->end_time }}</h5>


                                            </div>
                                        </div>
                                        <div class="personal-activity">
                                            <div class="personal-icons">
                                                @if($classSession->course->course_type ==1)
                                              
                                               <i class="fas fa-users"></i> 
                                              @else
                                             <i class="fas fa-desktop"></i>
                                              @endif
                                            </div>
                                            <div class="views-personal">
                                                <h4>Type</h4>
                           <h5>
    @if($classSession->course->course_type == 1)
        Face to Face
    @elseif($classSession->course->course_type == 2)
        Online
    @endif
</h5>
                                            </div>
                                        </div>
  

                  </div>
                                </div>
                            </div>
                          
                        </div>
                        <div class="col-lg-8">
                            <div class="student-personals-grp">
                                <div class="card mb-0">
                                    <div class="card-body">
                                        <div class="heading-detail">
                                            <h4>Report</h4>
                                        </div>
                                        <div class="">

                                            <p>{{$classSession->report??'The class is not Yet Submitted'}}</p>
                                         
                                        </div>
                                        <div class="hello-park">
                                         
                                 
                                       
                                         
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
