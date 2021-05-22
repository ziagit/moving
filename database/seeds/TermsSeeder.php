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
                'title' => 'Terms',
                'body' => '
                  <div class="md-body-1">
                  These Terms and Conditions (“Terms”) constitute a legal Agreement
                  between you and, Shipping Tap and its parent company EG Logistics
                  Inc. (collectively, “The Company”), (“We”, “Us”, or “Our”). The
                  access to our website and mobile applications (collectively, the
                  ”Platform”) is subject to the following Terms of this agreement,
                  which may be modified from time to time with or without prior
                  notice. By accessing and using our Services (the ”Services”) you
                  acknowledge that you have read, understood and agree to be lawfully
                  bound by these Terms and Conditions and our Privacy Policy.
                  </div>
                  <br />
                  <div class="md-title">Definition</div>
                  <div class="md-body-1">
                  <b>Carrier:</b> A person or company licensed to operate motor
                  vehicles to transport goods ( freight and/or household items) for
                  compensation. Carriers may be referred as “Service Provider”. <br />
                  <b>Shipper:</b> any user of the services that arranges to have goods
                  shipped. Shippers may be referred to as the “Customer”. <br />
                  <b>Broker:</b> A person who, for compensation, arranges, or offers
                  to arrange, the transportation of goods by an authorized motor
                  carrier.
                </div>
                <br />

          <div class="md-title">Services</div>
          <div class="md-body-1">
            Shipping Tap is an online shipping platform connects and matches
            shippers and carriers. Shipping Tap is not a motor carrier nor an
            agent of any motor carrier. <br />
            No interpretation of written or oral remarks in any agreement or
            document shall be construed to imply Shipping Tap is a motor
            carrier. All the transportation services are perform by third party
            independent Carriers. Service Providers are required to comply with
            all applicable laws, rules and regulations, including, traffic laws,
            requirements of the applicable motor vehicle agency, and applicable
            insurance requirements. Carriers are solely responsible for, and we
            shall not be liable or responsible for, the services provided or any
            acts, omissions, errors or misrepresentations made by any Carriers.
            <br />
            We reserve the right, but not the obligation, to limit the usage or
            supply of the Services to any entity, geographic region, or
            jurisdiction. We may use this right as per the necessity of our
            business. <br />
            We reserve the right to suspend the Service at any time. Any offer
            to provide any Services made on this Platform is invalid where
            banned.
          </div>
          <br />
          <div class="md-title">Services</div>
          <div class="md-body-1">
            We reserve the right, in our discretion, to change, modify, add to,
            or remove portions of the Terms (collectively, “Changes”), at any
            time. <br />
            The updated version will be effective immediately after posting.
            Your continued use of the services following the posting of changes
            will mean that you accept and agree to the Changes.
          </div>
          <br />
          <div class="md-title">Communications</div>
          <div class="md-body-1">
            By signing up to our services, you electronically agree to accept
            and receive communications from and/or on behalf of Shipping Tap,
            its parent company, Carriers and/or third parties providing services
            to us. The communication includes but not limited to emails, text
            messages, calls, push notifications and/or by an automatic telephone
            dialing system. You hereby consent to receiving such communications
            for transactional, operational, informational or marketing purposes.
            If you do not wish to receive promotional emails, text messages, or
            other communications, you may change your notification preferences
            by accessing the settings in your account. You may also opt-out of
            receiving text messages from us by replying “STOP” from the mobile
            device receiving the messages. Message and data rates may apply.
            <br />
            By creating an account with us, you also consent to the use of an
            electronic record to document your agreement. You may withdraw your
            consent to the use of the electronic record by emailing us at
            legal@shippingtap.com
          </div>
          <br />
          <div class="md-title">User Account</div>
          <div class="md-body-1">
            For accessing and using our services and, you may be required to
            provide specific information and to create a user ID and password to
            establish an account. <br />
            You accept that the details you provide about establishing an
            account are accurate and that you will keep your details up-to-date.
            You are responsible for the security of all of your user names,
            passwords, and registration information, and you are solely
            responsible for any use (authorized or not) of your accounts. You
            agree to notify us immediately about any unauthorized activity
            regarding any of your accounts or other breaches of security. We may
            at our discretion suspend or terminate any of your user names and
            passwords at any time with or without notice.
          </div>
          <br />
          <div class="md-title">User Content</div>
          <div class="md-body-1">
            The Platform permits you to post, user rating and reviews, comment
            and feedback (collectively, ”User Content”). Ratings and Reviews are
            not endorsed by Us and do not represent the views of Shipping Tap or
            its affiliates. We shall have no liability for Ratings and Reviews
            or for any claims for economic loss resulting from such Ratings and
            Reviews. You are solely responsible for the content posted by you.
            You represent that you are the owner of, or otherwise have the right
            to provide, all User Content that you submit, post and/or otherwise
            transmit through the Services. <br />
            You grant Shipping Tap an irrevocable, transferable, paid up,
            royalty-free, perpetual, non-exclusive worldwide sublicensable
            license to use, copy, display, publish, modify, remove, publicly
            perform, translate, create derivative works from, distribute, and/or
            otherwise use Your Content in connection with Shipping Tap or its
            partners’ or affiliates’ business and in all forms of media
            (collectively, the “Uses”). Further, if you provide any suggestions,
            input, or other feedback relating to the Platform or the Services we
            provide (collectively, the “Feedback”), We shall have the right to
            freely and fully exercise and exploit the Feedback in connection
            with our business or the business of our partners or affiliates. All
            Uses will be made without notification to and/or approval by you and
            without the requirement of payment to you or any other person or
            entity.
          </div>
          <br />
          <div class="md-title">Payment</div>
          <div class="md-body-1">
            Use of the Services may result in charges to you for the services or
            goods you receive ("Charges"). We will receive and/or enable your
            payment of the applicable Charges for services or goods obtained
            through your use of the Services. Charges will be inclusive of
            applicable taxes where required by law. All Charges and payments
            will be enabled by the Company using the preferred payment method
            designated in your Account. We may change the fees for our Services
            as we deem necessary or appropriate for our business. <br />
            <b>Authorization to Credit and Debit Accounts.</b> As a Shipper or
            Carrier, You irrevocably and expressly authorize the Company to
            credit any monies to the account that You have identified for
            Shipping Tap. You agree that it is your responsibility to maintain a
            valid credit card or bank account on file with us while using the
            Services.
          </div>
          <br />
          <div class="md-title">Rates and Fees</div>
          <div class="md-body-1">
            All transportation and accessorial rates are provided by the
            Carriers through their accounts dashboard, we do not set or control
            their rate tables. Rates Quoted include 30 minutes time loading and
            offloading for LTL shipments. Quotes are based on the information
            Shippers provide; however, if the actual shipment characteristics
            are materially different than specified by the Shipper and result in
            changes such as but not limited to equipment required, space
            required, accessorial services required, excess wait time, all
            duties, customs assessments, governmental penalties and fines,
            taxes, and legal costs allocable to shipments, then Carriers may
            invoice a different amount than the original quote, and the Shippers
            shall be responsible for all additional costs incurred. The quotes
            generated by the system includes the basic transportation rate, fuel
            surcharge, accessorial fee, applicable taxes and the Services fee.
          </div>
          <br />
          <div class="md-title">Bill of lading</div>
          <div class="md-body-1">
            The platform software generates an electronic and/or printable bill
            of lading containing the booking information provided by the shipper
            and their selection of carrier, for the use in tendering the
            shipment. The bill of lading issued in connection with each shipment
            is non-negotiable and shall be deemed, conclusively, to have been
            prepared by the Shipper. Failure by the Shipper to provide the bill
            of lading generated by the system may result in the loss of the
            quoted rate. Any changes to the shipment after booking requires a
            new bill of lading with updated information, which is to be done by
            cancelling the previous shipment and booking a new request.
          </div>
          <br />
          <div class="md-title">Claims and Insurance</div>
          <div class="md-body-1">
            All registered Carriers are required by terms of this agreement to
            have (a) Auto Insurance (b) Commercial general insurance (c) Cargo
            insurance to cover their liabilities against any shipment booked via
            the platform. The Carrier liability for any cargo damage, loss, or
            theft from any cause shall be determined under the presiding,
            applicable law. All cargo claims should be submitted immediately by
            the Shipper to the selected Carrier to help ensure timely
            resolution, and Shipping Tap and all of its affiliates have no
            liability responsibilities against any such claims. The liability
            for cargo loss offered will be determined by the individual
            Carrier’s governing claim and insurance policy in effect at the time
            of shipment.
          </div>
          <br />
          <div class="md-title">User Responsibilities</div>
          <div class="md-body-1">
            <ul>
              <li>
                You shall use the Platform for a lawful purpose and comply with
                all the applicable laws while using the Services.
              </li>
              <li>
                You shall not use or access the Platform for collecting any
                market research for some competing business.
              </li>
              <li>
                You shall not misrepresent or personate any person or entity for
                any false or illegal purpose.
              </li>
              <li>
                You will not interfere with or try to interrupt the proper
                operation of the Services through the use of any virus, device,
                information collection or transmission mechanism, software or
                routine, or access or try to gain access to any data, files, or
                passwords connected to the Services through hacking, password or
                data mining, or any other means.
              </li>
              <li>
                You will not cover, obscure, block, or in any way interfere with
                any advertisements and/or safety features (e.g., report abuse
                button) on the Platform;
              </li>
            </ul>
            We reserve the right, in our sole and absolute discretion, to deny
            your access to the Services, or any portion of the service, without
            notice, and to remove any content.
          </div>
          <br />
          <div class="md-title">Carriers Obligations</div>
          <div class="md-body-1">
            <ul>
              <li>
                The Carrier hereby grants to the Company for the Term a
                royalty-free irrevocable license to use its Intellectual
                Property to provide the Services by the Company as contemplated
                hereunder.
              </li>
              <li>
                The term “Intellectual Property” shall mean and include logos,
                trade names, brand names, trademarks, copyrights, and other
                relevant intellectual property rights relevant to the
                advertisement and sale of the Products.
              </li>
              <li>
                The Carrier takes full responsibility for all information
                provided by them and must indemnify the Company about any
                liability incurred by the Company as a result of such
                information.
              </li>
              <li>
                Vendor shall indemnify the Company for all claims and
                liabilities arising out of any use by the Carrier of the
                Services including costs and expenses incurred.
              </li>
              <li>
                All information provided by the Carrier on the platform must be
                accurate and kept up-to-date. This includes the correct name,
                address, telephone number, Pricing and Rates. Details entered by
                the Carrier on the platform will be publicly visible and may
                appear in search engine results.
              </li>
              <li>
                The Carrier agrees and undertakes to fully co-operate with the
                Company as reasonably required, in connection with any
                customer-service functions undertaken by the Company.
              </li>
              <li>
                The Carrier authorizes the Company to place on the platform; (a)
                description of the Carrier (including but not limited to; name,
                logo, address, contact information and history of business.) (b)
                description of services (c) The prices given by the carrier on
                selected shipment(s) (d) The Vendor rating based on vendor
                performance and customer reviews.
              </li>
            </ul>
          </div>
          <br />
          <div class="md-title">No Responsibility</div>
          <div class="md-body-1">
            <ul>
              <li>
                We are not responsible for any losses you may suffer by relying
                on any material or any commentary, postings or reviews (of our
                services or that of our partners), or any losses you suffer
                because you cannot use our Services at any time; or any errors
                in or omissions from our Services; or any unauthorized access or
                loss of personal information that is beyond our control.
              </li>
              <li>
                We do not provide any warranty or guarantee that the products
                and service descriptions are accurate, complete, reliable,
                current, or error-free.
              </li>
              <li>
                We disclaim any implied warranties of merchantability, fitness
                for a particular purpose, quiet enjoyment, or non-infringement;
                and any warranties arising out of course-of-dealing, usage, or
                trade. You assume all risk for any/all damages that may result
                from your use of or access to the Services. We shall not be
                responsible for the loss of, damage to, or unavailability of any
                information you have made available through the services, and
                you are solely responsible for ensuring that you have backup
                copies of any information you have made available through the
                services.
              </li>
              <li>
                We do not guarantee the accuracy of and disclaim all liability
                for, any errors or other inaccuracies in the information,
                content, recommendations, and materials made available through
                the Platform.
              </li>
              <li>
                No warranties regarding third parties. We make no
                representations, warranties, or guarantees, express or implied,
                regarding any third party service or advice provided by a third
                party.
              </li>
              <li>
                The Platform is licensed to you on a limited, non-exclusive,
                non-transferable, non-sublicensable basis, solely to be used in
                connection with the Service for your personal and commercial
                use, subject to all the terms and conditions of this Agreement
                as they apply to the Service.
              </li>
              <li>
                We shall have no liability to you for any failure to the
                shipment you have ordered or any delay in doing so or for any
                damage or defect to Products delivered if caused by any event or
                circumstances beyond our reasonable control including, without
                limitation, adverse weather, pandemics, strikes, lockouts, and
                other industrial disputes, breakdown or systems or network
                access, flood, fire, explosion or accident.
              </li>
            </ul>
          </div>
          <br />
          <div class="md-title">Disclaimer</div>
          <div class="md-body-1">
            The services are provided on an “As Is” and “As Available” basis
            without any warranties of any kind, including that the Services will
            operate error-free or that the website, its servers or its content
            are free of computer viruses or similar contamination or destructive
            features. <br />
            We disclaim all licenses or warranties, including, but not limited
            to, licenses or warranties of title, merchantability, non-violation
            of third parties’ rights, and fitness for particular purpose and any
            warranties arising from a matter of dealing, course of performance,
            or usage of trade. In relation with any warranty, contract, or
            common law tort claims: we shall not be liable for any unintended,
            incidental, or substantial damages, lost profits, or damages
            resulting from lost data or business stoppage resulting from the use
            or inability to access and use the Services or the content, even if
            we have been recommended of the possibility of such damages. <br />
            The Platform may comprise technical incorrectness or typographical
            errors or omissions. Unless required by applicable laws, we are not
            accountable for any such typographical, technical, or pricing errors
            recorded on the Services. The Platform may contain information on
            certain services, not all of which are available in every location.
            A reference to a service on the websites does not suggest that such
            service is or will be accessible in your location. We reserve the
            right to do changes, corrections, and/or improvements to the website
            at any time without notice.
          </div>
          <br />
          <div class="md-title">Exclusion of Liability</div>
          <div class="md-body-1">
            We take no responsibility for any indirect damage that may result
            from the Services. <br />
            We accept no responsibility for delays/errors due to circumstances
            outside the Company\'s ruling. These circumstances can be, for
            example, labor conflict, fire, war, government decisions, reduced or
            non-delivery from the supplier. We shall not be liable and
            responsible for the behavior of the users (both the carriers and
            shippers). And we are also not accountable for the quality of the
            services provided by the Carrier on the platform.
            <br />
            You understand and agree that we (a) do not guarantee the accuracy,
            completeness, validity, or timeliness of information listed by us or
            any third parties; and (b) shall not be responsible for any
            materials posted by us or any third party. You shall use your own
            judgment, caution, and common sense in evaluating any prospective
            methods or offers and any information provided by us or any third
            party. <br />
            Further, we shall not be liable for direct, indirect consequential,
            or any other form of loss or damage that may be suffered by a user
            through the use of the Services including loss of data or
            information or any kind of financial or physical loss or damage.
            <br />
            In no event shall The Company, nor its owners, directors, employees,
            partners, agents, suppliers, or affiliates, be accountable for any
            indirect, incidental, special, eventful or exemplary costs,
            including without limitation, loss of proceeds, figures, usage,
            goodwill, or other intangible losses, consequential from (a) your
            use or access of or failure to access or use the Service; (b) any
            conduct or content of any third party on the Service; and (c)
            unlawful access, use or alteration of your transmissions or content,
            whether or not based on guarantee, agreement, domestic wrong
            (including carelessness) or any other lawful concept, whether or not
            we\'ve been aware of the possibility of such damage.
          </div>
          <br />
          <div class="md-title">Third Party Links</div>
          <div class="md-body-1">
            The Platform may comprise links to external or third-party Websites
            (“External Sites”). These links are provided exclusively as ease to
            you and not as an authorization by us of the content on such
            External Sites. The content of such External Sites is created and
            used by others. You can communicate the site administrator for those
            External Sites. We are not accountable for the content provided in
            the link of any External Sites and do not provide any
            representations about the content or correctness of the information
            on such External Sites. You should take safety measures when you are
            downloading files from all these Websites to safeguards your
            computer from viruses and other critical programs. If you agree to
            access linked External Sites, you do so at your own risk.
          </div>
          <br />
          <div class="md-title">Personal Information</div>
          <div class="md-body-1">
            By accessing or using our Services, you approve us to use, store, or
            otherwise process your personal information as per our
            <a href="/privacy-polacies">Privacy Policy</a> .
          </div>
          <br />
          <div class="md-title">Copyright and Trademark</div>
          <div class="md-body-1">
            The Platform contains material, such as software, text, graphics,
            images, designs, sound recordings, audiovisual works, and other the
            material provided by or on behalf of us (collectively referred to as
            the “Content”). The Content may be possessed by us or third parties.
            Unauthorized use of the Content may infringe copyright, trademark,
            and other laws. You have no rights in or to the Content, and you
            will not take the Content except as allowed under this Agreement. No
            other use is allowed without prior written consent from us. You must
            recollect all copyright and other proprietary notices contained in
            the original Content on any copy you make of the Content. You may
            not transfer, provide license or sub-license, sell, or modify the
            Content or reproduce, display, publicly perform, make a derivative
            version of, distribute, or otherwise use the Content in any way for
            any public or commercial purpose. The use or posting of the Content
            on any other Website or in a networked computer environment for any
            purpose is expressly prohibited. <br />
            If you infringe any part of this Agreement, your permission to
            access and/or use the Services automatically terminates and you must
            immediately destroy any copies you have made of the Content. <br />
            Our trademarks, service marks, and logos used and displayed on the
            Website are registered and unregistered trademarks or service marks
            of us. Other company, product, and service names located on the
            Platform may be trademarks or service marks owned by others (the
            “Third-Party Trademarks,” and, collectively with us, the
            “Trademarks”). Nothing on the Platform should be construed as
            granting, by implication, estoppel, or otherwise, any license or
            right to use the Trademarks, without our prior written permission
            specific for each such use. None of the Content may be retransmitted
            without our express, written consent for every instance. <br />
            If you believe any content posted or made available on the Services
            constitutes infringement of your copyright rights, you may send a
            written notice of infringement to the Company legal team at
            legal@shippingtap.com
          </div>
          <br />
          <div class="md-title">Indemnification</div>
          <div class="md-body-1">
            You agree to defend, indemnify, and hold the Company and its
            officers, directors, employees, agents, shareholders, affiliates,
            and partners (each, an "Indemnified Party") harmless from and
            against any claims, actions, or demands, including, without
            limitation, reasonable legal and accounting fees, arising or
            resulting from your breach of this Agreement or your misuse of the
            Content or the Services. We shall provide notice to you of any such
            claim, suit, or proceeding and shall assist you, at your expense, in
            defending any such claim, suit, or proceeding. We reserve the right,
            at your expense, to assume the exclusive defense and control of any
            matter that is subject to indemnification under this section. In
            such case, you agree to cooperate with any reasonable requests
            assisting our defense of such matter.
          </div>
          <br />
          <div class="md-title">Dispute Resolution</div>
          <div class="md-body-1">
            If a dispute arises between you and the Company, our goal is to
            resolve such dispute quickly and cost effectively. Accordingly, you
            and the company agree that we will resolve any claim or controversy
            at law or equity that arises between us out of this Agreement or use
            of the Services in accordance with this section entitled "Dispute
            Resolution." Before resorting to these alternatives, you agree to
            first contact us directly to seek dispute assistance. <br />
            As per terms of this agreement and applicable law, each party
            submits to arbitration for the resolution of any disputes between
            the parties, to be conducted by a single arbitrator chosen by the
            parties.
          </div>
          <br />
          <div class="md-title">Governing Law</div>
          <div class="md-body-1">
            To the extent permitted by applicable law, the terms herein will be
            governed by and construed under the Law of the province of British
            Columbia and Canadian federal laws, without giving effect to any
            principles of conflicts of law. The Courts of Vancouver British
            Colombia shall have exclusive jurisdiction over any dispute arising
            from the use of the Services in Canada.
          </div>
          <br />
          <div class="md-title">Severability</div>
          <div class="md-body-1">
            If any provision of these Terms is found to be unenforceable or
            invalid, that provision will be limited or eliminated to the minimum
            extent necessary so that the Terms will otherwise remain in full
            force and effect and enforceable.
          </div>
          <br />
          <div class="md-title">Termination</div>
          <div class="md-body-1">
            The Services will be provided to you can be canceled or terminated
            by us. We may terminate these Services at any time, with or without
            prior notice. We will have no liability to you or any third party
            because of such termination. Termination of these Terms will
            terminate all of your Services subscriptions. <br />
            Upon termination of these Terms for any reason, or cancellation or
            expiration of your Services: (a) We will cease providing the
            Services; (b) you will not be entitled to any refunds or usage fees,
            or any other fees, pro-rata or otherwise; (c) any fees you owe to us
            will immediately become due and payable in full, and (d) we may
            delete your archived data within 30 days. All sections of the Terms
            that expressly provide for survival, or by their nature should
            survive, will survive termination of the Terms, including, without
            limitation, indemnification, warranty disclaimers, and limitations
            of liability.
          </div>
          <br />
          <div class="md-title">Entire Agreement</div>
          <div class="md-body-1">
            This Agreement constitutes the entire agreement between the parties
            hereto concerning the subject matter contained in this Agreement.
          </div>
          <br />
          <div class="md-title">Force Majeure</div>
          <div class="md-body-1">
            We will have no liability to you, your users, or any third party for
            any failure us to perform its obligations under these Terms if such
            non-performance arises as a result of the occurrence of an event
            beyond the reasonable control of us, including, without limitation,
            an act of war or terrorism, natural disaster, failure of electricity
            supply, riot, civil disorder, or civil commotion or other force
            majeure event.
          </div>
          <br />
          <div class="md-title">Assignment</div>
          <div class="md-body-1">
            The Company shall have the right to assign/transfer this agreement
            to any third party including its holding company, subsidiaries,
            affiliates, associates, and group companies, without any consent of
            the User.
          </div>
          <br />
          <div class="md-title">Contact</div>
          <div class="md-body-1">
            If you have any questions or comments about these Terms, pl ease
            contact us at legal@shippingtap.com
          </div>
                '
        ];

        Term::insert($data);
    }
}
