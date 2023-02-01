<div class="form-group">
    <div class="mb-4">
        <label style="color:black" for="name" class="form-label ">Name</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name='name' value="{{ old('name', $role->name) }}" placeholder="Role Name">
        @error('name')
        <p class="invalid-feedback">{{ $message }}</p>
        @enderror
    </div>
</div>
<div class="mb-4">
    <label style="color:black" for="abilities" class="form-label ">Abilities:</label>
    <div>
        @foreach(config('abilities') as $key => $label)
            <div class="mb-1">
                <label for="">
                    @if($role->abilities)
                    <input type="checkbox" name="abilities[]" value="{{$key}}" @if(in_array($key, $role->abilities)) checked @endif>
                    @else
                    <input type="checkbox" name="abilities[]" value="{{$key}}">
                    @endif
                    {{ $label }}
                </label>
            </div>
        @endforeach
    </div>
    @error('abilities')
    <p class="invalid-feedback">{{ $message }}</p>
    @enderror
</div>


<div class="mb-4">
    <label style="color:black" for="abilities" class="form-label ">Users:</label>
    <div>
        @foreach($users as $user)
            <div class="mb-1">
                <label for="">
                    @if($usersInRole)
                    <input type="checkbox" name="users[]" value="{{$user->id}}" @if(in_array($user->id, $usersInRole)) checked @endif>
                    @else
                    <input type="checkbox" name="users[]" value="{{$user->id}}">
                    @endif
                    {{ $user->name }}
                </label>
            </div>
        @endforeach
    </div>
    @error('users')
    <p class="invalid-feedback">{{ $message }}</p>
    @enderror
</div>


<button type="submit" class="btn btn-primary">{{$button}}</button>