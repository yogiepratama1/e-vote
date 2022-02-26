<div class="col-lg-12">
    <!-- /.card -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title text-lg">Users List</h3>
        </div>
        <div class="card-body table-responsive p-0">
            <h3 class="text-lg ml-3">Total Users = {{ $totals->total }}</h3>
            <h3 class="text-lg ml-3">Users Voted = {{ $totals->voted}}</h3>
            <h3 class="text-lg ml-3">Users Unvoted = {{ $totals->unvoted}}</h3>
            <div class="d-flex justify-content-center my-2">
                <input wire:model="searchTerm" type="text" class="border border-3 rounded-3 p-2 mr-2" placeholder="Search user...">
                <form action="/dashboard/user/update" method="POST">
                    @method('PUT')
                    @csrf
                    <button type="submit" class="badge bg-danger border-0 p-3" onclick="return confirm('Change all users to unvoted?')">CHANGE ALL USERS TO UNVOTED</button>
                </form>
            </div>
            <div>
                @if (session()->has('berhasil'))
                <div class="alert alert-success mx-2">
                    {{ session('berhasil') }}
                </div>
                @endif
            </div>
            <table class="table table-striped table-valign-middle">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>
                            {{ $user->name }}
                        </td>
                        <td>
                            @if($user->status_id == '1')
                            <span class="bg-success">
                                Voted
                            </span>
                            @else
                            <span class="bg-danger">
                                Unvoted
                            </span>
                            @endif
                        </td>
                        <td>
                            @if($user->isAdmin == '1')
                            <span class="bg-primary">
                                Admin
                            </span>
                            @else
                            <span>
                                Guest
                            </span>
                            @endif
                        </td>
                        <td>
                            <form action="/dashboard/user/admin/{{ $user->id }}" method="POST" class="d-inline">
                                @method('PUT')
                                @csrf
                                <button class="badge bg-success border-0" onclick="return confirm('Set user admin?');">Set Admin</button>
                            </form>
                            <form action="/dashboard/user/delete/{{ $user->id }}" method="POST" class="d-inline">
                                @method('delete')
                                @csrf
                                <button class="badge bg-danger border-0" onclick="return confirm('Delete user?')">DELETE</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $users->links() }}
        </div>
    </div>
    <!-- /.card -->
</div>
<script>
    $(function() {
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });
</script>