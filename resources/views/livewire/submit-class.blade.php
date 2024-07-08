<div>
    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col-sm-12">
                        <div class="page-sub-header">
                            <h3 class="page-title">Submit Class for Course: {{$course->name}} </h3>
                            
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('user/add/page') }}">User</a></li>
                                <li class="breadcrumb-item active">Add Class</li>
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
                            <form wire:submit='submitClass' >
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        <h5 class="form-title student-info">Class Information
                                            <span>
                                                <a href="javascript:;"><i class="feather-more-vertical"></i></a>
                                            </span>
                                        </h5>
                                    </div>
                       

                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Hours <span class="login-danger">*</span> <span class="font-weight-bold">{{$remainingHours}} Hours Remaining</span>
</label>
                                            <input disabled step="0.25" type="number" class="form-control @error('hours') is-invalid @enderror" name="hours" placeholder="Enter number of hours" wire:model.live.500ms='hours'>
                                            @error('hours')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

               <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms calendar-icon">
                                                <label class="@error('date') text-danger @enderror">Date <span class="login-danger">*</span>@error('date') {{ $message }} @enderror</label>

                                        <div  wire:ignore>
                                            <input disabled id="datepickeru" wire:model='date' class="form-control datetimepicker @error('date') is-invalid @enderror" name="date" type="text"  >
                                            </div>
                                            @error('date')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
    <div class="col-12 col-sm-4">
                                        <div   class="form-group local-forms calendar-icon">
                                                                                        <label class="@error('start_time') text-danger @enderror">Start Time <span class="login-danger">*</span>@error('end_time') {{ $message }} @enderror</label>

                                            <div wire:ignore>
            <input disabled type="text" class="form-control " id='start_time'  wire:model.live.500ms="start_time">
            </div>
                                            @error('start_time')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>


                        
    

     <div class="col-12 col-sm-4">
                                        <div wire:ignore  class="form-group local-forms calendar-icon">
                                            <label>End time <span class="login-danger"></span></label>
            <input disabled disabled type="text" class="form-control" id='end_time' wire:model="end_time">
                                            @error('end_time')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>


                                                                 <div class="col-12 col-sm-4">
    <div class="form-group local-forms">
        <label>Room <span class="login-danger">*</span></label>
        <div class="position-relative">
            <select disabled wire:model='room_id' class="form-control  @error('room_id') is-invalid @enderror" name="room_id">
                <option selected >Select Room</option>
               @foreach($rooms as $room)
  <option value="{{$room->id}}" >{{$room->name}}</option>
               @endforeach
            </select>
            @error('room_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>
                                                
                      <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Report <span class="login-danger"> </span></label>
                                            <textarea  wire:model='report' class="form-control @error('report') is-invalid @enderror" type="text" name="info" placeholder="Enter class report" ></textarea>
                                            @error('report')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                  
                                     

   

                                 
                                    
                                

                                
                                    <div class="col-12">
                                        <div class="student-submit">
                                            <button type="submit" class="btn btn-primary">Submit Class</button>
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




 var starTimepicker = $('#start_time').datetimepicker({

       
            format: "H:mm",

         
    useCurrent: true,
    showTodayButton: true,
    showClear: true,
    toolbarPlacement: 'bottom',
    sideBySide: true,
    icons: {
        time: "fa fa-clock-o",
        date: "fa fa-calendar",
        up: "fa fa-arrow-up",
        down: "fa fa-arrow-down",
        previous: "fa fa-chevron-left",
        next: "fa fa-chevron-right",
        today: "fa fa-clock-o",
          clear: "fa fa-trash-o"
        }
        
        });




     
  
 
starTimepicker.on('dp.change', function(e) {
    var selectedTime = e.date.format('HH:mm'); // Format the selected time
    @this.set('start_time', selectedTime); // Emit a Livewire event to update the start time
});
var datetimePicker =$('#datepickeru');


 datetimePicker.on('dp.change', function(e) {

         @this.set('date', e.date.format('DD-MM-YYYY'),false);

       

});
                                                        });
  
</script>
@endscript
        </div>
    </div>


</div>
