<!DOCTYPE html>
<html>
<head>
    <!-- Basic Page Info -->
    <meta charset="utf-8" />
    <title>VertexGrad Rigester</title>

    <!-- Site favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="vendors/images/apple-touch-icon.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="vendors/images/favicon-32x32.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="vendors/images/favicon-16x16.png" />

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="vendors/styles/core.css" />
    <link rel="stylesheet" type="text/css" href="vendors/styles/icon-font.min.css" />
    <link rel="stylesheet" type="text/css" href="src/plugins/jquery-steps/jquery.steps.css" />
    <link rel="stylesheet" type="text/css" href="vendors/styles/style.css" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="register-page">
<div class="login-header box-shadow">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <div class="brand-logo">
            <a href="login.html">
               <img src="{{ asset('vendors/images/VertexGrad_logoud.png') }}" alt=""class="light-logo"style="margin-top:13px;">
            </a>
        </div>
        <div class="login-menu">
            <ul>
               <li><a href="{{ route('login.show') }}">Login</a></li>

            </ul>
        </div>
    </div>
</div>

<div class="register-page-wrap d-flex align-items-center flex-wrap justify-content-center">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 col-lg-7">
                <img src="vendors/images/register-page-img.png" alt="" />
            </div>
            <div class="col-md-6 col-lg-5">
                <div class="register-box bg-white box-shadow border-radius-10">
                    <div class="wizard-content">
                        <form id="registerForm" class="tab-wizard2 wizard-circle wizard" action="{{ route('register.post') }}" method="POST">
                            @csrf
                            <!-- Step 1: Basic Account Credentials -->
                            <h5>Basic Account Credentials</h5>
                            <section>
                                <div class="form-wrap max-width-600 mx-auto">
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Email Address*</label>
                                        <div class="col-sm-8">
                                            <input type="email" name="email" class="form-control" required />
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Username*</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="username" class="form-control" required />
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Password*</label>
                                        <div class="col-sm-8">
                                            <input type="password" name="password" class="form-control" required />
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Confirm Password*</label>
                                        <div class="col-sm-8">
                                            <input type="password" name="password_confirmation" class="form-control" required />
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <!-- Step 2: Personal Information -->
                            <h5>Personal Information</h5>
                            <section>
                                <div class="form-wrap max-width-600 mx-auto">
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Full Name</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="full_name" class="form-control" required />
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center">
                                        <label class="col-sm-4 col-form-label">Gender</label>
                                        <div class="col-sm-8">
                                            <div class="custom-control custom-radio custom-control-inline pb-0">
                                                <input type="radio" id="male" name="gender" value="male" class="custom-control-input" required />
                                                <label class="custom-control-label" for="male">Male</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline pb-0">
                                                <input type="radio" id="female" name="gender" value="female" class="custom-control-input" required />
                                                <label class="custom-control-label" for="female">Female</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">City</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="city" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">State</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="state" class="form-control" />
                                        </div>
                                    </div>
                                </div>
                            </section>

                           
                            <h5>Overview Information</h5>
                            <section>
                                <div class="form-wrap max-width-600 mx-auto">
                                    <ul class="register-info">
                                        <li>
                                            <div class="row">
                                                <div class="col-sm-4 weight-600">Email Address</div>
                                                <div class="col-sm-8" id="overview-email"></div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="row">
                                                <div class="col-sm-4 weight-600">Username</div>
                                                <div class="col-sm-8" id="overview-username"></div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="row">
                                                <div class="col-sm-4 weight-600">Full Name</div>
                                                <div class="col-sm-8" id="overview-fullname"></div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="row">
                                                <div class="col-sm-4 weight-600">Location</div>
                                                <div class="col-sm-8" id="overview-location"></div>
                                            </div>
                                        </li>
                                    </ul>

                                    <!-- زر تجريبي لإرسال البيانات مباشرة -->
                                    
                            </section>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="text-center mt-3">
    <button type="button" id="testSubmit" class="btn btn-primary">  Register</button>
</div>


