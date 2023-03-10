<?php
use \Illuminate\Support\Facades\Session;
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

Route::get('/locale/{locale}', function ($locale){
    Session::put('locale', $locale);
    return back();
});
Route::get('/locale',function (){
   return view('locale');
});

Route::get('/', function () {
    return view('welcome');
});

//Auth::routes(['login' => false]);
Auth::routes();

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::post('generate-tiny-url', 'OnlineClassScheduleController@generateTinyUrl')->name('generate.tiny.url');


//Route::get('all-exams-grade/details/{class_id}', 'GradeController@allExamsGradeDetails');

Route::middleware(['auth','check.account.status'])->group(function () {

    if (config('app.env') != 'production') {
        Route::get('user/config/impersonate', 'UserController@impersonateGet');
        Route::post('user/config/impersonate', 'UserController@impersonate');
    }
    //Access for All authentic user
    Route::get('show-notice/{id}', 'NoticeController@show')->name('show.notice');
    Route::get('show-event/{id}', 'EventController@showListById')->name('show.event');
    Route::get('syllabus-list', 'SyllabusController@syllabusForStudentTeacher')->name('syllabus');
    Route::get('users/{school_code}/{student_code}/{teacher_code}', 'UserController@index')->name('all.student');
    Route::get('user/{user_code}', 'UserController@show')->name('user.show');
    Route::get('user/edit-information/{id}', 'UserController@editUserInfo')->name('edit-information');
    Route::patch('user/edit-information/{id}', 'UserController@updateUserInfo')->name('update-user-info');
    Route::patch('user/update-staff-information/{id}', 'UserController@updateStaffInformation')->name('update-staff-information');
    Route::get('user/config/change-password', 'UserController@changePasswordGet')->name('change.password');
    Route::post('user/config/change-password', 'UserController@changePasswordPost')->name('update.password');
    Route::get('notices-and-events', 'NoticeController@index');
    Route::get('absents/{id}', 'StuffAttendanceController@absents')->name('absents');
    Route::get('attendees/{id}', 'StuffAttendanceController@attendees')->name('attendees');
    Route::get('attendance/{user_id}', 'StuffAttendanceController@details')->name('user.attendance');

    Route::post('students/import', 'UserController@importStudents')->name('students.import');

    Route::get('user/rfid/{student_code}', 'UserController@rfidCreate')->name('rfid.create');
    Route::post('user/rfid/{student_code}', 'UserController@rfidStore')->name('rfid.store');
    // Route::get('user/rfid/{student_code}', 'UserController@rfidCreate')->name('rfid.edit');
    // Route::get('user/rfid/{student_code}', 'UserController@rfidCreate')->name('rfid.update');

    // Master role routes
    Route::group(['prefix' => 'master', 'middleware' => 'master'], function () {
        Route::get('/super-user-list', 'MasterHomeController@staffList')->name('super.user.list');
        Route::get('/home', 'MasterHomeController@index')->name('master.home');
        Route::get('register/admin/{id}', 'AdminController@create');
        Route::post('register/admin', 'AdminController@store');
        Route::get('activate-admin/{id}', 'AdminController@destroy');
        Route::delete('delete-admin/{id}', 'AdminController@delete')->name('delete-admin');
        Route::post('create-school', 'SchoolController@store');
        Route::get('school/admin-list/{school_id}', 'SchoolController@show');
        Route::get('school/{school_id}', 'SchoolController@showSchool')->name('school-details');
        Route::post('school/delete/{school_id}', 'SchoolController@destroy')->name('school.delete');
        Route::get('school/edit/{school_id}', 'SchoolController@edit');
        Route::post('school/edit/{school_id}', 'SchoolController@update');
        Route::get('new/create-school', 'SchoolController@create');
        Route::get('edit/admin/{id}', 'AdminController@edit');
        Route::post('edit/admin', 'AdminController@update');
        Route::get('new/all-school', 'MasterHomeController@allSchool')->name('all.school');
        Route::get('school/status/{school_id}/{status}', 'SchoolController@updateStatusSchool')->name('school.status.update');
        Route::get('school/status/{school_id}/{status}', 'SchoolController@updateStatusSchool')->name('school.status.update');
        Route::get('generate-invoice', 'InvoiceController@create')->name('generate.invoice');
        Route::post('send-invoice', 'InvoiceController@send')->name('send.invoice');
        Route::get('sms-summary/{school_id}', 'SchoolController@smsSummary')->name('sms.summary');
        Route::get('default/fee-types', 'FeeTypesController@defaultFeeTypes')->name('default.fee.types');
        Route::get('create/fee-types', 'FeeTypesController@create')->name('create.fee.type');
        Route::post('store/fee-types', 'FeeTypesController@store')->name('store.fee.type');
        Route::delete('delete/fee-types/{id}', 'FeeTypesController@destroy')->name('delete.fee.type');
        Route::delete('delete/fee-types/{id}', 'FeeTypesController@destroy')->name('delete.fee.type');
        Route::get('edit/fee-types/{id}', 'FeeTypesController@edit')->name('edit.fee.type');
        Route::patch('update/fee-types/{id}', 'FeeTypesController@update')->name('update.fee.type');
    });

    //Student role routes
    Route::group(['prefix' => 'student', 'middleware' => 'student'], function () {
        Route::get('/home', 'StudentHomeController@index')->name('student.home');
        Route::get('attendances/{section_id}/{user_id}/{exam_id}', 'AttendanceController@index');
        Route::get('courses/{teacher_id}/{section_id}', 'CourseController@index');
        Route::get('grades/{student_id}', 'GradeController@index')->name('student.grades');
        Route::get('user/notifications/{id}', 'NotificationController@index');
        Route::delete('user/notifications/delete/{id}', 'NotificationController@destroy')->name('message.delete');
        Route::get('/fees-summary', 'FeeTransactionController@studentFeeDetails')->name('fees.summary');
        Route::get('transaction-detail/{id}', 'FeeTransactionController@transactionDetail');
        Route::get('class-routine', 'RoutineController@index')->name('class.routines');
    });

    //Librarian role routes
    Route::group(['prefix' => 'librarian', 'middleware' => 'librarian'], function () {
        Route::get('/home', 'LibrarianHomeController@index')->name('librarian.home');
        Route::get('attendance/{user_id}', 'StuffAttendanceController@details');
        Route::get('issue-books', 'IssuedbookController@create');
        Route::get('issue-books/autocomplete/{query}', 'IssuedbookController@autocomplete');
        Route::post('issue-books', 'IssuedbookController@store');
        Route::get('issued-books', 'IssuedbookController@index')->name('issued-books');
        Route::get('returned-books', 'IssuedbookController@returnHistory')->name('returned-books');
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
        Route::get('fee-collection/section/student', 'FeeTransactionController@sectionsStudent');
        Route::get('fee-collection/get-fee/{id}', 'FeeTransactionController@collectFee')->name('student.fee');
        Route::get('fee-collections/{id}', 'FeeTransactionController@feeCollections')->name('student.fee.collections');
        Route::get('fee-collection/multiple-fee/{id}', 'FeeTransactionController@multipleFee')->name('multiple.fee');
        Route::post('multiple-fee', 'FeeTransactionController@multipleFeeStore')->name('multiple.fee.store');
        Route::get('transaction-detail/{id}', 'FeeTransactionController@transactionDetail');
        Route::get('/advance-collection','FeeTransactionController@advanceCollection');
        Route::post('/update-advance-collection','FeeTransactionController@updateAdvanceAmount');

        Route::get('attendance/{user_id}', 'StuffAttendanceController@details');
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
        Route::delete('delete-income/{id}', 'AccountController@deleteIncome');

        Route::get('expense', 'AccountController@expense');
        Route::post('create-expense', 'AccountController@storeExpense');
        Route::get('expense-list', 'AccountController@listExpense')->name('expenseList');
        Route::post('list-expense', 'AccountController@postExpense');
        Route::get('edit-expense/{id}', 'AccountController@editExpense');
        Route::post('update-expense', 'AccountController@updateExpense');
        Route::delete('delete-expense/{id}', 'AccountController@deleteExpense');
        Route::get('courses/{teacher_id}/{section_id}', 'CourseController@index');
    });

    // Teacher role routes
    Route::group(['prefix' => 'teacher', 'middleware' => 'teacher'], function () {
        Route::get('/home', 'TeacherHomeController@index')->name('teacher.home');
        Route::get('/my-students', 'TeacherHomeController@myStudent')->name('student.list');
        Route::get('courses/{teacher_id}/{section_id}', 'CourseController@index');
        Route::get('attendance/{user_id}', 'StuffAttendanceController@details');
        Route::get('attendances-summary/{section_id}', 'AttendanceController@attendancesSummaryDate')->name('attendance.summary.teacher');
        Route::get('messages/{id}', 'NotificationController@myMessages')->name('my.messages');
        Route::delete('user/notifications/delete/{id}', 'NotificationController@destroy')->name('message.delete');
        Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
        Route::get('attendances/students/{teacher_id}/{course_id}/{exam_id}/{section_id}', 'AttendanceController@addStudentsToCourseBeforeAtt');
        Route::get('attendances/{section_id}/{student_id}/{exam_id}', 'AttendanceController@index');
        Route::get('attendances/{section_id}', 'AttendanceController@sectionIndex');
        Route::post('attendance/take-attendance', 'AttendanceController@store');
        Route::get('attendance/adjust/{student_id}', 'AttendanceController@adjust');
        Route::post('attendance/adjust', 'AttendanceController@adjustPost');
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
        Route::get('routine', 'RoutineController@index')->name('routines');
    });

    Route::group(['prefix' => 'guardian', 'middleware' => 'guardian'], function () {
        Route::get('/home', 'GuardianHomeController')->name('guardian.home');
        Route::get('my-child', 'GuardianController@myChild')->name('child');
        Route::get('show/{user_id}', 'GuardianController@showByChildId')->name('child.show');
        Route::get('transaction-detail/{id}', 'FeeTransactionController@transactionDetail');
    });
    // Admin role routes
    Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
        Route::get('/home', 'HomeController@index')->name('admin.home');
        Route::get('find-user/{query}', 'AdminController@findUser')->name('admin.search');
        Route::get('search-user/', 'AdminController@index')->name('admin.search-user');
        Route::get('search-result/{id}', 'AdminController@search')->name('admin.search.result');
        Route::get('/sms-history/{school_id}', 'SchoolController@smsSummary')->name('admin.sms.summary');
        Route::get('messages', 'NotificationController@allMessages')->name('all.messages');
        Route::delete('user/notifications/delete/{id}', 'NotificationController@destroy')->name('message.delete');
        Route::get('gpa/create-gpa', 'GradesystemController@create')->name('gpa.system.create');
        Route::get('gpa/system-edit/{id}', 'GradesystemController@editGradeSystem')->name('gpa.system.edit');
        Route::Post('gpa/update/{id}', 'GradesystemController@updateGradeSystem')->name('gpa.system.update');
        Route::post('store-grade-system', 'GradesystemController@store');
        Route::post('store-gpa-info', 'GradesystemController@storeGradeInfo');
        Route::post('update-gpa/{id}', 'GradesystemController@update');
        Route::get('gpa/edit/{id}', 'GradesystemController@edit');
        Route::get('gpa/all-gpa', 'GradesystemController@index')->name('all.gpa');
        Route::DELETE('gpa/delete/{id}', 'GradesystemController@delete');
        Route::get('all-department', 'SchoolController@allDepartment')->name('all.department');
        Route::get('attendances/students/{teacher_id}/{course_id}/{exam_id}/{section_id}', 'AttendanceController@addStudentsToCourseBeforeAtt');

        Route::prefix('staff')->group(function () {
            Route::get('all-teachers', 'StuffAttendanceController@allTeacher');
            Route::get('teacher-attendance', 'StuffAttendanceController@index')->name('teacher.attendance');
            Route::post('teacher-attendance/store', 'StuffAttendanceController@store');
            Route::get('teacher-attendance/adjust/{teacher_id}', 'StuffAttendanceController@adjustMissingAttendance');
            Route::post('teacher-attendance/adjust/post', 'StuffAttendanceController@adjustMissingAttendancePost');
            Route::get('attendance/{user_id}', 'StuffAttendanceController@details')->name('staff.attendance');

            Route::get('all-staff', 'StuffAttendanceController@allStaff')->name('all.staff');
            Route::get('attendance', 'StuffAttendanceController@stuffAttendance')->name('staff.attendance');
            Route::post('attendance/store', 'StuffAttendanceController@stuffAttendanceStore')->name('staff.store');
            Route::get('attendance/adjust/{staff_id}', 'StuffAttendanceController@adjustStaffMissingAttendance')->name('adjust.attendance');
            Route::post('attendance/adjust/post', 'StuffAttendanceController@adjustStaffMissingAttendancePost');
        });

        Route::get('department-teachers/{id}', 'SchoolController@departmentTeachers');
        Route::get('department-students/{id}', 'SchoolController@departmentStudents');
        Route::get('section/students/{section_id}', 'UserController@sectionStudents');
        Route::prefix('exams')->group(function () {
            Route::get('/', 'ExamController@index')->name('exams');
            Route::get('/details/{exam_id}', 'ExamController@details');
            Route::get('create', 'ExamController@create')->name('exams.create');
            Route::post('create', 'ExamController@store');
            Route::post('activate-exam', 'ExamController@update');
            Route::get('remove/{id}', 'ExamController@destroy');
            Route::get('edit/{id}', 'ExamController@edit');
            Route::post('edit/{id}', 'ExamController@updateExam');
            Route::get('active', 'ExamController@indexActive')->name('exams.active');
            Route::get('results', 'ExamController@resultFiles')->name('exams.results');
            Route::get('edit/results/{exam_id}', 'ExamController@editResultFile')->name('exams.edit.result');
            Route::post('update/results/{exam_id}', 'ExamController@updateResultFile')->name('exams.update.result');
            Route::post('remove/result/{exam_id}', 'ExamController@removeResultFile')->name('exams.remove.result');
            Route::get('add/attendee/{exam_id}', 'ExamController@addAttendee')->name('exams.add.attendee');
            Route::get('attendees/{exam_id}', 'ExamController@attendees')->name('exams.attendees');
            Route::post('attendees/{exam_id}', 'ExamController@storeAttendees')->name('exams.store.attendees');
        });

        Route::prefix('inactive')->group(function () {
            Route::get('/notices', 'InactiveSettingsController@notices')->name('inactive.notices');
            Route::get('/events', 'InactiveSettingsController@events')->name('inactive.events');
            Route::get('/syllabuses', 'InactiveSettingsController@syllabuses')->name('inactive.syllabuses');
            Route::get('/routines', 'InactiveSettingsController@routines')->name('inactive.routines');
            Route::get('/students', 'InactiveSettingsController@students')->name('inactive.students');
            Route::get('/teachers', 'InactiveSettingsController@teachers')->name('inactive.teachers');
            Route::get('/librarians', 'InactiveSettingsController@librarians')->name('inactive.librarians');
            Route::get('/accountants', 'InactiveSettingsController@accountants')->name('inactive.accountants');
            Route::get('/staffs', 'InactiveSettingsController@staffs')->name('inactive.staffs');
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
        Route::post('update-sector', 'AccountController@updateSector')->name('update.sector');
        Route::delete('delete-sector/{id}', 'AccountController@deleteSector');

        Route::get('income', 'AccountController@income');
        Route::post('create-income', 'AccountController@storeIncome');
        Route::get('income-list', 'AccountController@listIncome');
        Route::post('list-income', 'AccountController@postIncome');
        Route::get('edit-income/{id}', 'AccountController@editIncome');
        Route::post('update-income', 'AccountController@updateIncome');
        Route::delete('delete-income/{id}', 'AccountController@deleteIncome');

        Route::get('expense', 'AccountController@expense');
        Route::post('create-expense', 'AccountController@storeExpense');
        Route::get('expense-list', 'AccountController@listExpense');
        Route::post('list-expense', 'AccountController@postExpense');
        Route::get('edit-expense/{id}', 'AccountController@editExpense');
        Route::post('update-expense', 'AccountController@updateExpense');
        Route::delete('delete-expense/{id}', 'AccountController@deleteExpense');

        Route::resource('fee-types', 'FeeTypesController');
        Route::resource('fee-discount', 'FeeDiscountController');
        Route::get('fee-master/class-fee', 'FeeMasterController@classFee')->name('class.fee');
        Route::resource('fee-master', 'FeeMasterController');
        Route::resource('fee-transaction', 'FeeTransactionController');
        Route::get('fee-collection/section/student', 'FeeTransactionController@sectionsStudent')->name('accountant.all-student');
        Route::get('fee-collection/get-fee/{id}', 'FeeTransactionController@collectFee')->name('student.fee');
        Route::get('fee-collection/multiple-fee/{id}', 'FeeTransactionController@multipleFee')->name('multiple.fee');
        Route::post('multiple-fee', 'FeeTransactionController@multipleFeeStore')->name('multiple.fee.store');
        Route::get('transaction-detail/{id}', 'FeeTransactionController@transactionDetail')->name('transaction.detail');
        Route::get('/advance-collection','FeeTransactionController@advanceCollection');
        Route::post('/update-advance-collection','FeeTransactionController@updateAdvanceAmount');

        //Accountant Routes End

        //Books Route
        Route::get('issue-books', 'IssuedbookController@create');
        Route::get('issue-books/autocomplete/{query}', 'IssuedbookController@autocomplete');
        Route::post('issue-books', 'IssuedbookController@store');
        Route::get('issued-books', 'IssuedbookController@index');
        Route::get('returned-books', 'IssuedbookController@returnHistory')->name('returned-books');
        Route::post('save_as_returned', 'IssuedbookController@update');
        Route::get('all-books', 'Library\BookController@index');
        Route::delete('/books/{id}', 'Library\BookController@destroy');
        Route::get('book/{id}', 'Library\BookController@show');
        Route::get('edit-book-details/{id}', 'Library\BookController@edit')->name('edit-book-details');
        Route::patch('update-book-details/{id}', 'Library\BookController@update')->name('update-book-details');
        Route::get('create/book', 'Library\BookController@create');
        Route::post('book/store', 'Library\BookController@store');

        Route::prefix('academic')->group(function () {
            Route::get("create-admit-card","AdmitCardController@create")->name('create.admit');
            Route::post("generate-admit-card","AdmitCardController@generate")->name('generate.admit');
            Route::get('upload-syllabus', 'SyllabusController@upload')->name('upload-syllabus');
            Route::post('upload-syllabus', 'SyllabusController@storeSyllabus')->name('store-syllabus');
            Route::get('syllabus', 'SyllabusController@index')->name('academic.syllabus');
            Route::get('syllabus/{class_id}', 'SyllabusController@create');
            Route::get('notice', 'NoticeController@list')->name('academic.notice');
            Route::get('create-notice', 'NoticeController@create')->name('create.notice');
            Route::post('store-notice', 'NoticeController@store')->name('store.notice');
            Route::get('events', 'EventController@eventList')->name('academic.event');
            Route::get('event/create', 'EventController@create')->name('create.event');
            Route::post('event/store', 'EventController@store')->name('store.event');
            Route::get('routine', 'RoutineController@index')->name('academic.routines');
            Route::get('notice/update/{id}', 'NoticeController@update');
            Route::post('notice/delete/{id}', 'NoticeController@deleteNotice')->name('notice.delete');
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

        Route::get('school/sections', 'SectionController@index')->name('school.section');
        Route::get('school/section/details/{section_id}', 'SectionController@sectionDetails');
        Route::get('grades/{student_id}', 'GradeController@index');
        Route::get('section/details/attendance/{section_id}', 'AttendanceController@attendanceDetails');
        Route::get('section/details/student-attendance/{section_id}', 'AttendanceController@attendanceDetailsview')->name('student.attendance');
        Route::get('students/export/{class_number}/{section_name}/{section_id}', 'AttendanceController@absentExport')->name('export.AbsentStudent');
        Route::get('attendance/adjust/{student_id}', 'AttendanceController@adjust');
        Route::post('attendance/adjust', 'AttendanceController@adjustPost');
        Route::get('attendances/{section_id}/{user_id}/{exam_id}', 'AttendanceController@index');
        Route::get('attendances-summary/{section_id}', 'AttendanceController@attendancesSummaryDate')->name('attendance.summary');
        Route::get('teacher-attendance-summary', 'AttendanceController@teacherAttendance')->name('teacher.summary');
        Route::get('grades/classes', 'GradeController@allExamsGrade')->name('grades.classes');
        Route::get('grades/section/{section_id}', 'GradeController@gradesOfSection');

        Route::get('create-department', 'SchoolController@createDepartment')->name('create.department');
        Route::get('manage-class', 'SchoolController@manageClasses')->name('manage.class');
        Route::get('add-course', 'CourseController@create')->name('add.course');
        Route::delete('delete-section/{id}', 'SectionController@destroy')->name('delete.section');
        Route::delete('delete-class/{class}', 'MyClassController@destroy')->name('delete.class');

        Route::get('import-student','UserController@importStudent');
        Route::get('/download', 'UserController@getDownload')->name('download');

        Route::get('new-student','UserController@createStudent');
        Route::get('new-teacher','UserController@createTeacher')->name('new.teacher');
        Route::get('new-librarian','UserController@createLibrarian');
        Route::get('new-accountant','UserController@createAccountant')->name('new.accountant');
        Route::get('new-staff','UserController@createStaff')->name('new.staff');

        Route::get('guardians', 'GuardianController@index')->name('all.guardian');
        Route::get('guardian/create','GuardianController@create')->name('create.guardian');
        Route::post('guardian/store', 'GuardianController@store')->name('store.guardian');
        Route::get('guardian/edit/{id}', 'GuardianController@edit')->name('edit.guardian');

        Route::prefix('school')->name('school.')->group(function () {
            Route::post('add-class', 'MyClassController@store');
            Route::post('add-section', 'SectionController@store');
            Route::post('add-department', 'SchoolController@storeDepartment')->name('add.department');
            Route::get('promote-students/{section_id}', 'UserController@promoteSectionStudents');
            Route::post('promote-students', 'UserController@promoteSectionStudentsPost');
            Route::post('theme', 'SchoolController@changeTheme');
        });

        Route::get('users/{school_code}/{role}', 'UserController@indexOther');
        Route::get('staffs', 'UserController@staffList')->name('staff.list');

        Route::prefix('register')->name('register.')->group(function () {
            Route::post('student', 'UserController@storeStudent')->name('student.store');
            Route::post('teacher', 'UserController@storeTeacher')->name('teacher.store');
            Route::post('accountant', 'UserController@storeAccountant')->name('accountant.store');
            Route::post('staff', 'UserController@storeStaff')->name('staff.store');
            Route::post('librarian', 'UserController@storeLibrarian');
        });
        Route::get('edit/course/{id}', 'CourseController@edit');
        Route::post('edit/course/{id}', 'CourseController@updateNameAndTime')->name('course.update');

        Route::get('edit/user/{id}', 'UserController@edit');
        Route::patch('edit/user', 'UserController@update')->name('edit.user');
        Route::post('upload/file', 'UploadController@upload');
        Route::get('user/deactivate/{id}', 'UserController@deactivateUser');
        Route::get('user/activate/{id}', 'UserController@activateUser');
        Route::get('courses/{teacher_id}/{section_id}', 'CourseController@index');
        Route::post('courses/store', 'CourseController@store');
        Route::post('user/bulk-action', 'UserController@bulkAction')->name('user.bulk.action');
        Route::get('student/export', 'UserController@exportStudent')->name('student.export');
        Route::post('upload/student/pic', 'UserController@uploadStudentPic')->name('upload.student.pic');
       
        Route::delete('user/{id}', 'UserController@destroy')->name('delete-user');

        Route::get('department/{id}/edit', 'SchoolController@departmentEdit');
        Route::patch('department/{id}', 'SchoolController@departmentUpdate')->name('department.update');
        Route::delete('department/{id}', 'SchoolController@departmentDestroy')->name('delete-department');

        Route::get('student-message','MessageController@adminSendMessage');

        Route::post('edit/section/{id}', 'SectionController@updateSection')->name('edit.section');
        
        Route::get('attendance-time', 'SectionMetaController@index')->name('configure.attendance.time');
        Route::get('attendance-time/create', 'SectionMetaController@create')->name('attendance.time.add');
        Route::post('attendance-time/store', 'SectionMetaController@store')->name('attendance.time.store');
        Route::get('attendance-time/edit/{id}', 'SectionMetaController@edit')->name('attendance.time.edit');
        Route::put('attendance-time/update/{id}', 'SectionMetaController@update')->name('attendance.time.update');
        Route::delete('attendance-time/delete/{id}', 'SectionMetaController@destroy')->name('attendance.time.delete');
        
        Route::get('shifts', 'ShiftController@index')->name('shifts');
        Route::get('shift/create/', 'ShiftController@create')->name('shift.create');
        Route::post('shift/store/', 'ShiftController@store')->name('shift.store');
        Route::get('shift/edit/{id}', 'ShiftController@edit')->name('shift.edit');
        Route::post('shift/update/{id}', 'ShiftController@update')->name('shift.update');
        Route::delete('shift/delete/{id}', 'ShiftController@destroy')->name('shift.delete');
        Route::get('school-settings/', 'SchoolController@schoolSetup')->name('school.setting');
        Route::post('school-settings/{school_id}', 'SchoolController@updateSchoolSetting')->name('school.update');

    });

    //Online class schedule

    Route::get('class-schedule', 'OnlineClassScheduleController@index')->name('class.schedule');
    Route::get('class-schedule/{id}', 'OnlineClassScheduleController@show')->name('class.schedule.show');
    Route::get('class-schedule/create', 'OnlineClassScheduleController@create')->name('class.schedule.create');
    Route::post('class-schedule/store', 'OnlineClassScheduleController@store')->name('class.schedule.store');

});

    // View Emails - in browser
    Route::prefix('emails')->group(function () {
        Route::get('/welcome', function () {
            $user = App\User::find(1);
            $password = "ABCXYZ";
            return new App\Mail\SendWelcomeEmailToUser($user, $password);
        });
});

Route::get('/account-suspended', 'UserController@inactiveAccount')->name('account.suspended');

Route::get('/debug-sentry', function () {
	throw new Exception('My first Sentry error!');
});

Route::get('/ch-trans/{trasaction_id}', 'FeeTransactionController@generateReceipt');
