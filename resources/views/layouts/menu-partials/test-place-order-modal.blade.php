<!-- Modal -->
<?php

$language = array("eng"=> array(
	"heading"=>"Complete the request", 
	"title"=>"Products", 
	"delivery"=>"Delievery" ,
	"receipt"=>"Receipt" ,
	"sweetened"=>"Local" ,
	"total"=>"Total" ,
	"currency"=>"rayal" ,
     "cash_on_delievery" => "Cash on Delievery",    
	"name"=>"Name" ,
	"phone"=>"Phone number (must start with 96)" ,
	"name_placeholder"=>"Please enter the name" ,

	"phone_placeholder"=>"Please enter the phone number" ,
	"address"=>"Address" ,

	"address_placeholder"=>"Please enter the address" ,
        "notes"=>"Notes" ,
        "notes_placeholder"=>"Enter notes on request",
        "btn_submit"=>"Submit",
        "btn_cancel"=>"Cancel"

	
	) , "arb"=> array(
	"heading"=>"اتمام الطلب", 
	"title"=>"المنتجات", 
	"delivery"=>"توصيل" ,
	"receipt"=>"استلام" ,
	"sweetened"=>"محلي" ,
	"total"=>"الاجمالي" ,
	"currency"=>"ريال" ,
    "cash_on_delievery"=>"نقدا على ديليفيري ",
	"name"=>"الاسم" ,
	"phone"=>"رقم التليفون (لابد ان يبدأ ب 96)" ,
	"name_placeholder"=>"من فضلك ادخل الاسم" ,

	"phone_placeholder"=>"من فضلك ادخل رقم التليفون" ,
	"address"=>"العنوان" ,

	"address_placeholder"=>"من فضلك ادخل العنوان" ,
        "notes"=>"ملحوظات" ,
        "notes_placeholder"=>"ادخل ملحوظات علي الطلب" ,
        "btn_submit"=>"اطلب",
        "btn_cancel"=>"الغاء")

	);

    $delivery_options = [];
    $bank_details = [];
    
    foreach(json_decode($restaurant->accounts)  as $item)
    {

        if(!in_array( $language[$_GET["lang"]][$item->type] ,$delivery_options))
        {
            array_push($delivery_options , $language[$_GET["lang"]][$item->type]);
        }
        if($item->type == "money_transfer")
        {
            array_push($bank_details , $item);    
        }
    }


?>


<div class="modal  fade" id="place-order-modal" tabindex="-1" role="dialog"
     aria-labelledby="place-order-modal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="padding: 25px !important;" >
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?php echo $language[$_GET["lang"]]["heading"]; ?>   </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h5><?php echo $language[$_GET["lang"]]["title"]; ?>    </h5>
		
		
                <ul class="list-group" id="order-items-container">
                    <li class="list-group-item" v-for="(orderItem, id) in cart">
                        <div class="d-flex justify-content-between">
                            <div>
                                <span>@{{orderItem.name}}</span>
                                <div>
                                    <i class="fas fa-plus cursor-pointer quantity-button"
                                       @click="changeQuantity(id,1)"></i>
                                    <div class="flatted-well active">@{{orderItem.quantity}}</div>
                                    <i class="fas fa-minus cursor-pointer quantity-button"
                                       @click="changeQuantity(id,-1)"></i>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between flex-column align-items-center">
                                            <span class="fs-12 d-block">
                                                @{{orderItem.current_price * orderItem.quantity}} ريال
                                            </span>
                                <span><i class="fas fa-trash text-danger cursor-pointer"
                                         @click="removeFromCart(id)"></i></span>
                            </div>
                          
                        </div>
                        <div style="display:flex" >
                            <div class="mx-2" v-for="index in orderItem.sub_details" :key="index" >
                                    <input type="checkbox" checked disabled>  
                                    @{{ index }}
                            </div>
                        </div>    
                    </li>
                </ul>

                <hr>
                <div class="d-flex flex-column align-items-end">
                    <div class="d-flex flex-column align-items-start">
                        <h6><?php echo $language[$_GET["lang"]]["total"]; ?>   </h6>
                        <h5 class="font-weight-bold">@{{calculateTotal()}}  <?php echo $language[$_GET["lang"]]["currency"]; ?>   </h5>
                    </div>
                </div>
                <hr>
                <form action="#">
                    <div class="form-group flex-1">
                    <?php
                    foreach($delivery_options as $item) 
                    {
                        ?>
                        <div class="form-check">
                                    <input class="form-check-input"
                                        type="radio"
                                        name="pickup_type"
                                        id="pickup_type"
                                        v-model="pickup_type"
                                        @change="changePickUpType"
                                        value="{{$item}}">
                                    <label class="form-check-label" for="pickup_type">
                                    <?php echo $item; ?> 
                                        <img src="{{asset('images/take_away.png')}}" alt="take_away"
                                            style="width: 20px; height: 20px; margin-right: 5px;">
                                    </label>
                                </div>
                        <?php
                    }
            ?>           
            
            <div class="bank_details" >

            <?php
                    foreach($bank_details as $item) 
                    {
                        ?>
                             <label for="">
                                <b>
                                <?php echo $item[0]; ?>   
                                </b> 
                             </label>    
                             <br>      
                             <label for="">
                                <b>
                                <?php echo $item[1]; ?>   
                                </b> 
                             </label>          
                             
                        <?php
                    }
            ?>     
     



                    <div class="d-flex flex-column flex-sm-row justify-content-around">
                        <div class="form-group flex-1">
                            <label for="name"><?php echo $language[$_GET["lang"]]["name"]; ?>   </label>
                            <input type="text" class="form-control" name="name" id="name" v-model="name"
                                   placeholder="    <?php echo $language[$_GET["lang"]]["name_placeholder"]; ?>">
                        </div>
                        <div class="form-group flex-1 ml-2">
                            <label for="phone"><?php echo $language[$_GET["lang"]]["phone"]; ?>    </label>
                            <input type="number" class="form-control" name="phone" id="phone"
                                   v-model="phone"
                                   placeholder="<?php echo $language[$_GET["lang"]]["phone_placeholder"]; ?>    ">
                        </div>
                    </div>
                    <div class="d-flex flex-column flex-sm-row justify-content-around">
                        <div class="form-group flex-1" id="address-field">
                            <label for="address"><?php echo $language[$_GET["lang"]]["address"]; ?>  </label>
                            <input type="text" class="form-control" name="address" id="address"
                                   v-model="address"
                                   placeholder="    <?php echo $language[$_GET["lang"]]["address_placeholder"]; ?>">
                        </div>
                        <div class="form-group flex-1 ml-2">
                            <label for="notes">  <?php echo $language[$_GET["lang"]]["notes"]; ?>  </label>
                            <textarea name="notes" class="form-control" id="notes" v-model="notes"
                                      placeholder="<?php echo $language[$_GET["lang"]]["notes_placeholder"]; ?>    "></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm text-danger" data-dismiss="modal">   <?php echo $language[$_GET["lang"]]["btn_cancel"]; ?>  </button>
                <button type="button" class="btn btn-success" @click="submit()">
<?php echo $language[$_GET["lang"]]["btn_submit"]; ?>                    

                <img src="{{asset('images/loading.gif')}}" v-if="modalLoading" alt="loading"
                         style="width: 20px">
                </button>
            </div>
        </div>
    </div>
</div>

