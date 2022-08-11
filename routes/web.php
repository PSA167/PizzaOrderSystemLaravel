<?php

use App\Http\Middleware\AdminCheckMiddleware;
use App\Http\Middleware\UserCheckMiddleware;
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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        if (Auth::check()) {
            if (Auth::user()->role == 'admin') {
                return redirect()->route('admin#profile');
            } elseif (Auth::user()->role == 'user') {
                return redirect()->route('user#index');
            }
        }
    })->name('dashboard');
});

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => [AdminCheckMiddleware::class]], function () {
    Route::get('profile', 'AdminController@profile')->name('admin#profile');
    Route::post('updateProfile/{id}', 'AdminController@updateProfile')->name('admin#updateProfile');
    Route::get('changePasswordPage', 'AdminController@changePasswordPage')->name('admin#changePasswordPage');
    Route::post('changePassword', 'AdminController@changePassword')->name('admin#changePassword');

    Route::get('category', 'CategoryController@category')->name('admin#category');
    Route::get('addCategory', 'CategoryController@addCategory')->name('admin#addCategory');
    Route::post('createCategory', 'CategoryController@createCategory')->name('admin#createCategory');
    Route::get('deleteCategory/{id}', 'CategoryController@deleteCategory')->name('admin#deleteCategory');
    Route::get('editCategory/{id}', 'CategoryController@editCategory')->name('admin#editCategory');
    Route::post('updateCategory', 'CategoryController@updateCategory')->name('admin#updateCategory');
    Route::get('searchCategory', 'CategoryController@searchCategory')->name('admin#searchCategory');
    Route::get('categoryItem/{id}', 'CategoryController@categoryItem')->name('admin#categoryItem');
    Route::get('category/download', 'CategoryController@categoryDownload')->name('admin#categoryDownload');

    Route::get('pizza', 'PizzaController@pizza')->name('admin#pizza');
    Route::get('createPizza', 'PizzaController@createPizza')->name('admin#createPizza');
    Route::post('insertPizza', 'PizzaController@insertPizza')->name('admin#insertPizza');
    Route::get('deletePizza/{id}', 'PizzaController@deletePizza')->name('admin#deletePizza');
    Route::get('infoPizza/{id}', 'PizzaController@infoPizza')->name('admin#infoPizza');
    Route::get('editPizza/{id}', 'PizzaController@editPizza')->name('admin#editPizza');
    Route::post('updatePizza/{id}', 'PizzaController@updatePizza')->name('admin#updatePizza');
    Route::get('searchPizza', 'PizzaController@searchPizza')->name('admin#searchPizza');
    Route::get('pizza/download', 'PizzaController@pizzaDownload')->name('admin#pizzaDownload');

    Route::get('userList', 'UserController@userList')->name('admin#userList');
    Route::get('adminList', 'UserController@adminList')->name('admin#adminList');
    Route::get('userList/search', 'UserController@userSearch')->name('admin#userSearch');
    Route::get('adminList/search', 'UserController@adminSearch')->name('admin#adminSearch');
    Route::get('userDelete/{id}', 'UserController@userDelete')->name('admin#userDelete');
    Route::get('user/download', 'UserController@userDownload')->name('admin#userDownload');
    Route::get('admin/download', 'UserController@adminDownload')->name('admin#adminDownload');
    Route::get('user/edit/{id}', 'UserController@userEdit')->name('admin#userEdit');
    Route::post('user/edit/changerole', 'UserController@userChangeRole')->name('admin#userChangeRole');

    Route::get('contactList', 'ContactController@contactList')->name('admin#contactList');
    Route::get('searchContact', 'ContactController@searchContact')->name('admin#searchContact');
    Route::get('contact/download', 'ContactController@contactDownload')->name('admin#contactDownload');

    Route::get('order/list', 'OrderController@orderList')->name('admin#orderList');
    Route::get('order/Search', 'OrderController@orderSearch')->name('admin#orderSearch');
    Route::get('order/download', 'OrderController@orderDownload')->name('admin#orderDownload');

});

Route::group(['prefix' => 'user', 'middleware' => [UserCheckMiddleware::class]], function () {
    Route::get('/', 'UserController@index')->name('user#index');

    Route::get('category/search/{id}', 'UserController@categorySearch')->name('user#categorySearch');
    Route::get('searchItem', 'UserController@searchItem')->name('user#searchItem');
    Route::get('searchByDatePrice', 'UserController@searchByDatePrice')->name('user#searchByDatePrice');

    Route::get('pizza/details/{id}', 'UserController@pizzaDetails')->name('user#pizzaDetails');

    Route::post('contact/create', 'Admin\ContactController@createContact')->name('user#createContact');

    Route::get('orderPage', 'UserController@orderPage')->name('user#orderPage');
    Route::post('orderCreate', 'UserController@orderCreate')->name('user#orderCreate');

});
