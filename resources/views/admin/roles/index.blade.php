<x-admin-layout title="Roles" routeHeadButton="{{route('roles.create')}}" headButton="Create Role">


    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">name</th>
                <th scope="col">Created at</th>
                <th scope="col">abilities</th>
                <th scope="col"></th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($roles as $role)
            <tr>
                <th scope="row">{{ $role->id }}</th>
                <td>{{ $role->name }}</td>
                <td>{{ count($role->abilities) }}</td>
                <td>{{ $role->created_at }}</td>
                <td><a href="{{ route('roles.edit', $role->id) }}">edit</a></td>
                <td>
                    <form action="{{route('roles.destroy', $role->id)}}" method="post">
                        @csrf
                        @method('delete')
                        <button class="btn btn-danger btn-sm">del</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>


    {{ $roles->links() }}

</x-admin-layout>