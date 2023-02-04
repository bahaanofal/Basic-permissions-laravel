<x-admin-layout title="Roles" routeHeadButton="{{route('roles.create')}}" headButton="Create Role">


    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">name</th>
                <th scope="col">abilities</th>
                <th scope="col">users</th>
                <th scope="col">Created at</th>
                @can('update', $roles)
                <th scope="col"></th>
                @endcan
                @can('delete', $roles)
                <th scope="col"></th>
                @endcan
            </tr>
        </thead>
        <tbody>
            @foreach($roles as $role)
            <tr>
                <th scope="row">{{ $role->id }}</th>
                <td>{{ $role->name }}</td>
                <td>@if($role->abilities != 0)
                    {{count($role->abilities)}}  
                @else
                    0
                @endif</td>
                <td>@if($role->users->count() != 0)
                    {{count($role->users)}}  
                @else
                    0
                @endif</td>
                <td>{{ $role->created_at }}</td>
                @can('update', $role)
                <td><a href="{{ route('roles.edit', $role->id) }}">edit</a></td>
                @endcan
                @can('delete', $role)
                <td>
                    <form action="{{route('roles.destroy', $role->id)}}" method="post">
                        @csrf
                        @method('delete')
                        <button class="btn btn-danger btn-sm">del</button>
                    </form>
                </td>
                @endcan
            </tr>
            @endforeach
        </tbody>
    </table>


    {{ $roles->links() }}

</x-admin-layout>