
<?php
use App\Models\Cart;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Auth;

function totalCartItems(){
    if(Auth::check()){ //if user is log-in get the user id
        $user_id = Auth::user()->id;
        $totalCartItems = Cart::where('user_id',$user_id)->sum('quantity');
    } else {
        $session_id = Session::get('session_id');
        $totalCartItems = Cart::where('session_id',$session_id)->sum('quantity');
    }

    return $totalCartItems;
}
?>