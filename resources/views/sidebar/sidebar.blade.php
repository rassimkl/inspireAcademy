<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="menu-title">
                    <span>Main Menu</span>
                </li>
 
@if(auth()->user()->user_type_id==1)
    <li class="{{set_active(['home'])}}">
        <a href="{{ route('home') }}">
       <i class="fas fa-home"></i>

            <span>Home</span>
        </a>
    </li>
@endif
@if(auth()->user()->user_type_id==2)
    <li class="{{set_active(['teacher/home'])}}">
        <a href="{{ route('teacher/home') }}">
       <i class="fas fa-home"></i>

            <span>Home</span>
        </a>
    </li>
@endif
@if(auth()->user()->user_type_id==3)
    <li class="{{set_active(['student/home'])}}">
        <a href="{{ route('student/home') }}">
           <i class="fas fa-home"></i>

            <span>Home</span>
        </a>
    </li>
@endif




                
                @if (Session::get('role_name') === 'Admin' || Session::get('role_name') === 'Super Admin')
                <li class="submenu {{set_active(['list/users'])}} {{ (request()->is('view/user/edit/*')) ? 'active' : '' }}">
                    <a href="#">
                        <i class="fas fa-shield-alt"></i>
                        <span>User Management</span> 
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('list/users') }}" class="{{set_active(['list/users'])}} {{ (request()->is('view/user/edit/*')) ? 'active' : '' }}">List Users</a></li>
                    </ul>
                </li>
                @endif
{{-- //user --}}
@if(auth()->user()->user_type_id==1)
                <li class="submenu {{set_active(['student/list','student/grid','user/add/page','teacher/list','intern/list','admin/list'])}} {{ (request()->is('users/edit/*')) ? 'active' : '' }} {{ (request()->is('user/profile/*')) ? 'active' : '' }}">
                    <a href="#"><i class="fas fa-graduation-cap"></i>
                        <span> Users</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                     <li><a href="{{ route('user/add/page') }}" class="{{set_active(['user/add/page'])}}">User Add</a></li>
                        <li><a href="{{ route('student/list') }}"  class="{{set_active(['student/list','student/grid'])}}">Student List</a></li>
                                                <li><a href="{{ route('teacher/list') }}"  class="{{set_active(['teacher/list','teacher/grid'])}}">Teacher List</a></li>
                                                <li><a href="{{ route('intern/list') }}"  class="{{set_active(['intern/list','intern/grid'])}}">Intern List</a></li>
                                                <li><a href="{{ route('admin/list') }}"  class="{{set_active(['admin/list','intern/grid'])}}">Admin List</a></li>

                       
                        {{-- <li><a class="{{ (request()->is('users/edit/*')) ? 'active' : '' }}">User Edit</a></li> --}}
                        {{-- <li><a href=""  class="{{ (request()->is('user/profile/*')) ? 'active' : '' }}">User View</a></li> --}}
                    </ul>
                </li>
                @endif
                  {{-- <li class="submenu {{set_active(['student/list','student/grid','student/add/page'])}} {{ (request()->is('student/edit/*')) ? 'active' : '' }} {{ (request()->is('student/profile/*')) ? 'active' : '' }}">
                    <a href="#"><i class="fas fa-graduation-cap"></i>
                        <span> Students</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('student/list') }}"  class="{{set_active(['student/list','student/grid'])}}">Student List</a></li>
                        <li><a href="{{ route('student/add/page') }}" class="{{set_active(['student/add/page'])}}">Student Add</a></li>
                        <li><a class="{{ (request()->is('student/edit/*')) ? 'active' : '' }}">Student Edit</a></li>
                        <li><a href=""  class="{{ (request()->is('student/profile/*')) ? 'active' : '' }}">Student View</a></li>
                    </ul>
                </li> --}}


                <li class="submenu  {{set_active(['courses/create','course/list'])}} {{ (request()->is('teacher/edit/*')) ? 'active' : '' }}">
                    <a href="#"><i class="fas fa-chalkboard-teacher"></i>
                        <span> Courses</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                      @if(auth()->user()->user_type_id==1)  <li><a href="{{ route('courses.create') }}" class="{{set_active(['courses/create'])}}">Create Course</a></li>    @endif
                         <li><a href="{{ route('course/list') }}" class="{{set_active(['course/list'])}}">Courses</a></li>
                 
                    </ul>
                </li>
                            

                {{-- @if(auth()->user()->user_type_id==1)

                <li class="submenu {{set_active(['department/add/page','department/edit/page'])}} {{ request()->is('department/edit/*') ? 'active' : '' }}">
                    <a href="#"><i class="fas fa-building"></i>
                        <span> Rooms</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="" class="{{set_active(['department/list/page'])}} {{ request()->is('department/edit/*') ? 'active' : '' }}">Rooms List</a></li>
                        <li><a href="" class="{{set_active(['department/add/page'])}}">Add Room</a></li>
                        <li><a>Edit Room</a></li>
                    </ul>
                </li>
                @endif --}}
 @if(auth()->user()->user_type_id==2 || auth()->user()->user_type_id==1)
                <li class="submenu {{set_active(['subject/list/page','subject/add/page','teacher/classes','courses/addclass'])}} {{ request()->is('submit/class/*') ? 'active' : '' }} {{ request()->is('add/class/*') ? 'active' : '' }} {{ request()->is('edit/class/*') ? 'active' : '' }}">
                    <a href="#"><i class="fas fa-book-reader"></i>
                        <span> Classes</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                             {{-- @if(auth()->user()->user_type_id==2)<li><a class="{{set_active(['subject/list/page'])}} {{ request()->is('subject/edit/*') ? 'active' : '' }} {{ request()->is('add/class/*') ? 'active' : '' }}" href="#">Add Class</a></li>     @endif --}}
                        <li><a class="{{set_active(['teacher/classes'])}}" href="{{ route('teacher/classes') }}">All Classes</a></li>   
                         {{-- @if(auth()->user()->user_type_id==2) <li><a class={{ request()->is('edit/class/*') ? 'active' : '' }}>Class Edit</a></li>     @endif --}}
                             @if(auth()->user()->user_type_id==2)    <li><a href="{{ route('courses/addclass') }}" class="{{set_active(['courses/addclass'])}}" class={{ request()->is('courses/addclass/*') ? 'active' : '' }}>Add Class</a></li>@endif
                    </ul>
                </li>
