<x-admin-layout title="Roles" routeHeadButton="{{route('roles.create')}}" headButton="Create Role">


<div class="container">
    <div class="row">
        <div class="col-12 table-responsive">
            <table class="table table-bordered roles_datatable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Abilities</th>
                        <th>Users</th>
                        <th>Created At</th>
                        <th width="50px">Edit</th>
                        <th width="50px">Delete</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

</x-admin-layout>