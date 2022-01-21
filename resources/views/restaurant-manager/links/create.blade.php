@extends('layouts.restaurant-manager-dashboard')

@section('content')
<div class="container">
    <div class="row mt-4">
        <h2>الروابط</h2>
        <a href="{{route('explore', request()->route('subdomain'))}}" class=" mx-4 btn btn-primary" >
            Explore
        </a>
            
    </div>

    <form action="{{route('add-feature', request()->route('subdomain'))}}" method="POST" enctype="multipart/form-data" >
    {{csrf_field()}}
        <input type="hidden" name="id" value="{{$links == '' ? 0 : $links->id }}" >
        <input type="hidden" name="image_path" value="{{ ($links == '' || $links == null ? '' :  $links->features == null) ? '' : $links->features['bg_image']  }}" >
        
        <div class="jumbotron  mx-2 my-2 py-2" >
                    <div class="row" >
                        <div class="" style="width:30%" >
                            <div class="px-2 my-2" >
                                    <div class="form-control">
                                        
                                        <input type="radio" value='color' name="selected" {{$links->features['selected'] == $links->features['bg_color'] ? 'checked' : ''  }} >
                                        <input type="color" name="bgColor" id="color" class="input-color" value="{{ ($links == '' ? '' :  $links->features == null) ? '' : $links->features['bg_color']  }}"  placeholder="اللون" required>
                                    </div>
                                    <div class="form-group  my-2  border-radius-10 box-color" style="background-color:{{ $links->features['bg_color']  }}" >

                                    </div>
                            </div>
                        </div>
                        <div class="" >
                                    <div class=""  >
                                       <label for="bgImage" class="form-control my-2" >
                                       <input type="radio" value='image' name="selected" {{$links->features['selected'] == $links->features['bg_image'] ? 'checked' : ''  }} >      
                                       الصورة 
                                      
                                                <i class="fa fa-file" ></i>
                                                <input type="file" name="bgImage" id="bgImage" class="col-lg-4 col-sm-12  collapse" placeholder="كتابة الاسم" >
                                                 
                                       </label>  
                                        <div class="form-group  {{ $links->features['bg_image'] == '' ? 'collapse' : ''  }}">
                                            
                                            <img src="/{{ ($links == '' ? '' :  $links->features == null) ? '' : $links->features['bg_image']  }}" width="100" height="100" class="border-radius-10" alt="">
                                        </div>
                                    </div>
                        </div>
                    </div>
                
            <button class="btn btn-primary" >
                {{\App\Constants\Translation::getTranslationByWord('arb' , 'add_feature')}}    
            </button>
        </div>
    </form>

    <form action="{{route('add-link', request()->route('subdomain'))}}" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id" value="{{$links == '' ? 0 : $links->id }}" >

        <div class="jumbotron mx-2 my-2 py-2" >
        <div class="col-lg-6 col-md-12">
            @include('layouts.messages')
            {{csrf_field()}}
            <div class="form-group">
                <label for="name">اسم </label>
                <input type="text" name="name" id="name" class="form-control" placeholder="كتابة الاسم" required>
            </div>
            <div class="form-group">
                <label for="url">عنوان url </label>
                <input type="text" name="url" id="url" class="form-control" placeholder="عنوان url" required>
            </div>
           
            <button class="btn btn-primary" > 
                Add
             </button>
            </div>
        </div>               
    </form>
    @if($links->links)
        <div class="overflow-auto" >
        <table class="table table-bordered" >
            <thead>
                <tr>
                    <td>
                           ID 
                    </td>
                    <td>
                          Name
                    </td>
                    <td>
                          Link
                    </td>
                    <td>

                    </td>
                </tr>
            </thead>
            <tbody>
            @if(count((array)json_decode($links->links)) > 0)
                @foreach(json_decode($links->links) as $index=>$link)
                    <tr id="item_{{$index}}" >
                        <td>
                            {{++$index}}
                        </td>
                        <td>
                        {{$link[0]}}
                        </td>
                        <td>
                            <a href="{{$link[1]}}">{{$link[1]}}</a>
                        </td>
                        <td>
                        <button class="btn btn-danger" onclick="deleteItem('{{$index}}')" >
                            {{\App\Constants\Translation::getTranslationByWord('eng' , 'delete')}}
                        </button>
                        </td>
                        
                    </tr>
                    
                @endforeach
            @else 
                <tr>
                    <td colspan="3" >
                        no recoreds
                    </td>
                </tr>
            @endif
                
            </tbody>
        </table>
       
    </div>
    @endif
</div>
@endsection
<script>
    function deleteItem(id)
    {
        --id;
        if (!confirm("Do you want to delete")){
          return ;
        }
        $.ajax({
            url: "/dashboard/links/delete?id="+id,
            type : 'GET',
            success:function(e)
            {
                $("#item_"+id).hide();     
                location.reload();  
            }
        })

    }
</script>
