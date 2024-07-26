<div>
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-sub-header">
                            <h3 class="page-title">Interns</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('intern/list') }}">Intern</a></li>
                                <li class="breadcrumb-item active">All Interns</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            {{-- message --}}
            {!! Toastr::message() !!}
         <div class="student-group-form">
                <div class="row">
                 
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                             <input wire:model.live.debounce.500ms="search"  type="text" class="form-control" placeholder="Search">
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="search-student-btn">
                            <button wire:click="clearSearch" type="btn" class="btn btn-primary">Clear</button>
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
                                        <h3 class="page-title">Interns</h3>
                                    </div>
                                    <div class="col-auto text-end float-end ms-auto download-grp">
                                        
                                      
                                        
                                        <a href="{{ route('user/add/page', ['user_type_id' => 4]) }}" class="btn btn-primary">Add Intern <i class="fas fa-plus"></i></a>
                                    </div>
                                </div>
                            </div>

                            <div class="per-page-container">
    <div class="row align-items-center">
        <div class="col-auto">
            <label class="my-1 mr-2" for="perPage">Show</label>
        </div>
        <div class="col-auto m-0 p-0">
            <select wire:model.live="perPage" id="perPage" class=" custom-select-sm form form-control-sm">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
            
        </div>
        <div class="col-auto">
            <label class="my-1" for="perPage">entries</label>
        </div>
    </div>
</div>


                            <div class="table-responsive">
                                <table
                                    class="table border-0 star-student table-hover table-center mb-0 datatable table-striped">
                                    <thead class="student-thread">
                                        <tr>
                                            <th>
                                               
                                            </th>
                                            <th>ID</th>
                                            <th>Name</th>
                                      <th>Gender</th>
                                            <th>DOB</th>
                                            <th>Email</th>
                                            <th>Mobile Number</th>
                                               <th>Languages</th>
                                            <th>Address</th>
                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                  
                                        @foreach ($interns as $intern )
                                        <tr>
                                            <td>
                                              
                                            </td>
                                            <td>STD{{ $intern->id }}</td>
                                           
                                            <td hidden class="avatar">{{ $intern->id }}</td>
                                            <td>
                                                <h2 class="table-avatar">
                                                    <a href="student-details.html"class="avatar avatar-sm me-2">
                                                        <img class="avatar-img rounded-circle" src="{{ $intern->profile_picture ? Storage::url('student-photos/'.$intern->profile_picture) :Storage::url('student-photos/default.png') }}" alt="User Image">
                                                    </a>
                                                    <a href="{{ route('user/details', ['user' => $intern->id]) }}">{{ $intern->first_name }} {{ $intern->last_name }}</a>
                                                </h2>
                                            </td>
                                            <td>{{ $intern->gender }} </td>
                                            <td>{{ $intern->date_of_birth }}</td>
                                            <td>{{ $intern->email }}</td>
                                            <td>{{ $intern->phone_number }}</td>
                                          <td> @foreach(json_decode($intern->languages) as $key => $language)
        {{ $language }}@if(!$loop->last),@endif
    @endforeach</td>
                                            <td>{{$intern->address}},{{$intern->city}}</td>
                                            <td class="text-end">
                                                <div class="actions">
                                                      <a        href="{{ route('user/edit', ['userId' => $intern->id]) }}" class="btn btn-sm bg-danger-light">
                                                        <i class="far fa-edit me-2"></i>
                                                    </a>
                                                    <a class="btn btn-sm bg-danger-light student_delete" data-bs-toggle="modal" data-bs-target="#studentUser">
                                                        <i class="far fa-trash-alt me-2"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                            <div class="d-flex justify-content-between">
                <div id="total-count" class="text-muted">Total: {{ $interns->total() }} entries</div>
                <nav>
                    {{ $interns->links() }}
                </nav>
            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- model student delete --}}
 
 
    



</div>
