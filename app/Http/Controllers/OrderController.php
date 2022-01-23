<?php

namespace App\Http\Controllers;

use App\Constants\constOrderStatus;
use App\Http\Requests\PlaceOrderRequest;
use App\Models\Item;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Rating;
use App\Helpers\ImageUploader;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Mail;
use App\Models\Notification;


class OrderController extends Controller
{
    public function index(Request $request)
    {
        $restaurant = auth()->user()->restaurant;
        $statuses = ['', constOrderStatus::NEW, constOrderStatus::NOTICED, constOrderStatus::FINISHED, constOrderStatus::CANCELLED];
    	$selected_orders = -1;
        if ($request->isMethod('post')) {
            $order_status = $request->input('order_status');
            if ($order_status > -1) {
            $selected_orders = $order_status; 
                $statuses = [$statuses[$order_status]];
            }
            //             return $statuses;
        }
        // $from  = '2000-01-01';
        // $to = date('Y-m-d');
        // if ($request->isMethod('post')) {

        //         if(!empty($request->input('from_date')) &&  !empty($request->input('to_date')) )
        //         {
        //             $from = $request->input('from_date');
        //             $to = $request->input('to_date');
        //         }

        // }

        // $orders = Order::ofRestaurant($restaurant->id)->where('created_at', '<=', $to)->where('created_at', '>=', $from)->whereIn('status', $statuses)->latest()->paginate(20);
        $location = 'الكل';
        $orders = Order::ofRestaurant($restaurant->id)->whereIn('status', $statuses)->latest()->paginate(20);

        if ($request->isMethod('post')) {
            $location = $request->input('location');
            if ($location != "الكل" && $location != "" ) {
                $orders = Order::ofRestaurant($restaurant->id)->whereIn('status', $statuses)->where('location', '=', $location)->latest()->paginate(20);
            }
        }

        $shops = Order::ofRestaurant($restaurant->id)->whereIn('status', $statuses)->where('location', '!=', 'null')->pluck('location')->toArray();
        $total_orders = Order::ofRestaurant($restaurant->id)->whereIn('status', $statuses)->count();
        $type = $request->query('past') ? 'الطلبات السابقة' : 'الطلبات الجديدة';
        array_push($shops, "الكل");
        $shops = array_unique($shops);
        $TotalOrders = Order::ofRestaurant($restaurant->id)->count();
        $FinishedOrders = Order::ofRestaurant($restaurant->id)->where('status', '=', '3')->count();
        $CancelledOrders = Order::ofRestaurant($restaurant->id)->where('status', '=', '0')->count();
        
        $NewOrders = Order::ofRestaurant($restaurant->id)->where('status', '=', '1')->count();

        return response()->view('restaurant-manager.orders.index', [
            'location' => $location,  'shops' => $shops, 'title' => $type, 'orders' => $orders, 'type' => $type, 'totalOrder' => $TotalOrders, 'restaurant_id' => $restaurant->id,
            'FinishedOrders' => $FinishedOrders,
            'NewOrders' => $NewOrders,
            'selected_orders' => $selected_orders,
            'CancelledOrders' => $CancelledOrders
        ]);
    }

    public function show(Request $request)
    {
        $restaurant = auth()->user()->restaurant;
        $order = $this->getOrder($request->route('id'), $restaurant->id);
        $order->transfer_type = json_decode($order->transfer_type);     
        return response()->view('restaurant-manager.orders.show', ['title' => "اوردر رقم $order->id", 'order' => $order]);
    }

    private function getOrder($id, $restaurantId)
    {
        $order = Order::with('orderItems')->ofRestaurant($restaurantId)->where('id', $id)->first();
        if (!$order) {
            return abort(404);
        }
        return $order;
    }

    public function getNewOrder()
    {
        $restaurantId = $_GET['restaurant_id'];
        $order_id = $_GET['order_id'];

        $order = Order::with('orderItems')->ofRestaurant($restaurantId)->where(['id' => $order_id, 'status' => constOrderStatus::NEW])->first();
        return json_encode($order);
    }


