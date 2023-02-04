<x-admin-layout title="Categories" routeHeadButton="{{route('categories.create')}}" headButton="Create Category">


    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">name</th>
                <th scope="col">slug</th>
                <th scope="col">parent_id</th>
                <th scope="col">created at</th>
                @can('update', $categories)
                <th scope="col"></th>
                @endcan
                @can('delete', $categories)
                <th scope="col"></th>
                @endcan
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr>
                <th scope="row">{{ $category->id }}</th>
                <td>{{ $category->name }}</td>
                <td>{{ $category->slug }}</td>
                <td>{{ $category->parent->name }}</td>
                <td>{{ $category->created_at }}</td>
                @can('update', $category)
                <td><a href="{{ route('categories.edit', $category->id) }}">edit</a></td>
                @endcan
                @can('delete', $category)
                <td>
                    <form action="{{route('categories.destroy', $category->id)}}" method="post">
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


    {{ $categories->links() }}

</x-admin-layout>