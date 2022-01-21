<!-- Modal -->
<?php

$delivery_const = array(

    "eng" => array(
        "delivery" => "1",
        "receipt" => "2",
        "sweetened" => "3",
    ),
    "arb" => array(
        "توصيل" => "1",
        "استلام" => "2",
        "محلي" => "3",
    )
);

$language = array(
    "eng" => array(
        "heading" => "Complete the request",
        "title" => "Products",
        "delivery" => "Delievery",
        "receipt" => "Receipt",
        "check_out" => "Check out",
        "cont_shopping" => "Continue Shopping",
        
        "sweetened" => "Local",
        "total" => "Total",
        "currency" => $restaurant->currency,
        "cash_on_delievery" => "Cash on Delievery",
        "name" => "Name",
        "phone" => "Phone number",
        "name_placeholder" => "Please enter the name",
        "money_transfer" => "Money Transfer",
        "other_transfer" => "Other Transfer",
        "phone_placeholder" => "Please enter the phone number",
        "address" => "Address",

        "address_placeholder" => "Please enter the address",
        "notes" => "Notes",
        "notes_placeholder" => "Enter notes on request",
        "btn_submit" => "Submit",
        "btn_cancel" => "Cancel"


    ), "arb" => array(
        "money_transfer" => "تحويل بنكي",
        "other_transfer" => "تحويل",
        "heading" => "قائمة الطلبات",
        "title" => "المنتجات",
        "delivery" => "توصيل",
        "check_out" => "اكمال الطلب",
        "cont_shopping" => "اضافه منتج اخر ",
        "receipt" => "استلام",
        "sweetened" => "محلي",
        "total" => "الاجمالي",
        "currency" => $restaurant->currency,
        "cash_on_delievery" => "الدفع عند الاستلام ",
        "name" => "الاسم",
        "phone" => "رقم التليفون ",
        "name_placeholder" => "من فضلك ادخل الاسم",

        "phone_placeholder" => "من فضلك ادخل رقم التليفون",
        "address" => "العنوان",

        "address_placeholder" => "من فضلك ادخل العنوان",
        "notes" => "ملحوظات",
        "notes_placeholder" => "ادخل ملحوظات علي الطلب",
        "btn_submit" => "اطلب",
        "btn_cancel" => "الغاء"
    )
);

try {
    $data = json_decode($restaurant->accounts);
    $delivery_options = [];
    $payment_options = [];

    $bank_details = [];
    $other_details = [];
    
    foreach (json_decode($restaurant->accounts)  as $item) {
        if ($item->category == "payment") {
            if (!in_array($language[$_GET["lang"]][$item->type], $payment_options)) {
                array_push($payment_options, $language[$_GET["lang"]][$item->type]);
            }
        }

        if ($item->category == "delivery") {
            if (!in_array($language[$_GET["lang"]][$item->type], $delivery_options)) {
                array_push($delivery_options, $language[$_GET["lang"]][$item->type]);
            }
        }

        if ($item->type == "money_transfer") {
            array_push($bank_details, $item);
        }
        if ($item->type == "other_transfer") {
            array_push($other_details, $item);
        }
    }
} catch (Exception $e) {
}
?>

