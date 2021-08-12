<?php
$stylesheet = "help";

?>

<?php
$props = DB::table('site_props')->where('id', 1)->get();
?>

@section('cpn', $cpn )
@section('wn', $wn )

@extends('layouts.store')

@section('website_content')
<div class="mainProductBanner">
    <div class="innerProductBanner container">
        <h3><?php echo $cpn; ?></h3>
        <p>We're here to help 24/7</p>
    </div>
</div>
    <div class="container mainHelpCont">
        <div class="bottomContainer">
            <div id="faq" class="faqBox">
                <h3>FAQ</h3>
                <div class="content">
                    <p><?php echo $props[0]->faq_text; ?></p>
                </div>
            </div>

            <div id="return_policy" class="returnPolicyBox">
                <h3>Return Policy</h3>
                <div class="content">
                    <p><?php echo $props[0]->return_policy; ?></p>
                </div>
            </div>
            <div id="contact_form" class="clearfix contactFormMain">
                <h3>Contact Us</h3>
                <div class="content col-md-6">
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <p>Feel free to contact us!</p>

                    <form action="{{ route('contact.send') }}" method="post">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputEmail4">Firstname</label>
                                <input type="text" name="firstname" class="form-control" id="inputEmail4" placeholder="Firstname">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputPassword4">Lastname</label>
                                <input type="text" name="lastname" class="form-control" id="inputPassword4" placeholder="Lastname">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail4">Email</label>
                            <input type="email" name="email" class="form-control" id="inputEmail4" placeholder="Email">
                        </div>
                        <div class="form-group">
                            <label for="inputEmail4">Subject</label>
                            <input type="text" name="subject" class="form-control" id="inputEmail4" placeholder="Subject">
                        </div>
                        <div class="form-group">
                            <label for="inputEmail4">Message</label>
                            <textarea name="message" class="form-control" id="inputEmail4" placeholder="Message"></textarea>
                        </div>
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-primary">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection