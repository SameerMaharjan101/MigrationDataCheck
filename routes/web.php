<?php

use App\Http\Controllers\CompareAccountDatabaseController;
use App\Http\Controllers\CompareAppSettingController;
use App\Http\Controllers\CompareAttributeFormsController;
use App\Http\Controllers\CompareAttributesController;
use App\Http\Controllers\CompareCalendarController;
use App\Http\Controllers\CompareCallsController;
use App\Http\Controllers\CompareClientController;
use App\Http\Controllers\CompareContactController;
use App\Http\Controllers\CompareEmailController;
use App\Http\Controllers\CompareEmailTemplateController;
use App\Http\Controllers\CompareFieldController;
use App\Http\Controllers\CompareFormsController;
use App\Http\Controllers\CompareMediaController;
use App\Http\Controllers\CompareOtpController;
use App\Http\Controllers\CompareProjectController;
use App\Http\Controllers\CompareProjectGroupController;
use App\Http\Controllers\ComparePropertyController;
use App\Http\Controllers\CompareRefreshTokensController;
use App\Http\Controllers\CompareResultCodeController;
use App\Http\Controllers\CompareResultCodeDescriptionController;
use App\Http\Controllers\CompareResultCodeOutcomeController;
use App\Http\Controllers\CompareResultCodeTypeController;
use App\Http\Controllers\CompareRightController;
use App\Http\Controllers\CompareSettingsController;
use App\Http\Controllers\CompareTeamController;
use App\Http\Controllers\CompareTranscriptionController;
use App\Http\Controllers\CompareTypesController;
use App\Http\Controllers\CompareUserGroupController;
use App\Http\Controllers\CompareUsersController;
use App\Http\Controllers\CompareViewsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// ── User comparison (existing) ──
Route::get('/compare-users', [CompareUsersController::class, 'index']);

// ── Batch A: name + soft deletes ──
Route::get('/compare-calendar', [CompareCalendarController::class, 'index']);
Route::get('/compare-forms', [CompareFormsController::class, 'index']);
Route::get('/compare-project', [CompareProjectController::class, 'index']);
Route::get('/compare-project-group', [CompareProjectGroupController::class, 'index']);
Route::get('/compare-result-code', [CompareResultCodeController::class, 'index']);
Route::get('/compare-result-code-description', [CompareResultCodeDescriptionController::class, 'index']);
Route::get('/compare-result-code-outcome', [CompareResultCodeOutcomeController::class, 'index']);
Route::get('/compare-result-code-type', [CompareResultCodeTypeController::class, 'index']);
Route::get('/compare-rights', [CompareRightController::class, 'index']);
Route::get('/compare-teams', [CompareTeamController::class, 'index']);
Route::get('/compare-user-groups', [CompareUserGroupController::class, 'index']);

// ── Batch B: name + no soft deletes ──
Route::get('/compare-email', [CompareEmailController::class, 'index']);
Route::get('/compare-email-template', [CompareEmailTemplateController::class, 'index']);
Route::get('/compare-views', [CompareViewsController::class, 'index']);
Route::get('/compare-account-database', [CompareAccountDatabaseController::class, 'index']);
Route::get('/compare-app-setting', [CompareAppSettingController::class, 'index']);

// ── Batch C: other keys + soft deletes ──
Route::get('/compare-attributes', [CompareAttributesController::class, 'index']);
Route::get('/compare-property', [ComparePropertyController::class, 'index']);
Route::get('/compare-settings', [CompareSettingsController::class, 'index']);
Route::get('/compare-types', [CompareTypesController::class, 'index']);
Route::get('/compare-otp', [CompareOtpController::class, 'index']);

// ── Batch D: other keys + no soft deletes ──
Route::get('/compare-contact', [CompareContactController::class, 'index']);
Route::get('/compare-calls', [CompareCallsController::class, 'index']);
Route::get('/compare-field', [CompareFieldController::class, 'index']);
Route::get('/compare-refresh-tokens', [CompareRefreshTokensController::class, 'index']);
Route::get('/compare-media', [CompareMediaController::class, 'index']);
Route::get('/compare-transcription', [CompareTranscriptionController::class, 'index']);

// ── Batch E: no clear business key ──
Route::get('/compare-attribute-forms', [CompareAttributeFormsController::class, 'index']);
Route::get('/compare-client', [CompareClientController::class, 'index']);
