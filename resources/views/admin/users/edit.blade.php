@if($errors->any())
    <div class="alert alert-danger">
        @foreach($errors->all() as $message)
            - {{ $message }}
        @endforeach
    </div>
@endif
<x-admin-layout title="Edit User" headButton="Users" :routeHeadButton="route('users.index')">

    <form action="{{ route('users.update', $user->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')
        @include('admin.users._form', [
            'button' => 'Update'    
        ]);
    </form>

</x-admin-layout>