<div class="modal no-padding fade" id="place-order-modal" tabindex="-1" role="dialog" aria-labelledby="place-order-modal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" >
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?php echo $language[$_GET["lang"]]["heading"]; ?> </h5>
                <div class="d-flex flex-column align-items-start">
                    </div>
                <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                
                <div class="contianer-products" >
                <h5>  <?php echo $language[$_GET["lang"]]["title"]; ?> </h5>
                <ul class="list-group" id="order-items-container">
                    <li class="list-group-item" v-for="(orderItem, id) in cart">
                        <div class="d-flex justify-content-between">
                            <div>
                                <span>@{{orderItem.name}}</span>
                                <div>
                                    <i class="fas fa-plus cursor-pointer quantity-button" @click="changeQuantity(getItem(),id,1)"></i>
                                    <div class="flatted-well active collapse">@{{getQuantity(id)}}</div>
                                    <i class="fas fa-minus cursor-pointer quantity-button" @click="changeQuantity(getItem(),id,-1)"></i>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between flex-column text-left">
                                <div class="d-flex justify-content-between align-items-center" >
                                    <span class="mx-2 bold d-block">
                                        @{{orderItem.current_price * orderItem.quantity}} {{$restaurant->currency}}
                                    </span>
                                    <span class="collapse" >
                                        (@{{getQuantity(id)}})
                                    </span>
                                </div>
                                <span><i class="fas fa-trash text-danger btn-item-remove cursor-pointer" @click="removeFromCart(id)"></i></span>
                            </div>

                        </div>
                        <div>
                            <div class="mx-2 my-2" v-for="index in orderItem.sub_details" :key="index">
                                <div v-if="index[2] == 'item' " >
                                    @{{ index[0] }}
                                    <span style="    padding: 0px 5px 0px 5px;
                                                        color: white;
                                                        background-color: grey;
                                                        border-radius: 102px;">

                                    @{{ index[1] > 0 ? index[1] : 0 }}
                                </div>
                            </div>
                            <div class="mx-2 my-2" v-for="index in orderItem.sub_details" :key="index">
                                <label v-if="index[2] == 'note' && index[0] != ''" class="lbl-bold" >* @{{ index[0] }} *</label>
                            </div>
                        </div>
                    </li>
                </ul>
                
                <div class="container-fixed-bottom collapse" >
                     <button class="btn btn-primary btn-check-out" onclick="ContinueShoppingOrCheckOut(true)"  >
                         <?php echo $language[$_GET["lang"]]["check_out"]; ?>
                     </button>    

                     <button class="btn btn-success btn-continue-shopping"  data-dismiss="modal" >
                         <?php echo $language[$_GET["lang"]]["cont_shopping"]; ?>
                     </button>    
                </div>    
                </div> 
            @if($restaurant->enable_component < 2)                       
            <div class="contianer-check-out" >
                <div>
                    <?php
                    $data = json_decode($restaurant->contacts);
                    $IS__LOCATION_FOUND = false;
                    if ($data) {
                    ?>
                        <!-- location links part started -->
                        <div>
                            <?php
                            foreach ($data as $name => $value) {

                                if ($value[3] == "location") {
                                    $IS__LOCATION_FOUND = true;
                                    break;
                                }
                            }

                            if ($IS__LOCATION_FOUND) {
                            ?>
                                <b> اختر الفرع </b>
                                <div class="social my-2" style="display:flex;justify-content: center;overflow: auto;">

                                    <?php
                                    $counter = 0;
                                    foreach ($data as $name => $value) {

                                        if ($value[3] == "location") {
                                            $IS__LOCATION_FOUND = true;
                                    ?>
                                            <div class="mx-2">
                                                <a class="mr-1" style="text-decoration:none" href="<?php echo $value[1]; ?>" style="font-size:20px;">
                                                    <div>
                                                        <input type="radio" v-model="location" name="location" value="<?php echo $value[2]; ?>" <?php                                                                                     ?> />
                                                        <b class="phone"> <?php echo $value[2]; ?></b>
                                                    </div>

                                                </a>
                                            </div>
                                    <?php
                                        }
                                        $counter = $counter + 1;
                                    }
                                    ?>

                                </div>
                            <?php
                            }
                            ?>


                        </div>
                        <!-- location links part ended -->

                        <br>
                    <?php
                    }
                    ?>
                </div>
                <div class="d-flex flex-column align-items-end">
                    <div class="d-flex flex-column align-items-start">
                        <h6><?php echo $language[$_GET["lang"]]["total"]; ?> </h6>
                        <h5 class="font-weight-bold">@{{calculateTotal()-1}} <?php echo $language[$_GET["lang"]]["currency"]; ?> </h5>
                    </div>
                </div>
                <hr>

                 <div class="" >
                 <form>
                    <div class="form-group flex-1">

                        <div class="container-tabs border" >

                            <div class="d-flex bg-grey" id="tabContainer" >
                                <button for="" onclick="openContainer(this,document.getElementById('PaymentOptions'))" class="width-50 tab-shipping-details-selected btn" type="button">
                                    خيارات الدفع
                                </button>
                                <button for="" onclick="openContainer(this,document.getElementById('DelieveryOptions'))" type="button" class="width-50  btn">
                                    خيارات التوصيل والاستلام
                                </button>
                            </div>
                            
                            <div id="PaymentOptions" class="payment-options my-2 mx-2">
                                <div class="">
                                    <?php

                                    try {
                                        foreach ($payment_options as $item) {

                                    ?>
                                            <div>
                                                <input onchange="checkPaymentType(this)" class="form-check-input-payment-option" type="radio" name="payment_type" id="payment_type" v-model="payment_type" value="{{$item}}">
                                                <label class="form-check-label" id="lblTransferType">
                                                    <?php echo $item; ?>
                                                </label>
                                            </div>
                                    <?php

                                        }
                                    } catch (Exception $e) {
                                    }

                                    ?>

                                </div>
                            </div>

                            <div id="DelieveryOptions" class="delivery-options my-2 mx-2 collapse">
                              
                                <div class="mx-4">
                                    <?php
                                    $index = 1;
                                    try {
                                        foreach ($delivery_options as $item) {

                                    ?>
                                            <div>
                                                <input class="form-check-input " type="radio" name="pickup_type" v-model="pickup_type" @change="changePickUpType" value="<?php echo $index; ?>" <?php if ($index == 1) echo "checked"; ?>>
                                                <label class="form-check-label" for="pickup_type">
                                                    <?php echo $item; ?>
                                                </label>
                                            </div>
                                    <?php
                                            $index = $index + 1;
                                        }
                                    } catch (Exception $e) {
                                    }

                                    ?>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="other_details" style="overflow: auto;display: none;">

                            <?php
                            try {
                                foreach ($other_details as $item) {
                            ?>

                                    <div class="border px-4 py-4" style="display:inline-block">

                                        <div>
                                            <label for="">
                                            من خلال  :
                                            </label>
                                            <label for="">
                                                <b>
                                                    <?php echo $item->Name; ?>
                                                </b>
                                            </label>
                                        </div>

                                        <div>
                                            <label for="">
                                            رقم الحساب :
                                            </label>
                                            <label for="">
                                                <b>
                                                    <?php echo $item->Number; ?>
                                                </b>
                                            </label>
                                        </div>

                                        <div>
                                            <label for="">
                                            ملاحظة:
                                            </label>
                                            <label for="">
                                                <b>
                                                    <?php echo $item->note; ?>
                                                </b>
                                            </label>
                                        </div>
                                    </div>



                            <?php
                                }
                            } catch (Exception $e) {
                            }

                            ?>
                            </div>



                    <div class="bank_details" style="overflow: auto;display: none;">

                        <?php
                        try {
                            foreach ($bank_details as $item) {
                        ?>

                                <div class="border px-4 py-4" style="display:inline-block">

                                    <div>
                                        <label for="">
                                            البنك :
                                        </label>
                                        <label for="">
                                            <b>
                                                <?php echo $item->bankName; ?>
                                            </b>
                                        </label>
                                    </div>

                                    <div>
                                        <label for="">
                                            اسم المحول له :
                                        </label>
                                        <label for="">
                                            <b>
                                                <?php echo $item->personName; ?>
                                            </b>
                                        </label>
                                    </div>

                                    <div>
                                        <label for="">
                                            رقم الحساب :
                                        </label>
                                        <label for="">
                                            <b>
                                                <?php echo $item->accountNumber; ?>
                                            </b>
                                        </label>
                                    </div>

                                    <div>
                                        <label for="">
                                            رقم الايبان :
                                        </label>
                                        <label for="">
                                            <b>
                                                <?php echo $item->fullAccountNumber; ?>
                                            </b>
                                        </label>
                                    </div>


                                </div>



                        <?php
                            }
                        } catch (Exception $e) {
                        }

                        ?>
                    </div>

                    <div class="form-group" >
                        <div class="flex-1 admin-note collapse">
                                <input type="checkbox" />
                                <label>
                                    {{$restaurant->admin_note ?? ''}}
                                </label>
                        </div>
                        <div>
                                <label class="form-control collapse recp-bank_transfer" id="recpBankTransfer" >
                                   <i class="fa fa-camera" ></i>
                                   <label for="">
                                   يرجى ارفاق صورة ايصال التحويل
                                   </label>
                                    <input class="collapse" onchange="saveImage(this)" type="file" id="fileBankTransfer" name="bank_transfer_recp"  />
                                </label>    
                        </div>
                        <div>
                             <img src="" height="100" width="100" class="mx-2 my-2 border collapse" style="object-fit: contain;" id="imgBankRecipt" alt="Reciept">
                        </div>
                    </div>        
                    <div class="d-flex flex-column flex-sm-row justify-content-around">
                        <div class="form-group flex-1">
                            <label for="name"><?php echo $language[$_GET["lang"]]["name"]; ?> </label>
                            <input type="text" class="form-control" name="name" id="name" v-model="name" placeholder="    <?php echo $language[$_GET["lang"]]["name_placeholder"]; ?>">
                        </div>
                        <div class="form-group flex-1 ml-2" id="phone-field" >
                            <label for="phone"><?php echo $language[$_GET["lang"]]["phone"]; ?> </label>
                            <div class="d-flex" style="direction: ltr;">
                                <input class="form-control" style="width:20%" name="phone_code" v-model="phone_code" value="@{{getPhoneCode()}}" disabled />
                                <input type="number" style="width:80%" class="form-control" name="phone" id="phone" v-model="phone" placeholder="<?php echo $language[$_GET["lang"]]["phone_placeholder"]; ?>    ">
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-column flex-sm-row justify-content-around">
                        <div class="form-group flex-1" id="address-field">
                            <label for="address"><?php echo $language[$_GET["lang"]]["address"]; ?> </label>
                            <input type="text" class="form-control" name="address" id="address" v-model="address" placeholder="    <?php echo $language[$_GET["lang"]]["address_placeholder"]; ?>">
                        </div>
                        <div class="form-group flex-1 ml-2">
                            <label for="notes"> <?php echo $language[$_GET["lang"]]["notes"]; ?> </label>
                            <textarea name="notes" class="form-control" id="notes" v-model="notes" placeholder="<?php echo $language[$_GET["lang"]]["notes_placeholder"]; ?>    "></textarea>
                        </div>
                    </div>
                </form>
              </div>       
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm text-danger" onclick="ContinueShoppingOrCheckOut(true)" data-dismiss="modal"> <?php echo $language[$_GET["lang"]]["btn_cancel"]; ?> </button>
                    <button type="button" class="btn btn-success btn-place-order" @click="submit(this)">
                        <?php echo $language[$_GET["lang"]]["btn_submit"]; ?>

                        <img src="{{asset('images/loading.gif')}}" v-if="modalLoading" alt="loading" style="width: 20px">
                    </button>
               </div>
            </div>
            @else 
                   <div class="text-center" >
                       <label for="">شكرا لاختياركم قائمة الطلبات كي نتمكن من خدمتكم بشكل افضل</label>
                   </div>         
            @endif
          </div>

        </div>
    </div>
