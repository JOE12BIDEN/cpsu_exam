<?php
session_start();
// Check if the clearDisabled action is triggered
if (isset($_GET['clearDisabled']) && $_GET['clearDisabled'] === 'true') {
    // Clear all disabled states in the session
    foreach ($_SESSION as $key => $value) {
        if (strpos($key, '_disabled') !== false) {
            unset($_SESSION[$key]);
        }
    }
}
$mysqli = new mysqli('localhost', 'root', '', 'exam');

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
if (isset($_POST['submit'])) {
    $courseId=$_POST['course'];
    $proctor = isset($_POST['proctor']) ? $_POST['proctor']:'';
    $subjectId=$_POST['subject'];
    $yearId = $_POST['year'];
    $sectionId = $_POST['section'];
    // Check if 'room' and 'time' keys exist in the $_POST array
    $room = isset($_POST['room']) ? $_POST['room'] : '';
    $time = isset($_POST['time']) ? $_POST['time'] : '';

    $date = $_POST['date'];
    
       $sql = "INSERT INTO exam_sched (course, proctor, subject, year, room, section, time, date) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

       if ($stmt = $mysqli->prepare($sql)) {
           $stmt->bind_param("ssssssss", $course, $proctor, $subject, $year, $room, $section, $time, $date);
           
// Fetch course from their respective table
 $courseQuery = "SELECT course FROM course WHERE id = ?"; 
 $courseStmt = $mysqli->prepare($courseQuery);
 $courseStmt->bind_param("s", $courseId); 
 $courseStmt->execute();
 $courseStmt->bind_result($course); 
 $courseStmt->fetch(); 
 $courseStmt->close(); 
   // Fetch year from their respective table
   $yearQuery = "SELECT year FROM year WHERE id = ?"; 
   $yearStmt = $mysqli->prepare($yearQuery);
   $yearStmt->bind_param("s", $yearId);
   $yearStmt->execute(); 
   $yearStmt->bind_result($year);
   $yearStmt->fetch();
   $yearStmt->close();
       // Fetch section from their respective table.
        $sectionQuery = "SELECT section FROM section WHERE id = ?";
        $sectionStmt = $mysqli->prepare($sectionQuery); $sectionStmt->bind_param("s", $sectionId);
        $sectionStmt->execute();
        $sectionStmt->bind_result($section); 
        $sectionStmt->fetch(); 
        $sectionStmt->close(); 
           // Fetch subject code from their respective table.
           $subjectQuery = "SELECT subject_code FROM subject WHERE id = ?";
           $subjectStmt = $mysqli->prepare($subjectQuery); $subjectStmt->bind_param("s", $subjectId);
           $subjectStmt->execute();
           $subjectStmt->bind_result($subject); 
           $subjectStmt->fetch();
           $subjectStmt->close(); 

           if ($stmt->execute()) {
                // Insert successful
                                // Disable selected radio buttons
            if (!empty($room)) {
                $_SESSION[$room . '_disabled'] = 'disabled';
            }

            
            if (!empty($time)) {
                $_SESSION[$time . '_disabled'] = 'disabled';
            }
            
            
            header('Location: /login/codetopdf/timetable.php');
             exit();
           } else {
               // Insert failed
               // Handle the error or display an error message
           }
           $stmt->close();
       } else {
           // Handle the error or display an error message
       }
   }
   $mysqli->close();
   ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Title</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="icon" type="image/jpg" href="https://www.negros-occ.gov.ph/wp-content/uploads/2019/12/CPSU-LOGO.jpg">

    <link rel="stylesheet" href="style.css">
</head>
<nav class="navbar navbar-expand-lg navbar-light bg
<body>-light">
<a class="navbar-brand" href="home.php">
<img src="https://www.negros-occ.gov.ph/wp-content/uploads/2019/12/CPSU-LOGO.jpg" width="30" height="30" class="d-inline-block align-top" alt="CPSU Logo">
CPSU EXAM SCHEDULING</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="/login/exam1/about_us.php"style="color: green;">About</a>
            </li>
            <li class="nav-item">
            </li>
                <a class="nav-link" href="services.php"style="color: blue;">Services</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="\login\logout.php" style="color: red;">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="red" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>Logout
            </a>
            </li>
        </ul>
    </div>
