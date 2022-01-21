

<div style="background-color: transparent;"
    class="w-100-sm   {{($restaurant->categories->count() < 10 && !is_mobile())? 'd-flex flex-row justify-content-center' : 'd-flex'}}"
    id="categories">
 
    <div style="display:flex;justify-content:center;" >

 @foreach($restaurant->categories as $index => $category)
	@foreach(explode('---', $category->name ) as $index => $info) 
    @if($info == $lang)
                    <div class="flatted-well category" style="font-size:16px !important;"
                        id="category-{{$category->id}}"
                        @click="chooseActiveCategory({{$category->id}})"
                    >
                @foreach(explode('---', $category->name ) as $index => $info) 
                @if($index == 0)
                 {{$info}}  
                @endif	
                @endforeach
            </div>

            @endif	
@endforeach
	    @endforeach


    </div>	
   

</div>


<style>

.category 
{
    background-color: transparent;
}

@media only screen and (max-width: 600px) {
  

.flatted-well
{
	margin:0px !important;
	padding:0px !important;		
}


}

</style>