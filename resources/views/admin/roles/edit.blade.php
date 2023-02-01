@if($errors->any())
    <div class="alert alert-danger">
        @foreach($errors->all() as $message)
            - {{ $message }}
        @endforeach
    </div>
@endif
<x-admin-layout title="Edit Role" headButton="Roles" :routeHeadButton="route('roles.index')">

    <form action="{{ route('roles.update', $role->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')
        @include('admin.roles._form', [
            'button' => 'Update'    
        ]);
    </form>

</x-admin-layout>