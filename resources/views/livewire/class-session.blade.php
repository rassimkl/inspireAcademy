<div>

    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col-sm-12">
                        <div class="page-sub-header">
                            <h3 class="page-title">Add Class for Course: {{$course->name}} </h3>
                            
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
                            <form wire:submit='createClass' >
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
                                            <input step="0.25" type="number" class="form-control @error('hours') is-invalid @enderror" name="hours" placeholder="Enter number of hours" wire:model.live.500ms='hours'>
                                            @error('conflict')
                                                <p class="text-danger" role="alert">
                                                    {{ $message }}
                                                </p>
                                            @enderror
                                               @error('hours')
                                                <p class="text-danger" role="alert">
                                                    {{ $message }}
                                                </p>
                                            @enderror
                                        </div>
                                    </div>

               <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms calendar-icon">
                                                <label class="@error('date') text-danger @enderror">Date <span class="login-danger">*</span>@error('date') {{ $message }} @enderror</label>

                                        <div  wire:ignore>
                                            <input id="datepickeru" wire:model.live='date' class="form-control datetimepicker @error('date') is-invalid @enderror" name="date" type="text" placeholder="DD-MM-YYYY" >
                                            </div>
                                           @error('date')
                                                <p class="text-danger" role="alert">
                                                    {{ $message }}
                                                </p>
                                            @enderror
                                        </div>
                                    </div>
    <div class="col-12 col-sm-4">
                                        <div   class="form-group local-forms calendar-icon">
                                                                                        <label class="@error('start_time') text-danger @enderror">Start Time <span class="login-danger">*</span>@error('start_time') {{ $message }} @enderror</label>

                                            <div wire:ignore>
            <input type="text" class="form-control" id='start_time' wire:model.live.500ms="start_time">
            </div>
                                             @error('start_time')
                                                <p class="text-danger" role="alert">
                                                    {{ $message }}
                                                </p>
                                            @enderror
                                        </div>
                                    </div>


                        
    

     <div class="col-12 col-sm-4">
                                        <div  class="form-group local-forms calendar-icon">
                                            <label>End time <span class="login-danger"></span></label>
                          <div  wire:ignore>                  
            <input disabled type="text" class="form-control" id='end_time' wire:model="end_time"></div>     
                                              @error('end_time')
                                                <p class="text-danger" role="alert">
                                                    {{ $message }}
                                                </p>
                                            @enderror
                                        </div>
                                    </div>


                                                                 <div class="col-12 col-sm-4">
    <div class="form-group local-forms">
        <label>Room <span class="login-danger">*</span></label>
        <div class="position-relative">
            <select wire:model.live='room_id' class="form-control  @error('room_id') is-invalid @enderror" name="room_id">
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
                                                
                
                                  
                                     

   

                                 
                                    
                                

                                
                                    <div class="col-12">
                                        <div class="student-submit">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                      <div class="form-check mt-2">
        <input class="form-check-input" type="checkbox" value="1" id="notifyUser" name="notifyUser" wire:model="notifyUser">
        <label class="form-check-label" for="notifyUser">
            Notify user
        </label>
    </div>
                                        
                                    </div>
                                </div>
                            </form>
                                 
                        </div>

              <div class="row">
  <div wire:ignore class="col-md-8 offset-md-2">
    <div id='calendarss' class="card">
      <div class="card-body">
        <!-- Calendar will be rendered here -->
      </div>
    </div>
  </div>
</div>
                    </div>
                </div>
            </div>

       <script>
    document.addEventListener('livewire:initialized', () => {
        var formattedDate;
        var events;

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

        var datetimePicker = $('#datepickeru');

        datetimePicker.on('dp.change', function(e) {
            @this.set('date', e.date.format('DD-MM-YYYY'), true);
        });

        starTimepicker.on('dp.change', function(e) {
            var selectedTime = e.date.format('HH:mm');
            @this.set('start_time', selectedTime);
        });

        var classes = @this.get('events');
        events = classes.map(function(item) {
            return {
                title: item.title,
                start: item.start,
                end: item.end
            };
        });

function initializeCalendar() {
            var calendarEl = document.getElementById('calendarss');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'timeGridDay',
                initialDate: formattedDate,
                themeSystem: "bootstrap",
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'timeGridDay'
                },
                slotMinTime: '08:00',
                slotMaxTime: '24:00',
                slotLabelFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false
                },
                events: events,
           slotEventOverlap:false,
           
            });

            calendar.render();

            return calendar;
        }






 var calendar = initializeCalendar();
        Livewire.on('dateChanged', function(date) {
      
            var parts = date[0].split('-');
            var parsedDate = new Date(parts[2], parts[1] - 1, parts[0]);
            var year = parsedDate.getFullYear();
            var month = ('0' + (parsedDate.getMonth() + 1)).slice(-2);
            var day = ('0' + parsedDate.getDate()).slice(-2);
            formattedDate = year + '-' + month + '-' + day;
            calendar.gotoDate(formattedDate);
        });

        Livewire.on('roomChanged', function(uevents) {
            console.log('room changed');
            events = uevents[0].map(function(item) {
                return {
                    title: item.title,
                    start: item.start,
                    end: item.end
                };
            });
            console.log(events);

            var calendar = initializeCalendar();
        });


         
    });
</script>

        </div>
    </div>


</div>
