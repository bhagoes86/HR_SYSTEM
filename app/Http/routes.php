<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['prefix' => ''], function()
{
	// ------------------------------------------------------------------------------------
	// LOGIN PAGE
	// ------------------------------------------------------------------------------------

	Route::group(['namespace' => 'Auth\\'], function() 
	{
		Route::get('/login', 				['uses' => 'LoginController@getLogin',				'as' => 'hr.login']);
		Route::post('/login',				['uses' => 'LoginController@postLogin',				'as' => 'hr.postlogin']);
		Route::get('/logout',				['uses' => 'LoginController@getLogout',				'as' => 'hr.logout']);
	});

	// ------------------------------------------------------------------------------------
	// LANDING PAGE (CHOOSE ORGANISATION OR CREATE ORGANISATION), SHOW ORGANISATION (STARTED WITH DASHBOARD)
	// ------------------------------------------------------------------------------------

	Route::resource('organisations',		'OrganisationController',							['names' => ['index' => 'hr.organisations.index', 'create' => 'hr.organisations.create', 'store' => 'hr.organisations.store', 'show' => 'hr.organisations.show', 'edit' => 'hr.organisations.edit', 'update' => 'hr.organisations.update', 'destroy' => 'hr.organisations.delete']]);

	// ------------------------------------------------------------------------------------
	// BRANCHES RESOURCE
	// ------------------------------------------------------------------------------------

	Route::resource('branches',				'BranchController',									['names' => ['index' => 'hr.branches.index', 'create' => 'hr.branches.create', 'store' => 'hr.branches.store', 'show' => 'hr.branches.show', 'edit' => 'hr.branches.edit', 'update' => 'hr.branches.update', 'destroy' => 'hr.branches.delete']]);

	// ------------------------------------------------------------------------------------
	// CALENDARS RESOURCE
	// ------------------------------------------------------------------------------------

	Route::resource('calendars',			'CalendarController',								['names' => ['index' => 'hr.calendars.index', 'create' => 'hr.calendars.create', 'store' => 'hr.calendars.store', 'show' => 'hr.calendars.show', 'edit' => 'hr.calendars.edit', 'update' => 'hr.calendars.update', 'destroy' => 'hr.calendars.delete']]);

	// ------------------------------------------------------------------------------------
	// WORKLEAVES RESOURCE
	// ------------------------------------------------------------------------------------

	Route::resource('workleaves',			'WorkleaveController',								['names' => ['index' => 'hr.workleaves.index', 'create' => 'hr.workleaves.create', 'store' => 'hr.workleaves.store', 'show' => 'hr.workleaves.show', 'edit' => 'hr.workleaves.edit', 'update' => 'hr.workleaves.update', 'destroy' => 'hr.workleaves.delete']]);

	// ------------------------------------------------------------------------------------
	// PERSONS RESOURCE
	// ------------------------------------------------------------------------------------

	Route::resource('persons',				'PersonController',									['names' => ['index' => 'hr.persons.index', 'create' => 'hr.persons.create', 'store' => 'hr.persons.store', 'show' => 'hr.persons.show', 'edit' => 'hr.persons.edit', 'update' => 'hr.persons.update', 'destroy' => 'hr.persons.delete']]);

	// ------------------------------------------------------------------------------------
	// PERSONS RESOURCE
	// ------------------------------------------------------------------------------------

	Route::resource('persons',				'PersonController',									['names' => ['index' => 'hr.persons.index', 'create' => 'hr.persons.create', 'store' => 'hr.persons.store', 'show' => 'hr.persons.show', 'edit' => 'hr.persons.edit', 'update' => 'hr.persons.update', 'destroy' => 'hr.persons.delete']]);

	// ------------------------------------------------------------------------------------
	// REPORTS RESOURCE
	// ------------------------------------------------------------------------------------

	Route::resource('reports',				'ReportController',									['names' => ['index' => 'hr.reports.index', 'create' => 'hr.reports.create', 'store' => 'hr.reports.store', 'show' => 'hr.reports.show', 'edit' => 'hr.reports.edit', 'update' => 'hr.reports.update', 'destroy' => 'hr.reports.delete']]);
});	

