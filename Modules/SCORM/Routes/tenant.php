<?php


use Illuminate\Support\Facades\Route;
use Modules\SCORM\Http\Controllers\SCORMController;

Route::prefix('scorm')->as('scorm.')->middleware('auth')->group(function () {
    Route::get('/', 'SCORMController@index');
    Route::get('/viewer/{version}/{link}', 'SCORMController@viewer')->name('viewer');
    Route::get('/action', 'SCORMController@action')->name('action');
    Route::post('/statement', 'SCORMController@statement')->name('statement');
    Route::post('/report-store', 'SCORMReportController@store')->name('report.store');
    Route::get('/report', 'SCORMReportController@index')->name('report.index')->middleware('RoutePermissionCheck:scorm.report.index');
    Route::get('/report-data', 'SCORMReportController@data')->name('report.data')->middleware('RoutePermissionCheck:scorm.report.index');
    Route::get('/report-details/{id}', 'SCORMReportController@details')->name('report.details')->middleware('RoutePermissionCheck:scorm.report.index');
    Route::get('/report-lesson-details/{user_id}/{lesson_id}', 'SCORMReportController@lessonDetails')->name('report.lesson-details')->middleware('RoutePermissionCheck:scorm.report.index');



    Route::post('/save-progress', [ScormController::class, 'saveProgress']);
    Route::get('/get-progress/{course_id}', [ScormController::class, 'getProgress']);
});