<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function () {
    // إزالة زر Finish الأصلي إذا موجود
    $(".actions li a[href='#finish']").remove();

    let testBtnExists = false;

    // عند محاولة تغيير الخطوة
    $("#registerForm").on("stepChanging", function (event, currentIndex, newIndex) {
        // مثال: تحقق من تعبئة الحقول في الخطوة الحالية
        let valid = true;

        if (currentIndex === 0) { // إذا كانت الخطوة الأولى
            $("#registerForm section").eq(currentIndex).find("input[required]").each(function () {
                if (!$(this).val()) {
                    valid = false;
                    $(this).addClass("is-invalid"); // يمكن إضافة إطار أحمر
                } else {
                    $(this).removeClass("is-invalid");
                }
            });

            if (!valid) {
                alert("❌ الرجاء إكمال جميع الحقول المطلوبة في الخطوة الأولى قبل الانتقال.");
                return false; // منع الانتقال
            }
        }

        // إزالة زر Register عند الانتقال
        $("#testSubmitBtn").remove();
        testBtnExists = false;

        return true; // السماح بالانتقال إذا كل شيء صحيح
    });

    // بعد اكتمال الانتقال إلى خطوة جديدة
    $("#registerForm").on("stepChanged", function (event, currentIndex) {
        var totalSteps = $("#registerForm").find("h5").length;

        if (currentIndex === totalSteps - 1 && !testBtnExists) {
            var prevBtn = $(".actions li a[href='#previous']");
            var registerBtn = $('<a href="javascript:void(0);" id="testSubmitBtn" class="btn btn-primary">Register</a>');

            prevBtn.parent().css("display", "flex");
            prevBtn.after(registerBtn);

            registerBtn.css({
                "padding": prevBtn.css("padding"),
                "font-size": prevBtn.css("font-size"),
                "height": prevBtn.css("height"),
                "line-height": prevBtn.css("line-height"),
                "margin-left": "10px"
            });

            registerBtn.on("click", function () {
                $("#testSubmit").click();
            });

            testBtnExists = true;
        }
    });

    $("#testSubmit").hide();

    function updateOverview() {
        $("#overview-email").text($("input[name='email']").val());
        $("#overview-username").text($("input[name='username']").val());
        $("#overview-fullname").text($("input[name='full_name']").val());
        var city = $("input[name='city']").val();
        var state = $("input[name='state']").val();
        var location = city;
        if (state) location += ", " + state;
        $("#overview-location").text(location);
    }

    $("input").on("input change", updateOverview);

    $.ajaxSetup({
        headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
    });

    $("#testSubmit").on("click", function () {
        var formData = $("#registerForm").serializeArray();
        $("#registerForm input[type=radio]:checked").each(function () {
            formData.push({ name: this.name, value: this.value });
        });

        $.ajax({
            url: $("#registerForm").attr("action"),
            method: "POST",
            data: formData,
            dataType: "json",
            success: function (response) {
                if (response.message) {
                    alert("✅ نجاح: " + response.message);
                    $("#registerForm")[0].reset();
                    updateOverview();
                } else {
                    alert("❌ فشل: " + response.message);
                }
            },error: function (xhr) {
    if (xhr.status === 422) {
        // أخطاء التحقق من الصحة
        let errors = xhr.responseJSON.errors;
        let msg = "";
        $.each(errors, function (key, value) {
            msg += "❌ " + value + "\n";
        });
        alert(msg);
    } else {
        // أي خطأ آخر: عرض كل التفاصيل من السيرفر
        let msg = "❌ حدث خطأ غير متوقع.\n";
        if (xhr.responseJSON && xhr.responseJSON.message) {
            msg += "Message: " + xhr.responseJSON.message + "\n";
        }
        if (xhr.responseJSON && xhr.responseJSON.trace) {
            msg += "Trace:\n" + xhr.responseJSON.trace;
        } else {
            msg += "Response Text:\n" + xhr.responseText;
        }
        alert(msg);
    

                }
            },
        });
    });
});


</script>

<!-- js -->
<script src="vendors/scripts/core.js"></script>
<script src="vendors/scripts/script.min.js"></script>
<script src="vendors/scripts/process.js"></script>
<script src="vendors/scripts/layout-settings.js"></script>
<script src="src/plugins/jquery-steps/jquery.steps.js"></script>
<script src="vendors/scripts/steps-setting.js"></script>
</body>
</html>
