@if($errors->any())
    <div class="alert alert-danger">
        @foreach($errors->all() as $message)
            - {{ $message }} <br>
        @endforeach
    </div>
@endif
<x-admin-layout title="Create Role" headButton="Roles" :routeHeadButton="route('roles.index')">

    <form action="{{ route('roles.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        @include('admin.roles._form', [
            'button' => 'Create'    
        ]);
    </form>

</x-admin-layout>