    public function finishOrder(Request $request)
    {
        if ($request->has('admin_notes') && $request->input('admin_notes')) {
            Order::where('id', $request->route('id'))->update(['admin_notes' => $request->input('admin_notes')]);
        }
        $this->updateRequestOrderStatus(constOrderStatus::FINISHED);
        session()->flash('success', 'تم انهاء الطلب بنجاح');
        return redirect()->to('/dashboard/orders');
    }

    private function updateRequestOrderStatus($status)
    {
        $restaurant = auth()->user()->restaurant;
        $order = $this->getOrder(request()->route('id'), $restaurant->id);
        if ($status === constOrderStatus::FINISHED) {
            $order->finish();
        } else if ($status === constOrderStatus::NOTICED) {
            $order->notice();
        }
        return true;
    }

    public function noticeOrder()
    {
        $this->updateRequestOrderStatus(constOrderStatus::NOTICED);
        return response()->json([
            'success' => true
        ], 200);
    }
    public function saveNotifications()
    {
        $order_id = $_GET["order_id"];
        $restaurant_id = $_GET["restaurant_id"];

        if (!Notification::where('order_id', $order_id)->exists()) {
                
            $status = 0;
            $notification = new Notification;
            $notification->order_id = $order_id;
            $notification->status = $status;
            $notification->restaurant_id = $restaurant_id;
            $notification->save();
         
            return response()->json([
                'success' => true
            ], 200);
        }

    }

