<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script type="text/javascript">
    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('users.getUsers') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'gender',
                    name: 'gender'
                },
                {
                    data: 'phone',
                    name: 'phone'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'avatar',
                    name: 'avatar',
                    render: function(data, type, full, meta) {
                        return "<img src='{{ asset('storage/avatars') }}" + '/' + data + "' height='50'/ alt='no image found'>";
                    }
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });

        $('#createNewUser').click(function() {
            $('#saveBtn').val("create-user");
            $('#user_id').val('');
            $('.uploadfile').hide();
            $('#userForm').trigger("reset");
            $('#modelHeading').html("Create New User");
            $('#ajaxModel').modal('show');
        });

        $('body').on('click', '.editUser', function() {
            var user_id = $(this).data('id');
            $.get("{{ route('users.index') }}" + '/' + user_id + '/edit', function(data) {
                console.log('new data', data);
                $('.uploadfile').show();
                $("#" + data.gender).prop("checked", true);
                $('#modelHeading').html("Edit User");
                $('#saveBtn').val("edit-user");
                $('#ajaxModel').modal('show');
                $('#user_id').val(data.id);
                $('#name').val(data.name);
                $('#phone').val(data.phone);
                $('#email').val(data.email);
                $('#upload_img').html(data.avatar);
                $('#upload_file').html(data.file);
                $('#password').val('');
            })
        });

        $('#saveBtn').click(function(e) {
            e.preventDefault();
            $(this).html('Sending..');

            var formData = new FormData($('#userForm')[0]);

            $.ajax({
                data: formData,
                url: "{{ route('users.store') }}",
                type: "POST",
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function(data) {
                    $('#userForm').trigger("reset");
                    $('#ajaxModel').modal('hide');
                    table.draw();
                    $('#saveBtn').html('Save changes');
                },
                error: function(data) {
                    var err = JSON.parse(data.responseText);
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: err.errors
                    });
                    $('#saveBtn').html('Save changes');
                }
            });
        });

        $('body').on('click', '.deleteUser', function() {
            var user_id = $(this).data("id");
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('users.store') }}" + '/' + user_id,
                        success: function(data) {
                            table.draw();
                        },
                        error: function(data) {
                            console.log('Error:', data);
                        }
                    });
                    Swal.fire({
                        title: "Deleted!",
                        text: "Your data has been deleted.",
                        icon: "success"
                    });
                }
            });
        });

    });
</script>