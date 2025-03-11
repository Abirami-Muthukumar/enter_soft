@php use Modules\StudentSetting\Entities\Institute; @endphp

@extends(theme('auth.layouts.app'))

@section('content')
<style type="text/css">
  .smallBox{
  /* Adjust the width as needed */
    padding: 10px;
    background-color: #e7e9eb;  /* Light gray background */
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

    .cursor-pointer {
        cursor: pointer;
    }
.text-red {
    color: red;
}
</style>


    <div class="login_wrapper">

        <div class="login_wrapper_left">

            <div class="logo text-center">

                <a href="#">

                    <img style="width: 170px" src="{{asset(Settings('logo') )}} " alt="">

                </a>

            </div>

            <div class="login_wrapper_content">

                <h4 class="text-center">Register</h4>

                <form action="{{route('register')}}" method="POST" id="regForm">

                    @csrf

                    <div class="row">



                        @if(isModuleActive('Organization'))

                            <div class="col-12 mt_20">

                                <label>{{trans('organization.account_type')}}</label>

                                <ul class="quiz_select d-flex">

                                    <li>

                                        <label

                                            class="primary_bulet_checkbox d-flex">

                                            <input checked class="quizAns"

                                                   name="account_type"

                                                   type="radio"

                                                   value="3">



                                            <span

                                                class="checkmark mr_10"></span>

                                            <span

                                                class="label_name">{{__('common.Student')}} </span>

                                        </label>

                                    </li>



                                    <li class="ms-3">

                                        <label

                                            class="primary_bulet_checkbox d-flex">

                                            <input class="quizAns"

                                                   name="account_type"

                                                   type="radio"

                                                   value="5">



                                            <span

                                                class="checkmark mr_10"></span>

                                            <span

                                                class="label_name">{{__('organization.Organization')}} </span>

                                        </label>

                                    </li>

                                </ul>

                            </div>

                        @endif 
                      <input type="hidden" name="status" value="1">
                      <div class="col-6">

                                <div class="mb-4">

                                     <h6>First Name <span class="text-red">*</span></h6>

                                    <div class="position-relative">

                                       <!--  <i class="fa-solid fa-user"></i> -->

                                        <input class="form-control" id="first_name" type="text" name="name" placeholder="Enter Your First Name" required>

                                    </div>

                                </div>

                            </div>
                      <div class="col-6">

                                 <div class="mb-4">

                                  <h6>Last Name <span class="text-red">*</span></h6>

                                    <div class="position-relative">

                                        <!-- <i class="fa-solid fa-user"></i> -->

                                        <input class="form-control" id="last_name" type="text" name="last_name" placeholder="Enter Your Last Name" required>

                                    </div>

                                </div>

                            </div>
                         <div class="col-6">

                                <div class="mb-4">

                                    <h6>Email Address <span class="text-red">*</span></h6>

                                    <div class="position-relative">

                                       <!--  <i class="fas fa-envelope"></i> -->

                                        <input class="form-control" id="email" type="email" name="email" placeholder="Enter Your Email" required>

                                    </div>

                                </div>

                            </div>
        <div class="col-6">

                                <div class="mb-4">

                                    <h6>Password <span class="text-red">*</span></h6>

                                    <div class="position-relative">

                                        <!-- <i class="fa-solid fa-key"></i> -->
                                        <div class="position-relative">
                                        <input class="form-control pe-5" id="password" type="password" name="password" placeholder="Enter Your Password" required oninput="validatePassword()">
            <i class="fa-solid fas fa-eye position-absolute top-50 translate-middle-y end-0 me-3 cursor-pointer"
               onclick="togglePassword()"></i>
                                    </div>
                                    </div>
                                  <small class="text-danger" id="passwordError"></small>

                                </div>

                            </div>
                            <div class="col-6 years_birth">
                                 <div class="mb-4">
                                  <h6>Birth Year <span class="text-red">*</span></h6>

                                    <div class="position-relative">
                                    <!-- <i class="fas fa-birthday-cake"></i> -->
                                        <select placeholder="Select Birth Year" class="small_select w-100"
                                                    name="birth" id="birth" {{ $custom_field->required_gender ? 'selected' : '' }}>
<!-- 
                                               <option value="" disabled selected>Select Birth Year</option> -->

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
                            </div>
                            <div class="col-6 years_birth">
                                 <div class="mb-4">
                                  <h6>Gender <span class="text-red">*</span></h6>

                                    <div class="position-relative">
                                    <!-- <i class="fas fa-birthday-cake"></i> -->
                                        <select class="small_select w-100"
                                                    name="gender" id="gender" >

                                             <!--  <option value="" disabled selected>Select Your Gender</option> -->

                                                <option value="Male">Male</option>

                                                <option value="Female">Female</option>

                                                <option value="Other">Other</option>

                                                <option value="Prefer not to say">Prefer not to say</option>

                                            </select>
                                           <span id="gender_error" class="error_select" style="color: red;"></span>

                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mt-3">
                                 <div class="mb-4">
                                  <h6>Employment Status <span class="text-red">*</span></h6>

                                    <div class="position-relative">
                                    <!-- <i class="fas fa-birthday-cake"></i> -->
                                        <select class="small_select w-100"
                                                    name="employment_status" id="employment_status" >

                                           <!--  <option value="" disabled selected>Select Employment Status</option> -->
                                            <option value="employed">Employed</option>
                                            <option value="unemployed">Unemployed</option>
                                            <option value="other">Other</option>

                                            </select>
                                             <span id="status_error" class="error_select" style="color: red;"></span>

                                    </div>
                                </div>
                            </div>
                            <div class="col-6 mt-3">
                                 <div class="mb-4">

                                  <h6>Post Code <span class="text-red">*</span></h6>

                                    <div class="position-relative">
                                    <!-- <i class="fas fa-vote-yea"></i> -->
                                        <input type="number" class="form-control" placeholder="Post Code" id="post_code" 
       name="post_code" min="1000" max="9999" required 
       oninput="limitLength(this)" pattern="\d{4}">



                                    </div>
                                </div>
                            </div>
                            <div class="col-6 mt-3" >
                                 <div class="mb-4">
                                  <h6>Name Of School <span class="text-red">*</span></h6>
                                    <div class="position-relative">
                                         <!-- <i class="fas fa-graduation-cap"></i> -->
                                        <input type="text" class="form-control" placeholder="School Name" id="school_name" name="school_name" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 ">

                        <h6>Equity Group <span class="text-red">*</span></h6>
                           <div class="smallBox">
                               <input type="checkbox" name="identity" id="Indigenous" value="Indigenous">&nbsp<span class="bold">Indigenous</span><br>

                               <input type="checkbox" name="identity" id="cald" value="CALD (Culturally and Linguistically Diverse)">&nbsp<span class="bold">CALD (Culturally and Linguistically Diverse)</span><br>

                               <input type="checkbox" name="identity" id="disability" value="Disability">&nbsp<span class="bold">Disability</span><br>

                               <input type="checkbox" name="identity" id="prefer_not_to_say" value="Prefer not to say">&nbsp<span class="bold">Prefer not to say</span><br>
                               <input type="checkbox" name="identity" id="none_of_the_above" value="None of the above">&nbsp<span class="bold">None of the above</span><br>
                        </div>
                                

                             <span id="group_error" class="error_select" style="color: red;"></span>

                        </div>
                         
                             <div class="col-12 mt-4">

                                <div class="mb-4">

                                     <h6>Mobile Number</h6>

                                    <div class="position-relative">

                                       <!--  <i class="fa-solid fa-user"></i> -->

                                         <input type="text"  class="form-control " placeholder="Enter Your Phone Number" id="phone" name="phone" value="04"  oninput="formatPhoneNumber(this)" maxlength="19" >

                                    </div>
                                     <small id="phoneError" style="color: red; display: none;margin-top:4px">Phone number must be in the format: 04 XXX XXX</small>
                                </div>

                            </div>
                      <span>(OR)</span>
                             <div class="col-12 mt-4">

                                <div class="mb-4">

                                     <h6>Landline Number</h6>

                                    <div class="position-relative">

                                       <!--  <i class="fa-solid fa-user"></i> -->

                                         <input type="text"  class="form-control " placeholder="Enter Your Phone Number" id="lanphone" name="land_phone"  oninput="formatLanPhoneNumber(this)" maxlength="19" > 

                                    </div>
                                    <small id="phoneLandError" style="color: red; display: none;margin-top:4px">Phone number must be in the format: (0X) XXXX XXXX</small>
                                </div>

                            </div>
                       <!--  @if($custom_field->show_name)

                            <div class="col-6 mt_20">

                                <div class="input-group custom_group_field">

                                    <input type="text" class="form-control ps-0"

                                           placeholder="{{__('Enter Your First Name')}} {{ $custom_field->required_name ? '*' : ''}}"

                                           {{ $custom_field->required_name ? 'required' : ''}} aria-label="Username"

                                           name="first_name" value="{{old('first_name')}}">

                                </div>

                                <span class="text-danger" role="alert">{{$errors->first('name')}}</span>

                            </div>

                             <div class="col-6 mt_20">

                                <div class="input-group custom_group_field">

                                    <input type="text" class="form-control ps-0"

                                           placeholder="{{__('Enter Your Last Name')}} {{ $custom_field->required_name ? '*' : ''}}"

                                           {{ $custom_field->required_name ? 'required' : ''}} aria-label="Username"

                                           name="last_name" value="{{old('last_name')}}">

                                </div>

                                <span class="text-danger" role="alert">{{$errors->first('name')}}</span>

                            </div>

                        @endif

                        <div class="col-6 mt_20">

                            <div class="input-group custom_group_field">

                                <input type="email" class="form-control ps-0" required

                                       placeholder="{{__('Enter Your Email Address')}} *" aria-label="email" name="email"

                                       value="{{old('email')}}">

                            </div>

                            <span class="text-danger" role="alert">{{$errors->first('email')}}</span>

                        </div>

                       <div class="col-6 mt_20">

                            <div class="input-group custom_group_field">

                                <input type="password" class="form-control ps-0" required

                                       placeholder="{{__('Enter Your Password')}} *"

                                       autocomplete="new-password"

                                       aria-label="password" name="password">

                            </div>

                            <span class="text-danger" role="alert">{{$errors->first('password')}}</span>

                        </div> -->
                       <!--   <div class="col-xl-12">
                                <div class="short_select mt-3">
                                    <div class="row">
                                        <div class="col-xl-5">
                                            <h5 class="mr_10 font_16 f_w_500 mb-0">Birth Year</h5>
                                        </div>
                                        <div class="col-xl-7">
                                            <select class="small_select w-100"
                                                    name="birth" id="birth" {{ $custom_field->required_gender ? 'selected' : '' }}>

                                               <option value="" disabled selected>Select Birth Year</option>

                                            <?php $currentYear = date("Y")-10; // Get the current year
                                                  $startYear = $currentYear - 50; // 65 years back
                                            for ($year = $currentYear; $year >= $startYear; $year--) {

                                            echo "<option class='years_select' value='$year'>$year</option>";

                                            }

                                            ?>

                                            </select>
                                        </div>
                                    </div>
                                    <span class="text-danger" role="alert">{{$errors->first('gender')}}</span>
                                </div>

                            </div>
                         <div class="col-xl-12">
                                <div class="short_select mt-3">
                                    <div class="row">
                                        <div class="col-xl-5">
                                            <h5 class="mr_10 font_16 f_w_500 mb-0">Gender</h5>
                                        </div>
                                        <div class="col-xl-7">
                                            <select class="small_select w-100"
                                                    name="gender" id="gender" >

                                              <option value="" disabled selected>Select Your Gender</option>

                                                <option value="Male">Male</option>

                                                <option value="Female">Female</option>

                                                <option value="Other">Other</option>

                                                <option value="Prefer not to say">Prefer not to say</option>

                                            </select>
                                        </div>
                                    </div>
                                    <span id="gender_error" class="error_select" style="color: red;"></span>
                                </div>

                            </div>
                            <div class="col-xl-12">
                                <div class="short_select mt-3">
                                    <div class="row">
                                        <div class="col-xl-5">
                                            <h5 class="mr_10 font_16 f_w_500 mb-0">Gender</h5>
                                        </div>
                                        <div class="col-xl-7">
                                            <select class="small_select w-100"
                                                    name="employment_status" id="employment_status" >

                                              <option value="" disabled selected>Select Employment Status</option>
                                            <option value="employed">Employed</option>
                                            <option value="unemployed">Unemployed</option>
                                            <option value="other">Other</option>

                                            </select>
                                        </div>
                                    </div>
                                    <span id="status_error" class="error_select" style="color: red;"></span>
                                </div>

                            </div>
 -->
                    

                       <!-- <div class="col-6 mt_20">

                                <div class="input-group custom_group_field">

                                    <input type="text" class="form-control ps-0"

                                           placeholder="{{__('Enter Post Code')}} {{ $custom_field->required_name ? '*' : ''}}"

                                           {{ $custom_field->required_name ? 'required' : ''}} aria-label="Username"

                                           name="post_code" value="{{old('post_code')}}">

                                </div>

                                <span class="text-danger" role="alert">{{$errors->first('post_code')}}</span>

                            </div>

                     <div class="col-6 mt_20">

                                <div class="input-group custom_group_field">

                                    <input type="text" class="form-control ps-0"

                                           placeholder="{{__('Enter Name Of School')}} {{ $custom_field->required_name ? '*' : ''}}"

                                           {{ $custom_field->required_name ? 'required' : ''}} aria-label="Username"

                                           name="school" value="{{old('school')}}">

                                </div>

                                <span class="text-danger" role="alert">{{$errors->first('school')}}</span>

                            </div> 

                        @if($custom_field->show_phone)

                            <div class="col-12 mt_20">

                                <div class="input-group custom_group_field">

                                    <input type="text" class="form-control ps-0"

                                           placeholder="{{__('Enter Your Phone Number')}} {{ $custom_field->required_phone ? '*' : ''}}"

                                            id="phone" name="phone" required value="04" oninput="formatPhoneNumber(this)" maxlength="19">

                                </div>

                                <small id="phoneError" style="color: red; display: none;">
                                  Phone number must be in the format: 04XX XXX XXX
                                </small>

                            </div>

                        @endif -->
                          
                        <!-- <div class="col-12 mt_20">

                            <div class="input-group custom_group_field">

                                <input type="password" class="form-control ps-0" required

                                       placeholder="{{__('frontend.Enter Password')}} *"

                                       autocomplete="new-password"

                                       aria-label="password" name="password">

                            </div>

                            <span class="text-danger" role="alert">{{$errors->first('password')}}</span>

                        </div>

                        <div class="col-12 mt_20">

                            <div class="input-group custom_group_field">

                                <input type="password" class="form-control ps-0" required

                                       placeholder="{{__('common.Enter Confirm Password')}} *"

                                       name="password_confirmation" aria-label="password_confirmation">

                            </div>

                            <span class="text-danger" role="alert">{{$errors->first('password_confirmation')}}</span>

                        </div> -->



                       <!--  @if($custom_field->show_dob)

                            <div class="col-12 mt_20">

                                <div class="input-group custom_group_field">

{{--                                    <label for="dob">{{__('common.Date of Birth')}} : </label>--}}

                                    <input id="dob" type="text" class="form-control ps-0 datepicker w-100" width="300"

                                           placeholder="{{__('common.Date of Birth')}} {{ $custom_field->required_dob ? '*' : ''}}"

                                           {{ $custom_field->required_dob ? 'required' : ''}} aria-label="Username"

                                           name="dob" value="{{ old('dob') }}">

                                </div>

                                <span class="text-danger" role="alert">{{$errors->first('name')}}</span>

                            </div>

                        @endif
 -->




                       <!--  @if($custom_field->show_company)

                            <div class="col-12 mt_20">

                                <div class="input-group custom_group_field">

                                    <input type="text" class="form-control ps-0"

                                           placeholder="{{__('common.Enter Company')}} {{ $custom_field->required_company ? '*' : ''}}"

                                           {{ $custom_field->required_company ? 'required' : ''}} aria-label="email"

                                           name="company" value="{{old('company')}}">

                                </div>

                                <span class="text-danger" role="alert">{{$errors->first('company')}}</span>

                            </div>

                        @endif -->


<!-- 
                        @if($custom_field->show_identification_number)

                            <div class="col-12 mt_20">

                                <div class="input-group custom_group_field">

                                    <input type="text" class="form-control ps-0"

                                           placeholder="{{__('common.Enter Identification Number')}} {{ $custom_field->required_identification_number ? '*' : ''}}"

                                           {{ $custom_field->required_identification_number ? 'required' : ''}}

                                           aria-label="email" name="identification_number"

                                           value="{{old('identification_number')}}">

                                </div>

                                <span class="text-danger"

                                      role="alert">{{$errors->first('identification_number')}}</span>

                            </div>

                        @endif



                        @if($custom_field->show_job_title)

                            <div class="col-12 mt_20">

                                <div class="input-group custom_group_field">

                                    <input type="text" class="form-control ps-0"

                                           placeholder="{{__('common.Enter Job Title')}} {{ $custom_field->required_job_title ? '*' : ''}}"

                                           {{ $custom_field->required_job_title ? 'required' : ''}} aria-label="email"

                                           name="job_title" value="{{old('job_title')}}">

                                </div>

                                <span class="text-danger" role="alert">{{$errors->first('job_title')}}</span>

                            </div>

                        @endif -->


<!-- 
                        @if($custom_field->show_gender)

                            <div class="col-xl-12">

                                <div class="short_select mt-3">

                                    <div class="row">

                                        <div class="col-xl-5">

                                            <h5 class="mr_10 font_16 f_w_500 mb-0">{{ __('common.choose_gender') }} {{ $custom_field->required_gender ? '*' : '' }}</h5>

                                        </div>

                                        <div class="col-xl-7">

                                            <select class="small_select w-100"

                                                    name="gender" {{ $custom_field->required_gender ? 'selected' : '' }}>

                                                {{--                                                <option value="" data-display="Choose">{{__('common.Choose')}}</option>--}}

                                                <option value="male">{{__('common.Male')}}</option>

                                                <option value="female">{{__('common.Female')}}</option>

                                                <option value="other">{{__('common.Other')}}</option>

                                            </select>



                                        </div>

                                    </div>

                                    <span class="text-danger" role="alert">{{$errors->first('gender')}}</span>



                                </div>

                            </div>

                        @endif



                        @if($custom_field->show_student_type)

                            <div class="col-xl-12">

                                <div class="short_select mt-3">

                                    <div class="row">

                                        <div class="col-xl-5">

                                            <h5 class="mr_10 font_16 f_w_500 mb-0">{{ __('common.choose_student_type') }} {{ $custom_field->required_student_type ? '*' : '' }}</h5>

                                        </div>

                                        <div class="col-xl-7">

                                            <select class="small_select w-100"

                                                    name="student_type" {{ $custom_field->required_student_type ? 'selected' : '' }}>

                                                <option value="personal">{{__('common.Personal')}}</option>

                                                <option value="corporate">{{__('common.Corporate')}}</option>

                                            </select>

                                        </div>

                                    </div>

                                    <span class="text-danger" role="alert">{{$errors->first('student_type')}}</span>



                                </div>

                            </div>

                        @endif



                        @if($custom_field->show_institute)

                            <div class="col-xl-12">

                                <div class="short_select mt-3">

                                    <div class="row">

                                        <div class="col-xl-5">

                                            <h5 class="mr_10 font_16 f_w_500 mb-0">{{ __('common.choose_institute') }} {{ $custom_field->required_institute ? '*' : '' }}</h5>

                                        </div>

                                        <div class="col-xl-7">

                                            <select class="small_select w-100"

                                                    name="institute_id">

                                                <option

                                                    value="">{{__('common.select_one')}}</option>

                                                @foreach(Institute::where('status',1)->get() as $institute)

                                                    <option value="{{$institute->id}}">

                                                        {{$institute->name}}

                                                    </option>

                                                @endforeach

                                            </select>

                                        </div>

                                    </div>

                                    <span class="text-danger" role="alert">{{$errors->first('institute_id')}}</span>



                                </div>

                            </div>

                        @endif

                        @if(isModuleActive('Affiliate'))

                            <div class="col-12 mt_20">

                                <div class="input-group custom_group_field">

                                    <input type="text" class="form-control ps-0"

                                           placeholder="{{__('affiliate.Referral Code')}} ({{__('frontend.Optional')}})"

                                           name="referral_code" value="{{old('referral_code')}}">

                                </div>

                                <span class="text-danger" role="alert">{{$errors->first('referral_code')}}</span>

                            </div>

                        @endif



                        <div class="col-12 mt_20">

                            <div class="remember_forgot_passs d-flex align-items-center">

                                <label class="primary_checkbox d-flex" for="checkbox">

                                    <input type="checkbox" id="checkbox" required>

                                    <span class="checkmark mr_15"></span>

                                    <p>{{__('frontend.By signing up, you agree to')}} <a target="_blank"

                                                                                         href="{{url('terms')}}">{{__('frontend.Terms of Service')}}</a> {{__('frontend.and')}}

                                        <a target="_blank"

                                           href="{{url('privacy')}}">{{__('frontend.Privacy Policy')}}</a></p>

                                </label>



                            </div>

                        </div>-->

                        <div class="col-12 mt_20">

                            @if(saasEnv('NOCAPTCHA_FOR_REG')=='true')

                                @if(saasEnv('NOCAPTCHA_IS_INVISIBLE')=="true")

                                    {!! NoCaptcha::display(["data-size"=>"invisible"]) !!}

                                @else

                                    {!! NoCaptcha::display() !!}

                                @endif



                                @if ($errors->has('g-recaptcha-response'))

                                    <span class="text-danger"

                                          role="alert">{{$errors->first('g-recaptcha-response')}}</span>s

                                @endif

                            @endif

                        </div> 



                        <div class="col-12 mt_20">

                            @if(saasEnv('NOCAPTCHA_FOR_REG')=='true' && saasEnv('NOCAPTCHA_IS_INVISIBLE')=="true")



                                <button type="button" class="g-recaptcha theme_btn text-center w-100 disable_btn"

                                        disabled

                                        data-sitekey="{{saasEnv('NOCAPTCHA_SITEKEY')}}" data-size="invisible"

                                        data-callback="onSubmit"

                                        class="theme_btn text-center w-100">   {{__('common.Register')}}</button>

                                <script src="https://www.google.com/recaptcha/api.js" async defer></script>

                                <script>

                                    function onSubmit(token) {

                                        document.getElementById("regForm").submit();

                                    }

                                </script>

                            @else

                                <button type="submit" class="theme_btn text-center w-100 " 

                                        id="submitBtn">

                                    {{__('common.Register')}}

                                </button>

                            @endif



                        </div>

                    </div>

                </form>

            </div>





            <h5 class="shitch_text mb-0">

                {{__('common.You have already an account?')}} <a style="color: #5dabfc" href="{{route('login')}}"> {{__('common.Login')}}</a>



            </h5>

        </div>



        @include(theme('auth.login_wrapper_right'))



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
    if (!value.startsWith("04")) {
        value = "04";
    }
    
    // Limit to 10 digits max
    if (value.length > 10) {
        value = value.slice(0, 10);
    }

    // Format as "04XX XXX XXX"
    let formattedNumber = value.replace(/(\d{4})(\d{3})?(\d{3})?/, function(_, p1, p2, p3) {
        return p1 + (p2 ? " " + p2 : "") + (p3 ? " " + p3 : "");
    });

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

    // Limit to 10 digits
    value = value.slice(0, 10);

    // Format as "(0X) XXXX XXXX"
    let formattedNumber = value.replace(/(\d{2})(\d{4})?(\d{4})?/, function(_, p1, p2, p3) {
        return `(${p1})` + (p2 ? ` ${p2}` : "") + (p3 ? ` ${p3}` : "");
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
<script>
function togglePassword() {
    let passwordInput = document.getElementById("password");
    passwordInput.type = passwordInput.type === "password" ? "text" : "password";
}

function validatePassword() {
    let password = document.getElementById("password").value;
    let errorMessage = document.getElementById("passwordError");

    // Check for uppercase and lowercase letters
    let hasUpperCase = /[A-Z]/.test(password);
    let hasLowerCase = /[a-z]/.test(password);
    let hasNumber = /\d/.test(password);

    // Common password patterns
    let commonPasswords = ["password123", "123456", "qwerty", "letmein", "admin", "welcome"];

    // Check if it's a passphrase of 5–7 words
    let wordCount = password.trim().split(/\s+/).length;
    let isPassphrase = wordCount >= 8 && wordCount <= 16;

    if (!hasUpperCase || !hasLowerCase || !hasNumber) {
        errorMessage.textContent = "Use a combination of uppercase, lowercase, and numbers.";
        return false;
    }

    if (commonPasswords.includes(password.toLowerCase())) {
        errorMessage.textContent = "Avoid common passwords like 'password123'.";
        return false;
    }

    if (!isPassphrase) {
        errorMessage.textContent = "Use a passphrase of 8-16 random Characters.";
        return false;
    }

    // If password is valid, clear error message
    errorMessage.textContent = "";
    return true;
}
</script>
@endsection

