<?php

use Illuminate\Support\Facades\Route;

//root
Route::get('/', function () {
    return view('auth.login');
});

// Auth Routes
//Auth::routes(['register' => false]);
Auth::routes();

//Auth Middleware grouping
Route::middleware(['auth'])->group(function () {


    Route::get('/home', 'HomeController@index')->name('home');


    // invoices
    Route::resource('invoices','InvoiceController');
    Route::get('invoices/create/section-products/{id}','InvoiceController@getSectionProducts')->name('getSectionProducts');

    // sections
    Route::resource('sections','SectionController');

    // products
    Route::resource('products','ProductController');



    Route::get('/InvoicesDetails/{id}', 'InvoiceDetailController@edit');

    Route::get('download/{invoice_number}/{file_name}', 'InvoiceDetailController@get_file');

    Route::get('View_file/{invoice_number}/{file_name}', 'InvoiceDetailController@open_file');

    Route::post('delete_file', 'InvoiceDetailController@destroy')->name('delete_file');

    Route::get('/edit_invoice/{id}', 'InvoiceController@edit');

    Route::get('/Status_show/{id}', 'InvoiceController@show')->name('Status_show');

    Route::post('/Status_Update/{id}', 'InvoiceController@Status_Update')->name('Status_Update');

    Route::resource('Archive', 'InvoiceArchiveController');

    Route::get('Invoice_Paid','InvoiceController@Invoice_Paid');

    Route::get('Invoice_UnPaid','InvoiceController@Invoice_UnPaid');

    Route::get('Invoice_Partial','InvoiceController@Invoice_Partial');

    Route::get('Print_invoice/{id}','InvoiceController@Print_invoice');

    Route::get('export_invoices', 'InvoiceController@export');

    //spatie
    Route::resource('roles','RoleController');
    Route::resource('users','UserController');

    //Reports
    Route::get('invoices_report', 'InvoiceReport@index');
    Route::post('Search_invoices', 'InvoiceReport@Search_invoices');

    Route::get('customers_report', 'CustomerReport@index')->name("customers_report");
    Route::post('Search_customers', 'CustomerReport@Search_customers');


    Route::get('MarkAsRead_all','InvoiceController@MarkAsRead_all')->name('MarkAsRead_all');

    Route::get('unreadNotifications_count', 'InvoiceController@unreadNotifications_count')->name('unreadNotifications_count');

    Route::get('unreadNotifications', 'InvoiceController@unreadNotifications')->name('unreadNotifications');


    Route::get('/{page}', 'AdminController@index');

});
//home

//Route::get('/{page}', 'AdminController@index');


