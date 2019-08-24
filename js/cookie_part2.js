	    $(document).ready(function() {
	     //get cookie value
	       var count = parseInt($.cookie('visitcount'));
	     //if the value of cookie is greater than 1
	     //show content for repeating user
	        if (count > 1) {
	         $('.repeatinguser').show();
	            $('.newuser').hide();        
	        }
	     //if the value of cookie is equal to 1
	     //show content for new user
	        else if(count==1){
	         $('.newuser').show();
	         $('.repeatinguser').hide();
	        }
	    });


$('#accept').on('click', function (e) {
    //ACTION
	 $('.newuser').hide();
})
