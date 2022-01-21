@include('layouts.menu-partials.sub_details_new')
@if(json_decode($item->sub_details))
<div class="px-2 btn-box" style="display: flex;justify-content: center;align-items: center;border-radius: 10px;"    >
    <label class="btn-open_details" style="width: 100%;" for="">
    <b> تفاصيل اضافية </b>
    </label>

    <div id="sub_details_item_{{$item->id}}" class="details shadow pop-sub-details"  >
    
    <div class="text-center" > 
    <i class="fa fa-times pull-left btn-close-sub-details "  ></i>
    <br>
    <div class="d-flex align-items-center mx-4" >
        <img loading="lazy" src="{{$item->image_path}}" alt="{{$item->name}}" height="50" width="50" aria-view="true">
        <div class="grid mx-2 " >
            <label class="no-margin line-height text-right" >
                    <b> 
                            @php
                                $name = trim($item->name)
                            @endphp
                        {{$name}} 
                        </b>
            </label>
            @if($item->current_price > 0)
            <label class="mx-2 no-margin light-grey text-right text-uppercase line-height" >
                    <b> {{$item->current_price}} {{$restaurant->currency}} </b>
            </label>
            @endif
        </div>
    </div>
    </div>    
    <div class="position-relative" >
        <div class="text-center btn-toggle-list-sub-items" onclick="toggleSubItemsList(document.getElementById('listSubItems{{$item->id}}'))" >
            <i class="fa fa-pen" ></i>
        </div>
        <hr>
    </div>
    <div class="font-10 position-relative scrollable max-height-70" id="listSubItems{{$item->id}}" >
                    @foreach(json_decode($item->sub_details) as $index => $value) 
                    
                            <div class="sub-details-inner my-2" >
                                <div  style="display: flex;justify-content: space-between;align-items: center" >
                                        <div class="checkbox" style="
                                            display: flex;
                                            margin: 0px  10px  0px  0px;
                                            align-items:center
                                        " >
                                        <div class="container-input-checkbox" >
                                        
                                            <input type="checkbox" class="input-checkbox" id="checkbox{{$item->id}}{{$index}}" onchange="toggleSelect(this , '<?php echo  $value[0] ?>' , '<?php echo  $value[1] ?>' , '{{$item->id}}','{{$index}}'  )" >                                        
                                        </div>
                                        <h6 class="mx-2 label-sub-detail-item" for="checkbox<?php echo  $value[0] ?>">
                                             {{$value[0]}}
                                        </h6>
                                        </div>
                                        <div class="text-align-left" >
                                            <div class="mx-2 font-size-15 line-height-0" >
                                                    @if($value[1] > 0 )                                                   
                                                            <label class="line-height  margin-0 " for="">{{$value[1] ?? ''}}</label>
                                                            <label class="line-height  margin-0 text-uppercase" for="">{{$restaurant->currency}}</label> 
                                                    @endif
                                            </div>
                                        </div>
                                    
                                </div>
                            </div>  
                    @endforeach
        <textarea name="" id="txtareaSubDetailsNote{{$item->id}}"   onkeyup="addSubDetailsNotes(this , '{{$item->id}}')" cols="30" placeholder="الملاحظات" class="width-available pos-abs form-control mx-2" rows="3"></textarea>                            
    </div>  
     <div class="mx-2 my-4 d-flex" >
           <div class="d-flex width-50 text-center section-quantity justify-content-center align-items-center" >
                    <i class="fa fa-plus border" @click="setQuantity({{$item->quantity_summary != null ? $item->quantity_summary['remaining'] == null ? 'null' : $item->quantity_summary['remaining']  : 'null' }},'{{$item->id}}',getItemCurrentQuantity('{{$item->id}}')+1)" >

                    </i>
                    <label for="" class="lbl-quantity" id="lblQuantity{{$item->id}}" >
                            1
                    </label>
                    <i class="fa fa-minus border" @click="setQuantity('{{$item}}','{{$item->id}}',getItemCurrentQuantity('{{$item->id}}')-1)" >

                    </i>
           </div>
           <button v-if="typeof cart[{{$item->id}}] === 'undefined'" @click="addItemToCart({{$item}},getItemCurrentQuantity('{{$item->id}}'))" class="width-50 btn btn-primary" >
             {{$language["add_to_cart"]}}
           </button>
           <button v-if="typeof cart[{{$item->id}}] !== 'undefined'" @click="removeFromCart({{$item->id}})" class="width-50 btn btn-danger" >
             {{$language["remove_from_cart"]}}
           </button> 
     </div>
    </div>
        
