<div>
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-sub-header">
                            <h3 class="page-title">Payments</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('course/list') }}">Payments</a></li>
                                <li class="breadcrumb-item active">Payments</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            {{-- message --}}
            {!! Toastr::message() !!}
         <div class="student-group-form">
                <div class="row">
                 
                    <div class="col-lg-2 col-md-4">
                        <div class="form-group">
                            <label for="teacherSelect" class="form-label text-center">Select Date :</label>
                        <div wire:ignore>
                        <input id="datepickeru" wire:model.live='selectedMonth' class="form-control  @error('date') is-invalid @enderror" name="date" type="text" placeholder="MM-YYYY" >
</div>
 @error('selectedMonth')
                                                <span class="text-danger" >
                                                    <p>{{ $message }}</p>
                                                </span>
                                            @enderror
                        </div>
                    </div>
               
                  
                     <div class=" mx-1 col-lg-2 col-md-3">
                        <div class="form-group">
                                <label for="teacherSelect" class="form-label">Select a Teacher :</label>

                               <select wire:model.live="selectedTeacher" class="form-select form-control">
                                <option value="">All Teachers</option>
                               @foreach($teachers as $teacher)
        <option value="{{$teacher->id}}">{{$teacher->first_name}}</option>
       
        @endforeach
    </select>
     @error('Selectedteacher')
                                                <span class="text-danger" >
                                                    <p>{{ $message }}</p>
                                                </span>
                                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-table comman-shadow">
                        <div class="card-body">
                            <div class="page-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h3 class="page-title">Payments</h3>
                                    </div>
                                    <div class="col-auto text-end float-end ms-auto download-grp">
                                        
                                      
                                        
                                        {{-- <a href="{{ route('') }}" class="btn btn-primary">Create Course <i class="fas fa-plus"></i></a> --}}
                                    </div>
                                </div>

                            <div class="table-responsive">
                                <table
                                    class="table border-0 star-student table-hover table-center mb-0  table-striped">
                                    <thead class="student-thread">
                       
                                        <tr>
                                   
                                            <th>
                                             
                                            </th>
                                            <th>ID</th>
                                            <th>Hours</th>
                                            <th>Amount</th>
                                               @if(!$selectedTeacher)
                                            <th>Teacher</th>@endif
                                              <th  class="text-center">Date</th>
                                          
                                       
                                        
                                         
                                        
                                        </tr>
                                    </thead>
                                    <tbody>
                         
                                  
                                        @foreach ($payments as $payment )
                                        <tr>
                                            <td>
                                              
                                            </td>
                                            <td>PYT{{ $payment->id }}</td>
                                           
                                            <td hidden class="avatar">{{ $payment->id }}</td>
                                            <td>
                                                <h2 class="table-avatar">
                                                 
                                                    <a href="{{ url('student/profile/'.$payment->id) }}">{{ $payment->hours }}</a>
                                                </h2>
                                            </td>
                                          
                                            <td>€{{ ($payment->amount) }}</td>
                                            @if(!$selectedTeacher)
                                           <td>{{ ($payment->user->first_name) }} {{ ($payment->user->last_name) }}</td>@endif
                                          
                                           <td class='text-center'>    {{ date('F j, Y', strtotime($payment->created_at)) }}
{{ date('H:i', strtotime($payment->created_at)) }}</td>

                                           
                                           
                                        </tr>
                                        @endforeach
                                        
                                    </tbody>

                                </table>
                                 {{ $payments->links() }}
                                {{-- {{ $courses->links() }} --}}
                            </div>
         @if ($payments->isEmpty())
    <p class="text-center">No Payments available.</p>
@endif

                        </div>
                         <div class="row">
        <div class="col-md-8">
            <!-- List of teachers and their classes -->
           
        </div>

         @if (!$payments->isEmpty())
        <div class="col-md-4">
            <!-- Total hours and total payment -->
            
            <div>
                <h2>Total Payment</h2>
                <p>€ {{$totalAmount}}</p> <!-- Replace with actual total payment -->
            </div>
              
        </div>
        
        @endif
        

    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- model student delete --}}

    @section('script')

    {{-- delete js --}}
    <script>
       document.addEventListener('livewire:initialized', () => {
 var datetimePicker = $('#datepickeru');
datetimePicker.datetimepicker({
    format: "MM/YYYY", // Display format for month and year
    viewMode: "months", // Initial view mode to show only months
});

        datetimePicker.on('dp.change', function(e) {
            @this.set('selectedMonth', e.date.format('MM-YYYY'), true);
        });

       });


    </script>
    @endsection





</div>
