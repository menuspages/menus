@if($item->sub_details_new != null)

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
                    @foreach($item->sub_details_new as $index => $value) 
                            @if(array_key_exists('subject', $value[0]))
                                <div class="px-2 direction-ltr bold" >
                                    <h5 class="bold" >{{$value[0]['subject']}}</h5>
                                </div>

                            @endif
                            @if(array_key_exists('items', $value[1]))
                                @foreach($value[1]['items'] as $it)
                                   
                                    <div class="sub-details-inner my-2" >
                                    <div  style="display: flex;justify-content: space-between;align-items: center" >
                                            <div class="checkbox"  >
                                            <div class="container-input-checkbox" >
                                            
                                                <input type="checkbox" class="input-checkbox" id="checkbox{{$item->id}}{{$index}}" onchange="toggleSelect(this , '{{$it["label"]}}' , '{{$it["price"]}}' , '{{$item->id}}','{{$index}}'  )" >                                        
                                            </div>
                                            <h6 class="mx-2 label-sub-detail-item" for="checkbox{{$it['label']}}">
                                                {{$it["label"]}}
                                            </h6>
                                            </div>
                                            <div class="text-align-left" >
                                                <div class="mx-2 font-size-15 line-height-0" >
                                                        @if($it["price"] > 0 )                                                   
                                                                <label class="line-height  margin-0 " for="">{{$it["price"] ?? ''}}</label>
                                                                <label class="line-height  margin-0 text-uppercase" for="">{{$restaurant->currency}}</label> 
                                                        @endif
                                                </div>
                                            </div>
                                        
                                    </div>
                                </div>  

                                @endforeach
                            @endif
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