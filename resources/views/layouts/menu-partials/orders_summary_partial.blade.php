<style>
    /* order filter css */
    .selected
    {
        background-color:green;
        color:white;
    }

    .btn-orders-filter {
        cursor: pointer;
        outline: none;
        margin:0px 0px 10px 0px;
        padding: 0px;
        border: none;
        color:black;
        border-radius:20px;
        background-color: transparent;
        width: 100%;
    }

    .btn-orders-filter .col span
    {
        margin:0px 10px 10px 0px;

    }
    .btn-orders-filter .col 
    {
        display: flex !important;
        align-items: center !important;
    }
    
    .btn-orders-filter:focus {
        outline: none;
        border: none;
    }

    .card {
        border: none;
    }

    form {
        border-radius: 5px;
        background-color: white;
    }
</style>

<div class="header-body">
    <!-- Card stats -->
    <div class="row">

        <div class="col-xl-3 col-lg-6">
            <a  href="/dashboard/orders/notifications-list"> 
                <button class="btn-orders-filter" type="submit">
                    <div class="card card-stats mb-4 mb-xl-0 border shadow">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase  mb-0">اشعارات الطلبات الجديدة</h5>
                                    <span class="live-orders h2 font-weight-bold mb-0">0</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape  rounded-circle">
                                        <i class="fas fa-signal"></i>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </button>
            </a>
        </div>

        <div class="col-xl-3 col-lg-6">
            <form method="post" role="form" action="{{Request::url()}}">
                {{ csrf_field() }}

                <input type="hidden" value="-1" name="order_status" />
               
                @if( strpos(Route::current()->getName(), 'orders') == true)
                <button class="btn-orders-filter" type="submit">
                    @else
                    <button class="btn-orders-filter" type="button">
                        @endif

                        <div class="card card-stats  mb-xl-0 border shadow <?php if($selected_orders == -1) echo "selected" ?> "
                        >
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase  mb-0">جميع الطلبات
                                        </h5>
                                        <span class="h2 font-weight-bold mb-0">{{$totalOrder}}</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape rounded-circle ">
                                            <i class="fas fa-shopping-basket"></i>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </button>
            </form>
        </div>

        <div class="col-xl-3 col-lg-6">
            <form method="post" role="form" action="{{Request::url()}}">
                {{ csrf_field() }}

                <input type="hidden" value="0" name="order_status" />
               
                @if( strpos(Route::current()->getName(), 'orders') == true)
                <button class="btn-orders-filter" type="submit">
                    @else
                    <button class="btn-orders-filter" type="button">
                        @endif

                        <div class="card card-stats  mb-xl-0 border shadow <?php if($selected_orders == 0) echo "selected" ?> "
                        >
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase  mb-0">
                                            الطلبات الملغاة
                                        </h5>
                                        <span class="h2 font-weight-bold mb-0">{{$CancelledOrders}}</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape rounded-circle ">
                                            <i class="fas fa-times"></i>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </button>
            </form>
        </div>

        <div class="col-xl-3 col-lg-6">

            <form method="post" role="form" action="{{Request::url()}}">
                {{ csrf_field() }}

                <input type="hidden" value="3" name="order_status" />

                @if( strpos(Route::current()->getName(), 'orders') == true)
                    <button class="btn-orders-filter" type="submit">
                    @else
                    <button class="btn-orders-filter" type="button">
                        @endif


                        <div class="card card-stats  mb-xl-0 border shadow <?php if($selected_orders == 3) echo "selected" ?> "
                        >
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase  mb-0">الطلبات المنجزة
                                        </h5>
                                        <span class="h2 font-weight-bold mb-0"> {{$FinishedOrders}}</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape   rounded-circle">
                                            <i class="fas fa-chart-line"></i>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </button>
            </form>
        </div>

        <div class="col-xl-3 col-lg-6">

            <form method="post" role="form" action="{{Request::url()}}">
                {{ csrf_field() }}

                <input type="hidden" value="1" name="order_status" />
                @if( strpos(Route::current()->getName(), 'orders') == true)
                    <button class="btn-orders-filter" type="submit">
                    @else
                    <button class="btn-orders-filter" type="button">
                        @endif
                        <div class="card card-stats mb-xl-0 border shadow <?php if($selected_orders == 1) echo "selected" ?> "
                        >
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase  mb-0"> الطلبات الجديدة 
                                        </h5>
                                        <span class="h2 font-weight-bold mb-0">{{$NewOrders}}</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape  rounded-circle">
                                            <i class="fas fa-bell "></i>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </button>
            </form>
        </div>


    </div>

    <br />
</div>
