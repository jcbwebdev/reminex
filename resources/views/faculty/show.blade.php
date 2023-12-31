@extends('layouts.guest2')


@section('content')

<div class="main">
				<main class="content">
					<div class="container-fluid p-0">

						<!-- <h1 class="h3 mb-3"><strong class="text-warning">Reminex</strong> Dashboard</h1>

						<div class="row">
							<div class="col-7">
								<div class="card">
									<div class="card-header">
										<h5 class="card-title mb-0">Exam Schedule <span class="badge bg-warning">Not Yet Available</span>.</h5>
									</div>
								</div>
							</div>					
						</div> -->
						<div class="row">
							<div class="col-md-12">
								<div class="card">
									<div class="card-header">
										<h4>Proctoring Selection</h4>
									</div>
									<div class="card-body">
										<form>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label for="dropdown1" class="text-right">Select Period:</label>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<select class="form-control" id="dropdown1" name="option1">
															<option value="none">--Select Period--</option>
															<option value="Prelims">Prelims</option>
															<option value="Midterms">Midterms</option>
															<option value="Pre-Finals">Pre-Finals</option>
															<option value="Finals">Finals</option>
														</select>
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label for="dropdown2" class="text-right">Select Day:</label>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<select class="form-control" id="dropdown2" name="option2">
															<option value="none">--Select Day--</option>
															<option value="1">Day 1</option>
															<option value="2">Day 2</option>
															<option value="3">Day 3</option>
														</select>
													</div>
												</div>
											</div>
										</form>
                                        
										<div class="d-flex justify-content-between">
											
                                            <h4>Selection Left: <span id="selectionCounter"> </span></h4>
											<button type="submit" onclick="handleFormSubmit()" class="btn btn-success" style="width: 150px;">Find Schedule</button>
										</div>
                                        <h4>Exam Date: <span id="examDateHeader"> </span></h4>
                                        <br>
                                        
									</div>
									<div class="card-body">
                                        <div class="table-responsive">
										<table class = "table table-bordered" id = "schedule">
											<thead>
												<tr>
													<th>Time</th>
													<th>Subject</th>
													<th>Rooms</th>
													<th>Section</th>
													<th>Section Number</th>
													<th>Instructor</th>
													<th>Student Count</th>
													<!-- <th>Proctors</th> -->
													<th>Actions</th>
												</tr>
											</thead>
											<tbody id="tableBody">

											</tbody>
										
										</table>
                                        </div>
														
									</div>
                                   	
								</div>
                                <div class="card">
                                    <div class="card-header">
										<h4>Selections</h4>
									</div>
                                    <div class="card-body">
                                    <div class="table-responsive">
                                    <table class = "table table-bordered" id = "schedule">
											<thead>
												<tr>
													<th>Time</th>
													<th>Subject</th>
													<th>Rooms</th>
													<th>Section</th>
													<th>Section Number</th>
													<th>Proctors</th>
													<th>Student Count</th>		
													<th>Actions</th>
												</tr>
											</thead>
											<tbody id="tableBody1">

											</tbody>
									</table>
                                    </div>
                                        <br>
                                        <button type="submit" onclick="reloadTable()" class="btn btn-success" style="width: 150px;">Refresh</button>
                                    </div>
                                    

                                </div> 
							</div>
						</div>
					</div>
				</main>
			</div>
			

<script src="{{asset('import/js/app.js')}}"></script>

