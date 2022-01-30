<?php
use Carbon\Carbon;
function adminNotifications(){
    $total_notifications_count = array();
    $total_notify_count = 0;

    //:admin_login
    $admin_login = \App\Notifications::where('type','App\Notifications\NewLogin')->whereNull('read_at')->orderby('created_at','DESC')->get();
    array_push($total_notifications_count,(int)$admin_login->count());
    if($admin_login->count()>0){ $total_notify_count++; }

    //:Web Visitors
    $web_visit = \App\Notifications::where('type','App\Notifications\NewVisit')->whereNull('read_at')->orderby('created_at','DESC')->get();
    array_push($total_notifications_count,(int)$web_visit->count());
    if($web_visit->count()>0){ $total_notify_count++; }

    //:User_notifications
    $users = \App\Notifications::where('type','App\Notifications\NewUser')->whereNull('read_at')->orderby('created_at','DESC')->get();
    array_push($total_notifications_count,(int)$users->count());
    if($users->count()>0){ $total_notify_count++; }

    //:answer_notifications
    $answers = \App\Notifications::where('type','App\Notifications\QuestionCompleted')->whereNull('read_at')->orderby('created_at','DESC')->get();
    array_push($total_notifications_count,(int)$answers->count());
    if($answers->count()>0){ $total_notify_count++; }

    //:order_notifications
    $orders =  \App\Notifications::where('type','App\Notifications\NewOrder')->whereNull('read_at')->orderby('created_at','DESC')->get();
    array_push($total_notifications_count,(int)$orders->count());
    if($orders->count()>0){ $total_notify_count++; }

    //:service_notifications
    $booking = \App\Notifications::where('type','App\Notifications\NewBooking')->whereNull('read_at')->orderby('created_at','DESC')->get();
    array_push($total_notifications_count,(int)$booking->count());
    if($booking->count()>0){ $total_notify_count++; }

    //:widthdrawal_notifications
    $withdrawal = \App\Notifications::where('type','App\Notifications\NewWithdrawal')->whereNull('read_at')->orderby('created_at','DESC')->get();
    array_push($total_notifications_count,(int)$withdrawal->count());
    if($withdrawal->count()>0){ $total_notify_count++; }

    //:voucher_notifications
    $vouchers = \App\Notifications::where('type','App\Notifications\NewVoucher')->whereNull('read_at')->orderby('created_at','DESC')->get();
    array_push($total_notifications_count,(int)$vouchers->count());
    if($vouchers->count()>0){ $total_notify_count++; }

    //:fund_transfer_notifications
    $funds = \App\Notifications::where('type','App\Notifications\NewFund')->whereNull('read_at')->orderby('created_at','DESC')->get();
    array_push($total_notifications_count,(int)$funds->count());
    if($funds->count()>0){ $total_notify_count++; }

    //:donation_notifications
    $donations = \App\Notifications::where('type','App\Notifications\NewDonation')->whereNull('read_at')->orderby('created_at','DESC')->get();
    array_push($total_notifications_count,(int)$donations->count());
    if($donations->count()>0){ $total_notify_count++; }

    $notify =array(
        'total_notifications_count' => array_sum($total_notifications_count),
        'total_notify_count' => $total_notify_count,
        'visitors' => $web_visit,
        'users' => $users,
        'answers' => $answers,
        'orders' => $orders,
        'booking' => $booking,
        'withdrawal' => $withdrawal,
        'vouchers' => $vouchers,
        'funds' => $funds,
        'donations' => $donations,
        'login' => $admin_login
    );
    return $notify;
}
?>
