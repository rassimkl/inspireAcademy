<div>


    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-sub-header">
                            <h3 class="page-title">Course Details</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="">Course</a></li>
                                <li class="breadcrumb-item active">Course Details</li>
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
                                <h4>Profile <span><a href="javascript:;"><i class="feather-more-vertical"></i></a></span></h4>
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
                                                <h4>{{$course->name}}</h4>
                                                <h5>{{$course->total_hours}} Hours</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 d-flex align-items-center">
                                        <div class="follow-group">
                                            <div class="students-follows">
                                                <h5>Hours Given</h5>
                                                <h4>{{$hoursGiven}}</h4>
                                            </div>
                                            <div class="students-follows">
                                                <h5>Remaining</h5>
                                                 <h4>{{($course->total_hours)-($hoursGiven)}}</h4>
                                            </div>

                                            <div class="students-follows">
                                                <h5>Submitted Classes</h5>
                                                 <h4>{{$classCount}}</h4>
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
                                                <i class="feather-user"></i>
                                            </div>
                                            <div class="views-personal">
                                                <h4>Teacher</h4>
                                                <h5>{{$course->teacher->first_name}} {{$course->teacher->last_name}}</h5>
                                            </div>
                                        </div>
                                        <div class="personal-activity">
                                            <div class="personal-icons">
                                                <img src="{{ URL::to('assets/img/icons/buliding-icon.svg') }}" alt="">
                                            </div>
                                            <div class="views-personal">
                                                <h4>Status </h4>
                                                @if($course->status_id == 1)
    <h5 style="color: red;">{{$course->status->name}}</h5>
@elseif($course->status_id == 2)
    <h5 style="color: green;">{{$course->status->name}}</h5>
@elseif($course->status_id == 3)
    <h5 style="color: blue;">{{$course->status->name}}</h5>
@else
    <h5>{{$course->status->name}}</h5>
@endif

                                            </div>
                                        </div>
                                        <div class="personal-activity">
                                            <div class="personal-icons">
                                                <i class="feather-phone-call"></i>
                                            </div>
                                            <div class="views-personal">
                                                <h4>Mobile</h4>
                                             <h5><a href="tel:{{$course->teacher->phone_number}}">{{$course->teacher->phone_number}}</a></h5>
                                            </div>
                                        </div>
                                        <div class="personal-activity">
                                            <div class="personal-icons">
                                                <i class="feather-mail"></i>
                                            </div>
                                           <div class="views-personal">
    <h4>Email</h4>
    <h5><a href="mailto:{{$course->teacher->email}}">{{$course->teacher->email}}</a></h5>
</div>

                                        </div>
                                  
                                        <div class="personal-activity">
                                            <div class="personal-icons">
                                                <i class="feather-calendar"></i>
                                            </div>
                                            <div class="views-personal">
                                                <h4>Created</h4>
                                                <h5>{{ ($course->created_at)->format('F j, Y') }}</h5>
                                            </div>
                                        </div>
                                        <div class="personal-activity">
                                            <div class="personal-icons">
                                                <i class="feather-italic"></i>
                                            </div>
                                            <div class="views-personal">
                                                <h4>Type</h4>
                           <h5>
    @if($course->course_type == 1)
        Face to Face
    @elseif($course->course_type == 2)
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
                                            <h4>Info</h4>
                                        </div>
                                        <div class="hello-park">
                                      
                                            <p>{{$course->info??'No info'}}</p>
                                         
                                        </div>
                                        <div class="hello-park">
                                            <h5>Classes</h5>
                                            @if(($course->classes)->isEmpty())
                                            <p class='text-center'>No Classes</p>@endif
                                            @foreach($course->classes as $classSession)
                                            <div class="educate-year">
                                            <h6>{{ \Carbon\Carbon::parse($classSession->date)->format('F j, Y') }}</h6>
<p style="color: {{ $classSession->status == 1 ? 'red' : ($classSession->status == 2 ? 'green' : '') }}">
    @if($classSession->status == 1)
        Not Completed
    @elseif($classSession->status == 2)
        Completed
    @endif
</p>
                                                </p>
                                            </div>
                                            @endforeach
                                         
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