</body>
<script>
	
    var period;
    var day;
    // var newSched;
    
    function handleFormSubmit() {	
               
        period = document.getElementById('dropdown1').value;
        day = document.getElementById('dropdown2').value;
        
        if (period == 'none' || day == 'none') {
        alert('Please Select Period and Day');
        
        }
        $('#tableBody').empty();
        $('#tableBody1').empty();
        $('#examDateHeader').empty();
       
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        $.ajax({
            method: 'POST',
            url: '/select-proctor', 
            data: { period: period, day: day },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
        success: function(response) {
            if (response && response.examTimes && response.examTimes.length > 0) {
            console.log('Success');
            } else {
            alert("The Selected Schedule Has Not Been Created yet");
             return;
            }
            // getData(response);
            console.log(response);
            console.log('respnose 2: ',response);
            usersNames = [response.userName];
            subCount = [response.subcount];

            var alterdata =[];
            var alterTime = [];
            let TimeSchedule = [];
            var ExamDates = [];
            // var newSched = [];
            // console.log( 'count',subCount);
        
        
            response.examTimes.forEach(function(examTime) {
                
                var TimeRooms = [];
                var TimeIDs = [];
                var SeCount = [];
                var alterRooms = [];
                var Sections = [];
                var ExamDate = [examTime.exam_day];

                ExamDate.forEach(function(dates) {
                        
                        
                    ExamDates.push([dates.date]);
                    
                });
                    

                examTime.exam_rooms.forEach(function(examRoom) {
                        // console.log('new',examRoom);
                    TimeRooms.push({rooms: examRoom.room_name});
                    TimeIDs.push([examRoom.id]);

                    alterRooms.push([examRoom.id, examRoom.room_name]);
                });
                // console.log('timerooms',TimeRooms);

                
                var alterSec = [];
                var alterCount = [];
                var alterSub = [];
                    examTime.exam_sub.forEach(function (subject) {
                        
                        subject.exam_sectionss.forEach(function (subjectSec) {
                            // if (subjectSec.proctor_name != null) {
                                Sections.push({
                                    secID: subjectSec.id,
                                    Subject_name: subject.subject_name,
                                    Section: subjectSec.section_name,
                                    Code: subjectSec.class_num,
                                    Instructor: subjectSec.Instructor,
                                    StudentCount: subjectSec.class_count,
                                    proctor: subjectSec.proctor_name,
        
                                });
                            // }
                            
                        });
                        
                    });

                    TimeSchedule.push({
                    Time: examTime.exam_time,
                    period: examTime.exam_period_ID,
                    Subjects: Sections,
                    rooms: TimeRooms
                            
                    });
                    alterdata.push({
                        Subject : Sections
                    })
                
                    
                    
                });
            //    console.log('check sec', alterTime);
                
                // console.log('TimeSchedule Data', TimeSchedule);
                
                var alterdatas = [];
                var DataFiltered = [];

                //exam date
                let examDate = ExamDates[0][0];
                    let examDateHeader = document.getElementById('examDateHeader');
                    examDateHeader.textContent += examDate;

            TimeSchedule.forEach((Timeslot) => {
                const combinedData = Timeslot.rooms.map((room, index) => {
                    
                    const instructors = Timeslot.Subjects[index].Instructor.split(', ');
                    // console.log('check instructor:',Timeslot);
                    // console.log(instructors);
                    const hasMatchingInstructor = instructors.some(instructor => usersNames.includes(instructor));
                    
                    if (hasMatchingInstructor) {
                        
                        DataFiltered.push({
                            Room: room.rooms,
                            SecId: Timeslot.Subjects[index].secID,
                            Subject_name: Timeslot.Subjects[index].Subject_name,
                            Sections: Timeslot.Subjects[index].Section,
                            Code: Timeslot.Subjects[index].Code,
                            Instructor: Timeslot.Subjects[index].Instructor,
                            StudentCount: Timeslot.Subjects[index].StudentCount,
                            proctor: Timeslot.Subjects[index].proctor,
                        });
                    

                        return null; // Return null for entries with matching instructors
                    }

                    return {
                        Room: room.rooms,
                        SecId: Timeslot.Subjects[index].secID,
                        Subject_name: Timeslot.Subjects[index].Subject_name,
                        Sections: Timeslot.Subjects[index].Section,
                        Code: Timeslot.Subjects[index].Code,
                        Instructor: Timeslot.Subjects[index].Instructor,
                        StudentCount: Timeslot.Subjects[index].StudentCount,
                        proctor: Timeslot.Subjects[index].proctor,
                    };
                });
        

                alterdatas.push({
                    Time: Timeslot.Time,
                    period: Timeslot.period,
                    Data: combinedData.filter(entry => entry !== null),
                });
                
            });
            console.log('alter data:', alterdatas);

            //subject filteration
            alterdatas.forEach((timeSlot) => {
                timeSlot.Data = timeSlot.Data.filter((entry) =>
                    !DataFiltered.some((filteredEntry) => filteredEntry.Subject_name === entry.Subject_name)
                );
                
            });
            //clone alter data
            newSched = JSON.parse(JSON.stringify(alterdatas));
            // console.log('first new sched:', newSched)



            const proctorData = alterdatas.flatMap(timeSlot => timeSlot.Data)
                .filter(entry => entry.proctor !== null); 
                
            const proctorSecIds = proctorData.map(entry => entry.SecId);
            alterdatas.forEach((timeSlot) => {
                timeSlot.Data = timeSlot.Data.filter((entry) =>
                    !proctorSecIds.includes(entry.SecId)
                );
            });
             
            

            // console.log('Filtered Data (Excluding Proctors and Specific SecIds):', alterdatas);
            // console.log('Combined Data:', alterdatas);

                
                //selection turn
                const subjectNames = DataFiltered.map(entry => entry.Subject_name);
                // const uniqueSubjectNames = [...new Set(subjectNames)];
                console.log('check subname',subjectNames);
                var SelectionLeft = parseInt(subCount[0], 10);

                console.log('SelectionLeft to subcount:', SelectionLeft);
                // console.log('check cnost:',SelectionLeft);
                
                // console.log('alterdata: ', alterdatas);
               

                const tableBody = document.getElementById('tableBody');
                let uniqueTimeSlots = [];
                

                alterdatas.forEach((timeSlots) => {
                    timeSlots.Data.forEach((subject, index) => {
                        const row = document.createElement('tr');

                        if (index === 0) {
                            const timeCell = document.createElement('td');
                            if (!uniqueTimeSlots.includes(timeSlots.Time)) {
                                timeCell.rowSpan = timeSlots.Data.length;
                                timeCell.textContent = timeSlots.Time;
                                uniqueTimeSlots.push(timeSlots.Time);
                            }
                            row.appendChild(timeCell);
                        }

                        // Subject
                        const subjectCell = document.createElement('td');
                        subjectCell.textContent = subject.Subject_name;
                        row.appendChild(subjectCell);

                        // Room
                        const roomCell = document.createElement('td');
                        roomCell.textContent = subject.Room;
                        row.appendChild(roomCell);

                        // Section
                        const sectionCell = document.createElement('td');
                        sectionCell.textContent = subject.Sections||subject.SecId;
                        row.appendChild(sectionCell);

                        // Section Number
                        const sectionNumberCell = document.createElement('td');
                        sectionNumberCell.textContent = subject.Code;
                        row.appendChild(sectionNumberCell);

                        // Instructor
                        const instructorCell = document.createElement('td');
                        instructorCell.textContent = subject.Instructor;
                        row.appendChild(instructorCell);

                        // Class Count
                        const classCountCell = document.createElement('td');
                        classCountCell.textContent = subject.StudentCount;
                        row.appendChild(classCountCell);

                        // Edit Button
                        const editCell = document.createElement('td');
                        const editButton = document.createElement('button');
                        editButton.textContent = 'Select';
                        editButton.addEventListener('click', () => handleEditClick(subject.SecId, SelectionLeft, editButton, usersNames, timeSlots.Time));
                        editCell.appendChild(editButton);
                        row.appendChild(editCell);
                        

                        tableBody.appendChild(row);
                    });
                    
                });
                

                const proctorData1 = newSched.flatMap(timeSlot => timeSlot.Data)
                    .filter(entry => entry.proctor !== null); 
                    // console.log('proctorDAta1', proctorData1);
                    
                const proctorSecIds1 = proctorData.map(entry => entry.SecId);
                newSched.forEach((timeSlot) => {
                    timeSlot.Data = timeSlot.Data.filter((entry) =>
                    proctorSecIds.includes(entry.SecId)
                    );
                
                    // Console.log('proctorDAta1', proctorData1);
                });
            
            console.log('new sched:', newSched)
            const tableBody1 = document.getElementById('tableBody1');
                let uniqueTimeSlots1 = [];
                
                // console.log('period', period);
                newSched.forEach((timeSlots) => {
                    timeSlots.Data.forEach((subject, index) => {
                        const row = document.createElement('tr');

                        if (index === 0) {
                            const timeCell = document.createElement('td');
                            if (!uniqueTimeSlots1.includes(timeSlots.Time)) {
                                timeCell.rowSpan = timeSlots.Data.length;
                                timeCell.textContent = timeSlots.Time;
                                uniqueTimeSlots.push(timeSlots.Time);
                            }
                            row.appendChild(timeCell);
                        }

                        // Subject
                        const subjectCell = document.createElement('td');
                        subjectCell.textContent = subject.Subject_name;
                        row.appendChild(subjectCell);

                        // Room
                        const roomCell = document.createElement('td');
                        roomCell.textContent = subject.Room;
                        row.appendChild(roomCell);

                        // Section
                        const sectionCell = document.createElement('td');
                        sectionCell.textContent = subject.Sections||subject.SecId;
                        row.appendChild(sectionCell);

                        // Section Number
                        const sectionNumberCell = document.createElement('td');
                        sectionNumberCell.textContent = subject.Code;
                        row.appendChild(sectionNumberCell);

                        // Instructor
                        const instructorCell = document.createElement('td');
                        instructorCell.textContent = subject.proctor;
                        row.appendChild(instructorCell);

                        // Class Count
                        const classCountCell = document.createElement('td');
                        classCountCell.textContent = subject.StudentCount;
                        row.appendChild(classCountCell);

                        // Edit Button
                        const editCell = document.createElement('td');
                        const editButton = document.createElement('button');
                        editButton.textContent = 'Deselect';
                        editButton.addEventListener('click', () => handleDeselectClick(subject.SecId,SelectionLeft,usersNames));
                        editCell.appendChild(editButton);
                        row.appendChild(editCell);
                        
                        tableBody1.appendChild(row);
                        
                    });
                });
            },
        error: function(error) {
            console.error(error);
        }
        });           
    }
    
   
    var editClickCounter = 0;
    // var editClickCounternega = ;
 

    
    
   // Assume you have a variable to store selected times
