<?php
Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::delete('member/delete', 'MemberController@delete')->name('member.delete');
Route::get('member/create', 'MemberController@create')->name('member.create');
Route::get('member/edit', 'MemberController@edit')->name('member.edit');
Route::post('member', 'MemberController@store')->name('member.store');
Route::post('member/{uuid}', 'MemberController@update')->name('member.update');