</div>    
@endif



<script>
$(function () {

       // check add to cart availability
       if ( $('#add_to_cart_avl{{$item->id}}').children().length == 0 )
        {
            $('#a{{$item->id}}').siblings('.btn-open_details').css({'display' : 'block'});
        }
        else 
        {
            $('#a{{$item->id}}').siblings('.btn-open_details').css({'display' : 'none'});
        }
})    
    function toggleSubItemsList(e)
    {
        $(e).toggle('slow');
    }
    product_sub_details = {};   
    function addSubDetailsNotes(e,product_id)
    {
            var value = $(e).val();
            selectedItems = getIfSubDetailsAlreadyExists(product_id);
            selectedItems = jQuery.grep(selectedItems, function(value) {
            return value[2] != "note";
            });

            item = []
            item.push(value);
            item.push(0);   
            item.push("note");   
            selectedItems.push(item);
            product_sub_details[product_id] = selectedItems;
            app.changeSubDetailsItems(product_id)
    }
    function getSubDetailsData(product_id)
    {
        return product_sub_details[product_id];
    }
    function getItemCurrentQuantity(product_id)
    {
        return parseInt($("#lblQuantity"+product_id).text())
    }
    function resetSubDetailsData(product_id)
    {
        unCheckAllSubItems(product_id);
    }
    
    function unCheckAllSubItems(product_id)
    {       
            if(product_sub_details[product_id] != undefined)
            {
                if(product_sub_details[product_id].length > 0)
                {
                    jQuery.grep(product_sub_details[product_id], function(value) {
                        $("#checkbox"+product_id+value[3]).css({"background-color" : "white"});
                        $("#checkbox"+product_id+value[3]).prop('checked',false);
                    });
                    product_sub_details[product_id] = [];

                }
                $("#txtareaSubDetailsNote"+product_id).val("")
            }
            
    }
    function getIfSubDetailsAlreadyExists(product_id) {
        selectedItems = [];
        if(product_sub_details[product_id] != undefined)
        {
            selectedItems = product_sub_details[product_id];
        }
        return selectedItems;
    }
    function toggleSelect(tag , name , price , product_id,item_id)
    {
        
        selectedItems = getIfSubDetailsAlreadyExists(product_id)
        if(tag.checked)
        {
            $(tag).css("background-color" , "red");
            item = []
            item.push(name);
            item.push(price == 'null' ? 0 : price);   
            item.push("item");
            item.push(item_id);
            
            selectedItems.push(item);
        }       
        else 
        {
            $(tag).css("background-color" , "white");
            selectedItems = jQuery.grep(selectedItems, function(value) {
            return value[0] != name;
            });
        }
        product_sub_details[product_id] = selectedItems;
        app.changeSubDetailsItems(product_id)
    }

    $(document).ready(function()
    {
            $('.btn-open_details').on('click' , function()
            {
                    $('#sub_details_item_{{$item->id}}').removeClass('collapse');
                    $('#sub_details_item_{{$item->id}}').css({'display' : 'initial'});
                    $('#sub_details_item_{{$item->id}}').animate({height: '100%'});
                    $('#sub_details_item_{{$item->id}}').css({'border' : 'border solid 1px'});
            });  
            $('.btn-close-sub-details').on('click' , function()
            {
                $('#sub_details_item_{{$item->id}}').animate({height: '0%'});
                $('#sub_details_item_{{$item->id}}').css({'display' : 'initial'});
                $('#sub_details_item_{{$item->id}}').css({'border' : 'none'});
            });                  
    });
</script>

