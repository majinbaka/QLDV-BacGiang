<?php
Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::delete('member/delete', 'MemberController@delete')->name('member.delete');
    Route::get('member/create', 'MemberController@create')->name('member.create');
    Route::get('member/{uuid}/edit', 'MemberController@edit')->name('member.edit');
    Route::post('member', 'MemberController@store')->name('member.store');
    Route::post('member/search', 'MemberController@search')->name('member.search');
    Route::post('member/{uuid}', 'MemberController@update')->name('member.update');



    Route::get('manage', 'ManageController@index')->name('manage.index');
    Route::get('manage/setting', 'ManageController@setting')->name('manage.setting');
    Route::post('manage/setting', 'ManageController@updateSetting')->name('manage.update');
    Route::get("/page", function(){
        return View::make("layouts.danhmuc");
    });
    //CRUD MEMBER INFO SELECT
    Route::get('english', 'EnglishController@index')->name('english.index');
    Route::get('english/{id}/edit', 'EnglishController@edit')->name('english.edit');
    Route::post('english', 'EnglishController@store')->name('english.store');
    Route::post('english/{id}', 'EnglishController@update')->name('english.update');
    Route::delete('english/delete', 'EnglishController@delete')->name('english.delete');

    Route::get('it', 'ItController@index')->name('it.index');
    Route::get('it/{id}/edit', 'ItController@edit')->name('it.edit');
    Route::post('it', 'ItController@store')->name('it.store');
    Route::post('it/{id}', 'ItController@update')->name('it.update');
    Route::delete('it/delete', 'ItController@delete')->name('it.delete');

    Route::get('knowledge', 'KnowledgeController@index')->name('knowledge.index');
    Route::get('knowledge/{id}/edit', 'KnowledgeController@edit')->name('knowledge.edit');
    Route::post('knowledge', 'KnowledgeController@store')->name('knowledge.store');
    Route::post('knowledge/{id}', 'KnowledgeController@update')->name('knowledge.update');
    Route::delete('knowledge/delete', 'KnowledgeController@delete')->name('knowledge.delete');

    Route::get('political', 'PoliticalController@index')->name('political.index');
    Route::get('political/{id}/edit', 'PoliticalController@edit')->name('political.edit');
    Route::post('political', 'PoliticalController@store')->name('political.store');
    Route::post('political/{id}', 'PoliticalController@update')->name('political.update');
    Route::delete('political/delete', 'PoliticalController@delete')->name('political.delete');

    Route::get('position', 'PositionController@index')->name('position.index');
    Route::get('position/{id}/edit', 'PositionController@edit')->name('position.edit');
    Route::post('position', 'PositionController@store')->name('position.store');
    Route::post('position/{id}', 'PositionController@update')->name('position.update');
    Route::delete('position/delete', 'PositionController@delete')->name('position.delete');

    Route::get('nation', 'NationController@index')->name('nation.index');
    Route::get('nation/{id}/edit', 'NationController@edit')->name('nation.edit');
    Route::post('nation', 'NationController@store')->name('nation.store');
    Route::post('nation/{id}', 'NationController@update')->name('nation.update');
    Route::delete('nation/delete', 'NationController@delete')->name('nation.delete');

    Route::get('religion', 'ReligionController@index')->name('religion.index');
    Route::get('religion/{id}/edit', 'ReligionController@edit')->name('religion.edit');
    Route::post('religion', 'ReligionController@store')->name('religion.store');
    Route::post('religion/{id}', 'ReligionController@update')->name('religion.update');
    Route::delete('religion/delete', 'ReligionController@delete')->name('religion.delete');

    //Group
    Route::get('group', 'GroupController@index')->name('group.index');
    Route::get('group/create', 'GroupController@create')->name('group.create');
    Route::get('group/{uuid}/edit', 'GroupController@edit')->name('group.edit');
    Route::get('group/{uuid}', 'GroupController@show')->name('group.show');
    Route::post('group', 'GroupController@store')->name('group.store');
    Route::post('group/{uuid}', 'GroupController@update')->name('group.update');
    Route::delete('group/delete', 'GroupController@delete')->name('group.delete');

    //User
    Route::get('user', 'UserController@index')->name('user.index');
    Route::get('user/create', 'UserController@create')->name('user.create');
    Route::post('user', 'UserController@store')->name('user.store');
    Route::get('user/{uuid}/edit', 'UserController@edit')->name('user.edit');
    Route::post('user/{uuid}', 'UserController@update')->name('user.update');
    Route::delete('user/delete', 'UserController@delete')->name('user.delete');

    //user profile
    Route::get('profile', 'Auth\ProfileController@changePassword')->name('profile.edit');
    Route::post('profile', 'Auth\ProfileController@updatePassword')->name('profile.update');
});