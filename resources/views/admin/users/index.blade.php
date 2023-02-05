<x-admin-layout title="Users" routeHeadButton="{{route('users.create')}}" headButton="Create User">

<div class="container">
    <div class="row">
        <div class="col-12 table-responsive">
            <table class="table table-bordered users_datatable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Type</th>
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