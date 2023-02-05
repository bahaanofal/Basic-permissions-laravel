<x-admin-layout title="Categories" routeHeadButton="{{route('categories.create')}}" headButton="Create Category">


<div class="container">
    <div class="row">
        <div class="col-12 table-responsive">
            <table class="table table-bordered categories_datatable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Parent</th>
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