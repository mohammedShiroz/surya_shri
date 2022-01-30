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
Route::get('/', [
    'uses' => 'PagesController@index',
    'as' => 'home'
]);

Route::get('/about-us',"PagesController@about")->name('about-us');
Route::get('/contact-us',"PagesController@contact")->name('contact-us');
Route::post('/contact-us/submit',"PagesController@contact_submit")->name('send.contact.msg');

Route::get('/careers',"PagesController@careers")->name('careers');
Route::get('/products','PagesController@products')->name('products');
Route::get('/products/{slug}','PagesController@view_product')->name('product.details');
Route::get('/quick-product-view/fetch-data/{id}', 'PagesController@product_quick_view')->name('product.quick.view');

Route::middleware(['active_tab'])->group(function () {
    Route::post('/products/add-review', 'PagesController@store_review')->name('product.add.review');
    Route::get('/products/reviews/load_more','PagesController@load_more_review');
    Route::POST('/products/reviews/remove','PagesController@remove_review')->name('products.remove.my.review');
});

Route::get('/category/{id}','PagesController@category_level_check')->name('products.category.level_check');
Route::get('/products/type/{id}','PagesController@product_category_level_one')->name('products.category.level_one');
Route::get('/products/type/{id}/{lvl2_id}','PagesController@product_category_level_two')->name('products.category.level_two');
Route::get('/products/type/{id}/{lvl2_id}/{lvl3_id}','PagesController@product_category_level_three')->name('products.category.level_three');

//:json_fetch_product_filter
Route::post('/fetch-data/sub_categories', 'PagesController@fetch_third_level_categories');
Route::post('/fetch-data/product-data', 'PagesController@fetch_product_filter_data');
Route::get('/search-product', 'PagesController@search_product')->name('products.search_product');

Route::post('/prakrti-parīksha/popup-curd', 'PagesController@pop_up_curd');
Route::middleware(['auth:web'])->group(function () {
    Route::get('/prakrti-parīksha/interview', 'PagesController@prakrti_interview')->name('prakrti.interview');
    Route::post('/prakrti-parīksha/store-answers', 'PagesController@store_interview_answers')->name('prakrti.store.answer');
    Route::get('/prakrti-parīksha/products', 'PagesController@prakrti_products')->name('prakrti.products');
    Route::get('/prakrti-parīksha/services', 'PagesController@prakrti_services')->name('prakrti.services');
    Route::post('/prakrti-parīksha/re-check', 'PagesController@re_check_interview')->name('prakrti.re_check');
    Route::post('/prakrti-parīksha/send-answer-copy', 'PagesController@send_answerd_copy')->name('prakrti.send_answerd_copy');
});
//:Shopping Cart Operations
Route::get('/shopping-cart', 'CartController@index')->name('shopping_cart');
Route::POST('/cart/add_item', 'CartController@create');
Route::POST('/cart/remove_item/{id}', 'CartController@destroy');
Route::POST('/cart/remove-shopping-cart_item/{id}', 'CartController@remove_shopping_cart_item');
Route::POST('/cart/remove-shopping-cart/all', 'CartController@remove_all_shopping_cart_item');
Route::POST('/cart/update_cart_qty/{id}/{qty}', 'CartController@update_cart_qty');
Route::POST('/cart/update_cart/all', 'CartController@update');

Route::middleware(['auth:web'])->group(function () {
    Route::get('/checkout', 'CheckoutController@index')->name('checkout');
    Route::POST('/checkout/voucher/valid', 'CheckoutController@check_voucher_valid')->name('checkout.voucher.valid');
    Route::POST('/checkout/voucher/remove/voucher', 'CheckoutController@remove_voucher_code')->name('checkout.voucher.remove');
    Route::POST('/checkout/submit', 'CheckoutController@points_payments')->name('order.create');
    Route::get('/checkout/payment-success', 'CheckoutController@order_payment_success')->name('order.payment.done');
    Route::get('/checkout/payment/notify', 'CheckoutController@order_payment_notify')->name('order.payment.notify');
    Route::get('/checkout/payment-failed', 'CheckoutController@order_payment_failed')->name('order.payment.failed');
    Route::get('/checkout/order-success', 'CheckoutController@order_success')->name('checkout.order.done');
});

Route::middleware(['auth:web'])->group(function () {
    Route::get('/wish-list', 'WishListController@index')->name('wish-list');
    Route::post('/wish-list/add-service', 'WishListController@store_service')->name('wish-list.add.service');
    Route::post('/wish-list/add-item', 'WishListController@store')->name('wish-list.add');
    Route::post('/wish-list/remove-item/{id}', 'WishListController@destroy')->name('wish-list.delete');
    Route::post('/wish-list/remove-service/{id}', 'WishListController@destroy_service')->name('wish-list.delete.service');
    Route::post('/wish-list/remove-all-wishList', 'WishListController@destory_all_wish_list_products')->name('wish-list.delete-all');
});

