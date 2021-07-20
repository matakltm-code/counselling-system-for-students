<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\FileController;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Profile route
Route::get('/profile', [ProfileController::class, 'index']);
Route::get('/profile/edit', [ProfileController::class, 'edit']);
Route::patch('/profile/{profile}', [ProfileController::class, 'update']);
Route::get('/profile/change-password', [ChangepasswordController::class, 'index']);
Route::post('/profile/change-password', [ChangepasswordController::class, 'store']);
// Aditional profile for conselor
Route::get('/profile/edit/specialty', [ProfileController::class, 'edit_specialty']);
Route::patch('/profile/{profile}/specialty', [ProfileController::class, 'update_specialty']);


// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Admin Route
Route::get('/files', [FileController::class, 'index']);
Route::get('/files/create', [FileController::class, 'create']);
Route::post('/files', [FileController::class, 'store']);
Route::get('/files/{file}', [FileController::class, 'show']);
Route::delete('/files/{file}', [FileController::class, 'destroy']);

Route::get('/account', [AccountController::class, 'index']);
Route::post('/account', [AccountController::class, 'store']);
Route::get('/account/login-history', [AccountController::class, 'login_history']);
Route::post('/account/enable-disable', [AccountController::class, 'enable_disable_account']);

// ----------------------------------------------------------








// Counselor Route
// get all request
Route::get('/counselling-requests', function () {
    if (!auth()->user()->is_counselor) {
        return redirect('/')->with('error', 'You are not allowed to this page.');
    }
    return view('counselor.student.requests', ['requests' => Appointment::orderBy('request_status', 'ASC')->where('counselor_id', auth()->user()->id)->paginate(10)]);
})->middleware('auth');
// Refuse request
Route::post('/counselling-requests', function (Request $request) {
    // dd($request);
    $data = $request->validate([
        'appointment_id' => 'required|integer',
    ]);
    // Add request to database
    Appointment::where('id', $data['appointment_id'])->update([
        'request_status' => 'refused',
    ]);
    return back()->with('success', 'Student counselling request refused successfuly.');
    // Redirect to requests table
})->middleware('auth');
// see specific request detail to accept the request
Route::get('/counselling-requests/{appointment}', function (Appointment $appointment) {
    return view('counselor.student.request-detail', ['appointment' => $appointment]);
})->middleware('auth');
// accept student request
Route::post('/counselling-request-accepted', function (Request $request) {
    // dd($request);
    $data = $request->validate([
        'appointment_id' => 'required|integer',
        'counselor_note' => 'required',
        'metting_id' => 'required',
        'metting_passcode' => 'required',
        'metting_time_date' => 'required',
    ]);
    // Add request to database
    Appointment::where('id', $data['appointment_id'])->update([
        'request_status' => 'accepted',
        'counselor_note' => $data['counselor_note'],
        'metting_id' => $data['metting_id'],
        'metting_passcode' => $data['metting_passcode'],
        'metting_time_date' => $data['metting_time_date'],
    ]);
    return back()->with('success', 'Counselling request accepted successfuly.');
    // Redirect to requests table
})->middleware('auth');





// ----------------------------------------------------------
// Student Route
Route::get('/counselors', function () {
    return view('student.counselor.list', ['users' => User::where('user_type', 'counselor')->paginate(10)]);
})->middleware('auth');
Route::get('/counselors/{counselor}', function (User $counselor) {
    return view('student.counselor.show-profile', ['user' => $counselor]);
})->middleware('auth');
// Student send a counslling request for conselor
Route::post('/counselors/send-counselling-request', function (Request $request) {
    // dd($request);
    $data = $request->validate([
        'counselor_id' => 'required|integer',
        'student_reason' => 'required|string|max:500',
        'student_date' => 'required|date',
    ]);
    // Add request to database
    Appointment::create([
        'student_id' => auth()->user()->id,
        'counselor_id' => $data['counselor_id'],
        'student_reason' => $data['student_reason'],
        'student_date' => $data['student_date'],
    ]);
    return back()->with('success', 'Your counselling request is added. <br/> Please check your request status frequently. ');
    // Redirect to requests table
})->middleware('auth');

// Appointments
Route::get('/appointments', [AppointmentController::class, 'index']);
