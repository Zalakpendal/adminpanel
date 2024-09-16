<?php


use App\Http\Controllers\Calendar\CalendarController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\adminController;
use App\Http\Controllers\RestaurantType\RestaueanrtypeController;
use App\Http\Controllers\Restaurant\RestaurantsController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Menu\MenuController;
use App\Http\Controllers\Offer\OfferController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UserController;

// use App\Http\Controllers\mail\mailController;


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

// Route::group(['middleware'=> ['role:super-admin|admin']],function(){
Route::group(['middleware'=>['admin']],function(){


Route::resource('permission', PermissionController::class);
Route::get('permission/{permissionId}/delete', [PermissionController::class, 'destory']);


Route::resource('role', RoleController::class);
Route::get('role/{roleId}/delete', [RoleController::class, 'destory']);
// ->middleware('permission:delete role');
Route::get('role/{roleId}/give-permissions', [RoleController::class, 'addpermissionToRole']);
Route::put('role/{roleId}/give-permissions', [RoleController::class, 'givepermissionToRole']);


Route::resource('users', UserController::class);
Route::get('users/{userId}/delete', [UserController::class, 'destroy']);

});












Route::get('admin/login', [adminController::class, 'showForm'])->name('showForm');
Route::post('admin/login', [adminController::class, 'checklogin'])->name('login');


Route::group(['namespace' => 'Admin', 'middleware' => ['admin'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('dashbord', [adminController::class, 'dashbord'])->name('dashbord');
    Route::get('logout', [adminController::class, 'logout'])->name('logout');
    Route::resource('permission', PermissionController::class);
   // Web Routes
Route::get('editprofile', [UserController::class, 'editprofile'])->name('editprofile');
Route::post('updateprofile', [UserController::class, 'updateProfile'])->name('updateProfile');

    



    // Restaurant type module
    Route::group(['prefix' => 'Restaurant', 'as' => 'restaurant.'], function () {

        Route::get('/list', [RestaueanrtypeController::class, 'listingpage'])->name('list');
        Route::get('/add', [RestaueanrtypeController::class, 'create'])->name('add');
        Route::post('/add', [RestaueanrtypeController::class, 'addrestauranttypeform'])->name('add');
        Route::get('/delete/{id}', [RestaueanrtypeController::class, 'destroy'])->name('delete');
        Route::get('/editform/{id}', [RestaueanrtypeController::class, 'editform'])->name('editform');
        Route::post('/updatedata/{id}', [RestaueanrtypeController::class, 'updatedata'])->name('updatedata');
        Route::post('/restauranttype/toggleStatus/{id}', [RestaueanrtypeController::class, 'toggleStatus'])->name('toggleStatus');
        Route::get('admin/restauranttype/search', [RestaueanrtypeController::class, 'search'])->name('search');

    });

    //Restaurants module
    Route::group(['prefix' => 'myallrestaurants', 'as' => 'allrestaurants.'], function () {

        Route::get('/list', [RestaurantsController::class, 'listingpage'])->name('list');
        Route::get('/add', [RestaurantsController::class, 'addrestaurantform'])->name('add');
        Route::post('/insert', [RestaurantsController::class, 'insertdataofrestaurant'])->name('insert');
        Route::get('/delete/{id}', [RestaurantsController::class, 'destroy'])->name('delete');
        Route::get('/editform/{id}', [RestaurantsController::class, 'editform'])->name('editform');
        Route::post('/updatedata/{id}', [RestaurantsController::class, 'updatedata'])->name('updatedata');
        Route::post('/restaurant/toggleStatus/{id}', [RestaurantsController::class, 'toggleStatus'])->name('toggleStatus');
        Route::get('admin/restaurant/search', [RestaurantsController::class, 'search'])->name('search');
    });

    //category module
    Route::group(['prefix' => 'category', 'as' => 'categories.'], function () {

        Route::get('/list', [CategoryController::class, 'listingpage'])->name('list');
        Route::get('/add', [CategoryController::class, 'addcategoryform'])->name('add');
        Route::post('/insert', [CategoryController::class, 'insertdata'])->name('insert');
        Route::get('/delete/{id}', [CategoryController::class, 'destroy'])->name('delete');
        Route::get('/editform/{id}', [CategoryController::class, 'editform'])->name('editform');
        Route::post('/updatedata/{id}', [CategoryController::class, 'updatedata'])->name('updatedata');
        Route::post('/categories/toggleStatus/{id}', [CategoryController::class, 'toggleStatus'])->name('toggleStatus');
        Route::get('admin/categories/search', [CategoryController::class, 'search'])->name('search');
    });

    //menu 
    Route::group(['prefix' => 'menu', 'as' => 'menuofrestaurants.'], function () {

        Route::get('/list/{id}', [MenuController::class, 'showmenu'])->name('list');
        Route::get('/add/{id}', [MenuController::class, 'addmenuform'])->name('add');
        Route::post('/insert/{id}', [MenuController::class, 'insertmenu'])->name('insert');
        Route::get('/delete/{restaurant_id}/{menu_id}', [MenuController::class, 'deletemenu'])->name('delete');
        Route::get('/editform/{restaurant_id}/{menu_id}', [MenuController::class, 'editform'])->name('editform');
        Route::post('/updateform/{restaurant_id}/{menu_id}', [MenuController::class, 'updateform'])->name('updateform');
        Route::post('/menu/toggleStatus/{restaurant_id}/{menu_id}', [MenuController::class, 'toggleStatus'])->name('toggleStatus');
        Route::get('admin/restaurants/{id}/menu/search', [MenuController::class, 'search'])->name('search');

    });

    //offer
    Route::group(['prefix' => 'offer', 'as' => 'offersofrestaurants.'], function () {

        Route::get('/list', [OfferController::class, 'listingpage'])->name('list');
        Route::get('/add', [OfferController::class, 'addoffers'])->name('add');
        Route::post('/insert', [OfferController::class, 'store'])->name('store');
        Route::post('/changestatus/{offer_id}', [OfferController::class, 'changeStatus'])->name('changeStatus');
        Route::get('/delete/{offer_id}', [OfferController::class, 'delete'])->name('delete');
        Route::get('/editform/{offer_id}', [OfferController::class, 'editform'])->name('editform');
        Route::post('/update/{offer_id}', [OfferController::class, 'update'])->name('update');
        Route::get('/admin/offers/search', [OfferController::class, 'searchOffers'])->name('search');
    });

    Route::group(['prefix' => 'calendar', 'as' => 'calendar.'], function () {
    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar');
    Route::get('/calendar/add', [CalendarController::class, 'create'])->name('create');
    Route::post('/calendar/add', [CalendarController::class, 'store'])->name('store');
    Route::get('/list', [CalendarController::class, 'list'])->name('list');
    Route::get('/edit/{id}', [CalendarController::class, 'edit'])->name('edit');
    Route::post('/update/{id}', [CalendarController::class, 'update'])->name('update');
    Route::delete('/calendar/delete/{id}', [CalendarController::class, 'destroy'])->name('destroy');

    });
    
});













// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