Route::get('/product/comparison', 'ComparisonController@index')->name('comparison');
Route::post('/product/comparison/add-item', 'ComparisonController@store')->name('comparison.add');
Route::post('/product/comparison/remove-item', 'ComparisonController@destroy')->name('comparison.delete');
Route::post('/product/comparison/remove-all-item', 'ComparisonController@destroy_all_comparison_items')->name('comparison.delete-all');

//: Service section route
Route::prefix('/clinique')->group(function () {
    Route::get('/', 'PagesController@services')->name('services');
    Route::get('/{tag}', 'PagesController@service_category')->name('services.category');
    Route::get('/{tag}/{slug}', 'PagesController@services_details')->name('services.details');
    Route::middleware(['active_tab'])->group(function () {
        Route::post('/add-review', 'ServiceOperationController@store_service_review')->name('services.add.review');
        Route::get('/reviews/fetch/load_more','ServiceOperationController@load_more_services_review');
        Route::POST('/reviews/remove','ServiceOperationController@remove_service_review')->name('services.remove.my.review');
    });

    Route::middleware(['auth:web'])->group(function () {
        Route::post('/reservations/time-slot', 'ServiceOperationController@get_book_times')->name('services.time_slot');
        Route::get('/reservation/{slug}/booking', 'ServiceOperationController@services_reservations_booking')->name('services.booking');
        Route::POST('/reservation/booking', 'ServiceOperationController@make_reservation_by_points')->name('services.store.booking');
        Route::POST('/reservations/voucher/valid', 'ServiceOperationController@check_voucher_valid')->name('services.voucher.valid');
        Route::POST('/reservations/voucher/remove/voucher', 'ServiceOperationController@remove_voucher_code')->name('services.voucher.remove');

    });
});

Route::post('/cliniques/fetch-data/service-data', 'PagesController@fetch_service_filter_data');

Route::middleware(['auth:web'])->group(function () {
    Route::get('/service/ps', 'ServiceOperationController@services_booking_payment_success')->name('services.booking.payment.done');
    Route::get('/service/payment-failed', 'ServiceOperationController@services_booking_payment_failed')->name('services.booking.payment.failed');
    Route::get('/service/reservation-success', 'ServiceOperationController@services_reservations_success')->name('services.booking.done');
});

Route::get('/privacy-policy','PagesController@privacy_policy')->name('privacy_policy');
Route::get('/affiliate-policy','PagesController@affiliate_policy')->name('affiliate_policy');
Route::get('/transaction-policy','PagesController@transaction_policy')->name('transaction_policy');
Route::get('/terms-and-conditions','PagesController@terms_and_condition')->name('termsAndCondition');
Route::get('/search', 'PagesController@search');
Route::get('/sit-map','PagesController@sitemap');
Route::get('blog',"PagesController@blog")->name('blog');



