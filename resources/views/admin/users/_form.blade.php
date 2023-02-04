<div class="form-group">
    <div class="mb-4">
        <label style="color:black" for="name" class="form-label ">Name</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name='name' value="{{ old('name', $user->name) }}" placeholder="User Name">
        @error('name')
        <p class="invalid-feedback">{{ $message }}</p>
        @enderror
    </div>
</div>
<div class="form-group">
    <div class="mb-4">
        <label style="color:black" for="email" class="form-label ">Email</label>
        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name='email' value="{{ old('email', $user->email) }}" placeholder="User Email">
        @error('email')
        <p class="invalid-feedback">{{ $message }}</p>
        @enderror
    </div>
</div>


<div style="margin-top:1.5em; margin-bottom:1.5em;">
    <h5 style="color:black">Type:</h5>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="type" value='user' id="user" checked @if($user->type == 'user') checked @endif>
        <label class="form-check-label" for="user">
            User
        </label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="type" value='super-admin' id="super-admin" @if($user->type == 'super-admin') checked @endif>
        <label class="form-check-label" for="super-admin">
            Super Admin
        </label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="type" value='admin' id="admin" @if($user->type == 'admin') checked @endif>
        <label class="form-check-label" for="admin">
            Admin
        </label>
    </div>
    @error('type')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>

<div class="mb-4">
    <label style="color:black" for="permissions" class="form-label ">permissions:</label>
    <div>
        @foreach(config('abilities') as $key => $label)
            <div class="mb-1">
                <label for="">
                    @if(in_array($key, $userAbilities))
                    <input type="checkbox" name="permissions[]" value="{{$key}}" checked > 
                    {{ $label }} => (by roles)
                    @elseif(in_array($key, $user->permissions))
                    <input type="checkbox" name="permissions[]" value="{{$key}}" checked >
                    {{ $label }}
                    @else
                    <input type="checkbox" name="permissions[]" value="{{$key}}">
                    {{ $label }}
                    @endif
                    
                </label>
            </div>
        @endforeach
    </div>
    @error('permissions')
    <p class="invalid-feedback">{{ $message }}</p>
    @enderror
</div>

<button type="submit" class="btn btn-primary">{{$button}}</button>