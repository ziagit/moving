<?php

use App\Legal;
use Illuminate\Database\Seeder;

class LegalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Legal::truncate();
        $data =  [
          'title' => 'Movers Contract Agreement',
          'body' => '
          <h1>Movers Contract Agreement</h1>
          <p>
            This Contract Agreement (hereinafter referred to as the "Agreement") is
            made and entered into by and between you, the Service Provider
            (hereinafter referred to as the "Mover"), an independent contractor
            performing moving services, and TingsApp and its parent company
            (collectively, “TingsApp”). This Agreement will become effective on the
            date it is accepted/agreed through the sign-up process of becoming a
            Mover.
          </p>
          <p>
            Hereinafter both the parties mentioned above are collectively referred
            to as “Parties” and individually as “Party”, as the context demands.
          </p>
          <p>
            NOW THEREFORE THIS AGREEMENT WITNESSED AND IT IS HEREBY AGREED BY AND
            BETWEEN THE PARTIES HERETO AS FOLLOWS:
          </p>
          <h2>The Services</h2>
          <p>
            “The Services” constitute a technology platform that enables users of
            TingsApp mobile applications and websites to arrange and schedule moving
            and logistics services with third party providers of such services,
            “Movers”, under agreement with TingsApp.
          </p>
          <p>
            TINGSAPP DOES NOT PROVIDE MOVING OR LOGISTICS SERVICES OR FUNCTION AS A
            MOVING CARRIER. YOU AGREE THAT TINGSAPP HAS NO RESPONSIBILITY OR
            LIABILITY TO YOU AND TO CUSTOMERS RELATED TO ANY MOVING OR LOGISTICS
            PROVIDED TO CUSTOMERS BY YOU THROUGH THE USE OF THE SERVICES.
          </p>
          <p>
            You are required to comply with all applicable laws, rules, and
            regulations, including, traffic laws, requirements of the applicable
            motor vehicle agency, and applicable insurance requirements. Movers are
            solely responsible for, and we shall not be liable or responsible for,
            the services provided, or any acts, omissions, errors, or
            misrepresentations made by the Movers. We reserve the right, but not the
            obligation, to limit the usage or supply of the Services to any entity,
            geographic region, or jurisdiction. We may use this right as per the
            necessity of our business. We reserve the right to suspend the Service
            at any time. Any offer to provide any services made on this platform is
            invalid where banned.
          </p>
          <h2>Independent Contractor</h2>
          <p>
            Both parties agree that the Movers will act as an Independent Contractor
            in the performance of its duties under this agreement. Furthermore, the
            Mover agrees and admits that Mover is not an employee of TingsApp or of
            its parent company or affiliates. Accordingly, the mover shall be
            responsible for payment of all taxes including federal, provincial, and
            local taxes arising out of the mover’s activities in accordance with
            this contract, including by way of illustration but not limitation,
            federal and any other taxes or business license fee as required.
          </p>
          <p>
            You desire to enter into this Agreement for the right to receive moving
            opportunities in the geographical location(s) you operate. You have the
            right to decline or accept any moving request made available through the
            services. However, once an order is accepted, Movers shall be
            contractually bound to complete the order in accordance with all
            customer specifications and the terms laid out in this Agreement. Mover
            shall have the sole right and responsibility to determine the manner,
            method, and means of performance by which Mover shall render the
            Services under this Agreement, consistent with the nature of the
            Services being provided by Service Provider and subject to any
            reasonable requests of customer. Notwithstanding the forgoing, Mover
            agrees to adhere to any applicable policies and procedures as may be
            required.
          </p>
          <h2>Personnel</h2>
          <p>
            The Mover will provide as well as remain responsible for all personnel
            deemed necessary for all the orders received via the Services. All
            personnel will have criminal background checked and will provide the
            work eligibility in the jurisdictions in which he/she operates. All
            movers are required to have workers\' compensation coverage for all their
            personnel performing any jobs received through the Services.
          </p>
          <h2>Damage Protection</h2>
          <p>
            Movers are required by terms of this agreement to have (a) Auto
            Insurance (b) Commercial general insurance (c) Cargo insurance to cover
            their liabilities against any services booked thru the platform. All
            claims will be settled between Movers and Customers directly. TINGSAPP
            AND ITS PARENT COMPANY HAVE NO LIABILITY AND RESPONSIBILITIES AGAINST
            ANY SUCH CLAIMS.
          </p>
          <h2>Pricing structure</h2>
          <p>
            Movers are responsible for determining and setting their hourly rate for
            two movers and a vehicle. Based on your hourly rate, the system will
            generate an
            <b>Up-front price</b> for a request considering different factors
            involved in a moving job such as moving size, travel time, distance,
            vehicle type, number of movers and number of floors. By signing up to
            the platform you acknowledge our upfront pricing structure and agree to
            accept a fixed price set by the platform for any given job order. Our
            payment system may permit consumers to add a gratuity to be paid to
            movers. Customer can also pay a gratuity in cash. Movers shall retain
            100% of any gratuity paid by the customer, whether by cash or credit
            card.
          </p>
          <h2>Moving Supplies</h2>
          <p>
            Customers may have an option of requesting moving supplies such as
            boxes, taps, wraps etc. via the Platform. The prices of such supplies
            are fixe based on current market price. Movers agree to provide these
            supplies as part of a moving order, whether from their in-house
            inventory or purchase these supplies from outside vendors. Customers
            will be charged for placing such orders and the total amount of the
            supplies will be reimbursed to movers.
          </p>
          <h2>Service Fee</h2>
          <p>
            Unless notified otherwise by TingsApp in writing or except as provided
            herein, Movers will be charged 10% on the total amount of an order,
            before Supplies, Tips (if applicable) and Taxes, as service fee for each
            successful job completed.
          </p>
          <h2>GST/HST</h2>
          <p>
            You agree that you have the obligation under the Excise Tax Act (Canada)
            to register for a GST/HST account with the Canada Revenue Agency. You
            also agree that TingsApp or its parent company shall collect GST/HST
            from Customers on your behalf, and that such collection shall be
            considered the same as a collection made directly by you from the
            Customer. TingsApp or its affiliate shall remit to you, or cause to be
            remitted to you, such collected GST/HST on a bi-weekly basis. You agree
            that the GST/HST amounts remitted to you need not be sent separately
            from any other remittances to you and need not be accompanied by any
            documentation setting out which portion of such remittance is on account
            of GST/HST. You understand that, in accordance with the Excise Tax Act
            (Canada), you will hold any such collected GST/HST in trust for the
            Government of Canada, subject to any right you may have to claim input
            tax credits. You, and not TingsApp, are responsible for timely
            remittance of the correct amount of such GST/HST to the Canada Revenue
            Agency. Notwithstanding anything in the Agreement, TingsApp shall
            calculate the Service Fee exclusive of GST/HST.
          </p>
          <h2>Payment</h2>
          <p>
            TingsApp shall electronically remit payment to the bank account
            specified by you. Payment shall be made every two weeks via direct
            deposit. In the event of a service failure, mover shall not be entitled
            to payment as determined in the Company reasonable discretion. Any
            withholding of payment shall be based upon proof provided by the
            Customer or any other party with information relevant to the dispute.
            TingsApp shall make the initial determination as to whether a Service
            Failure was the result of Mover ‘s action/omission. Mover shall have the
            right to challenge TingsApp determination through any legal means termed
            by this Agreement; however, Mover shall notify TingsApp in writing at
            the challenge and provide TingsApp the opportunity to resolve the
            dispute. In the event that TingsApp fails to remit payment in a timely
            or accurate manner, Mover shall have the right to seek proper payment by
            any legal means contemplated by this Agreement and, should Mover
            prevail, shall be entitled to recover reasonable costs incurred in
            pursuing proper payment provided however, Mover shall first inform
            TingsApp in writing the failure and provide a reasonable opportunity to
            cure it.
          </p>
          <h2>Intellectual property</h2>
          <p>
            The Mover hereby grants TingsApp for the term a royalty free irrevocable
            license to use its Intellectual Property for the purposes of providing
            the Services by the Company as contemplated hereunder. The term
            “Intellectual Property” shall mean and include business information,
            personal information, logos, trade names, brand names, trademarks,
            copyrights, and other relevant intellectual property rights relevant to
            the advertisement and sale of the products and services.
          </p>
          <h2>Indemnity and Liability</h2>
          <p>
            Both Parties agree to indemnify the other Party and hold harmless from
            and against all claims, losses, causes of action, liabilities, damages,
            and expenses (including, without limitation, reasonable attorneys\' fees)
            directly arising from, incurred as a consequence of or otherwise
            directly attributable to the gross negligence of either party as per the
            terms of this Agreement. In no event shall TingsApp and its parent
            company be liable to the Mover for any incidental, indirect,
            consequential, or punitive damages, loss of goodwill or business
            profits, regardless of the nature of the claim, even if TingsApp knew or
            should have known of the possibility of such damages or claims.
          </p>
          <h2>Confidentiality</h2>
          <p>
            Customers recognize that Movers have and will have the following
            information: Business information, Personal Information, Plans, and
            other proprietary information (collectively, "Information") which are
            valuable, special, and unique assets of customers and need to be
            protected from improper disclosure. In consideration for the disclosure
            of the Information, Movers agree that they will not at any time or in
            any manner, either directly or indirectly, use any Information for their
            own benefit, or divulge, disclose, or communicate in any manner any
            Information to any third party without the prior consent of the
            Customer. Movers will protect the Information and treat it as strictly
            confidential. A violation of this paragraph shall be a material
            violation of this Agreement.
          </p>
          <h2>Dispute Resolutions and Governing Laws</h2>
          <p>
            Any dispute between you and TingsApp arising under, or in relation to,
            this agreement or related to the Services shall be settled by binding
            arbitration. To the extent permitted by applicable law, the terms herein
            will be governed by and construed under the Law of the province of
            British Columbia and Canadian federal laws, without giving effect to any
            principles of conflicts of law. The Courts of Vancouver British Colombia
            shall have exclusive jurisdiction over any dispute arising from the use
            of the Services in Canada.
          </p>
          <h2>Non-Exclusivity</h2>
          <p>
            During the term of this Agreement, Movers can engage in other activities
            and can provide its services to other Companies/clients.
          </p>
          <h2>Service Period</h2>
          <p>
            This Agreement shall commence on the effective date and shall be valid
            for as long as both parties are agreed and operate under the terms of
            this Agreement. unless notified in written by any parties for
            termination of the contract.
          </p>
          <h2>Terms and Privacy</h2>
          <p>
            By signing up to the platform you acknowledge that you have reviewed,
            understood, and agreed to our general Terms and Conditions and Privacy
            Policy posted on our website and mobile application. Also, by accepting
            this Agreement you consent to all actions taken by TingsApp with respect
            to your information in accordance with our Privacy Statement.
          </p>

      '
  ];
        Legal::insert($data);
    }
}