// logged in user pages
Auth::routes();
Route::get('/users/activation/{token}', 'Auth\RegisterController@userActivation');
Route::get('/partners-register/partner/{id}/{name}', 'PagesController@employee_register')->name('partners.register');
Route::get('/verify/code/resent/{id}', 'Auth\RegisterController@resend_link')->name('activation.verify.resend');
Route::post('/partner/code/valid', 'Auth\RegisterController@check_partner_code')->name('partner.valid');
Route::post('/partner/code/valid', 'PagesController@check_partner_code')->name('partner.valid.check');
Route::post('/partner-user/code/valid', 'PagesController@check_user_code')->name('transfer-users.valid.check');
Route::middleware(['auth:web'])->group(function () {
    Route::get('/partners-request/partner/{id}/{name}', 'PagesController@employee_register_with_login')->name('partner.login.register');
});
//:: Dashboard Operations
Route::middleware(['auth:web'])->group(function () {
    Route::prefix('/dashboard')->group(function () {
        Route::get('/', 'DashboardController@index')->name('dashboard');
        Route::get('/orders', 'DashboardController@orders')->name('dashboard.orders');
        Route::get('/orders/{id}', 'DashboardController@orders_details')->name('dashboard.orders.detail');
        Route::post('/order/cancel', 'DashboardController@send_order_cancel_request')->name('dashboard.orders.cancel');
        Route::post('/order/hold', 'DashboardController@send_order_hold_request')->name('dashboard.orders.hold');

        Route::get('/wish-list', 'DashboardController@wishList')->name('dashboard.wish-list');
        Route::get('/account', 'DashboardController@account')->name('dashboard.account');
        Route::post('/account/update', 'DashboardController@update_user_info')->name('dashboard.account.update');
        Route::post('/account/change-user-pwd', 'DashboardController@update_user_pwd')->name('dashboard.account.update.pwd');
        Route::post('/account/update-user-name', 'DashboardController@add_coupon_codes')->name('dashboard.add.coupon-codes');
        Route::get('/my-address', 'DashboardController@address')->name('dashboard.address');
        Route::get('/transaction', 'DashboardController@transaction')->name('dashboard.transactions');
        Route::get('/reservations', 'DashboardController@reservations')->name('dashboard.reservations');
        Route::get('/reservation/{id}', 'DashboardController@show_reservations')->name('dashboard.reservations.view');
        Route::Post('/reservations/cancel/{id}', 'DashboardController@cancel_reservations')->name('dashboard.reservations.cancel');
    });

    Route::get('/users/bookings/events/all', 'DashboardController@get_coming_up_bookings')->name('bookings.events.all.pending');
    Route::post('/check-reservation', 'ServiceOperationController@check_reservation')->name('reservation.check.bookings');
    Route::get('/my-wallet', 'WalletController@index')->name('wallet');
    Route::get('/my-wallet/points', 'WalletController@points')->name('wallet.points');
    Route::get('/my-wallet/transfer-points', 'WalletController@transfer_points')->name('wallet.transfer_points');
    Route::post('/my-wallet/points/transfer', 'WalletController@update_transfer_point')->name('wallet.points.transfer');

    Route::get('/my-wallet/credited-points', 'WalletController@credited_points')->name('wallet.credited_points');
    Route::get('/my-wallet/used-points', 'WalletController@used_points')->name('wallet.used_points');
    Route::get('/my-wallet/refund-points', 'WalletController@refund_points')->name('wallet.refund_points');
    Route::get('/my-wallet/withdrawal-points', 'WalletController@withdrawal_points')->name('wallet.withdrawal_points');
    Route::post('/my-wallet/points/withdrawal', 'WalletController@update_withdrawal_point')->name('wallet.points.withdrawal');
    Route::post('/my-wallet/points-bank-info', 'WalletController@update_withdrawal_bank_details')->name('wallet.points.withdrawal.store.bank-details');
    Route::get('/my-wallet/seller-points', 'WalletController@seller_points')->name('wallet.seller_points');
    Route::get('/my-wallet/history', 'WalletController@history')->name('wallet.history');
    Route::resources([
        'user-address' => 'AddressController',
    ]);

    //: Select 2 Data fetch controls
    Route::post('fetch/city', 'DashboardController@fetch_city')->name('user.fetch.city');
    Route::post('fetch/user-name', 'WalletController@fetch_user')->name('select2.fetch.user');

    //:Employee group
    Route::prefix('/dashboard')->group(function () {
        Route::post('/partners-request', 'EmpController@send_employee_request')->name('send.partner.request');
        Route::get('/partners-account', 'EmpController@index')->name('partners');
        Route::get('/partners-account/profile', 'EmpController@profile')->name('partners.profile');
        Route::get('/partners-account/hierarchy', 'EmpController@hierarchy_view')->name('partners.hierarchy');
        Route::get('/partners-account/hierarchy/{id}', 'EmpController@partner_commission')->name('partners.hierarchy.commission');
        Route::get('/partners-account/products', 'EmpController@products')->name('partners.products');
        Route::get('/partners-account/services', 'EmpController@services')->name('partners.services');
        Route::get('/partners-account/vouchers', 'EmpController@vouchers')->name('partners.vouchers');
        Route::POST('/partner/voucher/generate', 'EmpController@generate_voucher_code')->name('partners.voucher.generate');
        Route::post('/partners-account/voucher/create', 'EmpController@create_redeem_vouchers')->name('redeem.voucher');
        Route::post('/partners-account/voucher/delete', 'EmpController@destroy_vouchers')->name('partners.vouchers.destroy');
        Route::get('/partners-account/summary', 'EmpController@summary')->name('partners.summary');
    });

    Route::get('/dashboard/seller-account', 'DashboardController@seller_account')->name('seller_account');
    Route::get('/dashboard/seller-account/add-product', 'DashboardController@add_product')->name('add_product');
    Route::get('/fetch-subcategory', 'DashboardController@get_sub_categories');
    Route::get('/fetch-last-category', 'DashboardController@get_last_categories');
    Route::post('/dashboard/seller-account/store-product', 'DashboardController@store_product')->name('add_new_product');
    Route::get('/dashboard/seller-account/manage-products', 'DashboardController@manage_products')->name('manage_products');
    Route::get('/dashboard/seller-account/pending-products', 'DashboardController@pending_products')->name('pending_products');
    Route::get('/dashboard/seller-account/products-orders', 'DashboardController@products_orders')->name('products_orders');
    Route::get('/dashboard/seller-account/products-orders/{id}', 'DashboardController@seller_orders_details')->name('seller.order_details');

    Route::get('/dashboard/seller-account/reviewed-products', 'DashboardController@reviewed_products')->name('reviewed_products');
    Route::get('/dashboard/seller-account/pending-products/view/{slug}', 'DashboardController@show_pending_product')->name('show.pending_product');
    Route::post('/dashboard/seller-account/products/stock', 'DashboardController@change_product_stocks')->name('edit.item_stock');

    Route::get('/dashboard/seller-account/pending-products/delete/{id}', 'DashboardController@delete_pending_product')->name('delete.pending_product');
    Route::get('/dashboard/seller-account/pending-products/confirm_pro/{id}', 'DashboardController@confirm_reviewed_product')->name('confirm_product_to_publish');
    Route::get('/dashboard/seller-account/pending-products', 'DashboardController@pending_products')->name('pending_products');
    Route::get('/dashboard/seller-account/payment-account', 'DashboardController@payment_account')->name('payment_account');
    Route::post('/dashboard/seller-account/add-payment-info', 'DashboardController@add_payment_info')->name('add_payment_info');
    Route::post('/dashboard/seller-account/edit-payment-info', 'DashboardController@edit_payment_info')->name('edit_payment_info');
    ///Route::post('/dashboard/seller-account/change_status', 'DashboardController@change_product_status')->name('change_product_status');
    Route::get('/dashboard/seller-account/change-publish-status', 'DashboardController@change_product_publish_status');

    Route::get('/dashboard/re-seller-account', 'DashboardController@re_seller_account')->name('reseller.account');
    Route::get('/dashboard/re-seller/products', 'DashboardController@show_resell_products')->name('reseller.manage_products');
    Route::get('/dashboard/re-seller/products/{slug}', 'DashboardController@show_resell_product_info')->name('reseller.show_product_info');
    Route::get('/dashboard/re-seller/products/{id}/delete','DashboardController@delete_resell_product')->name('reseller.delete_product');
});

