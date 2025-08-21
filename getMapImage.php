<?php
    
  function distance($lat1, $lon1, $lat2, $lon2, $unit) {

              $theta = $lon1 - $lon2;
              $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
              $dist = acos($dist);
              $dist = rad2deg($dist);
              $miles = $dist * 60 * 1.1515;
              $unit = strtoupper($unit);

                if ($unit == "K") {
                    return ($miles * 1.609344);
                  } else if ($unit == "N") {
                      return ($miles * 0.8684);
                } else {
                        return $miles;
                }
 }


    if(isset($_POST['submitlattlong'])){

             $latt = ($_POST['origin_latt'] + $_POST['destination_latt']) * 0.5;
             $long = ($_POST['origin_long'] + $_POST['destination_long']) * 0.5;

			 $startLattLong = $_POST['origin_latt'].','.$_POST['origin_long'];
			 $centerLattLong = number_format($latt, 7, '.', '').','.number_format($long, 7, '.', '');
			 $endLattLong = $_POST['destination_latt'].','.$_POST['destination_long'];

             echo $distance = distance($_POST['origin_latt'], $_POST['origin_long'], $_POST['destination_latt'], $_POST['destination_long'], "K");echo "  ===== ";

                if($distance > 0 && $distance < 500){
                    $zoom = 8;
                }else if($distance >= 500 && $distance < 1000){
                    $zoom = 6;
                }else if($distance >=1000 && $distance < 2500){
                    $zoom = 6;
                }else if($distance >= 2500 && $distance < 3000){
                    $zoom = 4;
                }else if($distance >= 3000 && $distance < 5000){
                    $zoom = 4;
                }else if($distance >= 5000 && $distance < 7000){
                    $zoom = 6;
                }else if($distance >= 7000){
                    $zoom = 1;
                }else{
                    $zoom = 1;
                }

                //$zoom = $_POST['zoom'];

             echo  $url = "https://maps.googleapis.com/maps/api/staticmap?center=".$centerLattLong."&zoom=".$zoom."&size=800x800&key=AIzaSyCjegP3MXhTwKzgeefbJXWRnuPyfBDWEtE&path=color:red|weight:5|".$startLattLong."|".$centerLattLong."|".$endLattLong."&markers=anchor:center|icon:https://tinyurl.com/yc4e59hv|".$startLattLong."&markers=anchor:center|icon:https://tinyurl.com/4s7y8une|".$centerLattLong."&markers=anchor:center|icon:https://tinyurl.com/yfh2r3j6|".$endLattLong."";

			 $imagename = "mapimages/".time().".jpg";
			 file_put_contents($imagename,file_get_contents($url));

			 echo "<img src=".$imagename." />";echo "<br>";
	}

?>
</br>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places,geometry&key=AIzaSyCjegP3MXhTwKzgeefbJXWRnuPyfBDWEtE"></script>
<form method="post"  action="">


	 				<div class="form-group">
									<!-- <input  type="text" class="form-control" placeholder="Start Destination" name="start_destination" id="start_destination"/> -->
                                    <input  type="text" name="start_destination" id="search_address" class="form-control" placeholder="Start Destination" onChange="return validateCity()" style="width: 25%;" value="<?php echo @$_POST['start_destination']; ?>"/>
                                     <span class="text-danger d-none"></span>
								</div>
								<br>
								<div class="form-group">
									<!-- <input  type="text" class="form-control" placeholder="End Destination" name="end_destination"  id="end_destination" /> -->
                                    <input  type="text" name="end_destination" id="search_address2" class="form-control" placeholder="End Destination" onChange="return validateCity2()" style="width: 25%;" value="<?php echo @$_POST['end_destination']; ?>"/>
                                     <span class="text-danger d-none"></span>
					</div><br>
			        <input type="text" placeholder="Zoom" name="zoom" value="<?php echo @$_POST['zoom']; ?>" /><br><br>


			        <input type="text" placeholder="Start Latt" name="origin_latt" id="origin_latt" value="<?php echo @$_POST['origin_latt']; ?>" />
			        <input type="text" placeholder="Start Long" name="origin_long" id="origin_long" value="<?php echo @$_POST['origin_long']; ?>" />
			        <input type="text" placeholder="End Latt" name="destination_latt" id="destination_latt" value="<?php echo @$_POST['destination_latt']; ?>" />
			        <input type="text" placeholder="End Latt" name="destination_long" id="destination_long" value="<?php echo @$_POST['destination_long']; ?>" /><br>
			<br><br>		
    <input type="submit" name="submitlattlong" />
</form>


<script>   
                        function initialize() 
                        { 
                            var input = document.getElementById('search_address');
                            var autocomplete = new google.maps.places.Autocomplete((input), {
                                types: ['geocode'],
                                //componentRestrictions: {country: "AU"},
                            });

                            autocomplete.addListener('place_changed', function() {
                                var place = autocomplete.getPlace();
                                if (!place.geometry) {
                                    window.alert("Autocomplete's returned place contains no geometry");
                                    return;
                                }
                                bindDataToForm(place.geometry.location.lat(),place.geometry.location.lng());
                            });
                        }
                        function bindDataToForm(lat,lng)
                        {
                          document.getElementById('origin_latt').value = lat;
                          document.getElementById('origin_long').value = lng;
                        }
                        google.maps.event.addDomListener(window, 'load', initialize);

                        function validateCity() {
                            return searchfield = $("#search_address").val(), "" == searchfield || null == searchfield ? !1 : ($("#search_address").val(""), !1)
                        }




                        function initialize2() 
                        { 
                            var input = document.getElementById('search_address2');
                            var autocomplete = new google.maps.places.Autocomplete((input), {
                                types: ['geocode'],
                                //componentRestrictions: {country: "AU"},
                            });

                            autocomplete.addListener('place_changed', function() {
                                var place = autocomplete.getPlace();
                                if (!place.geometry) {
                                    window.alert("Autocomplete's returned place contains no geometry");
                                    return;
                                }
                                bindDataToForm2(place.geometry.location.lat(),place.geometry.location.lng());
                            });
                        }
                        function bindDataToForm2(lat,lng)
                        {
                          document.getElementById('destination_latt').value = lat;
                          document.getElementById('destination_long').value = lng;
                        }
                        google.maps.event.addDomListener(window, 'load', initialize2);

                        function validateCity2() {
                            return searchfield = $("#search_address2").val(), "" == searchfield || null == searchfield ? !1 : ($("#search_address2").val(""), !1)
                        }
                    </script>
