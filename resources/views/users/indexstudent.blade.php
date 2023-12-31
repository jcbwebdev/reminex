@extends('layouts.app')

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><strong>{{ __('Student Users') }}</strong></h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12 col-lg-4">
                    <div>
                        <form action="{{route ('createstudent')}}" method="POST">
                            @csrf
                            @method('post')
                            <div class="card">
                            <div class="card-body">
                                <h4>Add Student</h4><br>

                                <div class="form-group row">
                                <label for="aidn" class="col-sm-3 text-end control-label col-form-label">User IDN</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="aidn" name="username"  placeholder="IDN Here" required/>
                                    </div>
                                </div>

                                <div class="form-group row">
                                <label for="aname" class="col-sm-3 text-end control-label col-form-label">Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="aname" name="name" placeholder="Name Here" required/>
                                    </div>
                                </div>

                                <div class="form-group row">
                                <label for="aidn" class="col-sm-3 text-end control-label col-form-label">Email</label>
                                    <div class="col-sm-9">
                                        <input type="email" class="form-control" id="aemail" name="email"  placeholder="Email Here" required/>
                                    </div>
                                </div>

                                <div class="form-group row">
                                <label for="adep" class="col-sm-3 text-end control-label col-form-label">Department</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="department" required>          
                                        <option disabled selected>Select Department...</option>
                                        <option>Academic Head</option> 
                                        <option>ICT Department</option>  
                                        <option>Hospitality Management</option>
                                        <option>Tourism Management</option>
                                        <option>BSA Department</option>
                                        <option>BSBA Department</option>
                                        <option>GE</option>
                                    </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="acourse" class="col-sm-3 text-end control-label col-form-label">Course</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" name="course" required>          
                                            <option disabled selected>Select Course...</option>
                                                @foreach ($requestcourses as $requestcourse)
                                                    <option value="{{ $requestcourse->course_name }}">{{ $requestcourse->course_name }}</option>
                                                @endforeach
                                                
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="asec" class="col-sm-3 text-end control-label col-form-label">Section</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" name="student_section" required>          
                                            <option disabled selected>Select Section...</option>
                                                @foreach ($requestsections as $requestsec)
                                                    <option value="{{ $requestsec->name }}">{{ $requestsec->name }}</option>
                                            @endforeach
                                        </select>    
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="astat" class="col-sm-3 text-end control-label col-form-label">Status</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" name="student_status" required>     
                                            <option disabled selected>Select Status...</option>     
                                            <option value="Regular">Regular</option>
                                            <option value="Irregular">Irregular</option>
                                        </select>    
                                    </div>
                                </div>
                                
                               

                                <div class="form-group row">
                                <label for="apass" class="col-sm-3 text-end control-label col-form-label">Password</label>
                                    <div class="col-sm-9">
                                        <input type="password" class="form-control" id="apass" name="password" placeholder="Password Here" required/>
                                    </div>
                                </div>

                                <div class="form-group row">
                                <label for="arole" class="col-sm-3 text-end control-label col-form-label">Role</label>
                                    <div class="col-sm-9">        
                                        <input type="text" class="form-control" id="arole" name="role" value="student" readonly/>
                                    </div>
                                </div>
                                
                            </div>  
                            
                            <div class="border-top">
                                <div class="card-body">
                                <input type="submit" class="btn btn-warning" value="Add Student">
                                </div>
                            </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="card">
                        <form action="/upload" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('post')

                            <div class="card-body">
                                <h4>User Batch Upload</h4><br>

                                <div class="form-group row">
                                    <div class="col-sm-9">
                                        <input type="file" id="fileInput" name="file" accept=".csv" onchange="displayFileName()">
                                            <label for="fileInput" class="custom-file-input">Choose CSV File</label>
                                    </div>
                                </div>
                                <div class="border-top">
                                    <input type="submit" class="btn btn-secondary" value="Submit">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="mt-3">
                        @if ($errors->any())
                            <div class="col-12">
                                @foreach ($errors->all() as $error)
                                    <div class="alert alert-danger">{{$error}}</div>                               
                                @endforeach
                            </div>
                        @endif

                        @if (session()->has('error'))
                            <div class="alert alert-danger">{{session('error')}}</div>                       
                        @endif

                        @if (session()->has('success'))
                            <div class="alert alert-success">{{session('success')}}</div>                       
                        @endif
                    </div>
                </div>	
            </div><br>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Users Datatable</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                    <div class="table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID Number</th>
                                <th>Name</th>
                                <th>Department</th>
                                <th>Email</th>
                                <th>Password</th>
                                <th>Section</th>
                                <th>Status</th>
                                <th>Course</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                        @if ($user->role === "student")
                            <tr>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->name }}</td>  
                                <td>{{ $user->department }}</td>  
                                <td>{{ $user->email }}</td>   
                                <td style="font-size:7px">{{ $user->password }}</td> 
                                <td>{{ $user->student_sec }}</td>
                                <td>{{ $user->student_status }}</td> 
                                <td>{{ $user->course }}</td> 
                                <td>

                                    <button class="btn btn-success btn-sm edit-button" data-toggle="modal" data-target="#editStudent" data-id="{{ $user->id }}">Edit</button>
                                    
                                </td> 
                            </tr>
                        @endif
                        @endforeach 
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>ID Number</th>
                                <th>Name</th>
                                <th>Department</th>
                                <th>Email</th>
                                <th>Password</th>
                                <th>Section</th>
                                <th>Status</th>
                                <th>Course</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        </table>
                    </div>
                    </div>
                    <!-- /.card-body -->
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="modal fade" id="editStudent" tabindex="-1" role="dialog" aria-labelledby="editStudentModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editStudentModalLabel">Edit Student</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('users.updateStudent') }}" method="post" id="editStudentForm">
                        @csrf
                        <input type="hidden" id="editUserId" name="user_id">
                        <div class="form-group">
                            <label for="editname">ID Number:</label>
                            <input type="text" class="form-control" id="editusername" name="username" required><br>
                            <label for="editname">Name:</label>
                            <input type="text" class="form-control" id="editname" name="name" required><br>
                            <label for="editdept">Department:</label>
                            <select class="form-control" id="editdept" name="department" required>          
                                        <option disabled selected>Select Department...</option>
                                        <option>Academic Head</option> 
                                        <option>ICT Department</option>  
                                        <option>Hospitality Management</option>
                                        <option>Tourism Management</option>
                                        <option>BSA Department</option>
                                        <option>BSBA Department</option>
                                        <option>GE</option>
                            </select><br>
                            <label for="editcourse">Course</label>
                            <select class="form-control" id="editcourse" name="course" required>          
                                        <option disabled selected>Select Course...</option>
                                            @foreach ($requestcourses as $requestcourse)
                                                <option value="{{ $requestcourse->course_name }}">{{ $requestcourse->course_name }}</option>
                                            @endforeach
                            </select><br>
                            <label for="editsection">Section</label>
                                <select class="form-control" id="editsection" name="section" required>          
                                    <option disabled selected>Select Section...</option>
                                        @foreach ($requestsections as $requestsec)
                                        <option value="{{ $requestsec->name }}">{{ $requestsec->name }}</option>
                                        @endforeach
                                </select><br>
                            <label for="editstatus">Status</label>
                                <select class="form-control" id="editstatus" name="status" required>     
                                    <option disabled selected>Select Status...</option>     
                                        <option value="Regular">Regular</option>
                                        <option value="Irregular">Irregular</option>
                                </select><br>
                            <label for="editemail">Email:</label>
                            <input type="email" class="form-control" id="editemail" name="email" required><br>
                            <label for="editpassword">Password:</label>
                            <input type="password" class="form-control" id="editpass" name="password" required>
                        </div>
                            <input type="submit" class="btn btn-primary" value="Save Changes">
                    </form>
                </div>
                <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

<script src="{{asset('import/js/edituser.js')}}"></script>
    
@endsection