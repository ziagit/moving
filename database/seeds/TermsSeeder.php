<?php

use App\Term;
use Illuminate\Database\Seeder;

class TermsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Term::truncate();

        $data =  [
                'title' => 'Terms of Use',
                'body' => '

                <h1>Terms of Use</h1>
                <p>Update: June 2021</p>
                <h2>Contractual Relationship</h2>
                <p>
                  These Terms and Conditions (“Terms”) constitute a legal agreement
                  between you and TingsApp and its parent company (collectively,
                  “TingsApp”).
                </p>
                <p>
                  The access to our website and mobile applications (collectively, the”
                  Services”) is subject to the following Terms of this agreement, which
                  may be modified from time to time with or without prior notice. By
                  accessing and using the Service you acknowledge that you have read,
                  understood and agree to be lawfully bound by these Terms and Conditions
                  and our
                  <a href="/privacy-policies">Privacy Policy</a>.
                </p>
                <h2>The Services</h2>
                <p>
                  The Services constitute a technology platform that enables users of
                  TingsApp mobile applications and websites to arrange and schedule moving
                  and logistics services with third party providers of such services,
                  under agreement with TingsApp.
                </p>
                <p>
                  YOU ACKNOWLEDGE THAT TINGSAPP DOES NOT PROVIDE MOVING OR LOGISTICS
                  SERVICES OR FUNCTION AS A MOVING CARRIER. YOU AGREE THAT TINGSAPP HAS NO
                  RESPONSIBILITY OR LIABILITY TO YOU RELATED TO ANY MOVING OR LOGISTICS
                  PROVIDED TO YOU BY THIRD PARTY PROVIDERS THROUGH THE USE OF THE
                  SERVICES.
                </p>
                <p>
                  All the services are performed by third party independent contractors.
                  Service Providers are required to comply with all applicable laws, rules
                  and regulations, including, traffic laws, requirements of the applicable
                  motor vehicle agency, and applicable insurance requirements. Service
                  Providers are solely responsible for, and we shall not be liable or
                  responsible for, the services provided, or any acts, omissions, errors
                  or misrepresentations made by any Service Providers.
                </p>
                <p>
                  We reserve the right, but not the obligation, to limit the usage or
                  supply of the Services to any entity, geographic region, or
                  jurisdiction. We may use this right as per the necessity of our
                  business. We reserve the right to suspend the Service at any time. Any
                  offer to provide any services made on this platform is invalid where
                  banned.
                </p>
                <h2>User Account</h2>
                <p>
                  For accessing and using the Services, you must be at least 18 years of
                  age, or the age of legal majority in your jurisdiction (if different
                  than 18) and you may be required to provide personal information, such
                  as your name, address, email, mobile phone number and age, as well as a
                  valid payment method to obtain an account.
                </p>
                <p>
                  You accept that the details you provide about establishing an account
                  are accurate and that you will keep your details up to date. You are
                  responsible for the security of all of your usernames, passwords, and
                  registration information, and you are solely responsible for any use of
                  your accounts. You agree to notify us immediately about any unauthorized
                  activity regarding any of your accounts or other breaches of security.
                  We may at our discretion suspend or terminate any of your usernames and
                  passwords at any time with or without notice.
                </p>
                <h2>Communications</h2>
                <p>
                  By signing up to the Services, you electronically agree to accept and
                  receive communications from and/or on behalf of TingsApp, its parent
                  company and third parties providing services to us. The communication
                  includes but not limited to emails, text messages, calls, push
                  notifications and/or by an automatic telephone dialing system. You
                  hereby consent to receiving such communications for transactional,
                  operational, informational or marketing purposes. If you do not wish to
                  receive promotional emails, text messages, or other communications, you
                  may change your notification preferences by accessing the settings in
                  your account.
                </p>
                <p>
                  You may also opt-out of receiving text messages from us by replying
                  “STOP” from the mobile device receiving the messages. Message and data
                  rates may apply.
                </p>
                <p>
                  By creating an account with us, you also consent to the use of an
                  electronic record to document your agreement. You may withdraw your
                  consent to the use of the electronic record by emailing us at
                  <a href="mailto:legal@TingsApp.com">legal@TingsApp.com</a>
                </p>
                <h2>User Content</h2>
                <p>
                  The platform permits you to post, user rating and reviews, comment and
                  feedback (collectively,” User Content”). Ratings and Reviews are not
                  endorsed by us and do not represent the views of TingsApp. We shall have
                  no liability for Ratings and Reviews or for any claims for economic loss
                  resulting from such Ratings and Reviews. You are solely responsible for
                  the content posted by you. You represent that you are the owner of, or
                  otherwise have the right to provide, all User Content that you submit,
                  post and/or otherwise transmit through the Services.
                </p>
                <p>
                  You grant TingsApp an irrevocable, transferable, paid up, royalty-free,
                  perpetual, non-exclusive worldwide sublicensable license to use, copy,
                  display, publish, modify, remove, publicly perform, translate, create
                  derivative works from, distribute, and/or otherwise use your content in
                  connection with TingsApp or its partners’ or affiliates’ business and in
                  all forms of media (collectively, the “Uses”). Further, if you provide
                  any suggestions, input, or other feedback relating to the Services we
                  provide (collectively, the “Feedback”), we shall have the right to
                  freely and fully exercise and exploit the Feedback in connection with
                  our business or the business of our partners or affiliates. All Uses
                  will be made without notification to and/or approval by you and without
                  the requirement of payment to you or any other person or entity.
                </p>
                <h2>Payment</h2>
                <p>
                  You understand that use of the Services may result in payments by you
                  for the services you receive from a third-party Service Provider
                  ("Charges"). Once you submit a request, we will place a temporary hold
                  on your payment instrument in an amount equal to 100% of the applicable
                  charges. After you have received services obtained through your use of
                  the Services, you will have the option of paying an additional gratuity
                  (a "Tip") to the third-party Service Provider. TingsApp will facilitate
                  payment of the applicable Charges and tip if any, on behalf of the
                  Service Provider, as such Service Provider\'s limited payment collection
                  agent, using the preferred payment method designated in your Account.
                  Charges will be inclusive of applicable taxes where required by law.
                  Charges paid by you are final and nonrefundable, unless otherwise
                  determined by TingsApp.
                </p>
                <h2>Cancellation</h2>
                <p>
                  If you cancel the requested service less than two (2) business days
                  prior to the scheduled date you will be charged a cancellation fee in
                  the amount of ten percent (10%) of the initial price.
                </p>
                <h2>Damage Protection</h2>
                <p>
                  All registered Service Providers are required by terms of this agreement
                  to have (a) Auto Insurance (b) Commercial general insurance (c) Cargo
                  insurance to cover their liabilities against any services booked thru
                  the platform. The Coverage will be determined by the individual Service
                  Providers governing claim and insurance policy in effect. All claims
                  should be submitted immediately to the third-party Service Provider to
                  help ensure timely resolution. TINGSAPP AND ITS PARENT COMPANY HAVE NO
                  LIABILITY AND RESPONSIBILITIES AGAINST ANY SUCH CLAIMS.
                </p>
                <h2>Disclaimer</h2>
                <p>
                  The services are provided on an “As Is” and “As Available” basis without
                  any warranties of any kind, including that the Services will operate
                  error-free or that the website, its servers or its content are free of
                  computer viruses or similar contamination or destructive features. We
                  disclaim all licenses or warranties, including, but not limited to,
                  licenses or warranties of title, merchantability, non-violation of third
                  parties’ rights, and fitness for particular purpose and any warranties
                  arising from a matter of dealing, course of performance, or usage of
                  trade. In relation with any warranty, contract, or common law tort
                  claims: we shall not be liable for any unintended, incidental, or
                  substantial damages, lost profits, or damages resulting from lost data
                  or business stoppage resulting from the use or inability to access and
                  use the Services or the content, even if we have been recommended of the
                  possibility of such damages.
                </p>
                <p>
                  The platform may comprise technical incorrectness or typographical
                  errors or omissions. Unless required by applicable laws, we are not
                  accountable for any such typographical, technical, or pricing errors
                  recorded on the Services. The platform may contain information on
                  certain services, not all of which are available in every location. A
                  reference to a service on the websites does not suggest that such
                  service is or will be accessible in your location. We reserve the right
                  to do changes, corrections, and/or improvements to the Services at any
                  time without notice.
                </p>
                <h2>Exclusion of Liability</h2>
                <p>
                  We take no responsibility for any indirect damage that may result from
                  the Services. We accept no responsibility for delays/errors due to
                  circumstances outside our ruling. These circumstances can be, for
                  example, labor conflict, fire, war, government decisions, reduced or
                  non-delivery from the supplier. We shall not be liable and responsible
                  for the behavior of the users (both Service Providers and customers).
                  And we are also not accountable for the quality of the services provided
                  by the third-party Service Providers on the platform.
                </p>
                <p>
                  You understand and agree that we (a) do not guarantee the accuracy,
                  completeness, validity, or timeliness of information listed by us or any
                  third parties; and (b) shall not be responsible for any materials posted
                  by us or any third party. You shall use your own judgment, caution, and
                  common sense in evaluating any prospective methods or offers and any
                  information provided by us or any third party.
                </p>
                <p>
                  Further, we shall not be liable for direct, indirect consequential, or
                  any other form of loss or damage that may be suffered by a user through
                  the use of the Services including loss of data or information or any
                  kind of financial or physical loss or damage.
                </p>
                <p>
                  In no event shall TingsApp, nor its parent company, owners, directors,
                  employees, partners, agents, suppliers, or affiliates, be accountable
                  for any indirect, incidental, special, eventful or exemplary costs,
                  including without limitation, loss of proceeds, figures, usage,
                  goodwill, or other intangible losses, consequential from (a) your use or
                  access of or failure to access or use the Service; (b) any conduct or
                  content of any third party on the Service; and (c) unlawful access, use
                  or alteration of your transmissions or content, whether or not based on
                  guarantee, agreement, domestic wrong (including carelessness) or any
                  other lawful concept, whether or not we\'ve been aware of the possibility
                  of such damage.
                </p>
                <h2>Indemnification</h2>
                <p>
                  You agree to defend, indemnify, and hold TingsApp and its parent
                  company, officers, directors, employees, agents, shareholders,
                  affiliates, and partners (each, an "Indemnified Party") harmless from
                  and against any claims, actions, or demands, including, without
                  limitation, reasonable legal and accounting fees, arising or resulting
                  from your breach of this Agreement or your misuse of the Content or the
                  Services. We shall provide notice to you of any such claim, suit, or
                  proceeding and shall assist you, at your expense, in defending any such
                  claim, suit, or proceeding. We reserve the right, at your expense, to
                  assume the exclusive defense and control of any matter that is subject
                  to indemnification under this section. In such case, you agree to
                  cooperate with any reasonable requests assisting our defense of such
                  matter.
                </p>
                <h2>Dispute Resolution</h2>
                <p>
                  Any dispute between you and TingsApp arising under, or in relation to,
                  this agreement or related to the Services shall be settled by binding
                  arbitration. Such arbitration shall be held in the City of Vancouver, in
                  accordance with the laws of the province of British Colombia.
                </p>
                <h2>Governing Law</h2>
                <p>
                  To the extent permitted by applicable law, the terms herein will be
                  governed by and construed under the Law of the province of British
                  Columbia and Canadian federal laws, without giving effect to any
                  principles of conflicts of law. The Courts of Vancouver British Colombia
                  shall have exclusive jurisdiction over any dispute arising from the use
                  of the Services in Canada.
                </p>
                <h2>Third Party Links</h2>
                <p>
                  The platform may comprise links to external or third-party websites
                  (“External Sites”). These links are provided exclusively as ease to you
                  and not as an authorization by us of the content on such External Sites.
                  The content of such External Sites is created and used by others. You
                  can communicate the site administrator for those External Sites. We are
                  not accountable for the content provided in the link of any External
                  Sites and do not provide any representations about the content or
                  correctness of the information on such External Sites. You should take
                  safety measures when you are downloading files from all these websites
                  to safeguards your computer from viruses and other critical programs. If
                  you agree to access linked External Sites, you do so at your own risk.
                </p>
                <h2>Copyright and Trademark</h2>
                <p>
                  The platform contains material, such as software, text, graphics,
                  images, designs, sound recordings, audiovisual works, and other material
                  provided by or on behalf of us (collectively referred to as the
                  “Content”). The Content may be possessed by us or third parties.
                  Unauthorized use of the Content may infringe copyright, trademark, and
                  other laws. You have no rights in or to the Content, and you will not
                  take the Content except as allowed under this Agreement. No other use is
                  allowed without prior written consent from us. You must recollect all
                  copyright and other proprietary notices contained in the original
                  Content on any copy you make of the Content. You may not transfer,
                  provide license or sub-license, sell, or modify the Content or
                  reproduce, display, publicly perform, make a derivative version of,
                  distribute, or otherwise use the Content in any way for any public or
                  commercial purpose. The use or posting of the Content on any other
                  website or in a networked computer environment for any purpose is
                  expressly prohibited.
                </p>
                <p>
                  If you infringe any part of this Agreement, your permission to access
                  and/or use the Services automatically terminates and you must
                  immediately destroy any copies you have made of the Content.
                </p>
                <p>
                  Our trademarks, service marks, and logos used and displayed on are
                  registered and unregistered trademarks or service marks of us. Other
                  company, product, and service names located on the platform may be
                  trademarks or service marks owned by others (the “Third-Party
                  Trademarks,” and, collectively with us, the “Trademarks”). Nothing on
                  the platform should be construed as granting, by implication, estoppel,
                  or otherwise, any license or right to use the Trademarks, without our
                  prior written permission specific for each such use. None of the Content
                  may be retransmitted without our express, written consent for every
                  instance.
                </p>
                <p>
                  If you believe any content posted or made available on the Services
                  constitutes infringement of your copyright, you may send a written
                  notice of infringement to our legal team at
                  <a href="mailto:legal@TingsApp">legal@TingsApp</a>.com
                </p>
                <h2>Termination</h2>
                <p>
                  The Services will be provided to you can be canceled or terminated by
                  us. We may terminate the Services at any time, with or without prior
                  notice. We will have no liability to you or any third party because of
                  such termination. Termination of these Terms will terminate all of your
                  Services subscriptions.
                </p>
                <p>
                  Upon termination of these Terms for any reason, or cancellation or
                  expiration of your Services: (a) We will cease providing the Services;
                  (b) you will not be entitled to any refunds or usage fees, or any other
                  fees, pro-rata or otherwise; (c) any fees you owe to us will immediately
                  become due and payable in full, and (d) we may delete your archived data
                  within 30 days. All sections of the Terms that expressly provide for
                  survival, or by their nature should survive, will survive termination of
                  the Terms, including, without limitation, indemnification, warranty
                  disclaimers, and limitations of liability.
                </p>
                <h2>Assignment</h2>
                <p>
                  TingsApp shall have the right to assign/transfer this agreement to any
                  third party including its holding company, subsidiaries, affiliates,
                  associates, and group companies, without any consent of the User.
                </p>
                <h2>Contact</h2>
                <p>
                  If you have any questions or comments about these Terms, please contact
                  us at <a href="mailto:legal@TingsApp.com">legal@TingsApp.com</a>
                </p>

                '
        ];

        Term::insert($data);
    }
}
