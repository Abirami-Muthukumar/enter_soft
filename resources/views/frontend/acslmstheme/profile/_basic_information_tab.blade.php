<style type="text/css">

  .smallBox{

  /* Adjust the width as needed */

    padding: 10px;

    background-color: #ffff;  /* Light gray background */

    border: 1px solid #ccc;  /* Subtle border */

    border-radius: 8px;  /* Rounded corners */

    box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1); /* Soft shadow */

    font-size: 14px;

}

.form-control{

  background-color: #e7e9eb;



}

.small_select{

  background-color: #e7e9eb;

}

</style>

<div class="tab-pane active" id="basic_information_tab">

    <div class="account_profile_form row">

        <div class="col-12">



            <h3>{{__('profile.basic_information')}}</h3>

            <hr>



            <form action="{{route('users.basic_info.update')}}" method="POST" enctype="multipart/form-data">

                @csrf

                <div class="row">

{{--                    <div class="col-md-6 mt_20">--}}

{{--                        <label class="primary_label2" for="first_name">{{__('common.First')}} {{__('common.Name')}}--}}

{{--                            <span class="required_mark">*</span></label>--}}

{{--                        <input id="first_name" name="first_name" placeholder="{{__('common.Name')}}"--}}

{{--                               onfocus="this.placeholder = ''"--}}

{{--                               onblur="this.placeholder = '{{__('common.Name')}}'"--}}

{{--                               class="primary_input" {{$errors->first('first_name') ? 'autofocus' : ''}}--}}

{{--                               value="{{old('first_name',$user->first_name)}}" type="text">--}}

{{--                        <span class="text-danger" role="alert">{{$errors->first('first_name')}}</span>--}}

{{--                    </div>--}}



{{--                    <div class="col-md-6 mt_20">--}}

{{--                        <label class="primary_label2" for="last_name">{{__('common.Last')}} {{__('common.Name')}}--}}

{{--                        </label>--}}

{{--                        <input id="last_name" name="last_name" placeholder="{{__('common.Name')}}"--}}

{{--                               onfocus="this.placeholder = ''"--}}

{{--                               onblur="this.placeholder = '{{__('common.Name')}}'"--}}

{{--                               class="primary_input" {{$errors->first('name') ? 'autofocus' : ''}}--}}

{{--                               value="{{old('last_name',$user->last_name)}}" type="text">--}}

{{--                        <span class="text-danger" role="alert">{{$errors->first('last_name')}}</span>--}}

