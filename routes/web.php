<?php
Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::delete('member/delete', 'MemberController@delete')->name('member.delete');
    Route::get('member/create', 'MemberController@create')->name('member.create');
    Route::get('member/edit', 'MemberController@edit')->name('member.edit');
    Route::post('member', 'MemberController@store')->name('member.store');
    Route::post('member/search', 'MemberController@search')->name('member.search');
    Route::post('member/{uuid}', 'MemberController@update')->name('member.update');

    Route::get('group', 'GroupController@index')->name('group.index');
    Route::get('group/create', 'GroupController@create')->name('group.create');
    Route::get('group/edit', 'GroupController@edit')->name('group.edit');
    Route::post('group', 'GroupController@store')->name('group.store');
    Route::post('group/search', 'GroupController@search')->name('group.search');
    Route::post('group/{uuid}', 'GroupController@update')->name('group.update');
    Route::delete('group/delete', 'GroupController@delete')->name('group.delete');

    Route::get('manage', 'ManageController@index')->name('manage.index');
    Route::get('manage/setting', 'ManageController@setting')->name('manage.setting');
    Route::post('manage/setting', 'ManageController@updateSetting')->name('manage.update');


    //User
    Route::get('user', 'UserController@index')->name('user.index');
    Route::get('user/create', 'UserController@create')->name('user.create');
    Route::post('user', 'UserController@store')->name('user.store');
    Route::get('user/{uuid}/edit', 'UserController@edit')->name('user.edit');
    Route::post('user/search', 'UserController@search')->name('user.search');
    Route::post('user/{uuid}', 'UserController@update')->name('user.update');
    Route::delete('user/delete', 'UserController@delete')->name('user.delete');



    //user profile
    Route::get('profile', 'Auth\ProfileController@changePassword')->name('profile.edit');
    Route::post('profile', 'Auth\ProfileController@updatePassword')->name('profile.update');
});