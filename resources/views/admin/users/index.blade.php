<x-admin-layout title="Users" routeHeadButton="{{route('users.create')}}" headButton="Create User">


    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Type</th>
                <th scope="col">Created at</th>
                @can('update', $users)
                <th scope="col"></th>
                @endcan
                @can('delete', $users)
                <th scope="col"></th>
                @endcan
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <th scope="row">{{ $user->id }}</th>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->type }}</td>
                <td>{{ $user->created_at }}</td>
                @can('update', $user)
                <td><a href="{{ route('users.edit', $user->id) }}">edit</a></td>
                @endcan
                @can('delete', $user)
                <td>
                    <form action="{{route('users.destroy', $user->id)}}" method="post">
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


    {{ $users->links() }}

</x-admin-layout>