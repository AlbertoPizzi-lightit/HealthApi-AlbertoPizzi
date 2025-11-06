<?php

declare(strict_types=1);

use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Support\Facades\Route;
use Lightit\Users\App\Controllers\{
    CancelMyAppointmentController,
    ListUserAppointmentsController,
    GetUserController,
    DeleteUserController,
    ListUserController,
    StoreUserAppointmentController,
    StoreUserController,
    UpdateUserController
};
use Lightit\Clinics\App\Controllers\{
    AssignDoctorToClinicController,
    DeleteClinicController,
    GetClinicController,
    ListClinicController,
    StoreClinicController,
    UpdateClinicController
};
use Lightit\Doctors\App\Controllers\{
    AssignClinicToDoctorController,
    DeleteDoctorController,
    GetDoctorController,
    ListDoctorController,
    StoreDoctorController,
    UpdateDoctorController
};
use Lightit\Appointments\App\Controllers\GetAppointmentController;
use Lightit\Appointments\App\Controllers\ListAppointmentController;
use Lightit\Authentication\App\Controllers\{
    LoginController,
    LogoutController,
    RefreshController
};

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')
    ->get('/me', fn(
        #[CurrentUser] $user
    ) => response()->json([
        'data' => $user,
    ]));

/*
|--------------------------------------------------------------------------
| Users Routes
|--------------------------------------------------------------------------
*/

Route::prefix('users')
    ->group(static function (): void {
        Route::get('/', ListUserController::class);
        Route::post('/', StoreUserController::class);
        Route::prefix('{user}')->group(static function (): void
        {
            Route::get('/', GetUserController::class)
                ->withTrashed();
            Route::put('/', UpdateUserController::class);
            Route::delete('/', DeleteUserController::class);
        })
            ->whereNumber('user');
        Route::prefix('me/appointments')->group(static function (): void
        {
            Route::get('/', ListUserAppointmentsController::class);
            Route::delete('/{appointment}', CancelMyAppointmentController::class);
            Route::post('/', StoreUserAppointmentController::class);
        })->middleware(['auth:api']);

    });
/*
|--------------------------------------------------------------------------
| Clinics Routes
|--------------------------------------------------------------------------
*/

Route::prefix('clinics')
    ->group(static function (): void {
        Route::get('/', ListClinicController::class);
        Route::post('/', StoreClinicController::class);
        Route::prefix('{clinic}')
            ->group(static function (): void
            {
                Route::get('/', GetClinicController::class);
                Route::put('/', UpdateClinicController::class);
                Route::delete('/', DeleteClinicController::class);
                Route::post('/', AssignDoctorToClinicController::class);
            })
            ->whereNumber('clinic');
    });

/*
|--------------------------------------------------------------------------
| Doctors Routes
|--------------------------------------------------------------------------
*/

Route::prefix('doctors')
    ->group(static function (): void {
        Route::get('/', ListDoctorController::class);
        Route::post('/', StoreDoctorController::class);
        Route::prefix('{doctor}')
            ->group(static function (): void
            {
                Route::put('/', UpdateDoctorController::class);
                Route::delete('/', DeleteDoctorController::class);
                Route::get('/', GetDoctorController::class);
                Route::post('/', AssignClinicToDoctorController::class);
            })
            ->whereNumber('doctor');
    });
/*
|--------------------------------------------------------------------------
| Login Routes
|--------------------------------------------------------------------------
*/

Route::prefix('auth')->group(static function (): void {
    Route::post('login', LoginController::class);
});
Route::prefix('auth')->middleware('auth:api')->group(static function (): void
{
    Route::post('logout', LogoutController::class);
    Route::post('refresh', RefreshController::class);
});

/*
|--------------------------------------------------------------------------
| Appointment Routes
|--------------------------------------------------------------------------
*/

Route::prefix('appointments')->group(static function (): void
{
    Route::prefix('{appointment}')
        ->group(static function (): void {
            Route::get('/', GetAppointmentController::class);
        })
        ->whereNumber('appointment');
    Route::get('/', ListAppointmentController::class);
});