{{--                    </div>--}}



                    <div class="col-md-6 mt_20">

                        <label class="primary_label2" for="name">First Name

                            <span class="required_mark">*</span></label>

                        <input id="name" name="name" placeholder="First Name"

                               onfocus="this.placeholder = ''"

                               onblur="this.placeholder = '{{__('common.Name')}}'"

                               class="primary_input" {{$errors->first('name') ? 'autofocus' : ''}}

                               value="{{old('name',$user->name)}}" type="text">

                        <span class="text-danger" role="alert">{{$errors->first('name')}}</span>

                    </div>

                    <div class="col-md-6 mt_20">

                        <label class="primary_label2" for="name">Last Name

                            <span class="required_mark">*</span></label>

                        <input id="last_name" name="last_name" placeholder="Last Name"

                               onfocus="this.placeholder = ''"

                               onblur="this.placeholder = '{{__('common.last_name')}}'"

                               class="primary_input" {{$errors->first('last_name') ? 'autofocus' : ''}}

                               value="{{old('last_name',$user->last_name)}}" type="text">

                        <span class="text-danger" role="alert">{{$errors->first('last_name')}}</span>

                    </div>

                    <div class="col-md-6 mt_20">

                        <div class="single_input ">

                            <span class="primary_label2">Birth Year</span>

                            <select required class="theme_select wide mb_20"

                                    name="birth" {{$errors->first('birth') ? 'autofocus' : ''}} >

                                <option value="" disabled selected>Select Birth Year</option>

                                 <?php $currentYear = date("Y")-10; // Get the current year

                                                  $startYear = $currentYear - 50; // 65 years back

                                            for ($year = $currentYear; $year >= $startYear; $year--) {



                                            echo "<option class='years_select' value='$year'>$year</option>";



                                            }



                                            ?>

                            </select>

                            <span id="birth_eroor" class="error_select" style="color: red;"></span>

                        </div>



                    </div>

                    <div class="col-md-6 mt_20">

                        <div class="single_input ">

                            <span class="primary_label2">Gender</span>

                            <select id="gender" required class="theme_select wide mb_20"

                                    name="gender" {{$errors->first('gender') ? 'autofocus' : ''}}>

                               <option value="" disabled selected>Select Your Gender</option>

                               <option value="Male">Male</option>

                               <option value="Female">Female</option>

                               <option value="Other">Other</option>                                                             <option value="Prefer not to say">Prefer not to say</option>

                            </select>

                            <span id="gender_error" class="error_select" style="color: red;"></span>

                        </div>



                    </div>

                      <div class="col-md-6 mt_20">

                        <div class="single_input ">

                            <span class="primary_label2">Employment Status</span>

                            <select required id="employment_status" class="theme_select wide mb_20"

                                    name="employment_status" {{$errors->first('employment_status') ? 'autofocus' : ''}}>

                              <option value="" disabled selected>Select Employment Status</option>

                              <option value="employed">Employed</option>

                              <option value="unemployed">Unemployed</option>

                              <option value="other">Other</option>

                            </select>

                            <span id="status_error" class="error_select" style="color: red;"></span>

                        </div>



                    </div>

                    <div class="col-md-6 mt_20">

                        <label class="primary_label2" for="post_code">Post Code

                            <span class="required_mark">*</span></label>

                        <input minlength='4' maxlength='4' id="post_code" name="post_code" placeholder="Post Code"

                               onfocus="this.placeholder = ''"

                               onblur="this.placeholder = 'Post Code'"

                               class="primary_input" {{$errors->first('post_code') ? 'autofocus' : ''}}

                               value="{{old('post_code',$user->post_code)}}" type="text">

                        <span class="text-danger" role="alert">{{$errors->first('post_code')}}</span>

                    </div>

                    <div class="col-md-6 mt_20">

                        <label class="primary_label2" for="school_name">Name Of School

                            <span class="required_mark">*</span></label>

                        <input minlength='4' maxlength='4' id="school_name" name="school_name" placeholder="School Name"

                               onfocus="this.placeholder = ''"

                               onblur="this.placeholder = 'School Name'"

                               class="primary_input" {{$errors->first('school_name') ? 'autofocus' : ''}}

                               value="{{old('school_name',$user->school_name)}}" type="text">

                        <span class="text-danger" role="alert">{{$errors->first('school_name')}}</span>

                    </div>

                     <div class="col-md-6 mt_20">

                        <label class="primary_label2" for="phone">Mobile Number


                            <span class="required_mark">*</span></label>

                        <input id="phone" name="phone" placeholder="{{__('common.Phone')}}"

                               onfocus="this.placeholder = ''"

                               onblur="this.placeholder = '{{__('common.Phone')}}'"

                               class="primary_input" {{$errors->first('phone') ? 'autofocus' : ''}}

                               value="{{old("phone")??@$user->phone }}" type="text">

                        <span class="text-danger" role="alert">{{$errors->first('phone')}}</span>

                    </div>
                   <div class="col-md-6 mt_20">

                        <label class="primary_label2" for="phone">Land Line

                           
                            <span class="required_mark">*</span></label>

                        <input id="lanphone" name="land_phone" placeholder="Enter Land Line"

                               onfocus="this.placeholder = ''"

                               onblur="this.placeholder = 'Enter Land Line'"

                               class="primary_input" {{$errors->first('land_phone') ? 'autofocus' : ''}}

                               value="{{old("land_phone")??@$user->landline }}" type="text">

                        <span class="text-danger" role="alert">{{$errors->first('land_phone')}}</span>

                    </div>
                    <div class="col-md-6 mt_20">

                         <label class="primary_label2" for="phone">Equity Group

                            

                            <span class="required_mark">*</span></label>

                       

                           <div class="smallBox">

                                <input type="checkbox" name="identity" id="Indigenous" value="Indigenous">&nbsp<span class="bold">Indigenous</span><br>



                               <input type="checkbox" name="identity" id="cald" value="CALD (Culturally and Linguistically Diverse)">&nbsp<span class="bold">CALD (Culturally and Linguistically Diverse)</span><br>



                               <input type="checkbox" name="identity" id="disability" value="Disability">&nbsp<span class="bold">Disability</span><br>



                               <input type="checkbox" name="identity" id="prefer_not_to_say" value="Prefer not to say">&nbsp<span class="bold">Prefer not to say</span><br>

                               <input type="checkbox" name="identity" id="none_of_the_above" value="None of the above">&nbsp<span class="bold">None of the above</span><br>
                           </div>

                                



                             <span id="group_error" class="error_select" style="color: red;"></span>



                        </div>

                  <!--   <div class="col-md-6 mt_20">

                        <label class="primary_label2" for="email">{{__('common.Email')}}

                            <span class="required_mark">*</span></label>

                        <input id="email" name="email" placeholder="{{__('common.Email')}}"

                               onfocus="this.placeholder = ''"

                               onblur="this.placeholder = '{{__('common.Email')}}'"

                               class="primary_input" {{$errors->first('email') ? 'autofocus' : ''}}

                               value="{{old("email")??@$user->email}}" type="email">

                        <span class="text-danger" role="alert">{{$errors->first('email')}}</span>

                    </div> -->

                   



                   <!--  <div class="col-md-6 mt_20">

                        <label class="primary_label2" for="identification_number">{{__('common.identification_number')}}

                        </label>

                        <input id="identification_number" name="identification_number"

                               class="primary_input" {{$errors->first('identification_number') ? 'autofocus' : ''}}

                               value="{{old('identification_number',$user->identification_number)}}" type="text">

                        <span class="text-danger" role="alert">{{$errors->first('identification_number')}}</span>

                    </div>

                    <div class="col-md-6 mt_20">

                        <div class="single_input ">

                            <span class="primary_label2">{{__('common.Currency')}}  </span>

                            <select class="theme_select wide mb_20"

                                    name="currency" {{$errors->first('currency') ? 'autofocus' : ''}}>

                                <option value=""> {{__('profile.select_one')}}</option>

                                @foreach ($currencies as $currency)

                                    <option

                                        value="{{@$currency->id}}"

                                        @if(old('currency'))

                                            @if (old('currency')==$currency->id) selected @endif

                                        @else

                                            @if(@$user->currency_id==$currency->id) selected @endif

                                        @endif>

                                        {{@$currency->name}} ({{$currency->code}})

                                    </option>

                                @endforeach

                            </select>

                            <span class="text-danger" role="alert">{{$errors->first('currency')}}</span>

                        </div>



                    </div>

                    <div class="col-md-6 mt_20">

                        <div class="single_input ">

                            <span class="primary_label2">{{__('common.Language')}}  </span>

                            <select class="theme_select wide mb_20"

                                    name="language" {{$errors->first('language') ? 'autofocus' : ''}}>

                                <option value=""> {{__('profile.select_one')}}</option>

                                @foreach ($languages as $language)

                                    <option value="{{@$language->id}}"

                                            @if(old('language'))

                                                @if(old('language')==$language->id) selected @endif

                                            @else

                                                @if(@$user->language_id==$language->id) selected @endif

                                        @endif>

                                        {{@$language->native}}

                                    </option>

                                @endforeach

                            </select>

                            <span class="text-danger" role="alert">{{$errors->first('language')}}</span>

                        </div>



                    </div>

                    <div class="col-md-6 mt_20">

                        <div class="single_input ">

                            <span class="primary_label2">{{__('profile.timezone')}}  </span>

                            <select class="theme_select wide mb_20"

                                    name="timezone" {{$errors->first('timezone') ? 'autofocus' : ''}}>

                                <option value=""> {{__('profile.select_one')}}</option>

                                @foreach ($timezones as $timezone)

                                    <option value="{{@$timezone->id}}"

                                            @if(old('timezone'))

                                                @if(old('timezone')==$timezone->id) selected @endif

                                            @else

                                                @if(@$user->userInfo->timezone_id == $timezone->id) selected @endif

                                        @endif>

                                        {{@$timezone->code}}

                                    </option>

                                @endforeach

                            </select>

                            <span class="text-danger" role="alert">{{$errors->first('timezone')}}</span>

                        </div>



                    </div> -->

                    <div class="col-12 text-end">

                        <hr class="d-block">

                        <button class="theme_btn small_btn text-center" type="submit"><i

                                class="ti-check me-1"></i> {{__('common.Save')}}</button>

                    </div>

                </div>

            </form>

        </div>

    </div>

   <script>



        $(function () {



            $('#checkbox').click(function () {







                if ($(this).is(':checked')) {



                    $('#submitBtn').removeClass('disable_btn');



                    $('#submitBtn').removeAttr('disabled');







                } else {



                    $('#submitBtn').addClass('disable_btn');



                    $('#submitBtn').attr('disabled', 'disabled');







                }



            });



        });



        $(document).ready(function () {



        $("#regForm").submit(function (event) {



            let birth = $("#birth").val();



            let employment_status = $("#employment_status").val();



            let identity = $("#identity").val();



            let gender = $("#gender").val();



            console.log(birth);



            if (birth === "" || birth=== null) {



                event.preventDefault(); // Prevent form submission



                $("#birth_eroor").text("Please Select a Birth Years");



            } else {



                $("#birth_eroor").text(""); // Clear error message



            }



            if (employment_status === "" || employment_status=== null) {



                event.preventDefault(); // Prevent form submission



                $("#status_error").text("Please Select a Employment Status");



            } else {



                $("#status_eroor").text(""); // Clear error message



            }



            if (gender === "" || gender=== null) {



                event.preventDefault(); // Prevent form submission



                $("#gender_error").text("Please Select a Gender");



            } else {



                $("#gender_error").text(""); // Clear error message



            }



            if (identity === "" || identity=== null) {



                event.preventDefault(); // Prevent form submission



                $("#group_error").text("Please Select a Equity Group");



            } else {



                $("#group_error").text(""); // Clear error message



            }



        });



    });



    </script>



