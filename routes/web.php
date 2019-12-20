<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//\Debugbar::enable();

Route::get('/', function () {
    return view('welcome');
});
Auth::routes(['login' => false]);


//Route::get('all-exams-grade/details/{class_id}', 'GradeController@allExamsGradeDetails');

Route::middleware(['auth'])->group(function () {

    if (config('app.env') != 'production') {
        Route::get('user/config/impersonate', 'UserController@impersonateGet');
        Route::post('user/config/impersonate', 'UserController@impersonate');
    }

    Route::get('users/{school_code}/{student_code}/{teacher_code}', 'UserController@index')->name('all.student');
    Route::get('user/{user_code}', 'UserController@show')->name('user.show');
    Route::get('user/edit-information/{id}', 'UserController@editUserInfo')->name('edit-information');
    Route::patch('user/edit-information/{id}', 'UserController@updateUserInfo')->name('update-user-info');
    Route::patch('user/update-staff-information/{id}', 'UserController@updateStaffInformation')->name('update-staff-information');
    Route::get('user/config/change_password', 'UserController@changePasswordGet');
    Route::post('user/config/change_password', 'UserController@changePasswordPost');

    Route::get('user/rfid/{student_code}', 'UserController@rfidCreate')->name('rfid.create');
    Route::post('user/rfid/{student_code}', 'UserController@rfidStore')->name('rfid.store');
    // Route::get('user/rfid/{student_code}', 'UserController@rfidCreate')->name('rfid.edit');
    // Route::get('user/rfid/{student_code}', 'UserController@rfidCreate')->name('rfid.update');

    // Master role routes
    Route::group(['prefix' => 'master', 'middleware' => 'master'], function () {
        Route::get('/home', 'MasterHomeController@index')->name('master.home');
        Route::get('register/admin/{id}', 'AdminController@create');
        Route::post('register/admin', 'AdminController@store');
        Route::get('activate-admin/{id}', 'AdminController@destroy');
        Route::delete('delete-admin/{id}', 'AdminController@delete')->name('delete-admin');
        Route::post('create-school', 'SchoolController@store');
        Route::get('school/admin-list/{school_id}', 'SchoolController@show');
        Route::get('school/{school_id}', 'SchoolController@showSchool')->name('school-details');
        Route::get('school/delete/{school_id}', 'SchoolController@destroy');
        Route::get('school/edit/{school_id}', 'SchoolController@edit');
        Route::post('school/edit/{school_id}', 'SchoolController@update');
        Route::get('new/create-school', 'SchoolController@create');
        Route::get('edit/admin/{id}', 'AdminController@edit');
        Route::post('edit/admin', 'AdminController@update');
        Route::get('new/all-school', 'MasterHomeController@allSchool');
    });

    //Student role routes
    Route::group(['prefix' => 'student', 'middleware' => 'student'], function () {
        Route::get('/home', 'StudentHomeController@index')->name('student.home');
        Route::get('attendances/{section_id}/{student_id}/{exam_id}', 'AttendanceController@index');
        Route::get('courses/{teacher_id}/{section_id}', 'CourseController@index');
        Route::get('grades/{student_id}', 'GradeController@index');
        Route::get('notices-and-events', 'NoticeController@index');
        Route::get('user/notifications/{id}', 'NotificationController@index');
    });

    //Librarian role routes
    Route::group(['prefix' => 'librarian', 'middleware' => 'librarian'], function () {
        Route::get('/home', 'LibrarianHomeController@index')->name('librarian.home');
        Route::get('attendance/{teacher_id}', 'StuffAttendanceController@details');
        Route::get('issue-books', 'IssuedbookController@create');
        Route::get('issue-books/autocomplete/{query}', 'IssuedbookController@autocomplete');
        Route::post('issue-books', 'IssuedbookController@store');
        Route::get('issued-books', 'IssuedbookController@index');
        Route::post('save_as_returned', 'IssuedbookController@update');
        Route::get('all-books', 'Library\BookController@index');
        Route::delete('/books/{id}', 'Library\BookController@destroy');
        Route::get('book/{id}', 'Library\BookController@show');
        Route::get('create/book', 'Library\BookController@create');
        Route::post('book/store', 'Library\BookController@store');
        Route::get('users/{school_code}/{role}', 'UserController@indexOther');
        Route::get('courses/{teacher_id}/{section_id}', 'CourseController@index');
        Route::get('edit-book-details/{id}', 'Library\BookController@edit')->name('edit-book-details');
        Route::patch('update-book-details/{id}', 'Library\BookController@update')->name('update-book-details');

    });

    //Accountant role routes
    Route::group(['prefix' => 'accountant', 'middleware' => 'accountant'], function () {
        Route::get('/home', 'AccountantHomeController@index')->name('accountant.home');
        Route::get('section/students/{section_id}', 'UserController@sectionStudents');
        Route::prefix('fees')->group(function () {
            Route::get('all', 'FeeController@index');
            Route::get('create', 'FeeController@create');
            Route::post('create', 'FeeController@store');
            Route::delete('remove/{id}', 'FeeController@destroy');
        });

        Route::resource('fee-types', 'FeeTypesController');
        Route::resource('fee-discount', 'FeeDiscountController');
        Route::get('fee-master/class-fee', 'FeeMasterController@classFee')->name('class.fee');
        Route::resource('fee-master', 'FeeMasterController');
        Route::resource('fee-transaction', 'FeeTransactionController');
        Route::get('fee-collection/section/student', 'FeeTransactionController@sectionsStudent')->name('accountant.all-student');
        Route::get('fee-collection/get-fee/{id}', 'FeeTransactionController@collectFee')->name('student.fee');
        Route::get('fee-collection/multiple-fee/{id}', 'FeeTransactionController@multipleFee')->name('multiple.fee');
        Route::post('multiple-fee', 'FeeTransactionController@multipleFeeStore')->name('multiple.fee.store');

        Route::get('attendance/{teacher_id}', 'StuffAttendanceController@details');
        Route::get('grades/{student_id}', 'GradeController@index');
        Route::get('users/{school_code}/{role}', 'UserController@indexOther');
        Route::get('sectors', 'AccountController@sectors');
        Route::post('create-sector', 'AccountController@storeSector');
        Route::get('edit-sector/{id}', 'AccountController@editSector');
        Route::post('update-sector', 'AccountController@updateSector');
        Route::delete('delete-sector/{id}', 'AccountController@deleteSector');

        Route::get('income', 'AccountController@income');
        Route::post('create-income', 'AccountController@storeIncome');
        Route::get('income-list', 'AccountController@listIncome');
        Route::post('list-income', 'AccountController@postIncome');
        Route::get('edit-income/{id}', 'AccountController@editIncome');
        Route::post('update-income', 'AccountController@updateIncome');
        Route::get('delete-income/{id}', 'AccountController@deleteIncome');

        Route::get('expense', 'AccountController@expense');
        Route::post('create-expense', 'AccountController@storeExpense');
        Route::get('expense-list', 'AccountController@listExpense');
        Route::post('list-expense', 'AccountController@postExpense');
        Route::get('edit-expense/{id}', 'AccountController@editExpense');
        Route::post('update-expense', 'AccountController@updateExpense');
        Route::get('delete-expense/{id}', 'AccountController@deleteExpense');
        Route::get('courses/{teacher_id}/{section_id}', 'CourseController@index');
    });

    // Teacher role routes
    Route::group(['prefix' => 'teacher', 'middleware' => 'teacher'], function () {
        Route::get('/home', 'TeacherHomeController@index')->name('teacher.home');
        Route::get('courses/{teacher_id}/{section_id}', 'CourseController@index');
        Route::get('attendance/{teacher_id}', 'StuffAttendanceController@details');

        Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
        Route::get('attendances/students/{teacher_id}/{course_id}/{exam_id}/{section_id}', 'AttendanceController@addStudentsToCourseBeforeAtt');
        Route::get('attendances/{section_id}/{student_id}/{exam_id}', 'AttendanceController@index');
        Route::get('attendances/{section_id}', 'AttendanceController@sectionIndex');
        Route::post('attendance/take-attendance', 'AttendanceController@store');
        Route::get('attendance/adjust/{student_id}', 'AttendanceController@adjust');
        Route::post('attendance/adjust', 'AttendanceController@adjustPost');
        Route::get('grades/{student_id}', 'GradeController@index');
        Route::get('section/students/{section_id}', 'UserController@sectionStudents');
        Route::get('course/students/{teacher_id}/{course_id}/{exam_id}/{section_id}', 'CourseController@course');
        Route::post('courses/create', 'CourseController@create');
        // Route::post('courses/save-under-exam', 'CourseController@update');
        Route::post('courses/save-configuration', 'CourseController@saveConfiguration');
        Route::get('grades/t/{teacher_id}/{course_id}/{exam_id}/{section_id}', 'GradeController@tindex')->name('teacher-grade');
        Route::get('grades/c/{teacher_id}/{course_id}/{exam_id}/{section_id}', 'GradeController@cindex');
        Route::get('grades/calculate-marks', 'GradeController@calculateMarks');
        Route::post('grades/save-grade', 'GradeController@update');
        Route::get('grades/{student_id}', 'GradeController@index');
        Route::post('message/students', 'NotificationController@store');
    });

    // Admin role routes
    Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
        Route::get('/home', 'HomeController@index')->name('admin.home');
        Route::get('find-user/{query}', 'AdminController@findUser')->name('admin.search');
        Route::get('search-user/', 'AdminController@index')->name('admin.search-user');
        Route::get('search-result/{id}', 'AdminController@search')->name('admin.search.result');

        Route::get('gpa/create-gpa', 'GradesystemController@create');
        Route::post('store-grade-system', 'GradesystemController@store');
        Route::post('store-gpa-info', 'GradesystemController@storeGradeInfo');
        Route::post('update-gpa/{id}', 'GradesystemController@update');
        Route::get('gpa/edit/{id}', 'GradesystemController@edit');
        Route::get('gpa/all-gpa', 'GradesystemController@index');
        Route::DELETE('gpa/delete/{id}', 'GradesystemController@delete');
        Route::get('all-department', 'SchoolController@allDepartment');
        Route::get('attendances/students/{teacher_id}/{course_id}/{exam_id}/{section_id}', 'AttendanceController@addStudentsToCourseBeforeAtt');

        Route::prefix('staff')->group(function () {
            Route::get('teacher-attendance', 'StuffAttendanceController@index');
            Route::post('teacher-attendance/store', 'StuffAttendanceController@store');
            Route::get('teacher-attendance/adjust/{teacher_id}', 'StuffAttendanceController@adjustMissingAttendance');
            Route::post('teacher-attendance/adjust/post', 'StuffAttendanceController@adjustMissingAttendancePost');
            Route::get('attendance/{teacher_id}', 'StuffAttendanceController@details');

            Route::get('attendance', 'StuffAttendanceController@stuffAttendance');
            Route::post('attendance/store', 'StuffAttendanceController@stuffAttendanceStore');
            Route::get('attendance/adjust/{staff_id}', 'StuffAttendanceController@adjustStaffMissingAttendance');
            Route::post('attendance/adjust/post', 'StuffAttendanceController@adjustStaffMissingAttendancePost');
        });

        Route::get('department-teachers/{id}', 'SchoolController@departmentTeachers');
        Route::get('department-students/{id}', 'SchoolController@departmentStudents');
        Route::get('section/students/{section_id}', 'UserController@sectionStudents');
        Route::prefix('exams')->group(function () {
            Route::get('/', 'ExamController@index');
            Route::get('/details/{exam_id}', 'ExamController@details');
            Route::get('create', 'ExamController@create');
            Route::post('create', 'ExamController@store');
            Route::post('activate-exam', 'ExamController@update');
            Route::get('remove/{id}', 'ExamController@destroy');
            Route::get('edit/{id}', 'ExamController@edit');
            Route::post('edit/{id}', 'ExamController@updateExam');
            Route::get('active', 'ExamController@indexActive');
        });

        Route::prefix('inactive')->group(function () {
            Route::get('/notices', 'InactiveSettingsController@notices');
            Route::get('/events', 'InactiveSettingsController@events');
            Route::get('/syllabuses', 'InactiveSettingsController@syllabuses');
            Route::get('/routines', 'InactiveSettingsController@routines');
            Route::get('/students', 'InactiveSettingsController@students');
            Route::get('/teachers', 'InactiveSettingsController@teachers');
            Route::get('/librarians', 'InactiveSettingsController@librarians');
            Route::get('/accountants', 'InactiveSettingsController@accountants');
        });

        //Accountant Routes
        Route::prefix('fees')->group(function () {
            Route::get('all', 'FeeController@index');
            Route::get('create', 'FeeController@create');
            Route::post('create', 'FeeController@store');
            Route::delete('remove/{id}', 'FeeController@destroy');
        });
        Route::get('sectors', 'AccountController@sectors');
        Route::post('create-sector', 'AccountController@storeSector');
        Route::get('edit-sector/{id}', 'AccountController@editSector');
        Route::post('update-sector', 'AccountController@updateSector');
        Route::delete('delete-sector/{id}', 'AccountController@deleteSector');

        Route::get('income', 'AccountController@income');
        Route::post('create-income', 'AccountController@storeIncome');
        Route::get('income-list', 'AccountController@listIncome');
        Route::post('list-income', 'AccountController@postIncome');
        Route::get('edit-income/{id}', 'AccountController@editIncome');
        Route::post('update-income', 'AccountController@updateIncome');
        Route::get('delete-income/{id}', 'AccountController@deleteIncome');

        Route::get('expense', 'AccountController@expense');
        Route::post('create-expense', 'AccountController@storeExpense');
        Route::get('expense-list', 'AccountController@listExpense');
        Route::post('list-expense', 'AccountController@postExpense');
        Route::get('edit-expense/{id}', 'AccountController@editExpense');
        Route::post('update-expense', 'AccountController@updateExpense');
        Route::get('delete-expense/{id}', 'AccountController@deleteExpense');

        Route::resource('fee-types', 'FeeTypesController');
        Route::resource('fee-discount', 'FeeDiscountController');
        Route::get('fee-master/class-fee', 'FeeMasterController@classFee')->name('class.fee');
        Route::resource('fee-master', 'FeeMasterController');
        Route::resource('fee-transaction', 'FeeTransactionController');
        Route::get('fee-collection/section/student', 'FeeTransactionController@sectionsStudent')->name('accountant.all-student');
        Route::get('fee-collection/get-fee/{id}', 'FeeTransactionController@collectFee')->name('student.fee');
        Route::get('fee-collection/multiple-fee/{id}', 'FeeTransactionController@multipleFee')->name('multiple.fee');
        Route::post('multiple-fee', 'FeeTransactionController@multipleFeeStore')->name('multiple.fee.store');
        //Accountant Routes End

        //Librarian Route
        Route::get('issue-books', 'IssuedbookController@create');
        Route::get('issue-books/autocomplete/{query}', 'IssuedbookController@autocomplete');
        Route::post('issue-books', 'IssuedbookController@store');
        Route::get('issued-books', 'IssuedbookController@index');
        Route::post('save_as_returned', 'IssuedbookController@update');
        Route::get('all-books', 'Library\BookController@index');
        Route::delete('/books/{id}', 'Library\BookController@destroy');
        Route::get('book/{id}', 'Library\BookController@show');
        Route::get('edit-book-details/{id}', 'Library\BookController@edit')->name('edit-book-details');
        Route::patch('update-book-details/{id}', 'Library\BookController@update')->name('update-book-details');
        Route::get('create/book', 'Library\BookController@create');
        Route::post('book/store', 'Library\BookController@store');
        //Librarian Route End

        Route::prefix('academic')->group(function () {
            Route::get('upload-syllabus', 'SyllabusController@upload')->name('upload-syllabus');
            Route::post('upload-syllabus', 'SyllabusController@storeSyllabus')->name('store-syllabus');
            Route::get('syllabus', 'SyllabusController@index')->name('academic-syllabus');
            Route::get('syllabus/{class_id}', 'SyllabusController@create');
            Route::get('notice', 'NoticeController@create');
            Route::get('event', 'EventController@create');
            Route::get('routine', 'RoutineController@index')->name('academic-routines');
            Route::get('notice/update/{id}', 'NoticeController@update');
            Route::get('syllabus/update/{id}', 'SyllabusController@update');
            Route::get('routine/{section_id}', 'RoutineController@create');
            Route::get('routine/update/{id}', 'RoutineController@update');
            Route::get('upload-routine', 'RoutineController@upload')->name('upload-routine');
            Route::post('upload-routine', 'RoutineController@storeRoutine')->name('store-routine');
            Route::get('event/update/{id}', 'EventController@update');
            Route::patch('update-class-info/{id}','MyClassController@updateClassDetails')->name('update-class-info');
            Route::prefix('remove')->name('remove.')->group(function () {
                Route::get('notice/{id}', 'NoticeController@update');
            });
        });

        Route::get('school/sections', 'SectionController@index');
        Route::get('school/section/details/{section_id}', 'SectionController@sectionDetails');
        Route::get('grades/{student_id}', 'GradeController@index');
        Route::get('section/details/attendance/{section_id}', 'AttendanceController@attendanceDetails');
        Route::get('section/details/student-attendance/{section_id}', 'AttendanceController@attendanceDetailsview')->name('student.attendance');

        Route::get('attendance/adjust/{student_id}', 'AttendanceController@adjust');
        Route::post('attendance/adjust', 'AttendanceController@adjustPost');
        Route::get('attendances/{section_id}/{student_id}/{exam_id}', 'AttendanceController@index');
        Route::get('attendances-summary/{section_id}', 'AttendanceController@attendancesSummaryDate')->name('attendance.summary');
        Route::get('grades/classes', 'GradeController@allExamsGrade');
        Route::get('grades/section/{section_id}', 'GradeController@gradesOfSection');

        Route::get('academic-settings', 'SchoolController@index');

        Route::prefix('school')->name('school.')->group(function () {
            Route::post('add-class', 'MyclassController@store');
            Route::post('add-section', 'SectionController@store');
            Route::post('add-department', 'SchoolController@addDepartment');
            Route::post('add-department', 'SchoolController@addDepartment');
            Route::get('promote-students/{section_id}', 'UserController@promoteSectionStudents');
            Route::post('promote-students', 'UserController@promoteSectionStudentsPost');
            Route::post('theme', 'SchoolController@changeTheme');
        });

        Route::get('users/{school_code}/{role}', 'UserController@indexOther');

        Route::prefix('register')->name('register.')->group(function () {
            Route::post('student', 'UserController@store')->name('student.store');
            Route::post('teacher', 'UserController@storeTeacher');
            Route::post('accountant', 'UserController@storeAccountant');
            Route::post('librarian', 'UserController@storeLibrarian');
        });
        Route::get('edit/course/{id}', 'CourseController@edit');
        Route::post('edit/course/{id}', 'CourseController@updateNameAndTime');

        Route::get('edit/user/{id}', 'UserController@edit');
        Route::patch('edit/user', 'UserController@update');
        Route::post('upload/file', 'UploadController@upload');
        Route::get('user/deactivate/{id}', 'UserController@deactivateUser');
        Route::get('user/activate/{id}', 'UserController@activateUser');
        Route::get('courses/{teacher_id}/{section_id}', 'CourseController@index');
        Route::post('courses/store', 'CourseController@store');

        Route::get('department/{id}/edit', 'SchoolController@departmentEdit');
        Route::patch('department/{id}', 'SchoolController@departmentUpdate')->name('admin.department.update');
        Route::delete('department/{id}', 'SchoolController@departmentDestroy')->name('delete-department');

        Route::get('student-message','MessageController@adminSendMessage');
    });

});

    // View Emails - in browser
    Route::prefix('emails')->group(function () {
        Route::get('/welcome', function () {
            $user = App\User::find(1);
            $password = "ABCXYZ";
            return new App\Mail\SendWelcomeEmailToUser($user, $password);
        });
});
