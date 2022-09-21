@extends('front.layouts.master')
@section('bg','https://thumbs.dreamstime.com/z/web-contact-us-icons-post-website-internet-page-concept-black-paper-isolated-white-background-35215369.jpg')
@section('content')
@section('title',Str::limit('İletişim',20))
<article class="mb-4">
    <div class="container px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-md-8 col-lg-8 col-xl-7">
                @if(session('success'))
                <div class="alert alert-success">
                    {{session('success')}}
                </div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                <p>Want to get in touch? Fill out the form below to send me a message and I will get back to you as soon
                    as possible!</p>
                <div class="my-5">
                    <!-- * * * * * * * * * * * * * * *-->
                    <!-- * * SB Forms Contact Form * *-->
                    <!-- * * * * * * * * * * * * * * *-->
                    <!-- This form is pre-integrated with SB Forms.-->
                    <!-- To make this form functional, sign up at-->
                    <!-- https://startbootstrap.com/solution/contact-forms-->
                    <!-- to get an API token!-->
                    <form method="post" action="{{route('contact.post')}}">
                        @csrf
                        <div class="form-floating">
                            <input class="form-control" name="name" type="text" value="{{old('name')}}" placeholder="Enter your name..."
                                   data-sb-validations="required"/>
                            <label for="name">Ad Soyad</label>
                            <div class="invalid-feedback" data-sb-feedback="name:required">A name is required.</div>
                        </div>
                        <div class="form-floating">
                            <input class="form-control" name="email" type="email" value="{{old('email')}}" placeholder="Enter your email..."
                                   data-sb-validations="required,email"/>
                            <label for="email">E-mail Adresi</label>
                            <div class="invalid-feedback" data-sb-feedback="email:required">An email is required.</div>
                            <div class="invalid-feedback" data-sb-feedback="email:email">Email is not valid.</div>
                        </div>
                        <div class="form-floating">
                            <input class="form-control" name="topic" type="text" value="{{old('topic')}}" placeholder="Write your topic..."
                                   data-sb-validations="required"/>
                            <label for="topic">Konu</label>
                            <div class="invalid-feedback" data-sb-feedback="topic:required">A topic is required.</div>
                        </div>
                        <div class="form-floating">
                            <textarea class="form-control" name="message" value="{{old('message')}}" placeholder="Enter your message here..."
                                      style="height: 12rem" data-sb-validations="required"></textarea>
                            <label for="message">Mesajınız</label>
                            <div class="invalid-feedback" data-sb-feedback="message:required">A message is required.
                            </div>
                        </div>
                        <br/>
                        <!-- Submit success message-->
                        <!---->
                        <!-- This is what your users will see when the form-->
                        <!-- has successfully submitted-->
                        <div class="d-none" id="submitSuccessMessage">
                            <div class="text-center mb-3">
                                <div class="fw-bolder">Form submission successful!</div>
                                To activate this form, sign up at
                                <br/>
                                <a href="https://startbootstrap.com/solution/contact-forms">https://startbootstrap.com/solution/contact-forms</a>
                            </div>
                        </div>
                        <!-- Submit error message-->
                        <!---->
                        <!-- This is what your users will see when there is-->
                        <!-- an error submitting the form-->
                        <div class="d-none" id="submitErrorMessage">
                            <div class="text-center text-danger mb-3">Error sending message!</div>
                        </div>
                        <!-- Submit Button-->
                        <button class="btn btn-primary text-uppercase " id="submitButton" type="submit">Gönder</button>
                    </form>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-default">
                    <div class="card-body">Panel Content</div>
                    Adress: Deneme
                </div>
            </div>
        </div>
    </div>
</article>
@endsection




