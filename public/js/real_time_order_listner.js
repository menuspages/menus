function playSound() {
    const audio = new Audio("http://test3.localhost:8000/sounds/order_placed.mp3");
    audio.play();
    // alert("New order recieved");
    setLiveOrdersCount(0);
    // make live orders active
  }
  
  function setLiveOrdersCount(count)
  {
      $('.live-orders').css({"color" : "green","font-weight" : "700"});
      var val=$('.live-orders').css({"color" : "green","font-weight" : "700"});
      if(count == 0)
      {
          $('.live-orders').text(parseInt($('.live-orders').text())+1);            
      }
      else 
      {
          $('.live-orders').text(count);
      }

  }

  function saveNotification(order_id)
  {
      $.ajax({
      url: "/dashboard/orders/save-notifications?order_id="+order_id+"&restaurant_id="+restaurant_id,
      type: "get",
      success: function (response) {
                   console.log(response); 
      },
      error: function(jqXHR, textStatus, errorThrown) {
         console.log(textStatus, errorThrown);
      }
  });
  }
