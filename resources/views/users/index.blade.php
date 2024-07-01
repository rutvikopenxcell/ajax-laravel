<!DOCTYPE html>
<html>

<head>
    <title>laravel-ajax</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
</head>

<body>
    <div class="container">
        <h2>Laravel-Ajax</h2>
        <a class="btn btn-success" href="javascript:void(0)" id="createNewUser">Create New User</a>
        <br><br>
        <table class="table table-bordered data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Avatar</th>
                    <th width="100px">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="ajaxModel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading"></h4>
                </div>
                <div class="modal-body">
                    <form id="userForm" name="userForm" class="form-horizontal" enctype="multipart/form-data">
                        <input type="hidden" name="user_id" id="user_id">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="" maxlength="50" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-12">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" value="" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Phone</label>
                            <div class="col-sm-12">
                                <input type="number" class="form-control" id="phone" name="phone" placeholder="Enter Phone" value="" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">
                                <input type="radio" id="male" name="gender" value="male" checked>Male
                            </label>
                            <label class="col-sm-2 control-label">
                                <input type="radio" id="female" name="gender" value="female">Female
                            </label>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Avatar</label>
                            <div class="col-sm-12">
                                <p class="uploadfile">Uploaded image name: <span id="upload_img"></span></p>
                                <input type="file" class="form-control-file" id="avatar" name="avatar" value="jkj">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">File</label>
                            <div class="col-sm-12">
                                <p class="uploadfile">Uploaded file name: <span id="upload_file"></span></p>
                                <input type="file" class="form-control-file" id="file" name="file">
                            </div>
                        </div>

                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('users.script')
</body>

</html>