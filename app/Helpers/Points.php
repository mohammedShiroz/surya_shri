<?php

function getCalPoints(){
    $total_withdrawal_provided_points = \App\Withdrawal_points::where('user_id',\Auth::user()->id)->where('status','Provided')->get()->sum('withdrawal_points');
    $total_withdrawal_approved_points = \App\Withdrawal_points::where('user_id',\Auth::user()->id)->Where('status','Approved')->get()->sum('withdrawal_points');


    $cal_points =array(
        'total_direct_points' => \App\Points::where('user_id',\Auth::user()->id)->get()->sum('direct_points'),
        'total_in_direct_points' => \App\Points::where('user_id',\Auth::user()->id)->get()->sum('in_direct_points'),
        'total_transferred_points' => \App\Points::where('user_id',\Auth::user()->id)->get()->sum('forward_points'),
        'total_credited_points' => \App\Points::where('forward_user_id',\Auth::user()->id)->get()->sum('forward_points'),
        'total_used_points' => \App\Payments::where('user_id',\Auth::user()->id)->get()->sum('paid_points'),
        'total_refund_points' => \App\Refund_points::where('user_id',\Auth::user()->id)->get()->sum('refund_points'),
        'total_seller_earn_points' => \App\Seller_points::where('user_id',\auth::user()->id)->whereNotNull('order_id')->get()->sum('earn_points'),
        'total_doctor_earn_points' => \App\Seller_points::where('user_id',\auth::user()->id)->whereNotNull('booking_id')->get()->sum('earn_points'),
        'total_redeem_points' => \App\RedeemPoints::where('user_id',\auth::user()->id)->get()->sum('points'),
        'total_withdrawal_points' => ($total_withdrawal_provided_points + $total_withdrawal_approved_points),
        'pending_withdrawal_points' => \App\Withdrawal_points::where('user_id',\Auth::user()->id)->where('status','Requested')->get()->sum('withdrawal_points'),
        'pending_paid_points' => \App\Withdrawal_points::where('user_id',\Auth::user()->id)->where('status','Approved')->whereNull('amount')->get()->sum('withdrawal_points'),
        'total_withdrawal_fee_points' => \App\Points_Commission::where('commission_user_id',\Auth::user()->id)->where('type','Site')->where('pay_type','Withdrawal Charge')->get()->sum('commission_points'),
    );
    return $cal_points;
}

function getFinalPoints(){

    $getCalPoints=getCalPoints();
    $final_points =array(
        'available_points' => (($getCalPoints["total_direct_points"]+$getCalPoints["total_in_direct_points"]+$getCalPoints["total_credited_points"]+$getCalPoints["total_redeem_points"]+$getCalPoints["total_refund_points"]+$getCalPoints["total_seller_earn_points"]+$getCalPoints["total_doctor_earn_points"])-($getCalPoints["total_transferred_points"]+$getCalPoints["total_used_points"]+$getCalPoints["total_withdrawal_points"]+$getCalPoints["pending_withdrawal_points"])),
        'total_points' => ($getCalPoints["total_direct_points"]+$getCalPoints["total_in_direct_points"]) - ($getCalPoints["pending_withdrawal_points"] + $getCalPoints["total_withdrawal_points"]+$getCalPoints["total_withdrawal_fee_points"]),
    );
    return $final_points;
}

function getTransferablePoints($id){
    $points =0;
    $getCalPoints=getCalPointsByUser($id);
    $transfer_points=(($getCalPoints["total_direct_points"]+$getCalPoints["total_in_direct_points"]+$getCalPoints["total_credited_points"]+$getCalPoints["total_seller_earn_points"]+$getCalPoints["total_doctor_earn_points"])-($getCalPoints["total_transferred_points"]+$getCalPoints["total_used_points"]+$getCalPoints["total_withdrawal_points"]+$getCalPoints["pending_withdrawal_points"]));
    if($transfer_points>0){
        $points = $transfer_points;
    }
    return $points;
}

