
	     var cookiename='visitcount';
	     //Check whether the cookie is already set
	       //$.cookie('visitcount',null,{path:'/'});
	     
	$(document).ready(function(){
 		 if($.cookie(cookiename))
	     {
		 //set visitcount cookie with incremented cookie value
	      $.cookie('visitcount',(parseInt($.cookie('visitcount')) + 1),{expires:1,path:'/'});
		 }
	     else
	      {
	      //set visitcount to 1 for first if the cookie is not already set
	      $.cookie('visitcount',1,{expires:1,path:'/'});
	      }
		});
