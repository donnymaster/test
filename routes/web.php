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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Auth::routes(['verify' => true]);

Route::get('/', 'HomeController@index')->name('root');

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('feedback', 'FeedbackController');

    Route::resource('broadcasts', 'BroadcastController');

    Route::resource('players', 'PlayersController');

    Route::resource('teams', 'TeamsController');

    Route::resource('user', 'UserController');

    Route::group([
        'prefix' => 'admin', 
        'middleware' => 'admin', 
        'middleware' => 'auth',
        'middleware' => 'verified'], function () {

        Route::get('index', 'ManagementController@index')->name('admin.index');
        Route::get('teams', 'ManagementController@teams')->name('admin.teams');
        Route::get('broadcasts', 'ManagementController@broadcasts')->name('admin.broadcasts');
        Route::get('players', 'ManagementController@players')->name('admin.players');
        Route::get('feedbacks', 'ManagementController@feedbacks')->name('admin.feedbacks');

        Route::get('broadcasts-json', 'ManagementController@broadcastsJson')->name('admin.broadcastsJson');
        Route::get('teams-json', 'ManagementController@teamsJson')->name('admin.teamsJson');
        Route::get('players-json', 'ManagementController@playersJson')->name('admin.playersJson');
        Route::get('feedbacks-lson', 'ManagementController@feedbacksJson')->name('admin.feedbacksJson');
        Route::get('feedbacks/{id}', 'ManagementController@answerFeedback')->name('admin.answerFeedback');
        Route::post('feedbacks', 'ManagementController@answerQuestion')->name('admin.answerQuestion');

        Route::get('autocomplete-teams', 'ManagementController@autocompleteTeams')->name('admin.complete.teams');
        Route::get('teams-all-teams', 'ManagementController@allTeams')->name('admin.complete.players');
        Route::get('teams-all-init', 'ManagementController@initUpdatePlayers')->name('admin.complete.all-teams-init');
    });

Route::get('chat/{id}', 'ChatsController@index');
Route::get('messages/{id}', 'ChatsController@fetchMessages');
Route::post('messages', 'ChatsController@sendMessage');

Route::get('messages-moderator/{id}', 'ModeratorMessageController@fetchMessagesModerator');
Route::post('messages-moderator', 'ModeratorMessageController@sendMessageModerator');