@endif 
@if(auth()->user()->user_type_id==1)

                <li class="submenu {{set_active(['teacher/payments','/teachers/all/payments'])}}" {{ request()->is('invoice/edit/*') ? 'active' : '' }}>
                    <a href="#"><i class="fas fa-clipboard"></i>
                        <span> Payments</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a class="{{set_active(['teacher/payments'])}}" href="{{ route('teacher/payments') }}">Manage Payments</a></li>
                         <li><a class="{{set_active(['teacher/payments/history'])}}" href="{{ route('teacher/payments/history')}}">Invoice</a></li>
                        <li><a class="{{set_active(['teachers/all/payments'])}}" href="{{ route('teacher/all/payments') }}">All Payments</a></li>
                       
                    </ul>
                </li>
@endif

@if(auth()->user()->user_type_id==1)
    <li class="{{ set_active(['online_courses.index']) }}">
        <a href="{{ route('online_courses.index') }}">
            <i class="fas fa-globe"></i>
            <span>Online courses</span>
        </a>
    </li>
@endif


@if(auth()->user()->user_type_id==2)
    <li class="{{set_active(['teacher/fiche'])}}">
        <a href="{{ route('teacher/fiche') }}">
            <i class="fas fa-file-alt"></i>
            <span>Fiche De Presence</span>
        </a>
    </li>
@endif

@if(auth()->user()->user_type_id==2)
    <li class="{{set_active(['my/payments'])}}">
        <a href="{{ route('my/payments') }}">
       <i class="fas fa-clipboard"></i>

            <span>My Payments</span>
        </a>
    </li>

@endif

@if(auth()->user()->user_type_id == 3)
    <li class="{{ set_active(['student/online-courses']) }}">
        <a href="{{ route('student.courses') }}">
            <i class="fas fa-globe text-primary"></i>
            <span>Online Courses</span>
        </a>
    </li>
@endif


@if(auth()->user()->user_type_id == 2)
    <li class="{{ set_active(['Teacher/online-courses']) }}">
        <a href="{{ route('teacher.OnlineCourses') }}">
            <i class="fas fa-globe text-primary"></i>
            <span>Online Courses</span>
        </a>
    </li>
@endif



            </ul>
        </div>
    </div>
</div>