</nav>
<div class="container mt-5">
    <div class="row">
        <div class="col-md-3">
            <form method="post">
                <select name="course" class="form-control" id="course">
                    <option>COURSE</option>
                </select>
            </div>
            <div class="col-md-2">
                <select name="year" class="form-control" id="year">
                    <option>YEAR</option>
                </select>
            </div>
            <div class="col-md-2">
                <select name="section" class="form-control" id="section">
                    <option>SECTION</option>
                </select>
            </div>
            <div class="col-md-2">
                <select name="subject" class="form-control" id="subject">
                    <option>SUBJECT</option>
                </select>
            </div>  
            <div class="col-md-2">
                <select name="proctor" class="form-control" id="proctor">
                    <option>PROCTOR</option>
                    <option value="SIR EMIL">SIR EMIL</option>
                </select>
            </div>
        </div>
        <div class="row mt-4">
    <div class="col-md-4">
        <h2>Rooms:</h2>
        <div class="custom-control custom-radio">
            <input type="radio" name="room" class="custom-control-input" id="room1" value="ROOM 1">
            <label class="custom-control-label" for="room1">Room 1</label>
        </div>
        <div class="custom-control custom-radio">
            <input type="radio" name="room" class="custom-control-input" id="room2" value="ROOM 2">
            <label class="custom-control-label" for="room2">Room 2</label>
        </div>
        <div class="custom-control custom-radio">
            <input type="radio" name="room" class="custom-control-input" id="room3" value="ROOM 3">
            <label class="custom-control-label" for= "room3">Room 3</label>
        </div>
        <div class="custom-control custom-radio">
            <input type="radio" name="room" class="custom-control-input" id="room4" value="ROOM 4">
            <label class="custom-control-label" for="room4">Room 4</label>
        </div>
        <div class="custom-control custom-radio">
            <input type="radio" name="room" class="custom-control-input" id="room5" value="ROOM 5">
            <label class="custom-control-label" for="room5">Room 5</label>
        </div>
        <div class="custom-control custom-radio">
            <input type="radio" name="room" class="custom-control-input" id="lab1" value="LAB 1">
            <label class="custom-control-label" for="lab1">Lab 1</label>
        </div>
        <div class="custom-control custom-radio">
            <input type="radio" name="room" class="custom-control-input" id="lab2" value="LAB 2">
            <label class="custom-control-label" for="lab2">Lab 2</label>
        </div>
        <div class="custom-control custom-radio">
            <input type="radio" name="room" class="custom-control-input" id="lab3" value="LAB 3">
            <label class="custom-control-label" for="lab3">Lab 3</label>
        </div>
    </div> 
    <span class="expand-collapse" onclick="toggleCheckbox('roomCheckbox')">+</span>
<div id="roomCheckbox" style="display: none;">
    <div class="custom-control custom-checkbox">
        <input type="checkbox" name="roomCheckbox" id="roomCheckboxRoom1" class="custom-control-input">
        <label class="custom-control-label" for="roomCheckboxRoom1">Room 1</label>
    </div>
    <div class="custom-control custom-checkbox">
        <input type="checkbox" name="roomCheckbox" id="roomCheckboxRoom2" class="custom-control-input">
        <label class="custom-control-label" for="roomCheckboxRoom2">Room 2</label>
    </div>
    <div class="custom-control custom-checkbox">
        <input type="checkbox" name="roomCheckbox" id="roomCheckboxRoom3" class="custom-control-input">
        <label class="custom-control-label" for="roomCheckboxRoom3">Room 3</label>
    </div>
    <div class="custom-control custom-checkbox">
        <input type="checkbox" name="roomCheckbox" id="roomCheckboxRoom4" class="custom-control-input">
        <label class="custom-control-label" for="roomCheckboxRoom4">Room 4</label>
    </div>
    <div class="custom-control custom-checkbox">
        <input type="checkbox" name="roomCheckbox" id="roomCheckboxRoom5" class="custom-control-input">
        <label class="custom-control-label" for="roomCheckboxRoom5">Room 5</label>
    </div>
    <div class="custom-control custom-checkbox">
        <input type="checkbox" name="roomCheckbox" id="roomCheckboxLab1" class="custom-control-input">
        <label class="custom-control-label" for="roomCheckboxLab1">Lab 1</label>
    </div>
    <div class="custom-control custom-checkbox">
        <input type="checkbox" name="roomCheckbox" id="roomCheckboxLab2" class="custom-control-input">
        <label class="custom-control-label" for="roomCheckboxLab2">Lab 2</label>
    </div>
    <div class="custom-control custom-checkbox">
        <input type="checkbox" name="roomCheckbox" id="roomCheckboxLab3" class="custom-control-input">
        <label class="custom-control-label" for="roomCheckboxLab3">Lab 3</label>
    </div>
