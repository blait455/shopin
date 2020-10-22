<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\profileController;
use App\Http\Controllers\commentController;
use App\Http\Controllers\postController;
use App\Http\Controllers\photoController;
use App\Http\Controllers\followersController;
use App\Http\Controllers\likeController;
use App\Http\Controllers\usersController;
use App\Http\Controllers\AutoCompleteController;
use App\Http\Controllers\messageController;
use App\Http\Controllers\adminController;


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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {

	//commentting resource
	Route::prefix('post')->group(function () {
		Route::resource('comment', commentController::class);
    });
    
	//home page
    Route::get('/', [HomeController::class, 'home']);
    
	//profile and post resources
	Route::resource('profile', profileController::class);
    Route::resource('post', postController::class);
    
	//home page(index)
    Route::get('/home', [HomeController::class, 'home'])->name('home');

	//profile setting,photos,followers,followings 
	Route::get('/setting', [profileController::class, 'show'])->name('psetting');
	Route::get('/photos', [photoController::class, 'index'])->name('pphotos');
	Route::get('/followers', [followersController::class, 'index'])->name('pfollowers');
    Route::get('/followings', [followersController::class, 'followings'])->name('pfollowings');
    
	//block , unblock a user
	Route::Post('blockuser/{id}', [followersController::class, 'blockUser']);
	Route::get('/unblockuser/{id}', [followersController::class, 'unblockUser']);

	//delete profile photos
    Route::delete('photo/delete/{id}', [photoController::class, 'destroy']);
    
	//share, like posts
	Route::Post('/share/{id}', [postController::class, 'share'])->name('sharepost');
    Route::post('like/store', [likeController::class, 'store']);   
    
	//getting likers
	Route::get('post/likers/{id}', [likeController::class, 'likers']);
    
    //follow, unfollow user
	Route::Post('/follow/store', [followersController::class, 'follow']);
	Route::Post('/unfollow/{id}', [followersController::class, 'unfollow']);
    
    //User home page, photos
	Route::get('/user/{id}', [usersController::class, 'index']);
	Route::get('/user/{id}/photos', [usersController::class, 'showphotos']);
    
    //ajax user search (header)
	Route::get('autocomplete',array('as'=>'autocomplete','uses'=>[AutoCompleteController::class, 'index']));
	Route::get('searchajax',array('as'=>'searchajax','uses'=>[AutoCompleteController::class, 'autoComplete']));
	Route::get('search', [profileController::class, 'search']);
    
    //chatting,store, getchats
	Route::Post('chatting/{id}', [messageController::class, 'store']);
	Route::get('chatting', [messageController::class, 'index']);
	Route::get('chatting/{id}', [messageController::class, 'getChats']);
    
    //logout user
	Route::get('logout',function(){
		Auth::logout();
		return view('auth.login');
	});

	//simple serach!!
	Route::get('search', [profileController::class, 'search']);

});

	Route::get('/admin/login', [adminController::class, 'login']);
	Route::get('/admin', [adminController::class, 'index']);
	Route::get('admin/records/users', [adminController::class, 'userRecords']);
	Route::get('admin/records/posts', [adminController::class, 'postRecords']);
	Route::get('/Impersonate/user/{id}', [adminController::class, 'impersonate']);
	Route::get('/stopImpersonate', [adminController::class, 'stopimpersonate']);
	Route::get('/admin/delete/user/{id}', [adminController::class, 'deleteaccount']);
	Route::get('/admin/delete/post/{id}', [adminController::class, 'deletePost']);
	Route::get('/admin/showpost/{id}', [adminController::class, 'showPost']);
	Route::get('/admin/user/search', [adminController::class, 'userSearch']);
	Route::get('/admin/logout',function(){
        Auth::logout();
        return view('admin.login');
	});

//!!!	
Route::get('sign-in',function (){
	return view('auth.sign-in');
});

Route::get('/welcome',function(){
	return view('welcome');
});

Route::get('Cnotification',function(){
	$notifications = Auth::user()->unreadnotifications->count();
	return $notifications;
});

