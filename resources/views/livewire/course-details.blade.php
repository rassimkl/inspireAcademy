
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
                                            <div class="profile-user-img"></div>
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
                                                <h5><a href="{{ route('user/details', ['user' => $course->teacher->id]) }}">{{$course->teacher->first_name}} {{$course->teacher->last_name}}</a></h5>
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
                                                    @if($course->course_type ==

 1)
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
                                            <h5>Classes :</h5>
                                            @if($course->classes->isEmpty())
                                            <p class='text-center'>No Classes</p>
                                            @else
                                            @foreach($course->classes->sortByDesc('date')->take(5) as $classSession)
                                            <div class="educate-year">
                                                <a href="{{ route('class/details', ['classId' => $classSession->id]) }}">
                                                    <h5 class='mb-2'>CLS{{$classSession->id}}</h5>
                                                    <h6>{{ \Carbon\Carbon::parse($classSession->date)->format('F j, Y') }} - {{ $classSession->start_time }} to {{ $classSession->end_time }}</h6>
                                                    <p style="color: {{ $classSession->status == 1 ? 'red' : ($classSession->status == 2 ? 'green' : '') }}">
                                                        @if($classSession->status == 1)
                                                        Not Completed
                                                        @elseif($classSession->status == 2)
                                                        Completed
                                                        @endif
                                                    </p>
                                                </a>
                                            </div>
                                            @if(!$loop->last)
                                            <hr/> <!-- Add your separator here -->
                                            @endif
                                            @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 col-lg-8">
                            <div class="student-personals-grp">
                                <div class="card mb-0">
                                    <div class="card-body">
                                        <div class="heading-detail">
                                            <h4>Students</h4>
                                        </div>
                                        <div class="hello-park">
                                            @if(($course->students)->isEmpty())
                                            <p class='text-center'>No Students Assigned to this course</p>
                                            @endif
                                            @foreach($course->students as $student)
                                            <div class="educate-year">
                                                <a href="{{ route('user/details', ['user' => $student->id]) }}">
                                                    <h5>{{$student->first_name}} {{$student->last_name}}</h5>
                                                </a>
                                               
    

  
                                            </div>
                                            @if(!$loop->last)
                                            <hr/> <!-- Add your separator here -->
                                            @endif
                                            @endforeach
                                        </div>


                                        
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 col-lg-12">
                            <div class="student-personals-grp">
                                <div class="card mb-0">
                                    <div class="card-body">
                                        <div class="heading-detail">
                                            <h4>Files</h4>
                                        </div>

                                        @can('addClass',$course)
                                                 <form  wire:submit="save">
                                       
        <input class="form-control" type="file" wire:model="doc">
             @error('doc')
                                                <span class="text-danger" >
                                                    <p>{{ $message }}</p>
                                                </span>
                                            @enderror
  <input type="text" class=" mt-2 form-control " name="title" placeholder="Enter title" wire:model='title'>
          @error('title')
                                                <span class="text-danger" >
                                                    <p>{{ $message }}</p>
                                                </span>
                                            @enderror
       <div class="col-12">
                                        <div class="student-submit">
                                            <button type="submit" class="btn btn-primary mt-2">Upload FIle</button>
                                        </div>
                                        
                                    </div>
    </form>
    @endcan
                                      <div class="table-responsive">
    <table class="table border-0 star-student table-hover table-center mb-0 table-striped">
        <thead class="student-thread">
            <tr>
                <th></th>
                <th>ID</th>
                <th>Title</th>
                <th>Type</th>
                <th>Date Uploaded</th>
               
                <th class="text-end">Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- This is where you would loop through your classes -->
            @foreach($course->files as $file)
            <tr>
                <td></td>
                <td><a href="#">FL{{$file->id}}</a></td>
                <td>
                    <h2 class="table-avatar">
                        <a href="#">{{$file->title}}</a>
                    </h2>
                </td>
                <td><a href="#">{{$file->mime_type}}</a></td>
             
                <td><span >{{ $file->created_at->diffForHumans() }}</span></td>
                <td class="text-end">
                    <div class="actions">

                       <a href="{{ asset('storage/' . $file->path) }}" class="btn btn-sm bg-danger-light">
                <i class="fa fa-download"></i>
            </a>
     @can('addClass',$course)
            <a wire:click="cdeleteFile({{ $file->id }})" class="btn btn-sm bg-danger-light">
    <i class="fa fa-trash"></i>

</a>
    @endcan
                    
                       
                    </div>
                </td>
            </tr>
            @endforeach
            <!-- Repeat this row for each class -->
        </tbody>
    </table>
    <!-- Pagination links -->
    
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
