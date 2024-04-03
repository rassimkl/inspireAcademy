<div>
    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col-sm-12">
                        <div class="page-sub-header">
                            <h3 class="page-title">Add Course</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('user/add/page') }}">User</a></li>
                                <li class="breadcrumb-item active">Add Course</li>
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
                            <form wire:submit='createCourse' >
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
        <label class="@error('teacher') text-danger @enderror">Teacher <span class="login-danger">*</span>@error('teacher') - Choose a teacher @enderror</label>
        <div >
<div wire:ignore>
            <select  class="form-control js-example-responsive  @error('teacher') is-invalid @enderror" id="teacher" >
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
        <label>Per Hour <span class="login-danger">*</span></label>
        <div class="position-relative">
             <input type="number" class="form-control " name="chargePerHour" placeholder="Enter Charge per hour" wire:model='chargePerHour'>
            @error('chargePerHour')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>

                                      
                                                
                                  <div class="col-12 col-sm-4">
    <div class="form-group local-forms">
        <label>Total Hours <span class="login-danger">*</span></label>
        <div class="position-relative">
             <input type="number" class="form-control @error('totalHours') is-invalid @enderror" name="totalHours" placeholder="Enter Total hours" wire:model='totalHours'>
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
                                            <button type="submit" class="btn btn-primary">Submit</button>
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

      
             $('#teacher').select2({});
             
  $('#teacher').on('change', function() {
                var selectedteacher = $(this).val();
          
                  @this.set('teacher',selectedteacher,false);
        
            });

                 Livewire.on('resetSelect2', function () {
             
            $('#teacher').val(null).trigger('change');
        });

datetimePicker.on('dp.change', function(e) {

         @this.set('date_of_birth', e.date.format('DD-MM-YYYY'),false);

       

});
    })

</script>
@endscript
        </div>
    </div>


</div>
