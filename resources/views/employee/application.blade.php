@extends('employee.index')

@section('title')
    General Application
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>General Application</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('employee.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">General Application</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-primary">

                            @if (Session::has('success'))
                                <div class="alert alert-success alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    {{ Session::get('success') }}
                                </div>
                            @endif

                            @if (Session::has('error'))
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    {{ Session::get('error') }}
                                </div>
                            @endif

                            <div class="card-header">
                                <h3 class="card-title">General Application Form</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form action="{{ route('employee.application_store') }}" method="post" enctype="multipart/form-data" id="leaveForm">
                            @csrf
                            <div class="card-body">
                                <input type="hidden" name="employee_id" value="{{ Auth::user()->id }}">

                                <!-- Multiple File Attachment Field -->
                                <div class="form-group col-md-12">
                                    <label>Attachments (Optional - Max 5 files)</label>
                                    <div class="custom-file mb-2">
                                        <input type="file" name="attachments[]" id="attachments" class="custom-file-input" multiple accept=".jpg,.jpeg,.png,.pdf,.doc,.docx,.txt,.xls,.xlsx">
                                        <label class="custom-file-label" for="attachments">Choose files (Max 5, 10MB each)</label>
                                    </div>
                                    <small class="form-text text-muted">
                                        Allowed file types: JPG, JPEG, PNG, PDF, DOC, DOCX, TXT, XLS, XLSX. Max size per file: 10MB
                                    </small>

                                    <!-- File list container -->
                                    <div id="selectedFilesContainer" class="mt-3"></div>

                                    <div id="fileError" class="text-danger mt-2" style="display: none;"></div>
                                    @error('attachments.*')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                    @error('attachments')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="form-group col-md-12">
                                    <label>Application <span class="text-danger">*</span></label>
                                    <textarea name="application" id="compose-textarea" class="form-control" style="height: 300px">
                                        <p>{{ date('jS F, Y') }}</p><p>The Chairman<br>RK Software (Bangladesh) Limited<br>House#286 (2nd floor), Road#19/C<br>New DOHS, Mohakhali, Dhaka-1206</p><p>Subject: </p><p>Dear Sir,</p><p>I beg most respectfully to state that, I am {{ Auth::user()->name }}, an employee of your company, RK Software (Bangladesh) Limited. My designation is {{ Auth::user()->designation }}.</p><p>I, therefore, pray and hope that you will consider my case and oblige thereby.</p><p>I remain<br>Sir<br>Your most obedient employee</p><p>{{ Auth::user()->name }}<br>{{ Auth::user()->designation }}<br>Mobile: {{ Auth::user()->mobile }}</p><br>
                                    </textarea>
                                    @error('application')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-success">Apply</button>
                                <button type="reset" class="btn btn-secondary" onclick="resetFileSelection()">Reset</button>
                            </div>
                            </form>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!--/.col (left) -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

@section('customJs')
    <script>
        $(function() {
            // Add text editor
            $('#compose-textarea').summernote()

            // Bootstrap custom file input
            bsCustomFileInput.init();
        })

        // Global array to store selected files
        let selectedFiles = [];
        const MAX_FILES = 5;
        const MAX_FILE_SIZE = 10 * 1024 * 1024; // 10MB
        const ALLOWED_TYPES = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'text/plain', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];

        // Function to format file size
        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        // Function to get file icon
        function getFileIcon(fileType) {
            if (fileType.includes('image')) return 'fa-file-image text-success';
            if (fileType.includes('pdf')) return 'fa-file-pdf text-danger';
            if (fileType.includes('word') || fileType.includes('document')) return 'fa-file-word text-primary';
            if (fileType.includes('excel') || fileType.includes('sheet')) return 'fa-file-excel text-success';
            if (fileType.includes('text')) return 'fa-file-alt text-info';
            return 'fa-file text-secondary';
        }

        // Function to update file input label
        function updateFileInputLabel() {
            const fileInput = document.getElementById('attachments');
            const label = document.querySelector('.custom-file-label');

            if (selectedFiles.length === 0) {
                label.innerHTML = 'Choose files (Max 5, 10MB each)';
                fileInput.value = '';
            } else {
                label.innerHTML = `${selectedFiles.length} file(s) selected`;
            }
        }

        // Function to display selected files
        function displaySelectedFiles() {
            const container = document.getElementById('selectedFilesContainer');
            container.innerHTML = '';

            if (selectedFiles.length === 0) {
                container.innerHTML = '<div class="alert alert-light text-center">No files selected</div>';
                return;
            }

            selectedFiles.forEach((file, index) => {
                const fileIcon = getFileIcon(file.type);
                const fileSize = formatFileSize(file.size);
                const fileItem = document.createElement('div');
                fileItem.className = 'alert alert-info alert-dismissible fade show mb-2';
                fileItem.innerHTML = `
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas ${fileIcon} fa-lg mr-2"></i>
                            <strong>${file.name}</strong>
                            <br>
                            <small class="text-muted">${fileSize} | ${file.type.split('/')[1].toUpperCase() || 'Unknown'}</small>
                        </div>
                        <button type="button" class="btn btn-sm btn-danger" onclick="removeFile(${index})">
                            <i class="fas fa-trash"></i> Remove
                        </button>
                    </div>
                `;
                container.appendChild(fileItem);
            });
        }

        // Function to remove a file
        function removeFile(index) {
            selectedFiles.splice(index, 1);

            // Update the file input with remaining files
            updateFileInput();
            displaySelectedFiles();
            updateFileInputLabel();

            // Hide error if exists
            document.getElementById('fileError').style.display = 'none';
        }

        // Function to update file input with current selected files
        function updateFileInput() {
            const fileInput = document.getElementById('attachments');
            const dataTransfer = new DataTransfer();

            selectedFiles.forEach(file => {
                dataTransfer.items.add(file);
            });

            fileInput.files = dataTransfer.files;

            // Trigger change event for custom file input
            $(fileInput).trigger('change');
        }

        // Function to validate file
        function validateFile(file) {
            // Check file type
            if (!ALLOWED_TYPES.includes(file.type)) {
                return {
                    valid: false,
                    message: `File "${file.name}" has invalid type. Allowed types: JPG, PNG, PDF, DOC, DOCX, TXT, XLS, XLSX`
                };
            }

            // Check file size
            if (file.size > MAX_FILE_SIZE) {
                return {
                    valid: false,
                    message: `File "${file.name}" exceeds 10MB limit`
                };
            }

            // Check for duplicate file names
            const duplicate = selectedFiles.some(existingFile =>
                existingFile.name === file.name && existingFile.size === file.size
            );

            if (duplicate) {
                return {
                    valid: false,
                    message: `File "${file.name}" is already selected`
                };
            }

            return { valid: true };
        }

        // Handle file selection
        document.getElementById('attachments').addEventListener('change', function(e) {
            const newFiles = Array.from(e.target.files);
            const errorContainer = document.getElementById('fileError');
            let hasError = false;
            let errorMessage = '';

            // Check if adding new files would exceed max limit
            if (selectedFiles.length + newFiles.length > MAX_FILES) {
                errorMessage = `You can only upload maximum ${MAX_FILES} files. Currently selected: ${selectedFiles.length}`;
                hasError = true;
            } else {
                // Validate each new file
                for (let file of newFiles) {
                    const validation = validateFile(file);
                    if (!validation.valid) {
                        hasError = true;
                        errorMessage = validation.message;
                        break;
                    }
                }
            }

            if (hasError) {
                errorContainer.textContent = errorMessage;
                errorContainer.style.display = 'block';
                // Reset file input
                updateFileInput();
                return;
            }

            // Clear error
            errorContainer.style.display = 'none';

            // Add new files to selectedFiles array
            selectedFiles = [...selectedFiles, ...newFiles];

            // Update file input
            updateFileInput();

            // Display selected files
            displaySelectedFiles();
            updateFileInputLabel();
        });

        // Function to reset all files
        window.resetFileSelection = function() {
            selectedFiles = [];
            updateFileInput();
            displaySelectedFiles();
            updateFileInputLabel();
            document.getElementById('fileError').style.display = 'none';
        }

        // Initialize display
        displaySelectedFiles();
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const fromDateInput = document.getElementById("from_date");
            const toDateInput = document.getElementById("to_date");
            const totalDayInput = document.getElementById("total_day");

            function calculateDays() {
                const fromDate = new Date(fromDateInput.value);
                const toDate = new Date(toDateInput.value);

                if (fromDate && toDate && !isNaN(fromDate) && !isNaN(toDate) && fromDate <= toDate) {
                    const diffTime = toDate.getTime() - fromDate.getTime();
                    const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24)) + 1;
                    totalDayInput.value = diffDays > 0 ? diffDays : 0;
                } else if (fromDate && toDate && fromDate > toDate) {
                    alert('To Date must be greater than or equal to From Date');
                    toDateInput.value = '';
                    totalDayInput.value = '';
                } else {
                    totalDayInput.value = "";
                }
            }

            fromDateInput.addEventListener("change", calculateDays);
            toDateInput.addEventListener("change", calculateDays);
        });
    </script>
@endsection