    public function cancelOrderStatus()
    {

                $order_id = $_GET["order_id"];
        Order::where('id',$order_id)
            ->update(['status' => 0]);

        $orderStatusHistory = OrderStatus::create([
            'status' => 0,
            'order_id' => $order_id,
            'user_id' => auth()->user()->id,
        ]);    

        return response()->json([
            'success' => true,
        ], 200);    
            
    }
    public function updateOrderStatus()
    {
        $status = $_GET["status"];
        $order_id = $_GET["order_id"];
        Order::where('id',$order_id)
            ->update(['status' => $status]);

        $orderStatusHistory = OrderStatus::create([
            'status' => $status,
            'order_id' => $order_id,
            'user_id' => auth()->user()->id,
        ]);    

        return response()->json([
            'success' => true,
            'nextUpdatedStatus' => constOrderStatus::STATUSES[$status] ,
            'nextStatus' => constOrderStatus::getStatusByIndex($status+1) ,
            
        ], 200);    
            
    }
    public function setRating(Request $request)
    {
        $name = $request->input('name');
        $rating_val = $request->input('rating');
        $rater_note = $request->input('rater_note');
        $restaurant_id = $request->input('restaurant_id');
        
        $rating=new Rating;
        $rating->name=$name;
        $rating->rate=$rating_val;
        $rating->rater_note=$rater_note;
        $rating->restaurant_id=$restaurant_id;
        $rating->created_at=date('Y-m-d H:i:s');
        $rating->save();

        return response()->json([
            'success' => true
        ], 200);     
    }  
    public function orderDetails()
    {
        $restaurant = auth()->user()->restaurant;
        $order_id = $_GET["order_id"];
        $order = Order::with('orderItems')->ofRestaurant($restaurant->id)->where('id','=',$order_id)->get();
        // $order = Order::with('orderItems')->ofRestaurant($restaurant->id)->where('orders.id','=',$order_id)->innerJoin('restaurants', 'restaurants.id', '=', 'orders.restaurant_id')->first();
        return response()->view('restaurant-manager.orders.order_detail', ['order' => $order[0]]);
    }
    public function notificationsList()
    {
        
        $restaurant = auth()->user()->restaurant;
        $notifications = Notification::all()->where('restaurant_id',$restaurant->id)->sortByDesc('created_at');
        return response()->view('restaurant-manager.orders.notifications', ['notifications' => $notifications]);

    }
    public function getUnseenNotificationsCount()
    {
        $restaurant_id = $_GET["restaurant_id"];
        $order_count = Notification::all()->where('status','0')->where('restaurant_id',$restaurant_id)->count();
        return response()->json([
            'success' => true,
            'notifications_count'=>$order_count
        ], 200);
    }
    public function placeOrder(PlaceOrderRequest $request)
    {

        $requestItems =  json_decode($request->input('items'), true);
        foreach($requestItems as $cartItem)
        {
             $item =  Item::all()->find($cartItem['id']);
             if ( $item['quantity_summary'] && isset($item['quantity_summary']['remaining']))
             {
                    $summary = $item['quantity_summary']; 
                    if($summary['remaining'] < $cartItem["quantity"])
                    {
                        return response()->json([
                            'errors' => [
                                'message' => ['نأسف لوجود منتج غير متاح']
                            ]
                        ], 422);
                    }
                    $summary['remaining'] =$summary['remaining'] - $cartItem["quantity"];
                    $item['quantity_summary'] = $summary;
                }
             $item->save(); 
        }
        $idArr = Arr::pluck($requestItems, 'id');
        $items = Item::whereIn('id', $idArr)->ofRestaurantId($request->get('restaurant')->id)->get();

        if (
            count($idArr) !== $items->pluck('id')->count()
            && Arr::pluck($requestItems, 'price') !== $items->pluck('current_price')
        ) {
            return response()->json([
                'errors' => [
                    'message' => ['نأسف لوجود منتج غير متاح']
                ]
            ], 422);
        }

        $total = $this->calculateTotalPrice($requestItems);
       
        $transferType  = array();
        if ($request->hasfile('transfer_type_recp')) {
            $path = ImageUploader::handle($request->file('transfer_type_recp'), 'bank_transfer');
            $transferType["image_path"] = $path;
        }
        $transferType["transfer_type"] = $request->input('transfer_type');

        $order = Order::create([
            'pickup_type' => $request->input('pickup_type'),
            'transfer_type' => json_encode($transferType),
            'customer_address' => $request->input('address'),
            'customer_name' => $request->input('name'),
            'customer_phone' => $request->input('phone'),
            'customer_notes' => $request->input('notes'),
            'location' => $request->input('location'), 
            'restaurant_id' => $request->get('restaurant')->id,
            'total' => $total,
            'cart_options->date' => $request->input('date'),
            'cart_options->note' => $request->input('note'),
            'cart_options->allergens' => $request->input('allergens'),
        ]);

        $order->items()->attach($this->formatItemOrderArray($requestItems, $items));
        $orderStatusHistory = OrderStatus::create([
            'status' => 1,
            'order_id' => $order->id,
            'user_id' => 0,
        ]);

        if (isset($request->get('restaurant')->user_email)) {
            $owner_email = $request->get('restaurant')->user_email;
            Mail::send('mail', ['user' => $request->get('name')], function ($m) use ($owner_email) {
                $m->from('bb17pugc@gmail', 'Menuspages');
                $m->to($owner_email, 'Manager')->subject('تم استلام طلب جديد');
            });
        }

        return response()->json([
            'success' => 'true',
            'message' => 'تم انشاء الطلب بنجاح' ,
            'order' => $order
        ], 201);
    }

    private function calculateTotalPrice($items)
    {
        $total = 0;
        foreach ($items as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }

    private function formatItemOrderArray($requestItems, $items)
    {
        $itemsNames = $items->pluck('name', 'id');
        $formattedItems = [];
        foreach ($requestItems as $requestItem) {
            $formattedItems[$requestItem['id']] = [
                'item_name' => $itemsNames[$requestItem['id']],
                'price_per_unit' => $requestItem['price'],
                'quantity' => $requestItem['quantity'],
                'sub_details_note' => json_encode(empty($requestItem['sub_details']) ? array() : $requestItem['sub_details'])
            ];
        }
        return $formattedItems;
    }
}
