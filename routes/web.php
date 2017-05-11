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
Route::get('/', 'Auth\LoginController@showLoginForm');
Route::get('/login', 'Auth\LoginController@showLoginForm');
Route::post('/', 'Auth\LoginController@login');
Route::post('/login', 'Auth\LoginController@login');

Route::get('/logout', 'Auth\LoginController@logout');

// Password reset link request routes...
Route::get('/password/email', 'Auth\PasswordController@getEmail');
Route::post('/password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
Route::get('/password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('/password/reset', 'Auth\PasswordController@postReset');

Route::group(array('middleware' => 'auth' ), function () {

    Route::get('/home', 'HomeController@home');

    

    Route::group(array('middleware' => 'UserAdd' ), function () {

        Route::get('/users','UsersController@index');
        Route::get('/users/{id?}/edit', 'UsersController@edit');    
        Route::post('/users/{id?}/edit','UsersController@update');
        Route::get('/duplicateCheck', 'UsersController@duplicateCheck'); 
        
        
        Route::get('/users/{id?}/password', 'UsersController@passwordChangeView');
        Route::post('/users/{id?}/password', 'UsersController@passwordChange');

        Route::get('/users/{id?}/disable', 'UsersController@disable');
        Route::get('/users/disabled','UsersController@usersDisabled');
        Route::get('/users/{id?}/restore', 'UsersController@restore');     


        Route::get('/users/register', 'Auth\RegisterController@showRegistrationForm');
        Route::post('/users/register', 'Auth\RegisterController@register');
    });

    Route::get('users/password/edit/self',function () {return view('users.passwordSelfEdit');});
    Route::post('users/password/edit/self', 'UsersController@passwordSelfUpdate');

    Route::group(array('middleware' => 'SuperUser' ), function () {
        Route::get('/roles/create', 'RolesController@create');
        Route::post('/roles/create', 'RolesController@store');
        Route::get('/roles', 'RolesController@index');
    });

 //-------------------------------ClientsController-----------------------------------------------   
    Route::get('clients/add', ['middleware' => 'ClientAdd','uses'=>'ClientsController@add']);
    Route::get('/cityLoader', 'ClientsController@cityLoader'); 
    Route::get('/clientAddCheck', 'ClientsController@clientAddCheck');
    Route::post('clients/add', ['middleware' => 'ClientAdd','uses'=>'ClientsController@save']); 

    Route::get('clients/{id?}/profile', 'ClientsController@profile');

    Route::get('clients/index', 'ClientsController@index');

    Route::get('clients/{id?}/edit', ['middleware' => 'ClientAdd','uses'=>'ClientsController@edit']);
    Route::post('clients/{id?}/edit', ['middleware' => 'ClientAdd','uses'=>'ClientsController@editProcess']);
    Route::get('/clientEditCheck', 'ClientsController@clientEditCheck');

//-------------------------------ContactsController-----------------------------------------------    

    Route::get('contacts/{id?}/add', ['middleware' => 'ContactAdd','uses'=>'ContactsController@add']);
    Route::get('/contactAddCheck', 'ContactsController@contactAddCheck');
    Route::post('contacts/{id?}/add', ['middleware' => 'ContactAdd','uses'=>'ContactsController@save']);

    Route::post('/deleteClientContact', ['middleware' => 'ContactAdd','uses'=>'ContactsController@deleteClientContact']);
    Route::post('/restoreClientContact', ['middleware' => 'ContactAdd','uses'=>'ContactsController@restoreClientContact']);

    Route::get('contacts/{clientId?}/{contactId?}/edit', ['middleware' => 'ContactAdd','uses'=>'ContactsController@edit']);
    Route::get('/contactEditCheck', 'ContactsController@contactEditCheck');
    Route::post('contacts/{clientId?}/{contactId?}/edit', ['middleware' => 'ContactAdd','uses'=>'ContactsController@editProcess']);

    Route::get('contacts/search', 'ContactsController@initiate');  
    Route::post('contacts/search', 'ContactsController@filterShow');  

    Route::get('contactSearchBind', 'ContactsController@searchBind');

//-------------------------------ClientsControllerExtra-----------------------------------------------    
 
    Route::get('clients/filter', 'ClientsControllerExtra@initiate');  
    Route::post('clients/filter', 'ClientsControllerExtra@filterShow'); 

//-------------------------------CallsController-----------------------------------------------    

    Route::get('/calls/{id?}/add',  'CallsController@add');
    Route::post('/calls/{id?}/add',  'CallsController@save');

    Route::get('/calls/{clientId?}/{contactId?}/edit','CallsController@edit');
    Route::post('/calls/{clientId?}/{contactId?}/edit','CallsController@editProcess');

    Route::post('/calls/{clientId?}/{id?}/delete','CallsController@delete');

//-------------------------------SettingsController-----------------------------------------------    

    Route::get('/settings/industries',  'SettingsController@industries');
    Route::get('/industryAddCheck', 'SettingsController@industryAddCheck');
    Route::post('/settings/industries',  'SettingsController@saveIndustry');
    Route::post('/updateIndustry',  'SettingsController@updateIndustry');
    Route::post('/updatePosition',  'SettingsController@updatePosition');


    Route::get('/settings/designations',  'SettingsController@positions');
    Route::get('/positionAddCheck', 'SettingsController@positionAddCheck');
    Route::post('/settings/designations',  'SettingsController@savePosition');

//-------------------------------ExcelController-----------------------------------------------    

    Route::get('/excelClientsList',  'ExcelController@clientsList');
    Route::get('/excelContactsFilter/{position}/{industry}/{country}/{city}',  'ExcelController@contactsFilter');

    Route::get('/hrm/test',  'testController@index');    

});