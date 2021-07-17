<?php


Route::get('/t','TestController@test');

Route::get('login','LoginController@index')->name('login');
Route::post('login','LoginController@login');
Route::get('test','TestController@index');
Route::get('home','TestController@homeindex');

Route::get('logout','LoginController@logout')->name('logout');

Route::group(['middleware' => 'auth'], function() {
	Route::get('/','LoginController@redirecter')->name('home');
	Route::get('download_voucher/{filename}','Admin\CampaignController@download_voucher');
    Route::post('change-password','LoginController@change_password');

    

    Route::group(['middleware' => 'Admin','namespace' => 'Admin'], function() {
    		Route::get('admin','AdminController@index')->name('admin.home');
            Route::get('customers','CustomerController@index')->name('customers');
        
 
            
            Route::get('campaigns','CampaignController@index')->name('campaigns');

            Route::post('add_campaign','CampaignController@add_campaign');
            Route::get('get_campaigns','CampaignController@get_campaigns');
            Route::post('delete_campaign','CampaignController@delete_campaign');
            Route::post('campaigns/import_customers','CampaignController@import_customers');
            Route::get('campaigns/download_customers/{id}','CampaignController@download_customers');

            Route::get('bookings','BookingController@index')->name('bookings');
            Route::post('add_booking','BookingController@add_booking');
            Route::post('mark_completed','BookingController@mark_completed');
            

            Route::post('mark_creditdelivered','BookingController@mark_creditdelivered');
            Route::post('mark_delivered','BookingController@mark_delivered');


            // Route::post('find_customer','BookingController@find_customer');
            Route::get('get_bookings','BookingController@get_bookings');
            Route::post('delete_booking','BookingController@delete_booking');


            Route::get('jobcards','JobcardController@index')->name('jobcards');
            Route::post('add_jobcard','JobcardController@add_jobcard');
            Route::get('get_jobcards','JobcardController@get_jobcards');
            Route::post('delete_jobcard','JobcardController@delete_jobcard');
            Route::post('delete_image','JobcardController@delete_image');
            Route::post('upload_image','JobcardController@upload_image');
            Route::post('jobcard/get_images','JobcardController@get_images');
            Route::get('print_jobcard/{id}','JobcardController@print_jobcard');
            Route::get('print_bill/{id}','JobcardController@print_bill');
            Route::get('find_jobcard/{id}','JobcardController@find_jobcard');
          Route::post('add_technician','JobcardController@add_technician');
           Route::post('add_followup','JobcardController@add_followup');


          Route::post('mark_received','JobcardController@receive_technician');
          Route::post('mark_holded','JobcardController@mark_holded');
          Route::post('mark_return','JobcardController@mark_return');
          Route::post('mark_returnback','JobcardController@mark_returnback');
          Route::post('release_hold','JobcardController@release_hold');
          Route::get('return_delivered/{id}','JobcardController@return_delivered');
          Route::post('return_delivered_from_jobcard','JobcardController@return_delivered_from_jobcard');
          Route::post('add_list','JobcardController@add_list');
           Route::post('add_adminlist','JobcardController@add_adminlist');

          Route::post('mark_jobcardcompleted','JobcardController@mark_jobcardcompleted');
          Route::post('mark_jobcarddelivered','JobcardController@mark_jobcarddelivered');
          Route::post('mark_adminjobcarddelivered','JobcardController@mark_adminjobcarddelivered');
          Route::post('mark_adminjobcardcreditdelivered','JobcardController@mark_adminjobcardcreditdelivered');
          Route::post('mark_jobcardcreditdelivered','JobcardController@mark_jobcardcreditdelivered');
        Route::post('jobcard/send-otp','JobcardController@send_otp');
        Route::post('jobcard/verify-otp','JobcardController@verify_otp');
          
          Route::get('get_designations','DesignationController@get_designations');

            Route::get('users','UserController@index')->name('users');
            Route::post('add_user','UserController@save');
            Route::get('get_users','UserController@get_users');
            Route::post('delete_user','UserController@delete_user');

             Route::get('products','ProductController@index')->name('products');
            Route::post('add_product','ProductController@save');
            Route::get('get_products','ProductController@get_products');
            Route::post('delete_product','ProductController@delete_product');
            Route::post('get_rate_by_product','ProductController@get_rate_by_product');

            Route::get('services','ServiceController@index')->name('services');
            Route::post('add_service','ServiceController@save');
            Route::get('get_services','ServiceController@get_services');
            Route::post('delete_service','ServiceController@delete_service');

            Route::get('expensecategories','ExpenseCategoryController@index')->name('expensecategories');
            Route::post('add_expensecategory','ExpenseCategoryController@save');
            Route::get('get_expensecategories','ExpenseCategoryController@get_expensecategories');
            Route::post('delete_expensecategory','ExpenseCategoryController@delete_expensecategory');


            Route::get('students','StudentController@index')->name('students');
            Route::post('add_student','StudentController@save');
            Route::get('get_students','StudentController@get_students');
            Route::post('delete_student','StudentController@delete_student');

           //vendors
            Route::get('vendors','PurchaseVendorController@index')->name('vendors');
            Route::post('add_vendor','PurchaseVendorController@save');
            Route::get('get_vendors','PurchaseVendorController@get_vendors');
            Route::post('delete_vendor','PurchaseVendorController@delete_vendor');

            Route::get('makes','VehicleMakeController@index')->name('makes');
            Route::post('add_make','VehicleMakeController@save');
            Route::get('get_makes','VehicleMakeController@get_makes');
            Route::post('delete_make','VehicleMakeController@delete_make');

            Route::get('sales','SaleController@index')->name('sales');
            Route::get('get_todaysales','SaleController@get_todaysales');
            Route::post('add_sale','SaleController@save');
            Route::get('get_sales','SaleController@get_sales');
            Route::post('delete_sale','SaleController@delete_sale');
            Route::get('print_sale/{id}','SaleController@print_sale');


             Route::get('pay_balance_receipts','SaleController@pay_balance_receipts')->name('pay_balance_receipts');

             Route::get('get_paybalance_receipt','SaleController@ReceiptPayBalanceReport');



            Route::get('sale_order','SalesOrderController@index')->name('sale_order');
            Route::get('get_today_orders','SalesOrderController@get_today_orders');
            Route::post('add_sale_order','SalesOrderController@save');
            Route::post('delete_sale_order','SalesOrderController@delete_sale_order');
            Route::get('print_sale_order/{id}','SalesOrderController@print_sale_order');

            


            Route::get('invoices','InvoiceController@index')->name('invoices');
            Route::get('/get_todayinvoices','InvoiceController@get_todayinvoices');
            Route::post('add_invoice','InvoiceController@save');
            Route::post('delete_invoice','InvoiceController@delete_invoice');
            Route::get('print_invoice/{id}','InvoiceController@print_invoice');
            
            Route::get('pay_balance_invoices','InvoiceController@pay_balance_invoices')->name('pay_balance_invoices');

             Route::get('get_paybalance_invoice','InvoiceController@InvoicePayBalanceReport');

             Route::post('find_customer','InvoiceController@find_customer');
           
            //closing
             Route::get('closing','ClosingController@index')->name('closing');
            Route::post('add_opening','ClosingController@addOpening')->name('add_opening');
            Route::post('close_acc','ClosingController@closeAcc');
            Route::get('get_opening','ClosingController@getOpening');
            Route::get('find_closing/{date}','ClosingController@find_closing');

            //today report
            Route::get('/today/report','ReportController@today_report')->name('today-report');
            Route::get('/get_today_deatils/report','ReportController@get_today_details_report');

                Route::get('/reports/closing','ReportController@closing_report')->name('closing-report');
            Route::get('/reports/closing/data','ReportController@closing_data');

             //purchase report 
            Route::get('/reports/purchases','ReportController@purchases_report')->name('purchase-report');
             Route::get('/reports/purchases/data','ReportController@purchase_report_data');

              //item Report
            Route::get('/reports/items','ReportController@items_report')->name('item-report');
             Route::get('/reports/items/data','ReportController@items_report_data');
             

            Route::get('categories','CategoryController@index')->name('categories');
            Route::post('add_category','CategoryController@save');
            Route::get('get_categories','CategoryController@get_categories');
            Route::post('delete_category','CategoryController@delete_category');


            Route::get('accessories','AccessoryController@index')->name('accessories');
            Route::post('add_accessory','AccessoryController@save');
            Route::get('get_accessories','AccessoryController@get_accessories');
            Route::post('delete_accessory','AccessoryController@delete_accessory');

            Route::get('catremarks','CatRemarkController@index')->name('catremarks');
            Route::post('add_catremark','CatRemarkController@save');
            Route::get('get_catremarks','CatRemarkController@get_catremarks');
            Route::post('delete_catremark','CatRemarkController@delete_catremark');
            Route::get('/get_catremarks_by_category/{id}','CatRemarkController@get_catremarks_by_category');

            Route::get('employees','EmployeeController@index')->name('employees');
            Route::post('add_employee','EmployeeController@save');
            Route::get('get_employees','EmployeeController@get_employees');
            Route::post('delete_employee','EmployeeController@delete_employee');


            Route::get('models','VehicleModelController@index')->name('models');
            Route::post('add_model','VehicleModelController@save');
            Route::get('get_models','VehicleModelController@get_models');
            Route::post('delete_model','VehicleModelController@delete_model');
            Route::get('/get_models_by_make/{id}','VehicleModelController@get_models_by_make');

            Route::get('expenses','ExpenseController@index')->name('expenses');
            Route::post('add_expense','ExpenseController@save');
            Route::get('get_expenses','ExpenseController@get_expenses');
            Route::post('delete_expense','ExpenseController@delete_expense');
            Route::get('/get_expenses_by_expensecategory/{name}','ExpenseController@get_expenses_by_expensecategory');
            Route::get('find_expense/{id}','ExpenseController@find_expense');

 
            Route::get('purchases','PurchaseController@index')->name('purchases');
            Route::post('add_purchase','PurchaseController@save');
            Route::get('get_purchases','PurchaseController@get_purchases');
            Route::post('delete_purchase','PurchaseController@delete_purchase');
            Route::get('/get_purchases_by_vendor/{id}','PurchaseController@get_purchases_by_vendor');

            //stocks
             Route::get('stock/{id}/details','StockController@viewStockDetails')->name('stock.details');
            Route::get('stocks','StockController@index')->name('stocks');
            Route::post('stocks','StockController@stockUpload')->name('stock.upload');

            Route::get('get_stocks','StockController@get_stocks');
            Route::post('edit_stock','StockController@edit_stock');
            Route::get('find_stock/{id}','StockController@find_stock');
            Route::post('delete_stock','StockController@delete_stock');
            Route::get('stockreport','StockController@stockreport')->name('stockreport');

           
            Route::get('incomecategories','IncomeCategoryController@index')->name('incomecategories');
            Route::post('add_incomecategory','IncomeCategoryController@save');
            Route::get('get_incomecategories','IncomeCategoryController@get_incomecategories');
            Route::post('delete_incomecategory','IncomeCategoryController@delete_incomecategory');

            Route::get('incomes','IncomeController@index')->name('incomes');
            Route::post('add_income','IncomeController@save');
            Route::get('get_incomes','IncomeController@get_incomes');
            Route::post('delete_income','IncomeController@delete_income');
            Route::get('/get_incomes_by_incomecategory/{name}','IncomeController@get_incomes_by_incomecategory');

           Route::get('payments/{invoice}','PaymentController@index');
           Route::post('payments/get','PaymentController@get_payments');
           Route::post('payments/add','PaymentController@add_payment');
           Route::post('payments/update','PaymentController@update_payment');
           Route::post('payments/delete','PaymentController@delete_payment');

           Route::get('rec_payments/{sale}','PaymentController@rec_index');
           Route::post('rec_payments/get','PaymentController@get_rec_payments');
           Route::post('rec_payments/add','PaymentController@add_rec_payment');
           Route::post('rec_payments/update','PaymentController@update_rec_payment');
           Route::post('rec_payments/delete','PaymentController@delete_rec_payment');           

 

            Route::get('loyalcustomer','LoyalCustomerController@index')->name('loyalcustomer');

            Route::get('loyalcustomer/get_history','LoyalCustomerController@get_history');
            Route::post('loyalcustomer','LoyalCustomerController@save');
            Route::post('credit_payed','LoyalCustomerController@credit_payed');

            Route::post('purchasecredit_payed','PurchaseController@purchasecredit_payed');

            Route::post('find_loyalcustomer','LoyalCustomerController@find_loyalcustomer');
            Route::post('add_expense','ExpenseController@save');
            //reports-musthafa
            Route::get('download','ReportController@download')->name('download');
            Route::get('customer_report','ReportController@customer_report')->name('customer_report');
            Route::get('/reports/campaigns','ReportController@campaigns_report')->name('campaigns-report');

            // ########################################
            Route::get('/reports/expenses','ReportController@expenses_report')->name('expenses-report');
            Route::get('/reports/deliveries','ReportController@delivery_report')->name('delivery-report');
            Route::get('/reports/return_report','ReportController@return_report')->name('return_report');


            Route::get('return_item','ReportController@return_page')->name('return_page');
            Route::get('/return_item/invoice_no','ReportController@return_item');


            Route::post('return_product','PurchaseController@return_product');
            Route::post('check_puchase','PurchaseController@check_puchase');


            Route::post('return_sale','SaleController@return_sale');
            Route::post('check_sale','SaleController@check_sale');


            Route::get('get_credits','ReportController@credit_report');
            Route::get('credits','ReportController@credit_index')->name('credits');
            
            Route::get('sale_credits','ReportController@sale_credit_index')->name('sale_credits');
            Route::get('get_sale_credits','ReportController@sale_credit_report');
            

            Route::get('payments/{invoice_id}','PaymentController@index');
            Route::get('purchase_payments/{purchase_id}','PaymentController@purchase_index');

            Route::post('payments/get','PaymentController@get_payments');
            Route::post('purchase_payments/get','PaymentController@get_purchasepayments');
            Route::post('payments/add','PaymentController@add_payment');
            Route::post('purchase_payments/add','PaymentController@add_purchasepayment');
            Route::post('purchase_payments/delete','PaymentController@delete_purchasepayment');
            Route::post('payments/delete','PaymentController@delete_payment');




             Route::get('get_purchasecredits','ReportController@purchasecredit_report');
            Route::get('purchasecredits','ReportController@purchasecredit_index')->name('purchasecredits');
            Route::get('purchase_details/{id}','ReportController@purchase_details');

            Route::get('/reports/paycredits','ReportController@paycredit_report')->name('paycredit-report');
            Route::get('/reports/paycredits/data','ReportController@paycredit_report_data');
            Route::get('/reports/payvendorcredits','ReportController@payvendorcredit_report')->name('payvendorcredit-report');
            Route::get('/reports/payvendorcredits/data','ReportController@payvendorcredit_report_data');
            Route::get('/reports/return_report/data','ReportController@return_report_data');
            Route::get('/reports/deliveries/data','ReportController@deliveries_report_data');

            // #######################################################
            Route::get('/reports/expenses/data','ReportController@expenses_report_data');
            Route::get('/reports/campaigns/data','ReportController@campaigns_report_data');
            Route::get('/reports/services','ReportController@services_report')->name('services-report');
            Route::get('/reports/services/data','ReportController@services_report_data');

            Route::get('/reports/balance_sheet','ReportController@balance_sheet')->name('balance_sheet');
            Route::get('/reports/balance_sheet/data','ReportController@balance_sheet_data');

             Route::get('/reports/invoices','ReportController@invoices_report')->name('invoices-report');
            Route::get('/reports/invoices/data','ReportController@invoices_report_data');


            Route::get('/dashboard','DashboardController@index')->name('dashboard');

    });

	Route::group(['namespace' => 'Service','middleware' => 'Service'], function() {
        Route::get('/service','ServiceController@index')->name('service.home');
      
        Route::get('/redeem','RedeemController@index')->name('redeem');
        Route::post('/redeem/search','RedeemController@search');
        Route::post('/redeem/send_otp','RedeemController@send_otp');
        Route::post('/redeem/verify_otp','RedeemController@verify_otp');
        Route::post('/redeem/redeem_submit','RedeemController@redeem_submit');
        Route::get('/print_receipt/{redeem_code}','RedeemController@print_receipt');
    });

	Route::group(['namespace' => 'Superadmin','middleware' => 'Superadmin'], function() {
        Route::get('/companies','CompanyController@index')->name('companies');
        Route::get('/get_companies','CompanyController@get_companies');
        Route::post('/add_company','CompanyController@save');
        Route::post('/delete_company','CompanyController@delete_company');

    });
});
