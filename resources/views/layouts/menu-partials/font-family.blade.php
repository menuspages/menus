

<button class="btn-font-family" type = "button" style="    position: absolute;
                                        top: -40px;
                                    right: 20px;
                                    border: none;
                                    background-color: white;
                                    border-radius: 2px;"
     >
    Font-family
    <i class="fa fa-angle-down" > </i>
</button> 

<ul class="font-styles" style="
        list-style-type: none;
        padding: 0px;
        background-color: white;
        top: 50px;
        right: 0px;
" >
            <li>
                <label style="font-family: GE-SS "  >
                    GE SS Text
                </label>

                <input class="font-family-input" type = "checkbox" value = "GE-SS" >
            </li>    
    </ul>  


    <script>

        $(function () {

            var dict = sessionStorage.getItem("fonts");
            $('.font-styles').hide();  

            if(dict != undefined)
                    {

                        $("#app").css('font-family' , dict["font-family"]);   
                    }
        });

        $(document).ready(
            function () {

                $('.btn-font-family').on('click' , function () {
                       $('.font-styles').toggle();  
                });

                $(".font-styles").children('li').children('.font-size').change(function(){
                    var newval=$(this).val();
                    $("#app").css('font-size' , newval+"px");    
                });

                $(".font-styles").children('li').children('.font-family-input').on('click' , function () {
                    var value = $(this).val();
                    if($(this).is(':checked'))
                    {
                        $("#app").css('font-family' , $(this).val())    
                    }
                    else 
                    {
                        $("#app").css('font-family' , '')    
                    }

                    data = sessionStorage.getItem("fonts");
                    if(data == undefined)
                    {
                        var dict = {
                            "font-family" : $(this).val(),
                            "font-size" : true,
                            "font-weight" : false
                            };
                        sessionStorage.setItem("fonts" , JSON.stringify(dict));    
                    }
                    else 
                    {
                        var dict = sessionStorage.getItem("fonts");
                        sessionStorage.setItem("fonts" , dict);    
                    }
                })
            }
        )

    </script>
