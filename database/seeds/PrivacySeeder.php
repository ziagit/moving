<?php

use App\Privacy;
use Illuminate\Database\Seeder;

class PrivacySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Privacy::truncate();

        $data =  [
                'title' => 'Privacy Notice',
                'body' => '
                <h1>Privacy Notice</h1>
                <p>Update: June 2021</p>
                <p>
                  Our Privacy Policy (“Policy”) forms part of and must be read in
                  conjunction with our Terms. We reserve the right to change this Privacy
                  at any time. This notice applies to all users and information collected
                  through our Apps, Websites, features, or other services, (Collectively,
                  the “Services”).
                </p>
                <p>
                  TingsApp and its parent company (collectively, “TingsApp”) respect the
                  privacy of our users and we are committed to protecting your personal
                  information and your right to privacy.
                </p>
                <p>
                  When you visit and/or use the Services, you trust us with your personal
                  information. We take your privacy seriously. In this Privacy notice, we
                  describe what information we collect, how we use it, and what rights you
                  have concerning it. Please read this Policy carefully as it will help
                  you make informed decisions about sharing your personal information with
                  us.
                </p>
                <p>
                  By using the Services, you accept the Terms and our privacy practices
                  described in this Policy.
                </p>
                <h2>What information do we collect?</h2>
                <h2>Personal Information</h2>
                <p>
                  We collect personal information that you voluntarily provide to us when
                  expressing an interest in obtaining information about us or the Services
                  when participating in activities on the platform or otherwise contacting
                  us.
                </p>
                <p>
                  The personal information that we collect depends on the context of your
                  interactions with us and the Services, the choices you make, and the
                  products and features you use. The personal information we collect can
                  include the following:
                </p>
                <p>
                  <b class="Personal">Name and contact data</b>. We collect your first and
                  last name, email address, postal address, phone number, and other
                  similar contact data.
                </p>
                <p>
                  <b class="Personal">Credentials</b>
                  We collect passwords, password hints, and similar security information
                  used for authentication and account access.
                </p>
                <h2>Location information</h2>
                <p>
                  We will track the device location by sending GPS coordinates to our
                  application. We may also determine location by using other data from
                  your mobile device, such as information about wireless networks or cell
                  towers near your device. We use and store information about your
                  location to enable many product and Service features that are dependent
                  upon location tracking. We may also use collected information to
                  troubleshoot software, to conduct data analysis, to do testing,
                  research, and to monitor and analyze usage and activity trends to
                  improve and customize the Services.
                </p>
                <h2>Payment Data</h2>
                <p>
                  We collect data necessary to process your payment if you make purchases,
                  such as your payment instrument number (i.e., a credit card number), and
                  the security code associated with your payment instrument. All payment
                  data is stored by our payment processor and you should review its
                  privacy policies and contact the payment processor directly if you have
                  any concern <a href="https://stripe.com/">@stripe.com</a>
                </p>
                <h2>Information automatically collected</h2>
                <p>
                  We automatically collect certain information when you visit, use, or
                  navigate the Services. This information does not reveal your specific
                  identity (like your name or contact information) but may include device
                  and usage information, such as your IP address, browser, and device
                  characteristics, operating system, language preferences, referring URLs,
                  device name, country, location, information about how and when you use
                  the Services and other technical information. If you access the Services
                  with your mobile device, we may automatically collect device information
                  (such as your mobile device ID, model, and manufacturer), operating
                  system, version information, and IP address. This information is
                  primarily needed to maintain the security and operation of our Site, and
                  for our internal analytics and reporting purposes.
                </p>
                <p>
                  Like many businesses, we also collect information through cookies and
                  similar technologies. You can find out more about this in our
                  <a href="">Cookie Policy</a>.
                </p>
                <h2>Information collected from other Sources</h2>
                <p>
                  We may obtain information about you from other sources, such as public
                  databases, joint marketing partners, social media platforms (such as
                  Facebook), as well as from other third parties.
                </p>
                <p>
                  If you have chosen to subscribe to our newsletter, your first name, last
                  name and email address will be shared with our newsletter provider. This
                  is to keep you updated with information and offers for marketing
                  purposes.
                </p>
                <h2>How do we use your information?</h2>
                <p>
                  We use your personal information for these purposes in reliance on our
                  legitimate business interests (“Business Purposes”), to enter into or
                  perform a contract with you (“Contractual”), with your consent
                  (“Consent”), and/or for compliance with our legal obligations (“Legal
                  Reasons”). We indicate the specific processing grounds we rely on next
                  to each purpose listed below.
                </p>
                <p>We use the information we collect or receive for:</p>
                <ul>
                  <li>
                    <b>Deliver targeted advertising to you</b> for our Business Purposes
                    and/or with your consent. We may use your information to develop and
                    display content and advertising (and work with third parties who do
                    so) tailored to your interests and/or location and to measure its
                    effectiveness. [For more information, see our
                    <a href="">Cookies Policy</a>.
                  </li>
                  <li>
                    <b>Request Feedback</b> for our Business Purposes and/or with your
                    Consent. We may use your information to request feedback and to
                    contact you about your use of the Services.
                  </li>
                  <li>
                    <b>To protect our Site</b> for Business Purposes and/or Legal Reasons.
                    We may use your information as part of our efforts to keep our Site
                    safe and secure (for example, for fraud monitoring and prevention).
                  </li>
                  <li>
                    <b>To enforce our terms, conditions, and policies</b> for our business
                    purposes and as legally required.
                  </li>
                  <li>
                    <b>To respond to legal requests and prevent harm</b> as legally
                    required. If we receive a subpoena or other legal request, we may need
                    to inspect the data we hold to determine how to respond.
                  </li>
                  <li>
                    <b>For other Business Purposes</b>. We may use your information for
                    other Business Purposes, such as data analysis, identifying usage
                    trends, determining the effectiveness of our promotional campaigns and
                    to evaluate and improve our Site, products, services, marketing, and
                    your experience.
                  </li>
                </ul>
          
                <h2>Will your information be shared with anyone?</h2>
                <p>
                  We only share and disclose your information in the following situations:
                </p>
                <ul>
                  <li>
                    <b>Compliance with Laws</b>. We may disclose your information where we
                    are legally required to do so to comply with applicable law,
                    governmental requests, a judicial proceeding, court order, or legal
                    processes, such as in response to a court order or a subpoena
                    (including in response to public authorities to meet national security
                    or law enforcement requirements).
                  </li>
                  <li>
                    <b>Vital Interests and Legal Rights</b>. We may disclose your
                    information where we believe it is necessary to investigate, prevent,
                    or take action regarding potential violations of our policies,
                    suspected fraud, situations involving potential threats to the safety
                    of any person and illegal activities, or as evidence in litigation in
                    which we are involved.
                  </li>
                  <li>
                    <b>Vendors, Consultants, and other Third-Party Service Providers</b>.
                    We may share your data with third-party vendors, service providers,
                    contractors, or agents who perform services for us or on our behalf
                    and require access to such information to do that work.
                  </li>
                  <li>
                    <b>Business Transfers</b>. We may share or transfer your information
                    in connection with, or during negotiations of, any merger, sale of
                    company assets, financing, or acquisition of all or a portion of our
                    business to another company.
                  </li>
                  <li>
                    <b>Third-Party Advertisers</b>. We may use third-party advertising
                    companies to serve Ads when you visit the Services. These companies
                    may use information about your visits to the Services and other
                    websites that are contained in web cookies and other tracking
                    technologies to provide advertisements about goods and services of
                    interest to you.
                  </li>
                  <li>
                    <b>Affiliates</b>. We may share your information with our affiliates,
                    in which case we will require those affiliates to honor this Privacy
                    Policy. Affiliates include our parent company and any subsidiaries,
                    joint venture partners, or other companies that we control or that are
                    under common control with us.
                  </li>
                  <li>
                    <b>Business Partners</b>. We may share your information with our
                    business partners to offer you certain products, services, or
                    promotions.
                  </li>
                  <li>
                    <b>With your Consent</b>. We may disclose your personal information
                    for any other purpose with your consent.
                  </li>
                  <li>
                    <b>Other Users</b>. When you share personal information (for example,
                    by posting comments, contributions, or other content to the Platform)
                    or otherwise interact with public areas of the Services, such personal
                    information may be viewed by all users and may be publicly distributed
                    outside the Platform in perpetuity.
                  </li>
                </ul>
                <h2>Do we use cookies and other tracking technologies?</h2>
                <p>
                  We may use cookies and similar tracking technologies (like web beacons
                  and pixels) to access or store information. Specific information about
                  how we use such technologies and how you can refuse certain cookies is
                  set out in our <a href="">Cookies Policy</a>.
                </p>
                <h1>
                  <u><b>Cookies Policy</b></u>
                </h1>
                <p>
                  By continuing to use the Services, you are agreeing to the use of
                  Cookies and similar technologies for the purpose we describe in this
                  Cookies Policy.
                </p>
                <h2>Cookies</h2>
                <p>
                  A cookie is a small text file that a website saves on your computer or
                  mobile device when you visit the site. In general, cookies have two main
                  purposes: to improve your browsing experience by remembering your
                  actions and preferences and to help us analyze our website traffic.
                </p>
                <h2>What do we do with Cookies?</h2>
                <p>
                  We use cookies to help us analyze traffic to the platform, to help us
                  improve website performance and usability, and to make the website more
                  secure. Third-party cookies help us use Google Analytics to count,
                  track, and analyze visits to the website. This helps us understand how
                  people are using the Services and where we need to make improvements.
                  These third-party cookies do not specifically identify you.
                </p>
                <h2>Types and Category of Cookies used</h2>
                <h3>Security</h3>
                <p>
                  We use cookies to enable and support our security features, and to help
                  us detect malicious activity violations of our Terms and Conditions.
                </p>
                <h3>Performance, Analytics, Research and Advertising</h3>
                <p>
                  Cookies help us learn how well our site and web products perform in
                  different locations. We also use these to understand, improve, and
                  research products, features, and services, including when you access
                  <a href="https://TingsApp.com/"><b>https://TingsApp.com</b></a>
                  from other websites, applications, or devices such as your work computer
                  or your mobile device. We also use third-party cookies to improve and
                  personalize our marketing messages/communications with you.
                </p>
                <h3>Control cookies</h3>
                <p>
                  You are always free to delete cookies that are already on your computer
                  through your browser settings, and you can set most browsers to prevent
                  them from being added to your computer. However, this may prevent you
                  from using certain features of the Services.
                </p>
                <h2>What is our stance on third party websites?</h2>
                <p>
                  The Services may contain advertisements from third parties that are not
                  affiliated with us and which may link to other websites, online
                  services, or mobile applications. We cannot guarantee the safety and
                  privacy of data you provide to any third parties. Any data collected by
                  third parties is not covered by this Privacy Policy. We are not
                  responsible for the content or privacy and security practices and
                  policies of any third parties, including other websites, services, or
                  applications that may be linked to or from the Services. You should
                  review the policies of such third parties and contact them directly to
                  respond to your questions.
                </p>
                <h2>How long do we keep your information?</h2>
                <p>
                  We will only keep your personal information for as long as it is
                  necessary for the purposes set out in this Privacy Policy unless a
                  longer retention period is required or permitted by law (such as tax,
                  accounting, or other legal requirements).
                </p>
                <p>
                  When we have no ongoing legitimate business need to process your
                  personal information, we will either delete or anonymize it, or, if this
                  is not possible (for example, because your personal information has been
                  stored in backup archives), then we will securely store your personal
                  information and isolate it from any further processing until deletion is
                  possible.
                </p>
                <h2>How do we keep your information safe?</h2>
                <p>
                  We have implemented appropriate technical and organizational security
                  measures designed to protect the security of any personal information we
                  process. However, please also remember that we cannot guarantee that the
                  internet itself is 100% secure. Although we will do our best to protect
                  your personal information, the transmission of personal information to
                  and from our platform is at your own risk. You should only access the
                  services within a secure environment.
                </p>
                <h2>What are your privacy rights?</h2>
                <p>
                  You may at any time review or change the information in your account or
                  terminate your account by contacting us using the contact information
                  provided below
                </p>
                <p>
                  Upon your request to terminate your account, we will deactivate or
                  delete your account and information from our active databases. However,
                  some information may be retained in our files to prevent fraud,
                  troubleshoot problems, assist with any investigations, enforce our
                  Terms, and/or comply with legal requirements.
                </p>
                <h2>Do we make updates to this Policy?</h2>
                <p>
                  We may update this Privacy Policy from time to time. The updated version
                  will be indicated by an updated “Revised” date and the updated version
                  will be effective as soon as it is accessible. If we make material
                  changes to this Privacy Policy, we may notify you either by prominently
                  posting a notice of such changes or by directly sending you a
                  notification. We encourage you to review this Policy frequently to be
                  informed of how we are protecting your information.
                </p>
                <h2>Where Do we Keep and Process Information?</h2>
                <p>
                  Regardless of where you use the Services, the information collected as
                  part of that use will be transferred to and maintained on our servers
                  located in the United States. Any information we obtain about you will
                  be stored in accordance with U.S. privacy laws, regulations, and
                  standards, which may not be equivalent to the laws in your country of
                  residence. By using the Services, you consent to this collection,
                  transfer, storage, and processing of information to and in the United
                  States.
                </p>
                <h2>How can you contact us about this Policy?</h2>
                <p>
                  If you have questions or comments about this Policy, please email us at
                  <a href="mailto:legal@TingsApp.com">legal@TingsApp.com</a>
                </p>
                '
        ];

        Privacy::insert($data);
    }
}