const selectedTimes = [];

function handleEditClick(secID, selectionLeft, button, usersNames, time) {
    // Check if the selected time has been previously selected
    if (selectedTimes.includes(time)) {
        // Alert the user and prevent further actions
        window.alert("You can't select the subjects with same time your schedule will be conflict.");
        return;
    }

    if (confirm("Are you sure you want to select this?")) {
        if (selectionLeft !== editClickCounter) {
            button.classList.add('selected');
            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            selectionLeft--;

            document.getElementById('selectionCounter').innerText = selectionLeft;
            $.ajax({
                method: 'POST',
                url: '/exam-sections/update',
                data: { secID: secID, userName: usersNames, selectSub: selectionLeft },
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function (response) {
                    window.alert('Updated Successfully');
                },
                error: function (error) {
                    console.error(error);
                }
            });

            // Update the selectedTimes array
            selectedTimes.push(time);
        } else {
            window.alert("You Have Reached The Maximum Selection");
        }
    } else {
        window.alert("You Have Reached The Maximum Selection");
    }

    reloadTable();
}

    function handleDeselectClick(secID,selectionLeft, usersNames) {
        console.log('newsched', newSched)
        
        if (confirm("Are you sure you want to deselect?")) {
            selectionLeft++;
            
            document.getElementById('selectionCounter').innerText = selectionLeft;

            
            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            // console.log('sec', secID, usersNames);

            $.ajax({
                method: 'POST',
                url: '/exam-sections/deselect',
                data: { secID: secID, userName: usersNames,subcount: selectionLeft},
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function (response) {
                    window.alert('Updated Successfully');
                    // location.reload();
                },
                error: function (error) {
                    console.error(error);
                }
            });

            // editClickCounter++;
            // selectionLeft--;
            // console.log('check 1',editClickCounter);
            // console.log('check 2',selectionLeft);
           
        } else {
           
        }
        reloadTable();
    }
    // var period;
    // var day;
    
//    Function to reload table data
    function reloadTable() {
        handleFormSubmit();
    }

    //for realtime fetching
    // var pollingInterval = 5000000; 
    // setInterval(handleFormSubmit, pollingInterval);






</script>


@endsection

