<form action="{{ route('request.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('post')
    <p class="text-danger"><em>*Note: One request per subject.</em></p>
    <label for="request"><strong>Name: </strong></label><br>
    <input type="text" class="form-control" name="stud_name" value="{{ auth()->user()->name }}" readonly><br>
    <label for="request"><strong>Department: </strong></label><br>
    <input type="text" class="form-control" name="department" value="{{ auth()->user()->department }}" readonly><br>

    <label for="request"><strong>Request Type: </strong></label>
    <select class="form-select mb-3" name="request_type" id="requestType" required>
        <option disabled selected>Select Request...</option>
        <option value="Reschedule Request">Reschedule Request</option>
        <option value="Special Exam Request">Special Exam Request</option>
    </select>

    <label for="period"><strong>Period: </strong></label>
    <select class="form-select mb-3" name="period" id="period" required>
        <option disabled selected>Select Period...</option>
        <option value="Prelim">Prelim</option>
        <option value="Midterm">Midterm</option>
        <option value="Prefinals">Prefinals</option>
        <option value="Finals">Finals</option>
    </select>

    <label for="request"><strong>Subject to Take: </strong></label><br>
    <select class="form-select mb-3" name="subject" id="subject" required>
        <option disabled selected>Select Subject...</option>
        @foreach ($subjectrecs as $subjectrec)
            @if($subjectrec->re_courses === auth()->user()->course || $subjectrec->re_courses === "GE")
                <option value="{{ $subjectrec->re_subjects }}">{{ $subjectrec->re_subjects }}</option>
            @endif
        @endforeach
    </select>

    <label for="request"><strong>Instructor: </strong></label>
    <select class="form-select mb-3" name="instructor" required>
        <option disabled selected>Select Instructor...</option>
        @php
        $sortedUserRecords = $userrecords->sortBy('name');
        @endphp
        @foreach($sortedUserRecords as $userrecord)
        @if($userrecord->role === "teacher" || $userrecord->role === "admin")
        @if($userrecord->department === auth()->user()->department || $userrecord->department === "GE")
        <option value="{{$userrecord->name}}">{{ $userrecord->name }}</option>
        @endif
        @endif
        @endforeach
    </select>

    <label for="request"><strong>Reason: </strong></label> 
    <p class="text-danger" id="subjectConflictNote"><em>(if subject conflict, please include the details)</em></p>
    <textarea class="form-control" rows="2" name="reason" placeholder="Reason details here..." required></textarea><br>

    <div id="timeAvailability">
        <label for="request"><strong>Time Available (Ranged): </strong></label><br>
        <input type="time" name="time_avail1" min="08:00"> - <input type="time" name="time_avail2" min="08:00"><br><br>
    </div>

    <label class="col-md-3"><strong>Requirements: </strong></label><br>
    <input type="file" class="form-control" id="fileInput" name="requirement" accept=".pdf, .docx" onchange="displayFileName()">
    <label for="fileInput" class="custom-file-input">Choose File</label>

    <p class="text-danger"><em>*Requirements should be in one (1) file only, either in .docx or .pdf format. It must include your <strong>request letter</strong>, <strong>photocopy of your guardian's ID with guardian's signature below</strong>, <strong>proof of your excuse (e.g. Medical Certificate)</strong>, and your <strong>exam permit</strong>.</em></p>
    <p class="text-danger" id="additionalNote"><em>*For those <strong>subject conflict</strong> as reason, you can only submit your <strong>exam permit</strong>.</em></p>
    <br>
    <input type="submit" class="btn btn-warning btn-lg form-control" id="sendRequest" value="Submit Request">
</form>