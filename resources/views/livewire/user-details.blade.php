<div>


    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-sub-header">
                            <h3 class="page-title">{{$user->userType->name}} Details</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="">{{$user->userType->name}}</a></li>
                                <li class="breadcrumb-item active">{{$user->userType->name}} Details</li>
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
                                                <h4>{{$user->first_name}} {{$user->last_name}}</h4>
                                                <h5>{{$user->userType->name}}</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-4 d-flex align-items-center">
                                        <div class="follow-group">
                                            <div class="students-follows">
                                                <h5>Courses</h5>
                                                <h4>{{$courses->count()}}</h4>
                                            </div>
                                            <div class="students-follows">
                                                <h5>Classes</h5>
                                                 <h4>{{$classesCount}}</h4>
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
                                            <h4>Personal Details :</h4>
                                        </div>
                                        <div class="personal-activity">
                                            <div class="personal-icons">
                                                <i class="feather-user"></i>
                                            </div>
                                            <div class="views-personal">
                                                <h4>Name</h4>
                                                <h5>{{$user->first_name}} {{$user->last_name}}</h5>
                                            </div>
                                        </div>
                                        <div class="personal-activity">
                                            <div class="personal-icons">
                                                <img src="{{ URL::to('assets/img/icons/buliding-icon.svg') }}" alt="">
                                            </div>
                                            <div class="views-personal">
                                                <h4>Department </h4>
                                                <h5>Language</h5>
                                            </div>
                                        </div>
                                        <div class="personal-activity">
                                            <div class="personal-icons">
                                                <i class="feather-phone-call"></i>
                                            </div>
                                            <div class="views-personal">
                                                <h4>Mobile</h4>
                                             <h5><a href="tel:{{$user->phone_number}}">{{$user->phone_number}}</a></h5>
                                            </div>
                                        </div>
                                        <div class="personal-activity">
                                            <div class="personal-icons">
                                                <i class="feather-mail"></i>
                                            </div>
                                           <div class="views-personal">
    <h4>Email</h4>
    <h5><a href="mailto:{{$user->email}}">{{$user->email}}</a></h5>
</div>

                                        </div>
                                        <div class="personal-activity">
                                            <div class="personal-icons">
                                                <i class="feather-user"></i>
                                            </div>
                                            <div class="views-personal">
                                                <h4>Gender</h4>
                                                <h5>{{$user->gender}}</h5>
                                            </div>
                                        </div>
                                        <div class="personal-activity">
                                            <div class="personal-icons">
                                                <i class="feather-calendar"></i>
                                            </div>
                                            <div class="views-personal">
                                                <h4>Date of Birth</h4>
                                                <h5>{{ \Carbon\Carbon::parse($user->date_of_birth)->format('F j, Y') }}</h5>
                                            </div>
                                        </div>
                                        <div class="personal-activity">
                                            <div class="personal-icons">
                                                <i class="feather-italic"></i>
                                            </div>
                                            <div class="views-personal">
                                                <h4>Language</h4>
                                              <h5>
        @php
            $languages = json_decode($user->languages);
            echo implode(', ', $languages);
        @endphp
    </h5>
                                            </div>
                                        </div>
                                                                              @if($user->blood_group)
    <div class="personal-activity ">
        <div class="personal-icons">
            <i class="feather-heart"></i> <!-- Assuming 'feather-heart' represents a heart icon -->
        </div>
        <div class="views-personal">
            <h4>Blood Group</h4>
            <h5>{{$user->blood_group}}</h5>
        </div>
    </div>
