jQuery(document).ready(function() {

        	// Set the date we're counting down to
				   //date_default_timezone_set('Europe/Berlin');
				   if(eventDate){


					var countDownDate = new Date(eventDate).getTime();
					//alert(eventDate);

					// Update the count down every 1 second
					var x = setInterval(function() {

					  // Get today's date and time
					  var now = new Date();
					 //alert(now);

					  // Find the distance between now and the count down date
					  var distance = countDownDate - now;

					  // Time calculations for days, hours, minutes and seconds
					  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
					  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
					  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
					  var seconds = Math.floor((distance % (1000 * 60)) / 1000);

					  // Display the result in the element with id="demo"
					  document.getElementById("leftday").innerHTML = days;
					  document.getElementById("lefthours").innerHTML = hours;
					  document.getElementById("leftmin").innerHTML = minutes;
					

					  // If the count down is finished, write some text
					  if (distance < 0) {
					    clearInterval(x);
					    document.getElementById("timeleft").innerHTML = "EXPIRED";
					  }
					}, 1000);

				}


		});