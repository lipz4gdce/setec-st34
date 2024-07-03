@extends('admin.template')
@section('content')

<!-- profile -->
<div class="col-12">
    <div class="profile__content">
        <!-- profile user -->
        <div class="profile__user">
            <div class="profile__avatar">
                <img src="{{ url('img/user.svg' ) }}" alt="" id="update_profile_pic" >
                <input type="file" id="FileUpload1" style="display: none" />
            </div>
            <!-- or red -->
            <div class="profile__meta profile__meta--green">
                <h3>{{ Auth::user()->name }}
                    <span>({{ (Auth::user()->status) ? 'Approved' : 'Block' }} )</span>
                </h3>
                <span>FlixTV ID: {{ Auth::user()->id }}</span>
            </div>
        </div>
        <!-- end profile user -->

        <!-- profile tabs nav -->
        <ul class="nav nav-tabs profile__tabs" id="profile__tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#tab-1" role="tab" aria-controls="tab-1" aria-selected="true">Profile</a>
            </li>

        </ul>
        <!-- end profile tabs nav -->

        <!-- profile mobile tabs nav -->
        <div class="profile__mobile-tabs" id="profile__mobile-tabs">
            <div class="profile__mobile-tabs-btn dropdown-toggle" role="navigation" id="mobile-tabs" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <input type="button" value="Profile">
                <span></span>
            </div>

            <div class="profile__mobile-tabs-menu dropdown-menu" aria-labelledby="mobile-tabs">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item"><a class="nav-link active" id="1-tab" data-toggle="tab" href="#tab-1" role="tab" aria-controls="tab-1" aria-selected="true">Profile</a></li>

                    <li class="nav-item"><a class="nav-link" id="2-tab" data-toggle="tab" href="#tab-2" role="tab" aria-controls="tab-2" aria-selected="false">Comments</a></li>

                    <li class="nav-item"><a class="nav-link" id="3-tab" data-toggle="tab" href="#tab-3" role="tab" aria-controls="tab-3" aria-selected="false">Reviews</a></li>
                </ul>
            </div>
        </div>
        <!-- end profile mobile tabs nav -->

        <!-- profile btns -->
        <div class="profile__actions">
            <a href="#modal-status3" class="profile__action profile__action--banned open-modal"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12,13a1.49,1.49,0,0,0-1,2.61V17a1,1,0,0,0,2,0V15.61A1.49,1.49,0,0,0,12,13Zm5-4V7A5,5,0,0,0,7,7V9a3,3,0,0,0-3,3v7a3,3,0,0,0,3,3H17a3,3,0,0,0,3-3V12A3,3,0,0,0,17,9ZM9,7a3,3,0,0,1,6,0V9H9Zm9,12a1,1,0,0,1-1,1H7a1,1,0,0,1-1-1V12a1,1,0,0,1,1-1H17a1,1,0,0,1,1,1Z"/></svg></a>
            <a href="#modal-delete3" class="profile__action profile__action--delete open-modal"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M10,18a1,1,0,0,0,1-1V11a1,1,0,0,0-2,0v6A1,1,0,0,0,10,18ZM20,6H16V5a3,3,0,0,0-3-3H11A3,3,0,0,0,8,5V6H4A1,1,0,0,0,4,8H5V19a3,3,0,0,0,3,3h8a3,3,0,0,0,3-3V8h1a1,1,0,0,0,0-2ZM10,5a1,1,0,0,1,1-1h2a1,1,0,0,1,1,1V6H10Zm7,14a1,1,0,0,1-1,1H8a1,1,0,0,1-1-1V8H17Zm-3-1a1,1,0,0,0,1-1V11a1,1,0,0,0-2,0v6A1,1,0,0,0,14,18Z"/></svg></a>
        </div>
        <!-- end profile btns -->
    </div>
</div>
<!-- end profile -->

<!-- content tabs -->
<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="tab-1" role="tabpanel" aria-labelledby="1-tab">
        <div class="col-12">
            <div class="sign__wrap">
                <div class="row">
                    <!-- details form -->
                    <div class="col-12 col-lg-6">
                        <form action="#" class="sign__form sign__form--profile sign__form--first">
                            <div class="row">
                                <div class="col-12">
                                    <h4 class="sign__title">Profile details</h4>
                                </div>

                                <div class="col-12 col-md-6 col-lg-12 col-xl-6">
                                    <div class="sign__group">
                                        <label class="sign__label" for="username">Login</label>
                                        <input id="username" type="text" name="username" class="sign__input" value="{{ Auth::user()->name }}">
                                    </div>
                                </div>

                                <div class="col-12 col-md-6 col-lg-12 col-xl-6">
                                    <div class="sign__group">
                                        <label class="sign__label" for="email">Email</label>
                                        <input id="email" type="text" name="email" class="sign__input" value="{{ Auth::user()->email }}">
                                    </div>
                                </div>

                                <div class="col-12 col-md-6 col-lg-12 col-xl-6">
                                    <div class="sign__group">
                                        <label class="sign__label" for="subscription">Subscription</label>
                                        <select class="js-example-basic-single" id="subscription">
                                            <option value="Basic">Basic</option>
                                            <option value="Premium">Premium</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6 col-lg-12 col-xl-6">
                                    <div class="sign__group">
                                        <label class="sign__label" for="rights">Role</label>
                                        <select class="js-example-basic-single" id="rights">
                                            <option value="User">User</option>
                                            <option value="Admin">Admin</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <button class="sign__btn" type="button">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- end details form -->

                    <!-- password form -->
                    <div class="col-12 col-lg-6">
                        <form action="#" class="sign__form sign__form--profile">
                            <div class="row">
                                <div class="col-12">
                                    <h4 class="sign__title">Change password</h4>
                                </div>

                                <div class="col-12 col-md-6 col-lg-12 col-xl-6">
                                    <div class="sign__group">
                                        <label class="sign__label" for="oldpass">Old password</label>
                                        <input id="oldpass" type="password" name="oldpass" class="sign__input">
                                    </div>
                                </div>

                                <div class="col-12 col-md-6 col-lg-12 col-xl-6">
                                    <div class="sign__group">
                                        <label class="sign__label" for="newpass">New password</label>
                                        <input id="newpass" type="password" name="newpass" class="sign__input">
                                    </div>
                                </div>

                                <div class="col-12 col-md-6 col-lg-12 col-xl-6">
                                    <div class="sign__group">
                                        <label class="sign__label" for="confirmpass">Confirm new password</label>
                                        <input id="confirmpass" type="password" name="confirmpass" class="sign__input">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <button class="sign__btn" type="button">Change</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- end password form -->
                </div>
            </div>
        </div>
    </div>

</div>
<!-- end content tabs -->
<script>

    let fileupload = $("#FileUpload1");
    let image = $("#update_profile_pic");

    image.click(function () {
            fileupload.click();
        });

    fileupload.change(function (e) {
        file = this.files[0];
        console.log(file);
        if (file) {
            let reader = new FileReader();
            reader.onload = function (event) {
                image.attr("src", event.target.result);
            };
            reader.readAsDataURL(file);
        }
    });

</script>
@endsection
