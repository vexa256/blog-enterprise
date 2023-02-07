<?php
/*
|--------------------------------------------------------------------------
| Buzzy Admin Routes
|--------------------------------------------------------------------------
*/


Route::get('/', 'DashboardController@index')->name('admin.dashboard');
Route::get('/reports/{type}', 'ReportsController@index');

Route::post('/handle-download', 'UpdateController@handle');

Route::get('plugins', 'PluginsController@show')->name('admin.plugins');
Route::post('activate-plugin', 'PluginsController@handleActivation')->name('admin.plugin.activate');

Route::get('themes/{theme}', 'ThemesController@settings')->name('admin.theme.settings');
Route::get('themes', 'ThemesController@show')->name('admin.themes');
Route::post('activate-theme', 'ThemesController@handleActivation')->name('admin.theme.activate');

Route::post('add-new-category', 'CategoriesController@addnew');
Route::get('categories/{category}/delete', 'CategoriesController@delete')->name('admin.category.delete');
Route::get('categories', 'CategoriesController@index')->name('admin.categories');
Route::get('test-mail-config', 'ConfigController@check_mail');
Route::get('config', 'ConfigController@index')->name('admin.configs');
Route::post('config', 'ConfigController@setconfig');

Route::get('tools', 'ToolsController@index')->name('admin.tools');
Route::get('removeTmpFolder', 'ToolsController@removeTmpFolder');

Route::get('posts-action', 'PostsController@bulkAction');
Route::get('posts-data', 'PostsController@getTableData');
Route::get('posts', 'PostsController@index')->name('admin.posts');

Route::get('comments-reports', 'CommentController@getCommentReportsModal');
Route::get('comments-action', 'CommentController@bulkAction');
Route::get('comments-data', 'CommentController@getTableData');
Route::get('comments', 'CommentController@index')->name('admin.comments');

Route::get('users-data', 'UserController@getTableData');
Route::get('users', 'UserController@users')->name('admin.users');

Route::get('pages/{page}/delete', 'PagesController@delete')->name('admin.pages.delete');
Route::post('pages', 'PagesController@store');
Route::get('pages', 'PagesController@index')->name('admin.pages');

Route::post('widgets/addwidget', 'WidgetsController@addnew');
Route::get('widgets/delete/{id}', 'WidgetsController@delete');
Route::get('widgets', 'WidgetsController@index')->name('admin.widgets');

Route::post('reactions/addnew', 'ReactionController@addnew');
Route::get('reactions/{id}/delete', 'ReactionController@delete');
Route::get('reactions', 'ReactionController@index')->name('admin.reactions');

Route::prefix('mailbox')->group(
    function () {
        Route::post('getmails', 'ContactController@getdata');
        Route::post('newmailsent', 'ContactController@newmailsent');
        Route::post('doaction', 'ContactController@doaction');
        Route::post('dostar', 'ContactController@dostar');
        Route::post('doimportant', 'ContactController@doimportant');
        Route::post('addcat', 'ContactController@addcat');

        Route::get('new', 'ContactController@newmail')->name('admin.mailbox.new');
        Route::get('mailcatdelete/{id}', 'ContactController@mailcatdelete');
        Route::get('maillabeldelete/{id}', 'ContactController@maillabeldelete');
        Route::get('read/{id}', 'ContactController@read')->name('admin.mailbox.read');
        Route::get('{type?}', 'ContactController@index')->name('admin.mailbox');
    }
);

Route::prefix('menus')->group(
    function () {
        Route::get('{menu}', 'MenuController@show')->name('admin.menu.show');
        Route::get('/', 'MenuController@index')->name('admin.menus');
        Route::get('menu/builder/{id}', 'MenuItemController@showMenuItems')->name('menu.builder');

        // Helpers Route
        Route::get('assets', 'MenuController@assets')->name('menu.asset');

        // Menus
        Route::get('getMenus', 'MenuController@getMenus');
        Route::post('menu', 'MenuController@store');
        Route::post('menu/sort', 'MenuController@sort');
        Route::put('menu', 'MenuController@update');
        Route::get('menu/delete/{id}', 'MenuController@destroy');

        // Menu Items
        Route::get('menu/items/{menu_id}', 'MenuItemController@getMenuItems');
        Route::get('menu/{menu_id}/item/{id}', 'MenuItemController@getMenuItem');
        Route::post('menu/item/sort', 'MenuItemController@sort');
        Route::post('menu/item', 'MenuItemController@store');
        Route::post('category-menu/item', 'MenuItemController@storeFromCategory');
        Route::put('menu/item', 'MenuItemController@update');
        Route::get('/menu/item/{id}', 'MenuItemController@destroy');
    }
);

Route::prefix('feeds')->group(
    function () {
        Route::get('{id}', 'FeedController@show');
        Route::get('/', 'FeedController@index')->name('admin.feeds');
        Route::post('/feed', 'FeedController@store');
        Route::put('/feed', 'FeedController@update');
        Route::get('delete/{id}', 'FeedController@destroy');
    }
);

Route::prefix('translations')->group(
    function () {
        Route::post('sort', 'TranslationController@sort');
        Route::get('{locale}/lock', 'TranslationController@lock');
        Route::get('{locale}/send', 'TranslationController@send');
        Route::post('{locale}', 'TranslationController@update');
        Route::get('{locale?}', 'TranslationController@index')->name('admin.translations');
    }
);
