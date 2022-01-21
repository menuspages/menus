@extends('layouts.restaurant-manager-dashboard')

@section('content')
<div class="main-content">
            <!-- Top navbar -->
<nav class="navbar navbar-top navbar-expand-md  navbar-dark" id="navbar-main">
    <div class="container-fluid">

        <!-- Brand -->
        <a class="h4 mb-0 text-white text-uppercase d-none d-lg-inline-block">    Restaurants
</a>
        
        <!-- Form -->
        <form method="GET" class="navbar-search navbar-search-dark form-inline mr-3 d-none d-md-flex ml-lg-auto">
           
        </form>
    </div>

</nav>
    
                <div class="modal fade" id="productModal" z-index="9999" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-" role="document" id="modalDialogItem">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="modalTitle" class="modal-title" id="modal-title-new-item"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <div class="card shadow border-0">
                    <div class="card-body px-lg-5 py-lg-5">
                        <div class="row">
                            <div class="col-sm col-md col-lg text-center" id="modalImgPart">
                                <img id="modalImg" src="" width="295px" height="200px">
                            </div>
                            <div class="col-sm col-md col-lg col-lg" id="modalItemDetailsPart">
                                <input id="modalID" type="hidden"></input>
                                <span id="modalPrice" class="new-price"></span>
                                <p id="modalDescription"></p>
                                <div id="variants-area">
                                    <label class="form-control-label">Select your options</label>
                                    <div id="variants-area-inside">
                                    </div>
                                </div>
                                <div id="exrtas-area">
                                    <br />
                                    <label class="form-control-label" for="quantity">Extras</label>
                                    <div id="exrtas-area-inside">
                                    </div>
                                </div>
                                                               <div class="quantity-area">
                                    <div class="form-group">
                                        <br />
                                        <label class="form-control-label" for="quantity">Quantity</label>
                                        <!--<input type="number" name="quantity" id="quantity" class="form-control form-control-alternative" placeholder="1" value="1" required autofocus>-->
                                            <input
                                                    type="number"
                                                    min="1"
                                                    step="1"
                                                    onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                                    name="quantity" 
                                                    id="quantity" 
                                                    class="form-control form-control-alternative" 
                                                    placeholder="1" 
                                                    value="1" 
                                                    required 
                                                    autofocus
                                            >
                                    </div>
                                    <div class="quantity-btn">
                                        <div id="addToCart1">
                                            <button class="btn btn-primary" v-on:click='addToCartAct'>Add To Cart</button>
                                        </div>
                                    </div>
                                   
                                </div>
                                                               <!-- Inform if closed -->
                                                                <!-- End inform -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-import-restaurants" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-new-item">Import restaurants from CSV</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <div class="card bg-secondary shadow border-0">
                    <div class="card-body px-lg-5 py-lg-5">
                        <div class="col-md-10 offset-md-1">
                        <form role="form" method="post" action="https://zebra-qr.com/import/restaurants" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="8Yn3Xjk4J6EF7HsUVugWf02nohePnxRgqkYf5zd2">                            <div class="form-group text-center">
                                <label class="form-control-label" for="resto_excel">Import your file</label>
                                <div class="text-center">
                                    <input type="file" class="form-control form-control-file" name="resto_excel" accept=".csv, .ods, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required>
                                </div>
                            </div>
                            <input name="category_id" id="category_id" type="hidden" required>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary my-4">Save</button>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0"> Notifications</h3>
                            </div>
                            <div class="col-4 text-right collapse">
                                <a href="https://zebra-qr.com/restaurants/create" class="btn btn-sm btn-primary">Add Restaurant</a>
                                                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                                            </div>
                    <div class="table-responsive">
                            <div class="container" >
                            @foreach($notifications as $item)
                                <div>
                                     <div class="bg-white px-2 py-2 d-flex" style="justify-content:space-between;background-color:{{$item->status == '0' ? '#dcdedd':'#fff' }} " >
                                            <div>
                                                    <h4>
                                                         تم استلام طلب جديد
                                                     </h4>
                                                     {{ date('h:m:s y-M-d', strtotime($item->created_at)) }}
                                            </div>
                                            <div class="pull-left" >
                                                  <a href="/{{explode('/',Request::path())[0]}}/orders/{{$item->order_id}}" class="btn btn-primary" >Details</a>
                                            </div>
                                     </div>
                                </div>
                            @endforeach
                            </div>
                    </div>
                    <div class="card-footer py-4">
                        <nav class="d-flex justify-content-end" aria-label="...">
                            <nav>
    </nav>

                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <footer class="footer">
    <div class="row align-items-center justify-content-xl-between">
</div></footer>    </div>
        </div>

@endsection

@section('body-scripts')
   
@endsection
