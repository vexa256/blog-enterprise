<?php

use Illuminate\Support\Facades\Route;

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

// Social Auth
Route::get('auth/social/{type}', 'Auth\SocialAuthController@socialConnect');
Route::get('auth/social/{type}/callback', 'Auth\SocialAuthController@socialCallback');
// Login Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
// Logout Routes...
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');
// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
// Password Confirmation Routes...
Route::get('password/confirm', 'Auth\ConfirmPasswordController@showConfirmForm')->name('password.confirm');
Route::post('password/confirm', 'Auth\ConfirmPasswordController@confirm');
// Email Verification Routes...
Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
Route::get('email/verify/{id}/{hash}', 'Auth\VerificationController@verify')->name('verification.verify');
Route::post('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');

// Misc
Route::get('sitemap.xml', 'RssController@index')->name('sitemap');
Route::get('{type}.xml', 'RssController@index')->name('feed');
Route::get('fbinstant.rss', 'RssController@fbinstant')->name('fbinstant');
Route::get('{type}.json', 'RssController@json')->name('feed-json');
Route::get('select-language/{locale}', 'LanguageController')->name('select-language');

// Contact
Route::post('contact', 'ContactController@create');
Route::get('contact', 'ContactController@index');

// Amp
Route::get('amp/{catname}/{slug}', 'AmpController@post');
Route::get('amp', 'AmpController@index');

// User Profile
Route::get('profile/{user:username_slug}', 'UserController@index')->name('user.profile');

Route::middleware('auth')->prefix('profile/{user:username_slug}')->group(
    function () {
        Route::get('messages/create', 'UserMessageController@create');
        Route::get('messages/{id}/read', 'UserMessageController@read');
        Route::get('messages/{id}/unread', 'UserMessageController@unread');
        Route::get('messages/{id}', 'UserMessageController@show')->name('user.message.show');
        Route::get('messages/{id}/action', 'UserMessageController@action');
        Route::put('messages/{id}', 'UserMessageController@update');
        Route::post('messages', 'UserMessageController@store');
        Route::get('messages', 'UserMessageController@index')->name('user.messages');

        Route::post('settings', 'UserController@updatesettings')->name('user.settings.update');
        Route::post('follow', 'UserController@follow')->name('user.follow');
        Route::get('settings', 'UserController@settings')->name('user.settings');
        Route::get('following', 'UserController@following')->name('user.following');
        Route::get('followers', 'UserController@followers')->name('user.followers');
        Route::get('feed', 'UserController@followfeed')->name('user.feed');
        Route::get('draft', 'UserController@draftposts')->name('user.draftposts');
        Route::get('trash', 'UserController@deletedposts')->name('user.trashpost');
    }
);

// Comments
// easyComment uses the comments prefix
Route::prefix('api/comments')->group(
    function () {
        Route::post('{id}/report', 'CommentController@report');
        Route::post('{id}/vote', 'CommentController@vote');
        Route::get('{id}/replies', 'CommentController@replies');
        Route::delete('{id}', 'CommentController@destroy');
        Route::put('{id}', 'CommentController@update');
        Route::get('{id}', 'CommentController@show');
        Route::post('/', 'CommentController@store');
        Route::get('/', 'CommentController@index')->name('comments');
    }
);

// Frontend Posting
Route::post('upload-a-image',  'UploadController@newUpload')->name('upload_image_request');
Route::post('fetch-video',  'FormController@fetchVideoEmbed')->name('fetch_video_request');
Route::get('addnewform',  'FormController@addnewform')->name('post.new-entry-form');
Route::post('create',  'PostEditorController@createPost')->name('post.save');
Route::get('create',  'PostEditorController@showPostCreate')->name('post.create');
Route::post('edit/{post_id}',  'PostEditorController@editPost')->name('post.update');
Route::get('edit/{post_id}',  'PostEditorController@showPostEdit')->name('post.edit');
Route::get('delete/{post_id}',  'PostEditorController@deletePost')->name('post.delete');

Route::get('get_content_data',  'FormController@get_content_data');
Route::post('post-share', 'ShareController')->name('post.share');

// Search
Route::get('search-users', 'SearchController@searchUsers');
Route::get('search',  'SearchController@index')->name('search');

// Tags
Route::post('tags',  'TagController@search')->name('tag.search');
Route::get('tag/{tag}',  'TagController@show')->name('tag.show');

// Reactions
Route::post('reactions/{reactionIcon:reaction_type}/{post}', 'ReactionController@vote')->name('reaction.vote');
Route::get('reactions/{reactionIcon:reaction_type}', 'ReactionController@show')->name('reaction.show');

// Polls
Route::post('poll/{entry}/{answer}', 'PollController@vote')->name('poll.vote');

// Pages
Route::get('pages/{page:slug}', 'PageController')->name('page.show');

// Posts
Route::get('autoload',  'PostController@autoload')->name('post.autoload');
Route::get('{catname}/{slug}', 'PostController@index')->name('post.show');

// Categories
Route::get('{catname}', 'CategoryController')->name('category.show');

// Home
Route::get('/', 'IndexController')->name("home");

// Catch all
Route::any('{any}', function ($any) {
    abort(404);
})->where('any', '.*');