<script>

function formatPhoneNumber(input) {

    let value = input.value.replace(/\D/g, ''); // Remove all non-numeric characters



    // Ensure it starts with "04"

    if (!value.startsWith("")) {

        value = "";

    }



    // Limit to max 15 digits







    if (value.length > 10) {







        value = value.slice(0, 10);







    }

    // Format the number as 04XX XXX XXX XXXXX

    let formattedNumber = value.replace(/(\d{4})(\d{3})?(\d{3})?(\d{5})?/, function(_, p1, p2, p3, p4) {







        return p1 + (p2 ? " " + p2 : "") + (p3 ? " " + p3 : "");







    });















    // Ensure total length (digits + spaces) does not exceed 19 (max 15 digits + 4 spaces)







    if (formattedNumber.length > 12) {







        formattedNumber = formattedNumber.slice(0, 12);







    }















    input.value = formattedNumber;















    // Show error if number is incomplete







    document.getElementById('phoneError').style.display = value.length === 10 ? 'none' : 'block';







}

function formatLanPhoneNumber(input) {

    let value = input.value.replace(/\D/g, ''); // Remove all non-numeric characters



    // Ensure it starts with "0X" (0 followed by another digit)

    if (!/^0\d/.test(value)) {

        value = "0";

    }



    // Limit to max 10 digits

    value = value.slice(0, 10);



    // Format as 0X XXXX XXXX

    let formattedNumber = value.replace(/(\d{2})(\d{4})?(\d{4})?/, function(_, p1, p2, p3) {

        return p1 + (p2 ? " " + p2 : "") + (p3 ? " " + p3 : "");

    });



    input.value = formattedNumber;



    // Show error if number is incomplete

    document.getElementById('phoneLandError').style.display = value.length === 10 ? 'none' : 'block';

}



