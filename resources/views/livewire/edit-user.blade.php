<div>
    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col-sm-12">
                        <div class="page-sub-header">
                            <h3 class="page-title">Update {{$userType}}</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('user/add/page') }}">User</a></li>
                                <li class="breadcrumb-item active">Add Users</li>
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
                            <form wire:submit='updateUser' >
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        <h5 class="form-title student-info">{{$userType}} Information
                                            <span>
                                                <a href="javascript:;"><i class="feather-more-vertical"></i></a>
                                            </span>
                                        </h5>
                                    </div>
                                        <div class="col-12 col-sm-4">
    <div class="form-group local-forms">
        <label>User <span class="login-danger">*</span></label>
        <div class="position-relative">
            <select disabled  wire:model='user_type_id' aria-label="Default select example" class=" form-select   @error('user_type_id') is-invalid @enderror" name="user_type_id">
               <option selected>Select Type</option>
             @foreach($userTypes as $id => $userType)
            <option value="{{ $id }}">{{ $userType }}</option>
        @endforeach
            </select>
            @error('user_type_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
              <input class='mx-1' type="checkbox" wire:model="active"> Active
        </div>
    </div>
    
</div>

                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>First Name <span class="login-danger">*</span></label>
                                            <input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" placeholder="Enter First Name" wire:model.live='first_name'>
                                            @error('active')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Last Name <span class="login-danger">*</span></label>
                                            <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" placeholder="Enter Last Name" wire:model='last_name'>
                                            @error('last_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            
                                        </div>
                                    </div>
                                  <div class="col-12 col-sm-4">
    <div class="form-group local-forms">
        <label>Gender <span class="login-danger">*</span></label>
        <div class="position-relative">
            <select wire:model='gender' class="form-control  @error('gender') is-invalid @enderror" name="gender">
                <option  >Select Gender</option>

                 <option value="Female" @if($gender == 'Female') selected @endif>Female</option>
                <option value="Male" @if($gender == 'Male') selected @endif>Male</option>
            </select>
            @error('gender')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>

                                      
                                    <div class="col-12 col-sm-4">
                                        <div wire:ignore class="form-group local-forms calendar-icon">
                                            <label>Date Of Birth <span class="login-danger"></span></label>
                                            <input id="datepickeru" wire:model='date_of_birth' class="form-control datetimepicker @error('date_of_birth') is-invalid @enderror" name="date_of_birth" type="text" placeholder="DD-MM-YYYY" >
                                            @error('date_of_birth')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                   
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Address </label>
                                            <input wire:model='address' class="form-control @error('address') is-invalid @enderror" type="text" name="address" placeholder="Enter address" >
                                            @error('address')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                  
                                      <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>City </label>
                                            <input wire:model='city' class="form-control @error('city') is-invalid @enderror" type="text" name="city" placeholder="Enter city name" >
                                            @error('city')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                      <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>ZipCode </label>
                                            <input wire:model='zip_code' class="form-control @error('zip_code') is-invalid @enderror" type="text" name="zip_code" placeholder="Enter zipcode" >
                                            @error('zip_code')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

   <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Country </label>
                                            <input wire:model='country' class="form-control @error('country') is-invalid @enderror" type="text" name="country" placeholder="Enter country" >
                                            @error('country')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>E-Mail <span class="login-danger">*</span></label>
                                            <input wire:model='email' class="form-control @error('email') is-invalid @enderror" type="text" name="email" placeholder="Enter Email Address" value="{{ old('email') }}">
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                
                                 <div class="col-12 col-sm-4">
    <div class="form-group local-forms">
        <label class="@error('languages') text-danger @enderror">Languages <span class="login-danger">*</span>@error('languages') - Choose at least 1 language @enderror</label>
        <div >
<div wire:ignore>
            <select  class="form-control js-example-responsive  @error('languages') is-invalid @enderror" id="languages" multiple="multiple">
            
            @foreach ($AllLanguages as $language)
        <option value="{{ $language }}">{{ $language }}</option>
    @endforeach
                <!-- Add more languages as needed -->
            </select>
            </div>
            @error('languages')
            <div  class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </div>
            @enderror
        </div>
    </div>
</div>

                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                              <label>Phone <span class="login-danger">*</span></label>
<input wire:model='phone_number' class="form-control @error('phone_number') is-invalid @enderror" type="text" name="phone_number" placeholder="Enter Phone Number" value="{{ old('phone_number') }}">
                                            @error('phone_number')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

 <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Siret<span class="login-danger"></span></label>
                                            <input type="text" class="form-control @error('first_name') is-invalid @enderror" name="siret" placeholder="Enter Siret" wire:model.live='siret'>
                                            @error('siret')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                      <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Iban <span class="login-danger"></span></label>
                                            <input type="text" class="form-control @error('iban') is-invalid @enderror" name="iban" placeholder="Enter IBAN" wire:model.live='iban'>
                                            @error('iban')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                      <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Bic<span class="login-danger"></span></label>
                                            <input type="text" class="form-control @error('bic') is-invalid @enderror" name="bic" placeholder="Enter Bic" wire:model.live='bic'>
                                            @error('bic')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                      <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Name In Bank<span class="login-danger"></span></label>
                                            <input type="text" class="form-control @error('name_on_bank') is-invalid @enderror" name="name_on_bank" placeholder="Enter Name in the Bank" wire:model.live='name_on_bank'>
                                            @error('name_on_bank')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
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
                                    
                                 <div class="col-12 col-sm-4">
                                <div class="form-group local-forms">
                                            <label>Password </label>
                                            <input @if(!$passwordEnabled) disabled @endif wire:model='password' class="form-control @error('password') is-invalid @enderror" type="text" name="password" placeholder="Enter password" >
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                              <input class='mx-1' type="checkbox" wire:model.live="passwordEnabled"> Update Password?
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
          var datetimePicker = $('#datepickeru');

        datetimePicker.on('dp.change', function(e) {
            @this.set('date_of_birth', e.date.format('DD-MM-YYYY'), true);
        });


       
          var selectedLanguages = @this.get('languages');
       
           $('#languages').select2({}).val(selectedLanguages).trigger('change');//preload select with the user languages
   
             


          
  $('#languages').on('change', function() {
                var selectedLanguages = $(this).val();
                //console.log('Selected languages:', selectedLanguages);
                  @this.set('languages',selectedLanguages,false);
                // You can perform further actions here based on the selected values
            });


    })

</script>
@endscript
        </div>
    </div>


</div>
