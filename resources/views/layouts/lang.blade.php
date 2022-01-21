    <style>
        .selected 
        {
             color:white !important;
             background-color:brown;
        }
        .btn-lang 
        {
            text-decoration:none;
             color:black;
        }

   </style>
<?php
$IS_ENG_EXISTS = false;
foreach ($restaurant->categories as $key => $value) {
    //  echo $value["name"];
    if (str_contains($value["name"], 'eng')) { 
        $IS_ENG_EXISTS =true;
    }
}

if(isset($_GET["lang"]) && $IS_ENG_EXISTS ) 
{
?>    
<div class="lang-box" >
                
                <a class="btn-lang  <?php if ( isset($_GET['lang']) && $_GET['lang'] == "arb")  echo "selected" ?>" href="{{$current_url}}?lang=arb" style="color:black">
                     عربي
                </a>

                <a class="btn-lang <?php if (isset($_GET['lang']) &&  $_GET['lang'] == "eng")  echo "selected" ?> " href="{{$current_url}}?lang=eng" style="color:black">
                    English
                </a>
                    
            </div>
            <?php
            
}

?>