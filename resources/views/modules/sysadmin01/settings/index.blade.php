@extends('sysadmin::layouts.master')
@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h3>Site Settings</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Settings</li>
    <li class="breadcrumb-item active">index</li>
@endsection


@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 col-md-12 box-col-12">
                <div class="email-right-aside bookmark-tabcontent contacts-tabs">
                    <div class="card email-body radius-left">
                        <div class="ps-0">
                            <div class="tab-content">
                                <div class="tab-pane fade active show" id="pills-personal" role="tabpanel"
                                    aria-labelledby="pills-personal-tab">
                                    <div class="card mb-0">
                                        <div class="card-header d-flex">
                                            <h5>Settings</h5>
                                            <span class="f-14 pull-right mt-0">Site Settings</span>
                                        </div>
                                        <div class="card-body p-0">
                                            <div class="row list-persons" id="addcon">
                                                <div class="col-xl-3 col-md-3">
                                                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                                                        aria-orientation="vertical">
                                                        <a class="contact-tab-0 nav-link active" id="v-pills-user-tab"
                                                            data-bs-toggle="pill" onclick="activeDiv(0)"
                                                            href="#v-pills-user" role="tab" aria-controls="v-pills-user"
                                                            aria-selected="true">
                                                            <div class="media">
                                                                <div class="media-body">
                                                                    <h6> <span class="first_name_0">System Settings </span>
                                                                    </h6>
                                                                    <p class="email_add_0">Title, Logo, etc.,</p>
                                                                </div>
                                                            </div>
                                                        </a>
                                                        <a class="contact-tab-1 nav-link" id="v-pills-profile-tab"
                                                            data-bs-toggle="pill" onclick="activeDiv(1)"
                                                            href="#v-pills-profile" role="tab"
                                                            aria-controls="v-pills-profile" aria-selected="false">
                                                            <div class="media">
                                                                <div class="media-body">
                                                                    <h6> <span class="first_name_0">Social Media Settings
                                                                        </span>
                                                                    </h6>
                                                                    <p class="email_add_0">FB, Twiiter Page, etc.,</p>
                                                                </div>
                                                            </div>
                                                        </a>
                                                        <a class="contact-tab-2 nav-link" id="v-pills-messages-tab"
                                                            data-bs-toggle="pill" onclick="activeDiv(2)"
                                                            href="#v-pills-messages" role="tab"
                                                            aria-controls="v-pills-messages" aria-selected="false">
                                                            <div class="media">
                                                                <div class="media-body">
                                                                    <h6> <span class="first_name_0">Eamil Settings </span>
                                                                    </h6>
                                                                    <p class="email_add_0">SMTP, etc.,</p>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="col-xl-9 col-md-9">
                                                    <div class="tab-content" id="v-pills-tabContent">
                                                        <div class="tab-pane contact-tab-0 tab-content-child fade show active"
                                                            id="v-pills-user" role="tabpanel"
                                                            aria-labelledby="v-pills-user-tab">
                                                            <div class="profile-mail">
                                                                <h5>System Settings</h5>

                                                            </div>
                                                        </div>
                                                        <div class="tab-pane contact-tab-1 tab-content-child fade"
                                                            id="v-pills-profile" role="tabpanel"
                                                            aria-labelledby="v-pills-profile-tab">
                                                            <div class="profile-mail">
                                                                <h5>Social Media Settings</h5>

                                                            </div>
                                                        </div>
                                                        <div class="tab-pane contact-tab-2 tab-content-child fade"
                                                            id="v-pills-messages" role="tabpanel"
                                                            aria-labelledby="v-pills-messages-tab">
                                                            <div class="profile-mail">
                                                                <h5>SMTP Settings</h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
@endsection
