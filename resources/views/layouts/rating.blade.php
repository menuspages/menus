@if($restaurant->evaluation_enabled)
<i class="fa fa-thumbs-up open-rating-box" data-toggle="modal" data-target="#ratingModal" >
</i>
<div class="modal fade" id="ratingModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">نسعد بتقييمكم</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         <input type="text" name="rater_name" class="form-control" placeholder="الاسم / الايميل" >
         <textarea name="rater_note" id="" rows="3" class="form-control my-2 width-100" placeholder="الملاحظات" ></textarea>
         <div class="rating-container" >
             <div class="text-center my-2" >
                   <label class="font-size-30 rate-symbol" onclick="saveRating('128543')" >
                       &#128543;
                   </label>

                   <label class="font-size-30 rate-symbol" onclick="saveRating('128577')" >
                       &#128577;
                   </label>
                   
                   <label class="font-size-30 rate-symbol" onclick="saveRating('128528')" >
                       &#128528;
                   </label>
                   
                   <label class="font-size-30 rate-symbol" onclick="saveRating('128522')" >
                       &#128522;
                   </label>
                   
                   <label class="font-size-30 rate-symbol" onclick="saveRating('128525')" >
                       &#128525;
                   </label>
                   
             </div>  
             <div class="alert alert-warning rating-in-progress collapse" >
             جاري الارسال ...
             </div> 
             <div class="alert alert-success rating-done collapse" >
                 شكرا لتقييمكم             
            </div> 
         </div>
      </div>
    </div>
  </div>
</div>

@endif

<script>
   function saveRating(val)
   {

      var rater_name=$('input[name="rater_name"]').val();
      var rater_note=$('textarea[name="rater_note"]').val();
      var restaurant_id = "{{$restaurant->id ??''}}";
     
      if(rater_name == "")
            {
                alert("الرجاء اضافه الاسم او الايميل")
            }
            else 
            {
                $('.rating-in-progress').toggleClass('collapse')
                            $.ajax({
                            type: "GET",
                            url: "/set-rating",
                            data: {
                              "restaurant_id" : restaurant_id,
                              "name":rater_name , "rating":val, "rater_note" : rater_note},
                            success: function(data){
                                $('.rating-in-progress').toggleClass('collapse')
                                $('.rating-done').toggleClass('collapse')
                                window.setTimeout(function() {
                                    $('.rating-done').toggleClass('collapse');
                                }, 3000);

                                }
                            });      
            }
   }
    $(document).ready(function()
    {
       $('.rate-symbol').on('click',function()
       {
        $('.rate-symbol').removeClass('border');
        $(this).addClass('border');
       })
    })
</script>