</div>

<script>
    function getItem()
    {
        return "hi";
    }
    function openContainer(e , container )
    {
         $("#DelieveryOptions").addClass("collapse")
         $("#PaymentOptions").addClass("collapse")
          
         $("#tabContainer").children("button").removeClass("tab-shipping-details-selected");
         $(e).addClass("tab-shipping-details-selected") ;
         $(container).removeClass("collapse")  ;
    }                        
    function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#imgBankRecipt').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}
    function saveImage(e)
    {
        app.saveImage($("#fileBankTransfer")[0].files[0])
        readURL(e);
        $("#imgBankRecipt").removeClass("collapse")
    }
    function checkPaymentType(tag) {

        $("#recpBankTransfer").addClass("collapse")
        $("#imgBankRecipt").addClass("collapse")
        $('.admin-note').addClass("collapse");
        app.saveImage('')
        var payment_type=$("input[name='payment_type']:checked").val();
        app.setPaymentType(payment_type)
        var value = $(tag).val();
        if (value == "Money Transfer" || value == "تحويل بنكي") {
            $('.admin-note').removeClass("collapse");
            $("#recpBankTransfer").removeClass("collapse")
        } 
    }

    function phone_code() {
        return '<?php echo $restaurant->phone_code ?>';
    }


    function ContinueShoppingOrCheckOut(status)
        {
               $(".contianer-check-out").toggleClass("collapse")
               $(".contianer-products").toggleClass("collapse")
        }
    $(document).ready(function() {


        $(".form-check-input-payment-option").change(function() {

            data = $(this).val();
            if (data == "تحويل بنكي" || data == "Money Transfer") {
                if (this.checked) {
                    $('.bank_details').css("display", "flex");
                }
            } else {
                $('.bank_details').css("display", "none");
            }

            if (data == "تحويل" || data == "Other Transfer") {
                if (this.checked) {
                    $('.other_details').css("display", "flex");
                }
            } else {
                $('.other_details').css("display", "none");
            }

        });
    });
</script>
