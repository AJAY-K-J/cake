<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::namespace('Api')->group( function() {
    Route::post('Login', 'LoginController@login');

    Route::middleware('auth:api')->group( function() {
        Route::post('CreateBooking', 'APIController@create_booking');
        Route::post('CreateThankyou', 'APIController@create_thankyou');
                Route::post('MarkCompleted', 'APIController@mark_completed');
                Route::post('MarkDelivered', 'APIController@mark_delivered');
                Route::post('dashboard', 'APIController@dashboard');
                Route::post('PendingBookingLists', 'APIController@pending_booking_lists');
                Route::post('PendingDeliveryLists', 'APIController@pending_delivery_lists');
                Route::post('DeliveryLists', 'APIController@delivery_lists');
                        Route::post('CollectionReport', 'APIController@collection_report');
                        Route::post('DeleteBooking', 'APIController@delete_booking');
                        Route::post('FindCustomer', 'APIController@find_customer');

                        Route::post('AddService', 'APIController@add_service');
                        Route::post('ListServices', 'APIController@list_services');
                        Route::post('EditService', 'APIController@edit_service');
                        Route::post('DeleteService', 'APIController@delete_service');
                        
                        Route::post('ListExpenseCategories', 'APIController@list_expensecategories');
                       Route::post('MarkCreditDelivered', 'APIController@mark_creditdelivered');
                       Route::post('AddExpense', 'APIController@add_expense');
                        Route::post('ListMakes', 'APIController@list_makes');
                        Route::post('FindModel', 'APIController@find_model_by_make');
                      Route::post('Logout', 'APIController@logout');

       
    });
});
