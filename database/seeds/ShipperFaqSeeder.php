<?php

use App\ShipperFaq;
use Illuminate\Database\Seeder;

class ShipperFaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ShipperFaq::truncate();

        $data =  [
            [
                'title' => 'What is ShippingTAP?',
                'body' => '
                <div class="md-title"></div>
                <div class="md-body-1">
                  ShippingTAP is a free, easy-to-use platform that uses the best technology from
                  shippingtab’s popular ride-sharing service. It allows shippers to see upfront
                  prices on shipments and tender their loads at the touch of a button.
                  <div class="break"></div>
                  The ultimate aim of ShippingTAP is to make the lives of both shippers and
                  truck drivers easier, with transparent, upfront pricing, visibility to their
                  truck(s) location(s), fast payment, and the ability to easily and simply book
                  a truck for their load(s).
                </div>
                <div class="break"></div>
                '
            ],
            [
                'title' => 'Are carriers required to have cargo liability insurance?',
                'body' => '
                <div class="md-body">
                <b>Yes</b>. Carriers working with ShippingTAP are required to have at least
                €100,000 in cargo liability coverage, and these coverages are regularly
                verified by ShippingTAP.
                <div class="break"></div>
                For German national loads, the requirement is to have at least €600,000 in
                cargo liability coverage
                <div class="break"></div>
              </div>
              <div class="break"></div>
                '
            ],
            [
                'title' => 'Who uses ShippingTAP?',
                'body' => '
                <div class="md-body">
                We work with shippers of all sizes, from those that move a few loads a week to
                larger companies with thousands of loads a day. Every day we’re activating new
                shippers and we’re excited about the amount of interest in our services. We do
                not disclose shipper names due to confidentiality clauses.
              </div>
              <div class="break"></div>
                '
            ],
            [
                'title' => 'Shipper platform FAQ',
                'body' => '
                <div class="md-title">How do I cancel a shipment?</div>
                <div class="md-body">
                  Log on to the shipper platform and select the shipment you would like to
                  cancel. This will open the load details page. Click “edit” and then click
                  “cancel shipment.”
                </div>
                <div class="break"></div>
      
                <div class="md-title">What is your cancellation policy?</div>
                <div class="md-body">
                  A load can be canceled through the shipper platform up to 48 hours before
                  pickup. If you want to cancel the load within 48 hours of pickup, please
                  contact our team at shipper-eu@shippingtab.com. If a load is canceled on the
                  day of scheduled pickup or within 24 hours a Cancellation Fee will be issued.
                </div>
                <div class="break"></div>
      
                <div class="md-title">How do I update my email notification settings?</div>
                <div class="md-body">
                  In the upper right corner of the shipper platform, click your name and then
                  “settings” to open the notifications preferences panel.
                </div>
                <div class="break"></div>
      
                <div class="md-title">What should I do if I forget my password?</div>
                <div class="md-body">
                  When you try to log on to the shipper platform, click “forget password” and
                  follow the instructions.
                </div>
                <div class="break"></div>
      
                <div class="md-title">
                  Why can’t I track a specific shipment on the dashboard?
                </div>
                <div class="md-body">
                  Certain loads may not have live tracking enabled. Email
                  shipper-eu@shippingtab.com if you’re unable to track your shipment.
                </div>
                <div class="break"></div>
      
                <div class="md-title">How do I add a new user to my account?</div>
                <div class="md-body">
                  Email shipper-eu@shippingtab.com with the name and email address of the new
                  user.
                </div>
                <div class="break"></div>
      
                <div class="md-title">
                  How do I download my proof of delivery (POD) or invoice?
                </div>
                <div class="md-body">
                  Open the load details page and click on either “Download Proof of Delivery
                  (POD)” or “Download Invoice.” You can also enable or disable email
                  notifications for when these documents become available.
                </div>
                <div class="break"></div>
      
                <div class="md-title">What kind of payment does ShippingTAP accept?</div>
                <div class="md-body">
                  Via bank transfer:
                  <ul>
                    <li>Name: Bank of America, N.A.</li>
                    <li>Bank Address: 2 King Edward Street, London EC1A 1HQ</li>
                    <li>Account Name: FREIGHT NL</li>
                    <li>SWIFT: BOFAGB22VAM</li>
                    <li>IBAN Number: GB69BOFA30023100925848</li>
                    <li>Account Number: 900800925848</li>
                    <li>Sort code: 300231</li>
                  </ul>
                </div>
                <div class="break"></div>
      
                <div class="md-title">
                  What are the accessorial charges and when do I get charged?
                </div>
                <div class="md-body">
                  Please see our accessorial schedule in our Welcome Packet to learn more.
                  Alternatively, please consult section four of our terms and conditions. The
                  charges will be included on your invoice if incurred.
                </div>
                <div class="break"></div>
      
                <div class="md-title">Where can I view invoices?</div>
                <div class="md-body">
                  Invoices are emailed to the billing contact after the load has been delivered.
                  Invoices are also available within each individual loadcard on the ShippingTAP
                  shipper platform dashboard. For any questions on invoicing statements, please
                  email shipper-eu@shippingtab.com.
                </div>
                <div class="break"></div>
      
                <div class="md-title">
                  Can I add multiple email addresses to receive invoices?
                </div>
                <div class="md-body">
                  Yes, please email your additional addresses to shipper-eu@shippingtab.com.
                </div>
                <div class="break"></div>
      
                <div class="md-title">How long should I expect to wait for invoices?</div>
                <div class="md-body">
                  We start processing invoices as soon as the driver uploads the POD. This can
                  create some delays, but you should expect to receive invoices 1–2 weeks after
                  a shipment is delivered. Your net 30 terms won’t start until receipt of the
                  invoice.
                </div>
                <div class="break"></div>
      
                <div class="md-title">Do you take credit cards?</div>
                <div class="md-body">Not at the moment.</div>
                <div class="break"></div>
      
                <div class="md-title">How do I reach customer support?</div>
                <div class="md-body">
                  You can contact ShippingTAP support by emailing shipper-eu@shippingtab.com or
                  by calling +31 800 4200026 or +31 20 241 8687. Our support team is available
                  during business hours, Monday to Friday.
                </div>
                <div class="break"></div>
      
                <div class="md-title">
                  Is ShippingTAP currently servicing LTL or partial shipments on the platform?
                </div>
                <div class="md-body">Not at the moment.</div>
                <div class="break"></div>
      
                <div class="md-title">
                  Is ShippingTAP servicing shipments to non-EU countries?
                </div>
                <div class="md-body">
                  Not at the moment. If you have non-EU shipments, please reach out to your
                  sales rep for additional information.
                </div>
                <div class="break"></div>
      
                <div class="md-title">
                  Is ShippingTAP currently servicing flatbed shipments on the shipper platform?
                </div>
                <div class="md-body">
                  Not at the moment. If you have flatbed shipments, please reach out to your
                  sales rep for additional information.
                </div>
                <div class="break"></div>
      
                <div class="md-title">Can ShippingTAP handle blind shipments?</div>
                <div class="md-body">
                  Yes, we recommend sending all paperwork directly to your pickup and delivery
                  facilities. Please include a description of these requirements in the load
                  notes when booking the load on our platform.
                </div>
                <div class="break"></div>
      
                <div class="md-title">Can ShippingTAP handle scale tickets?</div>
                <div class="md-body">
                  Yes, please ensure that all special requirements are detailed in the “Notes”
                  section when building your load.
                </div>
                <div class="break"></div>
      
                <div class="md-title">Can ShippingTAP deliver to unstaffed warehouses?</div>
                <div class="md-body">
                  Yes, we recommend sending all paperwork directly to your pickup and delivery
                  facilities. Please email shipper-eu@shippingtab.com before building your
                  shipment to ensure our team is aware of the situation.
                </div>
                <div class="break"></div>
      
                <div class="md-title">Can I build a multi-stop shipment?</div>
                <div class="md-body">
                  The shipper platform does not currently support multi-stop shipments. However,
                  we do support shipments with 1 pickup and 2 deliveries or 2 pickups and 1
                  delivery. You can get a quote by emailing the individual addresses and dates
                  for these shipments to shipper-eu@shippingtab.com.
                </div>
                <div class="break"></div>
      
                <div class="md-title">Will ShippingTAP insure my loads?</div>
                <div class="md-body">
                  Carriers who work with ShippingTAP are required to have at least €100.000 of
                  cargo liability insurance and will be liable to you for cargo damage in
                  accordance with the applicable Laws and/or Convention. ShippingTAP will assist
                  you with cargo claims against a carrier.
                </div>
                <div class="break"></div>
      
                <div class="md-title">
                  What happens if my cargo is a short product or there is an overage or damage
                  to my load?
                </div>
                <div class="md-body">
                  If you discover any overages, shortages, or damages (OSD), please email
                  shipper-eu@shippingtab.com. Our team will investigate the situation and
                  connect you with our claims department, if necessary.
                </div>
                <div class="break"></div>
      
                <div class="md-title">Related articles</div>
                <div class="md-body">
                  <ul>
                    <li>Carrier Payment and Accessorials Guide</li>
                    <li>Using Fleet Mode</li>
                    <li>Are carriers required to have cargo liability insurance?</li>
                    <li>How to contact customer support</li>
                    <li>Using the ShippingTAP app</li>
                  </ul>
                </div>
                '
            ],
            [
                'title' => 'How pricing works',
                'body' => '
                <div class="md-body">
                Prices are generated by shippingtab’s proprietary algorithm and expire after
                ten minutes. We guarantee that we will cover the load at the price we quote.
                The price quoted represents the line-haul service and does not include any
                type of accessorial services such as driver assist. Our accessorial policy can
                be found in our terms and conditions page accessible through the platform.
              </div>
                '
            ],
            [
                'title' => 'I need to reset my ShippingTAP password',
                'body' => '
                <div class="md-body">
                You can reset your password by following this
                <router-link to="/login">link</router-link>. If you still have problems
                signing in, please reach out to us at shipper-eu@shippingtab.com, and we will
                help you.
              </div>
                '
            ],
            [
                'title' => 'How to contact ShippingTAP',
                'body' => '
                <div class="md-title">Shipper Support</div>
                <div class="md-body">
                  <ul>
                    <li>shipper-eu@shippingtab.com</li>
                    <li>Toll free only for callers within Netherlands: +31 800 4200026</li>
                    <li>Local: +31 20 241 8687</li>
                  </ul>
                </div>
                '
            ],
            [
                'title' => 'Reporting a cargo damage claim',
                'body' => '
                <div class="md-body">
                Carriers are liable to shippers for loss or damage to cargo in accordance with
                applicable law. ShippingTAP helps facilitate resolution and support in the
                case of cargo loss or damage and will help to coordinate your claim with the
                carrier. Please contact shipper-eu@shippingtab.com to report a cargo claim.
              </div>
                '
            ]
        ];

        ShipperFaq::insert($data);
    }
}