@endif
                                        <div class="personal-activity">
                                            <div class="personal-icons">
                                                <i class="feather-map-pin"></i>
                                            </div>
                                            <div class="views-personal">
                                                <h4>Address</h4>
                                                <h5><a href="https://www.google.com/maps?q={{urlencode($user->address)}}">{{$user->address}}</a></h5>
                                            </div>
                                        </div>
  

 <div class="personal-activity mb">
        <div class="personal-icons">
            <i class="feather-globe"></i> <!-- Assuming 'feather-globe' represents a globe icon -->
        </div>
        <div class="views-personal">
            <h4>Country</h4>
          

            <h5>{{$user->country}}</h5>

          
        </div>
    </div>


    @if($user->user_type_id==2 || $user->user_type_id==4)
         @if( auth()->user()->user_type_id==1 || auth()->user()->id == $user->id)                         
 <div class="personal-activity mb-0">
        <div class="personal-icons">
            <i class="fas fa-file-contract"></i> <!-- Assuming 'feather-globe' represents a globe icon -->
        </div>
        <div class="views-personal">
            <h4>Contract</h4>
          

  @if (!$user->contracts()->exists())

                                 
                                    <div class="mt-2 views-personal">
            

        </div>

          @can('viewAdmin',$user->userType)

                                                    <form class='mt-2'  wire:submit="save">
                                       
        <input class="form-control" type="file" wire:model="contract">
             @error('contract')
                                                <span class="text-danger" >
                                                    <p>{{ $message }}</p>
                                                </span>
                                            @enderror

       <div class="col-12">
                                        <div class="student-submit">
                                            <button type="submit" class="btn btn-primary mt-2">Upload Contract</button>
                                        </div>
                                        
                                    </div>
    </form>
     @endcan

       @cannot('viewAdmin',$user->userType)
<p>No contract uploaded</p>
       @endcannot
  @elseif( auth()->user()->user_type_id==1 || auth()->user()->id == $user->id)

                       <a href="{{ asset('storage/' . $user->contracts->first()->path) }}" class="btn btn-sm bg-danger-light">
               <i class="fa fa-download">Download</i>
            </a>
   @can('viewAdmin',$user->userType)
                    <a wire:click="cdeleteFile({{$user->contracts->first()->id }})" class="btn btn-sm bg-danger-light">
    <i class="fa fa-trash">Delete</i>

</a>
 @endcan
    @endif
   
    @endif
   









        </div>
    </div>
       @endif
    

    
                                    </div>
                                    
                                </div>
                            </div>
                          
                        </div>
                        <div class="col-lg-8">
                            <div class="student-personals-grp">
                                <div class="card mb-0">
                                    <div class="card-body">
                                        <div class="heading-detail">
                                            <h4>About Me</h4>
                                        </div>
                                        <div class="hello-park">
                                      
                                            <p>{{$user->info}}</p>
                                         
                                        </div>
                                           <hr> <!-- Add your separator here -->

                                           @if(auth()->user()->user_type_id==1)
                                        <div class="hello-park">

                     <div class="d-flex align-items-center">
    <h5 class="mb-0 mr-4 ">Courses : {{$loopcourses->count()}} </h5> <!-- Adding mr-2 for margin right -->
    <div class="form-group mb-0 px-4">
        <label for="status" class="visually-hidden">Filter by Status:</label>
        <select id="status" wire:model.live="status" class="form-select">
           
            @foreach($courseStatuses as $status)
                <option value="{{$status->id}}">{{$status->name}}</option>
            @endforeach
        </select>
    </div>
</div>

                  
                                            @if($loopcourses->isEmpty())
                                            <p class='text-center'>No Courses</p>@endif
                                            @foreach($loopcourses as $course)
                                            <div class="educate-year pt-4">
                                                <h6>{{ ($course->created_at)->format('F j, Y') }}</h6>
                                              <p>
 @if($user->user_type_id == 2)
   <a href="{{ route('course/deails', ['course' => $course]) }}">{{$course->name}}</a>
@else
   <a href="{{ route('course/deails', ['course' => $course]) }}">{{$course->name}}</a> with <a href="{{ route('user/details', ['user' => $course->teacher->id]) }}">
        {{$course->teacher->first_name}} {{$course->teacher->last_name}}
    </a>
@endif
    @if($course->status_id == 1)
        <span style="color: red;">({{$course->status->name}})</span>  {{$course->classes_sum_hours??0}} out of {{$course->total_hours}} Hours
    @elseif($course->status_id == 2)
        <span style="color: green;">({{$course->status->name}})</span> {{$course->classes_sum_hours??0}} out of {{$course->total_hours}} Hours
    @elseif($course->status_id == 3)
        <span style="color: blue;">({{$course->status->name}})</span>  {{$course->classes_sum_hours??0}} out of {{$course->total_hours}} Hours
    @endif

  
</p>

                                                </p>
                                            </div>
                                              @if(!$loop->last)
        <hr> <!-- Add your separator here -->
    @endif
                                            @endforeach
                                         
                                        </div>
                                    </div>
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