//:copy code
Route::get('/voucher/{code}', 'PagesController@voucher_code')->name('share_voucher_code');
//: Backend Routes
Route::get('verify/resend', 'Auth\TwoFactorController@resend')->name('verify.resend');
Route::resource('verify', 'Auth\TwoFactorController')->only(['index', 'store']);
Route::prefix('/admin')->group(function () {
    Route::get('/login', 'Auth\AdminLoginController@show_login_form')->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
    Route::middleware(['auth:admin'])->group(function () {
        Route::post('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');
    });
    Route::middleware(['auth:admin', 'two_factor'])->group(function () {
            Route::get('/', 'AdminController@index')->name('admin.home');
            Route::get('/dashboard', 'AdminController@index')->name('admin.dashboard');
            Route::get('/bookings/events/all', 'AdminController@get_coming_up_bookings')->name('bookings.events.all');
            Route::resources([
                'question-type' => 'QuestionTypeController',
                'questions' => 'QuestionsController',
                'submitted-questionnaires' => 'SubmittedQuestionnairesController',
                'answers' => 'AnswersController',
                'product-category' => 'ProductCategoryController',
                'products' => 'ProductController',
                'product-questions' => 'ProductQuestionsController',
                'users' => 'UsersController',
                'partners' => 'EmployeeController',
                'sellers' => 'SellerController',
                'doctors' => 'DoctorController',
                'service-category' => 'ServiceCategoryController',
                'services' => 'ServiceController',
                'services-questions' => 'ServicesQuestionsController',
                'reservations' => 'BookingController',
                'vouchers' => 'VouchersController',
                'voucher-customers' => 'VoucherCustomersController',
                'orders' => 'OrdersController',
                'web-visitors' => 'VisitLogController',
                'admin-users' => 'AdminUsersController',
                'product-payments' => 'ProductPaymentController',
                'service-payments' => 'ServicePaymentController',
                'seller-payments' => 'SellerPaymentController',
                'user-points' => 'UserPointsController',
                'user-wallet' => 'UserWalletController',
                'withdrawal-wallet' => 'WithdrawalWalletController',
                'global-wallet' => 'GlobalWalletController',
                'site-wallet' => 'SiteWalletController',
                'bonus-wallet' => 'BonusWalletController',
                'donation-wallet' => 'DonationsWalletController',
                'seller-wallet' => 'SellerWalletController',
                'doctor-wallet' => 'DoctorWalletController',
                'site-visitors' => 'VisitLogController',
                'activity-log' => 'ActivityController',
                'permission' => 'PermissionController',
                'role' => 'RoleController',
                'notifications' => 'NotificationController',
                'withdrawal-details' => 'WithdrawalDetailsController',
            ]);

            Route::post('question-type/delete-all', 'QuestionTypeController@destroy_all')->name('question-type.destroy_all');
            Route::post('questions/delete-all', 'QuestionsController@destroy_all')->name('questions.destroy_all');
            Route::get('questions/{id}/answer/{answer_id}', 'QuestionsController@edit_answer')->name('answers.edited');
            //Route::post('answers/delete-all', 'AnswersController@destroy_all')->name('answers.destroy_all');
            Route::post('product-category/delete-all', 'ProductCategoryController@destroy_all')->name('product-category.destroy_all');
            Route::get('product-category/{parent_id}/sub-category/{sub_id}', 'ProductCategoryController@edit_sub_category')->name('product-category.sub_edit');
            Route::Post('product-category/store/sub-category', 'ProductCategoryController@store_sub_category')->name('product-category.sub-category.store');
            Route::PUT('product-category/update/sub-category/{id}', 'ProductCategoryController@update_sub_category')->name('product-category.sub-category.update');
            Route::get('product-category/{parent_id}/category-two/{sub_category_id}', 'ProductCategoryController@show_sub_category')->name('product-category.show_third_category');
            Route::get('product-category/{parent_id}/category-two/{sub_id}/category-three/{id}', 'ProductCategoryController@edit_third_sub_category')->name('product-category.sub_third_edit');
            Route::post('products/delete-all', 'ProductController@destroy_all')->name('products.destroy_all');
            Route::post('users/delete-all', 'UsersController@destroy_all')->name('users.destroy_all');
            Route::post('withdrawals-details/auto-withdrawal/time', 'WithdrawalDetailsController@update_auto_withdrawal_time')->name('withdrawal-details.update.w-time');

            Route::Post('users/additional/add-notes', 'UsersController@add_notes')->name('users.add.notes');
            Route::GET('users/additional/delete-notes/{id}', 'UsersController@delete_notes')->name('users.delete.notes');

            Route::GET('notifications/type/{type}', 'NotificationController@notification_types')->name('notifications.type');
            Route::POST('notifications/type/{type}/update', 'NotificationController@update_notifications')->name('notifications.update-notifications');

            Route::get('/withdrawal-wallet-user', 'WithdrawalWalletController@users')->name('withdrawal-wallet.user');
            Route::get('/withdrawal-wallet-seller', 'WithdrawalWalletController@sellers')->name('withdrawal-wallet.seller');
            Route::get('/withdrawal-wallet-doctors', 'WithdrawalWalletController@doctors')->name('withdrawal-wallet.doctors');
            Route::get('/withdrawal-wallet-site', 'WithdrawalWalletController@site')->name('withdrawal-wallet.site');
            Route::get('/withdrawal-wallet-global', 'WithdrawalWalletController@global')->name('withdrawal-wallet.global');
            Route::get('/withdrawal-wallet-gift', 'WithdrawalWalletController@gift')->name('withdrawal-wallet.gift');
            Route::get('/withdrawal-wallet-donations', 'WithdrawalWalletController@donations')->name('withdrawal-wallet.donations');
            Route::get('/withdrawal-wallet/{type}/details/{id}', 'WithdrawalWalletController@withdrawal_points_details')->name('withdrawal-wallet.show-details');

            Route::post('/withdrawal-wallet/points/withdrawal', 'WithdrawalWalletController@send_withdrawal_request')->name('withdrawal-wallet.send.request');

            Route::get('/withdrawal-wallet/requested/points', 'WithdrawalWalletController@requested_withdrawal')->name('withdrawal-wallet.requested');
            Route::post('/withdrawal-wallet/request/user/points/confirm', 'WithdrawalWalletController@confirm_request')->name('withdrawal-wallet.requested.confirm');
            Route::post('/withdrawal-wallet/request/user/points/reject', 'WithdrawalWalletController@reject_request')->name('withdrawal-wallet.requested.reject');
            Route::get('/withdrawal-wallet/payment/points', 'WithdrawalWalletController@withdrawal_payments')->name('withdrawal-wallet.payments');
            Route::get('/withdrawal-wallet/payment/points/details/{id}', 'WithdrawalWalletController@withdrawal_payments_details')->name('withdrawal-wallet.show.payments');
            Route::post('/withdrawal-wallet/payment/user/points/confirm', 'WithdrawalWalletController@confirm_payment')->name('withdrawal-wallet.payment.confirm');
            Route::get('/get-visitors-info', 'VisitLogController@get_visitor_info');

            Route::post('/withdrawal-wallet/bank/details/verification/approve', 'WithdrawalWalletController@approve_bank_info')->name('withdrawal-wallet.bank-info.approve');
            Route::post('/withdrawal-wallet/bank/details/verification/reject', 'WithdrawalWalletController@reject_bank_info')->name('withdrawal-wallet.bank-info.reject');


        //: pending deliveries
            Route::get('orders/pending/deliveries', 'OrdersController@show_pending_delivery')->name('orders.pending.delivery');
            Route::Post('orders/additional/add-notes', 'OrdersController@add_notes')->name('orders.add.notes');
            Route::GET('orders/additional/delete-notes/{id}', 'OrdersController@delete_notes')->name('orders.delete.notes');
            //:product image curd
            Route::post('products/add/image/more', 'ProductController@add_more_image')->name('products.add.more.image');
            Route::post('products/delete/image/more', 'ProductController@delete_more_image')->name('products.delete.more.image');

            Route::middleware(['active_tab'])->group(function () {
                Route::post('/add/product/reply', 'ProductController@reply_review')->name('products.add.reply');
                Route::POST('product/reviews/remove','ProductController@remove_product_review')->name('products.remove.user.review');
                Route::POST('product/reply/remove','ProductController@remove_product_review_reply')->name('products.remove.admin.reply');
            });

            //:service image curd
            Route::post('services/add/image/more', 'ServiceController@add_more_image')->name('services.add.more.image');
            Route::post('services/delete/image/more', 'ServiceController@delete_more_image')->name('services.delete.more.image');
            Route::Post('booking/additional/add-notes', 'BookingController@add_notes')->name('booking.add.notes');
            Route::GET('booking/additional/delete-notes/{id}', 'BookingController@delete_notes')->name('booking.delete.notes');

            Route::middleware(['active_tab'])->group(function () {
                Route::post('/add-reply', 'ServiceController@reply_review')->name('services.add.reply');
                Route::POST('/reviews/remove','ServiceController@remove_service_review')->name('services.remove.user.review');
                Route::POST('/reply/remove','ServiceController@remove_service_review_reply')->name('services.remove.admin.reply');
            });

        Route::prefix('/partners')->group(function () {
                Route::get('/hierarchy/structure', 'EmployeeController@show_hierarchy')->name('partners.view.hierarchy');
                Route::get('/users/request', 'EmployeeController@request_users')->name('partners.request');
                Route::get('/users/request/view/{id}', 'EmployeeController@show_request_users')->name('partners.request.review');
                Route::get('/users/request/rejected/{id}', 'EmployeeController@request_users_reject')->name('partners.request.reject');
                Route::post('/users/request/approve', 'EmployeeController@request_users_approve')->name('partners.request.approve');
                Route::post('/users/approved/update', 'EmployeeController@modifiy_agent_placement')->name('partners.placement.update');
            });
            Route::post('/sellers/add/product', 'SellerController@add_seller_product')->name('sellers.add.product');
            Route::post('/sellers/remove/product', 'SellerController@remove_seller_product')->name('sellers.remove.product');
            Route::post('/service-category/delete-all', 'ServiceCategoryController@destroy_all')->name('service-category.destroy_all');
            Route::post('/services/delete-all', 'ServiceController@destroy_all')->name('services.destroy_all');
            Route::post('vouchers/delete-all', 'VouchersController@destroy_all')->name('vouchers.destroy_all');
            Route::post('voucher-customers/delete-all', 'VoucherCustomersController@destroy_all')->name('voucher-customers.destroy_all');
            Route::get('/seller-payments/payment/paid/{id}', 'SellerPaymentController@set_paid_amount')->name('seller-payments.payment.paid');
            Route::get('/seller-payments/payment/pending/{id}', 'SellerPaymentController@set_pending_amount')->name('seller-payments.payment.pending');

            Route::GET('/reservations/status/pending', 'BookingController@pending_bookings')->name('reservations.pending');
            Route::GET('/reservations/status/confirmed', 'BookingController@confirmed_bookings')->name('reservations.confirmed');
            Route::GET('/reservations/status/canceled', 'BookingController@canceled_bookings')->name('reservations.canceled');
            Route::GET('/reservations/status/rejected', 'BookingController@rejected_bookings')->name('reservations.rejected');
            Route::GET('/reservations/status/expired', 'BookingController@expired_bookings')->name('reservations.expired');
            Route::GET('/reservations/status/completed', 'BookingController@completed_bookings')->name('reservations.completed');

            Route::GET('/reservations/status/pending/{id}', 'BookingController@show')->name('reservations.pending.show');
            Route::GET('/reservations/status/confirmed/{id}', 'BookingController@show')->name('reservations.confirmed.show');
            Route::GET('/reservations/status/canceled/{id}', 'BookingController@show')->name('reservations.canceled.show');
            Route::GET('/reservations/status/rejected/{id}', 'BookingController@show')->name('reservations.rejected.show');
            Route::GET('/reservations/status/expired/{id}', 'BookingController@show')->name('reservations.expired.show');
            Route::GET('/reservations/status/completed/{id}', 'BookingController@show')->name('reservations.completed.show');

            Route::post('/reservations/delete-all', 'BookingController@destroy_all')->name('reservations.destroy_all');
            Route::post('/reservations/confirm/reservation/{id}', 'BookingController@confirm_book')->name('reservations.confirm.book');
            Route::post('/reservations/cancel/reservation/{id}', 'BookingController@cancel_book')->name('reservations.cancel.book');
            Route::post('/reservations/completed/reservation/{id}', 'BookingController@completed_book')->name('reservations.completed.book');
            Route::post('/reservations/reject/reservation/{user_id}/{id}', 'BookingController@reject_book')->name('reservations.reject.book');
            Route::get('/reservations/coming-up-events/all', 'BookingController@get_coming_up_bookings')->name('reservations.all.events');


        //: Select 2 Data fetch controls
            Route::post('fetch-category-two', 'ProductController@fetch_category_two')->name('products.category.two');
            Route::post('fetch-category-three', 'ProductController@fetch_category_three')->name('products.category.three');
            Route::post('fetch-questions-answer', 'ProductQuestionsController@fetch_question_answers')->name('products.question.answers');

//        Route::get('/dashboard/customers', 'BuyerController@index')->name('admin.customers');
//        Route::get('/dashboard/customers/delete/{id}', 'BuyerController@destroy')->name('admin.customers.delete');

            Route::get('/dashboard/sellers', 'SellerController@index')->name('admin.sellers');
            Route::get('/dashboard/seller-requests', 'SellerController@seller_requests')->name('admin.seller_requests');
            Route::get('/dashboard/sellers/view/{id}', 'SellerController@review_seller')->name('admin.seller.review');
            Route::get('/dashboard/sellers/approve/{id}', 'SellerController@seller_approve')->name('admin.seller.approve');
            Route::get('/dashboard/sellers/reject/{id}', 'SellerController@seller_reject')->name('admin.seller.reject');
            Route::get('/dashboard/sellers/delete/{id}', 'SellerController@destroy')->name('admin.seller.delete');

            Route::get('/dashboard/products', 'ProductsController@index')->name('admin.products');
            Route::get('/dashboard/products/view/{id}', 'ProductsController@view_product')->name('admin.products.view_product');

            Route::get('/dashboard/re-view-products', 'ProductsController@review_products')->name('admin.products.reviews');
            Route::get('/dashboard/re-viewed-products', 'ProductsController@reviewed_products')->name('admin.products.reviewed');
            Route::get('/dashboard/rejected-products', 'ProductsController@show_rejected_products')->name('admin.products.rejected');
            Route::get('/dashboard/confirmed-products', 'ProductsController@show_confirmed_products')->name('admin.products.confirmed');

            Route::get('/dashboard/products/approve/{id}', 'ProductsController@approve_product')->name('admin.product.approve');
            Route::post('/dashboard/products/approve/send-request', 'ProductsController@send_product_request')->name('admin.product.request');
            Route::post('/dashboard/products/approve/send-request-by-size', 'ProductsController@send_product_request_by_size')->name('admin.product.request.by_size');

            //:delete
            Route::get('/dashboard/products/delete/{id}', 'ProductsController@destroy')->name('admin.products.delete');
            ///----

            //:delete-all-record routing
            Route::post('/send/verification/{type}', 'TwoWayDeleteController@destroy_all_record')->name('admin.record.delete');
            Route::get('/delete-all-record/{type}/verify', 'TwoWayDeleteController@show_two_factor_view')->name('show.verification.page');
            Route::get('/delete-all-record/re-send/{type}', 'TwoWayDeleteController@resend_verification_code')->name('admin.resend.verification');
            Route::post('/delete-all-record/verification', 'TwoWayDeleteController@verify_code')->name('admin.verify.delete');
            ///----
            Route::prefix('/orders')->group(function () {
                Route::get('/show-order/{id}/{page_name}', 'OrdersController@show_order_details')->name('orders.view');
                Route::get('/request/pending-orders', 'OrdersController@show_pending_orders')->name('orders.pending');
                Route::get('/request/completed-orders', 'OrdersController@show_completed_orders')->name('orders.completed');
                Route::get('/request/confirmed-orders', 'OrdersController@show_confirmed_orders')->name('orders.confirmed');
                Route::get('/request/rejected-orders', 'OrdersController@show_rejected_orders')->name('orders.rejected');
                Route::get('/request/canceled-orders', 'OrdersController@show_canceled_orders')->name('orders.canceled');
                Route::post('/delete-all', 'OrdersController@destroy_all')->name('orders.destroy_all');
                Route::post('/request/customer/confirm', 'OrdersController@confirm_order')->name('orders.request.confirm');
                Route::post('/request/customer/reject', 'OrdersController@reject_order')->name('orders.request.reject');
                Route::post('/delivery/customer/send', 'OrdersController@set_send_delivery')->name('orders.delivery.send');
                Route::post('/delivery/customer/not-send', 'OrdersController@set_not_send_delivery')->name('orders.delivery.not-send');
                Route::post('/delivery/customer/hold', 'OrdersController@set_hold_delivery')->name('orders.delivery.hold');
                Route::post('/delivery/customer/pending', 'OrdersController@set_pending_delivery')->name('orders.delivery.pending');
                Route::post('/delivery/customer/self-pickup', 'OrdersController@set_self_pickup_delivery')->name('orders.delivery.self-pickup');
                Route::post('/delivery/customer/delivered', 'OrdersController@set_delivered_delivery')->name('orders.delivery.delivered');
            });

            Route::get('/dashboard/order/edit/{id}', 'OrdersController@edit_order')->name('admin.order.edit');
            Route::get('/dashboard/order/delete/{id}', 'OrdersController@delete_order')->name('admin.order.delete');

            Route::get('/dashboard/delivery', 'logisticController@index')->name('delivery.orders');
            Route::get('/dashboard/pending-delivery', 'logisticController@pending_delivery')->name('delivery.pending');
            Route::get('/dashboard/confirmed-delivered', 'logisticController@delivered_order')->name('delivery.delivered');
            Route::get('/dashboard/delivery/view/{id}', 'logisticController@show')->name('delivery.orders.review');
            Route::Post('/dashboard/delivery/update/status', 'logisticController@update')->name('delivery.update.status');

            Route::get('/dashboard/payments', 'PaymentController@index')->name('payments');
            Route::get('/dashboard/pending-payments', 'PaymentController@pending_payments')->name('payment.pending');
            Route::get('/dashboard/Payments/view/{id}', 'PaymentController@view_payment')->name('payment.review');
            Route::get('/dashboard/Payments/confirm-payment/{id}/{amount}', 'PaymentController@confirm_payment')->name('payment.confirm');
            Route::get('/dashboard/Payments/un-confirm-payment/{id}', 'PaymentController@un_confirm_payment')->name('payment.un_confirm');


            Route::resource('/main-categories', 'MainCategoryController');
            Route::get('/categories/delete/fetch_data/{id}', 'MainCategoryController@delete_info');
            Route::get('/categories/delete/{id}', 'MainCategoryController@destroy')->name('main_category.delete');
            Route::get('/categories/delete/bulk-delete', 'MainCategoryController@destroy_all');

            Route::get('/sub-categories/', 'MainCategoryController@sub_categories')->name('sub_categories');
            Route::get('/sub-categories/create', 'MainCategoryController@show_add_sub_category')->name('sub_categories.add');
            Route::post('/sub-categories/create/add', 'MainCategoryController@store_sub_category')->name('store_sub_category');
            Route::get('/sub-categories/{id}/edit', 'MainCategoryController@show_edit_sub_category')->name('sub_categories.edit');
            Route::post('/sub-categories/edit/save/{id}', 'MainCategoryController@update_sub_category')->name('update_sub_category');
            Route::get('/sub-categories/delete/{id}', 'MainCategoryController@destroy_sub_category');
            Route::get('/sub-categories/delete/all/bulk-delete', 'MainCategoryController@destroy_all_sub_category');

            Route::get('/last-categories/', 'MainCategoryController@last_categories')->name('last_categories');
            Route::get('/last-categories/create', 'MainCategoryController@show_add_last_category')->name('last_categories.add');
            Route::post('/last-categories/create/add', 'MainCategoryController@store_last_category')->name('store_last_category');
            Route::get('/last-categories/{id}/edit', 'MainCategoryController@show_edit_last_category');
            Route::post('/last-categories/edit/save/{id}', 'MainCategoryController@update_last_category')->name('update_last_category');
            Route::get('/last-categories/delete/{id}', 'MainCategoryController@destroy_last_category');
            Route::get('/last-categories/delete/all/bulk-delete', 'MainCategoryController@destroy_all_last_category');

            /*
             * Laratrust Operations
             */
            Route::middleware(['active_tab'])->group(function () {
                Route::post('/laratrust/user_permission', 'LaratrustController@userPermission')->name('laratrus.user_permission');
                Route::post('/laratrust/user_role', 'LaratrustController@userRole')->name('laratrus.user_role');
                Route::post('/laratrust/role_permission', 'LaratrustController@rolePermission')->name('laratrus.role_permission');
            });
            /*
            * Laratrust Operations end
            */

            /*
             * Laratrust Operations
             */
            Route::middleware(['active_tab'])->group(function () {
                Route::get('/profile', 'AdminController@show_profile')->name('admin.profile');
                Route::post('/profile/update', 'AdminController@update_profile_info')->name('admin.update_profile');
                Route::post('/profile/update_pwd', 'AdminController@profile_change_password')->name('admin.change_password');
            });

            /*
             * CRUD Operations
             */
            Route::post('/crud/permission', 'CRUDController@permission')->name('crud.permission');
            Route::post('/crud/admin', 'CRUDController@admin')->name('crud.admin');
    });
});

Route::get('admin/password/reset', 'Auth\AdminForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
Route::post('admin/password/email', 'Auth\AdminForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
Route::get('admin/password/reset/{token}', 'Auth\AdminResetPasswordController@showResetForm')->name('admin.password.reset');
Route::post('admin/password/reset', 'Auth\AdminResetPasswordController@reset')->name('admin.password.update');

//Clear route cache:
Route::get('/clear-all', function() {
    $exitCode1 = Artisan::call('config:cache');
    $exitCode2 = Artisan::call('cache:clear');
    $exitCode3 = Artisan::call('view:clear');
    $exitCode4 = Artisan::call('config:clear');
    return 'All cleared';
});
