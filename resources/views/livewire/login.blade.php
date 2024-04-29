<div>
  
<div class="login-right">
    <div class="login-right-wrap">
        <h1>Welcome to Inspire Academy</h1>
        <p class="account-subtitle"><a href=" "></a></p>
        <h2>Sign in</h2>
        <form wire:submit='login' method="POST">
            @csrf
            <div class="form-group">
                <label>Email<span class="login-danger">*</span></label>
                <input wire:model='email' type="email" class="form-control @error('email') is-invalid @enderror" name="email">
                <span class="profile-views"><i class="fas fa-envelope"></i></span>
                  @error('email')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
            </div>
            <div class="form-group">
                <label>Password <span class="login-danger">*</span></label>
                <input wire:model='password' type="password" class="form-control pass-input @error('password') is-invalid @enderror" name="password">
                <span class="profile-views feather-eye toggle-password"></span>
                  @error('password')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
            </div>
            <div class="forgotpass">
                <div class="remember-me">
                    <label class="custom_check mr-2 mb-0 d-inline-flex remember-me"> Remember me
                        <input  wire:model="remember" type="checkbox" name="radio">
                        <span class="checkmark"></span>
                    </label>
                </div>
                <a href="forgot-password.html"></a>
            </div>
            <div class="form-group">
                <button class="btn btn-primary btn-block" type="submit">Login</button>
            </div>
        </form>
        <div class="login-or">
            <span class="or-line"></span>
      
        </div>
      
    </div>
</div>



</div>
