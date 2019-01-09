<?php
Auth::routes();

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

Route::get('profile', 'Auth\ProfileController@changePassword')->name('profile.edit');
Route::post('profile', 'Auth\ProfileController@updatePassword')->name('profile.update');