$(document).ready(function(){

  $('#prefer_not_to_say').click(function(){

    var status = $(this).val();



      if($(this).is(':checked')) {

             $('#Indigenous').prop('checked', false);

             $('#cald').prop('checked', false);

             $('#disability').prop('checked', false);

             }





  });

   $('#Indigenous').click(function(){

    var status = $(this).val();



      if($(this).is(':checked')) {

             $('#prefer_not_to_say').prop('checked', false);

            

             }

           



  });

    $('#cald').click(function(){

    var status = $(this).val();



      if($(this).is(':checked')) {

             $('#prefer_not_to_say').prop('checked', false);

            

             }

           



  });

    $('#disability').click(function(){

    var status = $(this).val();



      if($(this).is(':checked')) {

             $('#prefer_not_to_say').prop('checked', false);

            

             }

           



  });

});





</script>

<script>

    function togglePassword() {

        let passwordInput = document.getElementById("password");

        let icon = event.target;

        if (passwordInput.type === "password") {

            passwordInput.type = "text";

            icon.classList.remove("fa-eye");

            icon.classList.add("fa-eye-slash");

        } else {

            passwordInput.type = "password";

            icon.classList.remove("fa-eye-slash");

            icon.classList.add("fa-eye");

        }

    }

</script>

<script>

    function limitLength(input) {

        if (input.value.length > 4) {

            input.value = input.value.slice(0, 4); // Trim input to 4 digits

        }

    }

    $(document).ready(function(){

  $('#prefer_not_to_say').click(function(){

    var status = $(this).val();



      if($(this).is(':checked')) {

             $('#Indigenous').prop('checked', false);

             $('#cald').prop('checked', false);

             $('#disability').prop('checked', false);

             $('#none_of_the_above').prop('checked', false);

             }





  });

   $('#Indigenous').click(function(){

    var status = $(this).val();



      if($(this).is(':checked')) {

             $('#prefer_not_to_say').prop('checked', false);

            

             }

           



  });

    $('#cald').click(function(){

    var status = $(this).val();



      if($(this).is(':checked')) {

             $('#prefer_not_to_say').prop('checked', false);

            

             }

           



  });

    $('#disability').click(function(){

    var status = $(this).val();



      if($(this).is(':checked')) {

             $('#prefer_not_to_say').prop('checked', false);

            

             }

           



  });

       $('#none_of_the_above').click(function(){

    var status = $(this).val();



      if($(this).is(':checked')) {

             $('#prefer_not_to_say').prop('checked', false);

            

             }

           



  });



});

        $(document).ready(function(){

  $('#none_of_the_above').click(function(){

    var status = $(this).val();



      if($(this).is(':checked')) {

             $('#Indigenous').prop('checked', false);

             $('#cald').prop('checked', false);

             $('#disability').prop('checked', false);

              $('#prefer_not_to_say').prop('checked', false);

             }





  });

   $('#Indigenous').click(function(){

    var status = $(this).val();



      if($(this).is(':checked')) {

             $('#none_of_the_above').prop('checked', false);

            

             }

           



  });

    $('#cald').click(function(){

    var status = $(this).val();



      if($(this).is(':checked')) {

             $('#none_of_the_above').prop('checked', false);

            

             }

           



  });

    $('#disability').click(function(){

    var status = $(this).val();



      if($(this).is(':checked')) {

             $('#none_of_the_above').prop('checked', false);

            

             }

           



  });

       $('#prefer_not_to_say').click(function(){

    var status = $(this).val();



      if($(this).is(':checked')) {

             $('#none_of_the_above').prop('checked', false);

            

             }

           



  });

});

</script>


</div>