function getCalPointsByUser($id){

    $total_withdrawal_provided_points = \App\Withdrawal_points::where('user_id',$id)->where('status','Provided')->get()->sum('withdrawal_points');
    $total_withdrawal_approved_points = \App\Withdrawal_points::where('user_id',$id)->Where('status','Approved')->get()->sum('withdrawal_points');

    $total_withdrawal_provided_paid = \App\Withdrawal_points::where('user_id',$id)->where('status','Provided')->get()->sum('amount');
    $total_withdrawal_approved_paid = \App\Withdrawal_points::where('user_id',$id)->Where('status','Approved')->get()->sum('amount');

    $cal_points =array(
        'total_direct_points' => \App\Points::where('user_id',$id)->get()->sum('direct_points'),
        'total_in_direct_points' => \App\Points::where('user_id',$id)->get()->sum('in_direct_points'),
        'total_transferred_points' => \App\Points::where('user_id',$id)->get()->sum('forward_points'),
        'total_credited_points' => \App\Points::where('forward_user_id',$id)->get()->sum('forward_points'),
        'total_used_points' => \App\Payments::where('user_id',$id)->get()->sum('paid_points'),
        'total_refund_points' => \App\Refund_points::where('user_id',$id)->get()->sum('refund_points'),
        'total_donated_points' => \App\Points_Commission::where('user_id',$id)->where('type','Donations')->get()->sum('commission_points'),
        'total_seller_earn_points' => \App\Seller_points::where('user_id',$id)->whereNotNull('order_id')->get()->sum('earn_points'),
        'total_doctor_earn_points' => \App\Seller_points::where('user_id',$id)->whereNotNull('booking_id')->get()->sum('earn_points'),
        'total_redeem_points' => \App\RedeemPoints::where('user_id',$id)->get()->sum('points'),
        'total_withdrawal_points' => ($total_withdrawal_provided_points+$total_withdrawal_approved_points),
        'total_withdrawal_paid' => ($total_withdrawal_provided_paid+$total_withdrawal_approved_paid),

        'pending_withdrawal_points' => \App\Withdrawal_points::where('user_id',$id)->where('status','Requested')->get()->sum('withdrawal_points'),
        'pending_paid_points' => \App\Withdrawal_points::where('user_id',$id)->where('status','Approved')->whereNull('amount')->get()->sum('withdrawal_points'),
        'total_withdrawal_fee_points' => \App\Points_Commission::where('commission_user_id',$id)->where('type','Site')->where('pay_type','Withdrawal Charge')->get()->sum('commission_points'),

    );
    return $cal_points;
}

function getFinalPointsByUser($id){

    $getCalPoints=getCalPointsByUser($id);
    $final_points =array(
        'available_points' => (($getCalPoints["total_direct_points"]+$getCalPoints["total_in_direct_points"]+$getCalPoints["total_credited_points"]+ $getCalPoints["total_seller_earn_points"] + $getCalPoints["total_doctor_earn_points"]  + $getCalPoints["total_refund_points"] +$getCalPoints["total_redeem_points"])-($getCalPoints["total_transferred_points"]+$getCalPoints["total_used_points"]+$getCalPoints["total_withdrawal_points"]+$getCalPoints["pending_withdrawal_points"])),
        'total_points' => ($getCalPoints["total_direct_points"]+$getCalPoints["total_in_direct_points"]) - ($getCalPoints["pending_withdrawal_points"] + $getCalPoints["total_withdrawal_points"]+ $getCalPoints["total_withdrawal_fee_points"]),
        'total_donation_points' => \App\Points_Commission::where('user_id',$id)->where('type','Donations')->get()->sum('commission_points'),
    );
    return $final_points;
}

function getWithdrawalablePointsByUser($id){

    $getAvPoints=getFinalPointsByUser($id);
    $final_points =array(
        'total_Withdrawalable_points' => ($getAvPoints["available_points"])
    );
    return $final_points;
}

function getWithdrawalablePointsByAdmin($id){

    $getAvPoints=getFinalPointsByUser($id);
    $getCalPoints=getCalPointsByUser($id);
    $final_points =array(
        'total_Withdrawalable_points' => ($getAvPoints["available_points"])
    );
    return $final_points;
}
?>
