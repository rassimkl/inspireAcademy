<div>
    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col-sm-12">
                        <div class="page-sub-header">
                            <h3 class="page-title">Edit Course</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('user/add/page') }}">Course</a></li>
                                <li class="breadcrumb-item active">Edit Course</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            {{-- message --}}
            {!! Toastr::message() !!}
            <div class="row">
                <div class="col-sm-12">
                    <div class="card comman-shadow">
                        <div class="card-body">
                            <form wire:submit='updateCourse' >
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        <h5 class="form-title student-info">Course Information
                                            <span>
                                                <a href="javascript:;"><i class="feather-more-vertical"></i></a>
                                            </span>
                                        </h5>
                                    </div>
                       

                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Course Name <span class="login-danger">*</span></label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="first_name" placeholder="Enter Course Name" wire:model.live='name'>
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                       <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Type<span class="login-danger"></span></label>
                                             <div class="position-relative">
                                            <select wire:model='course_type' class="form-control  @error('blood_group') is-invalid @enderror" name="blood_group">
                                               
                                                <option value="1">Face To Face</option>
                                                <option value="2" >Online</option>
                                            
                                            </select>
                                            @error('course_type')
                                                <span class="text-danger" >
                                                    <p>{{ $message }}</p>
                                                </span>
                                            @enderror
                                              </div>
                                        </div>
                                    </div>

             <div class="col-12 col-sm-4">
    <div class="form-group local-forms">
        <label class="@error('teacher') text-danger @enderror">Teacher <span class="login-danger">*</span>@error('teacher') - Choose a teacher @enderror</label>
        <div >
<div wire:ignore>
            <select @if($course->status_id > 1) disabled @endif   class="form-control js-example-responsive  @error('teacher') is-invalid @enderror" id="teacher" >
               <option value="null">Choose a teacher</option>
            @foreach ($teachers as $teacher)
        <option value="{{ $teacher->id }}">{{ $teacher->first_name }} {{ $teacher->last_name }} </option>
    @endforeach
                <!-- Add more languages as needed -->
            </select>
            </div>
            @error('teacher')
            <div  class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </div>
            @enderror
        </div>
    </div>
</div>


     <div class="col-12 col-sm-4">
    <div class="form-group local-forms">
        <label class="@error('selectedStudents') text-danger @enderror">Students <span class="login-danger">*</span>@error('selectedStudents') - Choose at least 1 Student @enderror</label>
        <div >
<div wire:ignore>
            <select  class="form-control js-example-responsive  @error('selectedStudents') is-invalid @enderror" id="students" multiple="multiple">
            
            @foreach ($students as $student)
        <option value="{{ $student->id }}">{{ $student->first_name }} {{ $student->last_name }}</option>
    @endforeach
                <!-- Add more languages as needed -->
            </select>
            </div>
            @error('selectedStudents')
            <div  class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </div>
            @enderror
        </div>
    </div>
</div>
                                    
    

  <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Charge/Hour<span class="login-danger">*</span></label>
                                            <input type="number" class="form-control @error('chargePerHour') is-invalid @enderror" name="chargePerHour" placeholder="Enter Charge per hour" wire:model='chargePerHour'>
                                            @error('chargePerHour')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

   </div>

                                      
                                                
                                  <div class="col-12 col-sm-4">
    <div class="form-group local-forms">
     
        <label>Total Hours <span class="login-danger">*</span> <span style="color: black;">Done Hours: {{$doneHours}}</span> / <span style="color: black;">Pending Hours: {{$pendingHours}}</span>
</label>
        <div class="position-relative">
             <input type="number" step="0.01" class="form-control @error('totalHours') is-invalid @enderror" name="totalHours" placeholder="Enter Total hours" wire:model='totalHours'>
            @error('totalHours')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>
                                  
                                     

   

                                 
                                    
                                

                                          <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Info <span class="login-danger"></span></label>
                                            <textarea  wire:model='info' class="form-control @error('info') is-invalid @enderror" type="text" name="info" placeholder="Enter info" ></textarea>
                                            @error('info')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                  
                                    <div class="col-12">
                                        <div class="student-submit">
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                        
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            @script
            
            <script>
          

        

    document.addEventListener('livewire:initialized', () => {
    $('#students').select2({});
    $('#teacher').select2({});


   var selectedStudents = @this.get('selectedStudents');
     console.log(selectedStudents);
           $('#students').select2({}).val(selectedStudents).trigger('change');//preload select with the user languages

        $('#students').on('change', function() {
                var selectedStudents = $(this).val();
                //console.log('Selected languages:', selectedLanguages);
                  @this.set('selectedStudents',selectedStudents,false);
                // You can perform further actions here based on the selected values
            });

             
              var teacher = @this.get('teacher');;
        $('#teacher').select2().val(teacher).trigger('change');

  $('#teacher').on('change', function() {
                var selectedteacher = $(this).val();

                  @this.set('teacher',selectedteacher,false);
                  });





    })

</script>
@endscript
        </div>
    </div>


</div>
