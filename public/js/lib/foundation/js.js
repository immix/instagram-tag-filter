// $(window).load(function() {
//     $('#tabs').tabulous({
//     	effect: 'scaleUp'
//     });	
//     $('#tabs2').tabulous({
//     	effect: 'slideLeft'
//     });			
// });
// $(window).resize(function(){
// 	$('#tabs').tabulous({
//     	effect: 'scaleUp'
//     });	
// 	$('#tabs2').tabulous({
// 			effect: 'slideLeft'
// 	});	
// });
// $(document).ready(function ($) {
// 	$('#tabs').tabulous({
//     	effect: 'scaleUp'
//     });	
// 	$('#tabs2').tabulous({
// 		effect: 'slideLeft'
// 	});	
//     //accordion
// 	(function($) {
	    
// 	  var allPanels = $('.accordion > dd').hide();
	    
// 	  $('.accordion > dt > a').click(function() {
// 	      $this = $(this);
// 	      $target =  $this.parent().prev();
	      
	    
// 	      if($target.hasClass('active')){
// 	        $target.removeClass('active').slideUp(); 
// 	      }else{
// 	         $this.nextAll().removeClass('active').slideUp();
// 	        $target.addClass('active').slideDown();
// 	      }
	      
// 	    return false;
// 	  });
	  
// 	  var allPanels2 = $('.accordion_down > dd').hide();
	  
// 	  $('.accordion_down > dt > a').click(function() {
// 	      $this = $(this);
// 	      $target =  $this.parent().next();
	      
// 	      if($this.hasClass('active_link')) {
// 		  	$this.removeClass('active_link');    
// 	      } else {
// 		     $this.addClass('active_link');
// 	      }
	    
// 	      if($target.hasClass('active')){
// 	        $target.removeClass('active').slideUp();
// 	      }else{
// 	         $this.nextAll().removeClass('active').slideUp();
// 	        $target.addClass('active').slideDown();
// 	      }
	      
// 	    return false;
// 	  });
	
// 	})(jQuery);
// });