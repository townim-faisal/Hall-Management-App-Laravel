<?php

Auth::routes();

Route::get('/', function(){
	return redirect('/login');
});

//for all type of users to view dashboard
Route::get('/dashboard', [
	'uses' => 'UserController@index',
	'as' => 'dashboard',
	'middleware' => ['auth', 'roles'],
	'roles' => ['admin', 'student', 'employee']
]);

//for all type of users to view own profile and edit it
Route::group(['prefix'=>'profile', 'middleware' => ['auth', 'roles'] , 'roles' => ['admin', 'student', 'employee']], function(){
	Route::get('/', [
		'uses' => 'UserController@getProfile',
		'as' => 'profile.info',		
	]);

	Route::get('/edit', [
		'uses' => 'UserController@getEditProfile',
		'as' => 'profile.edit',
	]);

	Route::post('/edit', [
		'uses' => 'UserController@postEditProfile',
		'as' => 'profile.edit',
	]);
});

//for all type of users to view hall manager profile but only admin and employee can create & remove hall manager
Route::group(['prefix'=>'hall_manager', 'middleware' => ['auth', 'roles'] ], function(){
	Route::get('/', [
		'uses' => 'UserController@getHallManager',
		'as' => 'hallmanager.info',
		'roles' => ['admin', 'student', 'employee']
	]);

	Route::post('/', [
		'uses' => 'AdminController@postHallManager',
		'as' => 'hallmanager.create',
		'roles' => ['admin', 'employee']
	]);

	Route::post('/remove', [
		'uses' => 'AdminController@removeHallManager',
		'as' => 'hallmanager.remove',
		'roles' => ['admin', 'employee']
	]);
});

//for all type of users to change his own password but admin can change everyone's password
Route::group(['prefix'=>'change_password', 'middleware' => ['auth', 'roles'] ], function(){
	Route::get('/', [
		'uses' => 'UserController@getChangePassword',
		'as' => 'change.password',
		'roles' => ['admin', 'student', 'employee']
	]);

	Route::post('/', [
		'uses' => 'UserController@postChangePassword',
		'as' => 'change.password',
		'roles' => ['admin', 'student', 'employee']
	]);

	Route::get('/users', [
		'uses' => 'AdminController@getChangeUserPassword',
		'as' => 'changeuser.password',
		'roles' => ['admin']
	]);

	Route::post('/users', [
		'uses' => 'AdminController@postChangeUserPassword',
		'as' => 'changeuser.password',
		'roles' => ['admin']
	]);

});

//for all type of users to view employee
Route::group(['prefix'=>'staffs', 'middleware' => ['auth', 'roles'], 'roles' => ['admin', 'student', 'employee'] ], function(){
	Route::get('/', [
		'uses' => 'UserController@getEmployees',
		'as' => 'employees.info',
	]);
});

//for all type of users to view students but only admin and employee can edit and delete profile
Route::group(['prefix'=>'students', 'middleware' => ['auth', 'roles']], function(){
	Route::get('/', [
		'uses' => 'AdminController@getStudents',
		'as' => 'students.info',
		'roles' => ['admin', 'employee', 'student'] 
	]);

	Route::delete('/', [
		'uses' => 'AdminController@deleteStudents',
		'as' => 'students.info',
		'roles' => ['admin', 'employee'] 
	]);

	Route::get('/search', [
		'uses' => 'AdminController@searchStudent',
		'as' => 'students.search',
		'roles' => ['admin', 'employee', 'student'] 
	]);

	Route::get('/{roll}', [
		'uses' => 'AdminController@getSingleStudent',
		'as' => 'student.info',
		'roles' => ['admin', 'employee', 'student'] 
	]);

	Route::get('/{roll}/edit', [
		'uses' => 'AdminController@getEditSingleStudent',
		'as' => 'student.edit',
		'roles' => ['admin', 'employee'] 
	]);

	Route::post('/{roll}/edit', [
		'uses' => 'AdminController@postEditSingleStudent',
		'as' => 'student.edit',
		'roles' => ['admin', 'employee'] 
	]);
});

//for admin and employee to view hall allotment
Route::group(['prefix'=>'hallsummary', 'middleware' => ['auth', 'roles'], 'roles' => ['admin', 'employee'] ], function(){
	Route::get('/', [
		'uses' => 'AdminController@getHallSummary',
		'as' => 'hall.summary',
	]);

	Route::post('/', [
		'uses' => 'AdminController@postHallSummary',
		'as' => 'hall.summary',
	]);
});

//for admin to access control and delte users
Route::group(['prefix'=>'settings', 'middleware' => ['auth', 'roles'], 'roles' => ['admin'] ], function(){
	Route::get('/acl', [
		'uses' => 'AdminController@getAssignRoles',
		'as' => 'settings.acl',
	]);

	Route::post('/acl', [
		'uses' => 'AdminController@postAssignRoles',
		'as' => 'settings.acl',
	]);

	Route::delete('/acl', [
		'uses' => 'AdminController@deleteUser',
		'as' => 'settings.acl',
	]);
});