</div>
            <div class="col-md-4">
                <h2>Time:</h2>
                <div class="custom-control custom-radio">
                    <input type="radio" name="time" class="custom-control-input" id="time1" value="8:00AM-9:30AM">
                    <label class="custom-control-label" for="time1">8:00AM-9:30AM</label> 
                </div>
                <div class="custom-control custom-radio">
                    <input type="radio" name="time" class="custom-control-input" id="time2" value="9:30AM-11:00AM">
                    <label class="custom-control-label" for="time2">9:30AM-11:00AM</label>
                </div>
                <div class="custom-control custom-radio">
                    <input type="radio" name="time" class="custom-control-input" id="time3" value="1:00PM-2:30PM">
                    <label class="custom-control-label" for="time3">1:00PM-2:30PM</label>
                    </div>
                <div class="custom-control custom-radio">
                    <input type="radio" name="time" class="custom-control-input" id="time4" value="2:30PM-4:00PM">
                    <label class="custom-control-label" for="time4">2:30PM-4: 00PM</label>
                </div>
            </div>
            <div class="col-md-4">
                <h2>DATE:</h2>
                <input type="date" name="date" class="form-control">
            </div>
        <div class="col-12 mt-4 text-right">
        <button type="submit" name="submit" class="btn btn-success btn-lg" onclick="handleSubmit()">SUBMIT</button>
        </div>
        <div class="col-12 mt-4 text-right">
        <a href="?clearDisabled=true" class="btn btn-danger btn-lg" onclick="clearDisabledStates()">Clear Disabled States</a>
    </div>
</form>
<!--Javascript Libraries-->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<!--Custom Libraries-->
<script src="main.js"></script>
<script src="clear.js"></script>
<script src="plus.js"></script>
<script src="roomdisabled.js"></script>
    <script>
// Function to update section dropdown dynamically
function updateSectionDropdown(courseValue) {
    // Assuming you have an endpoint to fetch sections based on the selected course
    $.get('getSections.php', { course: courseValue }, function (data) {
        $('#sectionDropdown').empty();
        $.each(data.sections, function (index, section) {
            $('#sectionDropdown').append('<option value="' + section + '">' + section + '</option>');
        });

        // After updating the sections, update radio button states
        updateRadioStates($('#sectionDropdown').val());
    });
}

// Function to update radio button states based on successful submissions
function updateRadioStates(currentSection) {
    // Enable all time radio buttons
    $('input[name="time"]').attr('disabled', false);

    // Disable based on SessionStorage
    $('input[name="time"]').each(function () {
        var time = $(this).val();
        if (localStorage.getItem(currentSection + '_' + time + '_disabled') === 'disabled') {
            $(this).attr('disabled', true);
        }
    });
}

// Function to handle form submission
function handleSubmit() {
    var currentSection = $('#sectionDropdown').val();
    var selectedTime = $('input[name="time"]:checked').val();

    if (selectedTime) {
        localStorage.setItem(currentSection + '_' + selectedTime + '_disabled', 'disabled');

        // Assuming you have an endpoint to handle the server-side logic
        $.post('submitHandler.php', { section: currentSection, time: selectedTime }, function (data) {
            // Function to handle form submission
function handleSubmit() {
    var currentSection = $('#sectionDropdown').val();
    var selectedTime = $('input[name="time"]:checked').val();

    if (selectedTime) {
        localStorage.setItem(currentSection + '_' + selectedTime + '_disabled', 'disabled');

        // Assuming you have an endpoint to handle the server-side logic
        $.post('submitHandler.php', { section: currentSection, time: selectedTime }, function (data) {
            // Handle the response from the server here
            if (data.success) {
                // If the submission was successful, you can perform actions or show messages
                console.log('Submission successful!');
            } else {
                // Handle other scenarios or errors
                console.error('Submission failed.');
            }

            // After a successful or unsuccessful submission, update radio button states
            updateRadioStates(currentSection);
        }).fail(function () {
            // Handle AJAX failure here
            console.error('Error in AJAX request.');
        });
    }
}


            // After a successful submission, update radio button states
            updateRadioStates(currentSection);
        });
    }
}

// Update section dropdown and radio button states when the document is ready
$(document).ready(function () {
    $('#course').change(function () {
        // Update section dropdown when course changes
        updateSectionDropdown($(this).val());
    });

    $('#sectionDropdown').change(function () {
        // Update radio button states when section changes
        updateRadioStates($(this).val());
    });
});

</script>
</body>
</html>
