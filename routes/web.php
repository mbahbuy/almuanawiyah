<?php

use Illuminate\Support\Facades\{Route, Auth};

// Halaman Home
Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);

// Halaman Blog Posts
Route::get('/blogposts', ['as' => 'blogposts', 'uses' => 'HomeController@blogposts'] );

// Halaman Single Post
Route::get('/blogposts/{post:slug}', ['as' => 'blogpost', 'uses' => 'HomeController@blogpost'] );

// Halaman Courses
Route::get('/courses', ['as' => 'courseshome', 'uses' => 'HomeController@courseshome']);
Route::get('/courses/{courses:slug}', ['as' => 'homecourses', 'uses' => 'HomeController@courses']);

Route::post('/pendaftaranppdb', ['as' => 'pendaftaranppdb', 'uses' => 'PpdbController@store']);

Route::post('/contact-us', ['as' => 'contact.us.store', 'uses' => 'ContactController@store']);

Auth::routes(['verify' => true]);

Route::group(['middleware' => 'auth'], function () {
    Route::get('/profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);

	Route::group(['middleware'=> 'verified'], function () {
		Route::put('/profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
		Route::put('/profile/password', ['as'=> 'profile.password', 'uses' => 'ProfileController@password']);
	});
	
	Route::group(['middleware' => 'editor'], function () {
		Route::resource('/post', 'PostController');
	});
	
	Route::group(['middleware' => 'admin'], function(){
		Route::get('/ppdb', ['as' => 'ppdb.index', 'uses' => 'PpdbController@index']);

		Route::resource('/information', 'InformationController')->only(['index','store', 'destroy']);
		Route::post('/information/switch', ['as' => 'information.switch', 'uses' => 'InformationController@switch']);

		Route::resource('/categories', 'CategoryController')->except('show');

		Route::resource('/users', 'UsersController')->except('show');
		Route::put('/users/{user:username}/mEditor', ['as' => 'users.mEditor', 'uses' => 'UsersController@mEditor']);
		Route::put('/users/{user:username}/mAdmin', ['as' => 'users.mAdmin', 'uses' => 'UsersController@mAdmin']);

		Route::get('/allposts', ['as' => 'allposts.index', 'uses' => 'AllPostsController@index']);
		Route::get('/allposts/{post:slug}', ['as' => 'allposts.show', 'uses' => 'AllPostsController@show']);
		Route::delete('/allposts/{post:slug}', ['as' => 'allposts.destroy', 'uses' => 'AllPostsController@destroy']);

		Route::get('/views', ['as' => 'views', 'uses' => 'ViewsController@index']);
		Route::get('/views/main', ['as' => 'mainview', 'uses' => 'ViewsController@MainView']);
		Route::get('/views/home', ['as' => 'homeview', 'uses' => 'ViewsController@HomeView']);
		Route::get('/views/about', ['as' => 'aboutview', 'uses' => 'ViewsController@AboutView']);
		Route::get('/views/coursestitle', ['as' => 'coursesview', 'uses' => 'ViewsController@CoursesView']);
		Route::get('/views/why', ['as' => 'whyview', 'uses' => 'ViewsController@WhyView']);
		Route::get('/views/why/alasan', ['as' => 'alasanview', 'uses' => 'ViewsController@alasanView']);
		Route::get('/views/video', ['as' => 'videoview', 'uses' => 'ViewsController@VideoView']);
		Route::get('/views/contact', ['as' => 'contactview', 'uses' => 'ViewsController@ContactView']);
		Route::get('/views/blog', ['as' => 'blogview', 'uses' => 'ViewsController@BlogView']);
		Route::get('/views/ppdb', ['as' => 'ppdbview', 'uses' => 'ViewsController@ppdbView']);

		Route::post('/views/main',['as' => 'main.store', 'uses' => 'ViewsController@MainStore']);
		Route::put('/views/main/{views}',['as' => 'main.update', 'uses' => 'ViewsController@MainUpdate']);

		Route::post('/views/blog',['as' => 'blog.store', 'uses' => 'ViewsController@BlogStore']);
		Route::put('/views/blog/{views}',['as' => 'blog.update', 'uses' => 'ViewsController@BlogUpdate']);

		Route::post('/views/home',['as' => 'home.store', 'uses' => 'ViewsController@HomeStore']);
		Route::put('/views/home',['as' => 'home.update', 'uses' => 'ViewsController@HomeUpdate']);

		Route::post('/views/about',['as' => 'about.store', 'uses' => 'ViewsController@AboutStore']);
		Route::put('/views/about',['as' => 'about.update', 'uses' => 'ViewsController@AboutUpdate']);

		Route::post('/views/coursestitle',['as' => 'coursesTitle.store', 'uses' => 'ViewsController@CoursesStore']);
		Route::put('/views/coursestitle',['as' => 'coursesTitle.update', 'uses' => 'ViewsController@CoursesUpdate']);

		Route::post('/views/why',['as' => 'why.store', 'uses' => 'ViewsController@WhyStore']);
		Route::put('/views/why',['as' => 'why.update', 'uses' => 'ViewsController@WhyUpdate']);

		Route::post('/views/video',['as' => 'video.store', 'uses' => 'ViewsController@VideoStore']);
		Route::put('/views/video',['as' => 'video.update', 'uses' => 'ViewsController@VideoUpdate']);

		Route::post('/views/contact',['as' => 'contact.store', 'uses' => 'ViewsController@ContactStore']);
		Route::put('/views/contact',['as' => 'contact.update', 'uses' => 'ViewsController@ContactUpdate']);

		Route::post('/views/ppdb',['as' => 'ppdb.store', 'uses' => 'ViewsController@ppdbStore']);
		Route::put('/views/ppdb',['as' => 'ppdb.update', 'uses' => 'ViewsController@ppdbUpdate']);

		Route::resource('setting', 'SettingController')->except(['show', 'create', 'edit', 'destroy']);
		Route::get('/setting/footer/create', ['as' => 'footer.create', 'uses' => 'SettingController@createFooter']);
		Route::post('/setting/footer', ['as' => 'footer.store', 'uses' => 'SettingController@storeFooter']);
		Route::get('/setting/footer/{setting}/edit', ['as' => 'footer.edit', 'uses' => 'SettingController@editFooter']);
		Route::put('/setting/footer/{setting}', ['as' => 'footer.update', 'uses' => 'SettingController@updateFooter']);
		Route::delete('/setting/footer/{setting}', ['as' => 'footer.destroy', 'uses' => 'SettingController@destroyFooter']);

		Route::get('/views/courses', ['as' => 'courses.index', 'uses' => 'CoursesController@index']);
		Route::get('/views/courses/create', ['as' => 'courses.create', 'uses' => 'CoursesController@create']);
		Route::post('/views/courses', ['as' => 'courses.store', 'uses' => 'CoursesController@store']);
		Route::get('/views/courses/{courses}/edit', ['as' => 'courses.edit', 'uses' => 'CoursesController@edit']);
		Route::put('/views/courses/{courses}/update', ['as' => 'courses.update', 'uses' => 'CoursesController@update']);
		Route::delete('/views/courses/{courses}', ['as' => 'courses.destroy', 'uses' => 'CoursesController@destroy']);

		Route::get('/views/why/alasan/create', ['as' => 'alasan.create', 'uses' => 'ViewsController@alasanCreate']);
		Route::post('/views/why/alasan', ['as' => 'alasan.store', 'uses' => 'ViewsController@alasanStore']);
		Route::get('/views/why/alasan/{views}/edit', ['as' => 'alasan.edit', 'uses' => 'ViewsController@alasanEdit']);
		Route::put('/views/why/alasan/{views}/update', ['as' => 'alasan.update', 'uses' => 'ViewsController@alasanUpdate']);
		Route::delete('/views/why/alasan/{views}', ['as' => 'alasan.destroy', 'uses' => 'ViewsController@alasanDestroy']);

	});

	Route::get('/checkSlug', ['as' => 'checkslug', 'uses' => 'CheckslugController']);
});