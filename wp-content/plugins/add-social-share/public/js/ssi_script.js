var wpsocial_networks = new Array();
var wpsocial_networks_links = new Array();
jQuery(document).ready(function($) {   
	$(window).load(function() {

		wpsocial_networks =["facebook" , 
		"twitter" , 
		"google" , 
		"linkedin" , 
		"pinterest"];
		wpsocial_networks_ids = ["wpsocial-facebook-share",
		"wpsocial-twitter-share",
		"wpsocial-google-share",
		"wpsocial-linkedin-share",
		"wpsocial-pinterest-share"];
		wpsocial_networks_url = ["http://www.facebook.com/sharer/sharer.php?u=",
		"https://twitter.com/share?url=",
		"https://plus.google.com/share?url=",
		"http://www.linkedin.com/shareArticle?url=",
		"http://pinterest.com/pin/create/button/?url="];
		arrayLength = wpsocial_networks.length;
		arrayLengthlink = wpsocial_networks_ids.length;
		post_url = $("#wpsocial-get-post-id").val();
		for (var i = 0; i < arrayLength ; i++) {
		
			if($("#wpsocial-selected-social-network"+[i+1]).val() ==''){
				$(".wpsocial-social-icons-box").find("[data-"+[i+1]+"]").remove();
			}
			else{

			}
		}

		for (var j = 0 ; j < arrayLengthlink; j++) {
		
			$("."+wpsocial_networks_ids[j]).attr("href", wpsocial_networks_url[j]+post_url);
		}
		if($("#wpsocial-selected-alignment").val() == "alignleft"){
			$('.wpsocial-social-icons-box').addClass("wpsocial-alignleft");
		}
		if($("#wpsocial-selected-alignment").val() == "alignright"){
			$('.wpsocial-social-icons-box').addClass("wpsocial-alignright");
		}
		if($("#wpsocial-selected-alignment").val() == "aligncenter"){
			$('.wpsocial-social-icons-box').addClass("wpsocial-aligncenter");
		}	


		var message = $("#wpsocial-selected-message").val();
		var customMessage = $("#wpsocial-selected-custom-message").val();

		if($("#wpsocial-selected-message").val()=="None"){
			$(".wpsocial-user-sharing-message").append("");	
		}
		else if($("#wpsocial-selected-message").val()=="Custom Message"){
			$(".wpsocial-user-sharing-message").append(customMessage);	
		}
		else{
		$(".wpsocial-user-sharing-message").append(message);	
		}
		var message_font = $("#wpsocial-selected-message-font").val();
		$('.wpsocial-user-sharing-message').css('font-family',message_font);
		message_font = message_font.replace(/\s+/g, '+');
		$("<link href='https://fonts.googleapis.com/css?family="+message_font+"' rel='stylesheet' type='text/css'>").appendTo(document.head);



	});

});
