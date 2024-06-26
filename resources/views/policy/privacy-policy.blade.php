@extends('layouts.file')

@section('title')
    {{ __('Privacy Policy Servicein') }}
@endsection


@section('content')
    <div class="container-fluid my-5">
        <div class="col-md-12">
            <div class="container">
                <div class="card txt-third">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-center py-5 mb-4 pb-4">
                            <img src="{{ url('assets/img/Logo2.png') }}" alt="logo" class="logo-img">
                        </div>
                        <div class="d-flex justify-content-center align-items-center txt-gold mb-5">
                            <span class="fw-semibold text-bar">{{ __('Privacy Policy') }}</span>
                        </div>


                        <h1>{{ __("Privacy Policy for Servicein") }}</h1>
                        <p>{{ __("At Servicein, accessible from ") }} <a href="https://servicein.me/" class="fw-semibold text-decoration-none txt-third">{{ __("https://servicein.me/") }}</a>, {{ ("one of our main priorities is the privacy of
                            our visitors. This Privacy Policy document contains types of information that is collected and
                            recorded by Servicein and how we use it.") }}</p>
                        <p>{{ __("If you have additional questions or require more information about our Privacy Policy, do not
                            hesitate to contact us.") }}</p>
                        <h2>{{ ("Log Files") }}</h2>
                        <p>{{ __("Servicein follows a standard procedure of using log files. These files log visitors when they
                            visit websites. All hosting companies do this and a part of hosting services' analytics. The
                            information collected by log files include internet protocol (IP) addresses, browser type,
                            Internet Service Provider (ISP), date and time stamp, referring/exit pages, and possibly the
                            number of clicks. These are not linked to any information that is personally identifiable. The
                            purpose of the information is for analyzing trends, administering the site, tracking users'
                            movement on the website, and gathering demographic information. Our Privacy Policy was created
                            with the help of the ") }}</p>
                        <h2>{{ __("Cookies and Web Beacons") }}</h2>
                        <p>{{ __("Like any other website, Servicein uses \"	cookies\" . These cookies are used to store information
                            including visitors' preferences, and the pages on the website that the visitor accessed or
                            visited. The information is used to optimize the users' experience by customizing our web page
                            content based on visitors' browser type and/or other information.")}}</p>
                        <h2>{{ __("Privacy Policies") }}</h2>

                        <P>{{ __("You may consult this list to find the Privacy Policy for each of the advertising partners of
                            Servicein.") }}</p>

                        <p>{{ __("Third-party ad servers or ad networks uses technologies like cookies, JavaScript, or Web Beacons
                            that are used in their respective advertisements and links that appear on Servicein, which are
                            sent directly to users' browser. They automatically receive your IP address when this occurs.
                            These technologies are used to measure the effectiveness of their advertising campaigns and/or
                            to personalize the advertising content that you see on websites that you visit.") }}</p>

                        <p>{{ __("Note that Servicein has no access to or control over these cookies that are used by third-party
                            advertisers")}}.</p>

                        <h2>{{ __("Third Party Privacy Policies") }}</h2>

                        <p>{{ __("Servicein's Privacy Policy does not apply to other advertisers or websites. Thus, we are advising
                            you to consult the respective Privacy Policies of these third-party ad servers for more detailed
                            information. It may include their practices and instructions about how to opt-out of certain
                            options.") }} </p>

                        <p>{{ __("You can choose to disable cookies through your individual browser options. To know more detailed
                            information about cookie management with specific web browsers, it can be found at the browsers'
                            respective websites. What Are Cookies?") }}</p>

                        <h2>{{ __("Children's Information") }}</h2>

                        <p>{{ __("Another part of our priority is adding protection for children while using the internet. We
                            encourage parents and guardians to observe, participate in, and/or monitor and guide their
                            online activity.") }}</p>

                        <p>{{ __("Servicein does not knowingly collect any Personal Identifiable Information from children under
                            the age of 13. If you think that your child provided this kind of information on our website, we
                            strongly encourage you to contact us immediately and we will do our best efforts to promptly
                            remove such information from our records.") }}</p>

                        <h2>{{ __("Online Privacy Policy Only") }}</h2>

                        <p>{{ __("This Privacy Policy applies only to our online activities and is valid for visitors to our
                            website with regards to the information that they shared and/or collect in Servicein. This
                            policy is not applicable to any information collected offline or via channels other than this
                            website.") }}</p>

                        <h2>{{ __("Consent") }}</h2>

                        <p>{{ __("By using our website, you hereby consent to our Privacy Policy and agree to its Terms and
                            Conditions.") }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
