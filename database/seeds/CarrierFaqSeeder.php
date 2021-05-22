<?php

use App\CarrierFaq;
use Illuminate\Database\Seeder;

class CarrierFaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CarrierFaq::truncate();

        $cities =  [
            [
                'title' => 'Equipment types',
                'body' => '
                <div class="md-body-1">
                Currently, you must have at least one of the equipment types from this list:
                <ul>
                  <li>Tautliner</li>
                  <li>Mega trailer</li>
                  <li>Road train</li>
                  <li>Jumbo</li>
                  <li>Tilt</li>
                  <li>Joloda</li>
                  <li>Box</li>
                  <li>Frigo/Frigolona</li>
                </ul>
              </div>

                '
            ],
            [
                'title' => 'Plated trailer requirements',
                'body' => '
                <div class="md-body-1">
                For loads that require plated trailers please reference the requirements in
                this support article.
                <ul>
                  <li>
                    Plated trailers are required to have swing doors and not have wood
                    paneling on interior walls, see diagram below.
                  </li>
                  <li>Interior dimensions must be at least 2.45m wide.</li>
                  <li>Must be a food-grade trailer without damage.</li>
                </ul>
                If a carrier is rejected due to their trailer, the carrier will not be
                reimbursed. <br />
              </div>

                '
            ],
            [
                'title' => 'Signing up to be a carrier',
                'body' => '
                <div class="md-title">Who is eligible and how do I sign up?</div>
                <div class="md-body-1">
                  Carriers can download the ShippingTAP app and web portal free of charge. The
                  app and web portal can only be used to book loads by drivers who are
                  authorized to book their own loads on behalf of their carrier. As a carrier,
                  you can sign up, submit your information, and once you’re approved you can add
                  your drivers. It’s that simple!
                </div>
                <div class="break"></div>
                <div class="md-title">How do I get started with ShippingTAP?</div>
                <div class="md-body-1">
                  You’ll first need to sign up and tell us a bit about your business. To sign up
                  you’ll need to agree to our contract, submit your insurance and license, and
                  give us your banking information so we can pay you! Right now we’re only
                  working with Tautliners and their variants and Frigos/Frigolonas.
                </div>
                <div class="break"></div>
                <div class="md-title">How does the ShippingTAP app work?</div>
                <div class="md-body-1">
                  The ShippingTAP app is free and available in the App Store and Google Play
                  Store. The ShippingTAP app lists loads that you can book right from your
                  phone. Once you book one of the loads, the load is confirmed for your carrier,
                  so please only book loads that you and your carrier are willing to take.
                </div>
                <div class="break"></div>
                <div class="md-title">Document requirements</div>
                <div class="md-body-1">
                  <ul>
                    <li>
                      All carriers must provide a Cargo Liability Coverage evidencing cargo
                      liability, and must complete our Carrier Service Level Agreement.
                    </li>
                    <li>
                      All carriers must also provide a Transport Cargo License which can be
                      either a Community License or a National License, depending on the areas
                      of operations.
                    </li>
                  </ul>
                </div>
                <div class="md-title">Vehicle requirements</div>
                <div class="md-body-1">
                  For now, you must have either a Tautliner (Mega, Box, etc. are included) or a
                  Frigo.
                </div>
                <div class="break"></div>
                <div class="md-title">Insurance requirements</div>
                <div class="md-body-1">
                  Our carrier contract contains Our carrier contract contains insurance
                  requirements including:
                  <ul>
                    <li>At least €100.000 in cargo liability coverage per event.</li>
                    <li>
                      At least €100.000 in auto liability coverage per event (only for romanian
                      and italian carriers)
                    </li>
                  </ul>
                </div>
                <div class="md-title">Optional requirements</div>
                <div class="md-body-1">
                  <ul>
                    <li>
                      For national loads in Germany, the requirement is at least €600.000 in
                      cargo liability coverage per event.
                    </li>
                    <li>
                      For Cabotage loads in Germany, the requirement is at least €600.000 in
                      cargo liability coverage per event.
                    </li>
                  </ul>
                </div>
                <div class="break"></div>
                <div class="md-title">To create account, what information is required?</div>
                <div class="md-body-1">
                  <ul>
                    <li>Cargo Liability Coverage</li>
                    <li>Transport Cargo License</li>
                    <li>Bank Account Information</li>
                  </ul>
                </div>
                <div class="md-title">Setting up payment</div>
                <div class="md-body-1">
                  <ul>
                    <li>
                      We offer weekly payments which will be deposited in the bank account that
                      you’ve provided on the Carrier Service Level Agreement.
                    </li>
                    <li>
                      We pay carriers within 7 days of submitting the Proof of delivery and
                      Invoice.
                    </li>
                  </ul>
                </div>
                <div class="md-title">Downloading the app</div>
                <div class="md-body-1">
                  The ShippingTAP app is free and available in the
                  <router-link to="https://apple.com">App Store</router-link>
                  and
                  <router-link to="https//play.google.com">Google Play</router-link>
                  Store.
                </div>
                <br />

                '
            ],
            [
                'title' => 'Using fleet mode',
                'body' => '

                <div class="md-title">What is fleet mode?</div>
                <div class="md-body-1">
                  Fleet mode empowers dispatchers to manage their fleet without leaving the
                  ShippingTAP app. When dispatchers open the app, they see a full list of their
                  drivers and their details—like their location and schedule—so they can assign,
                  book, and manage their loads from start to finish.
                  <div class="break"></div>
                </div>
                <div class="md-title">How can I get access to fleet mode?</div>
                <div class="md-body-1">
                  Download the ShippingTAP app from the App or Play Store, sign up and select
                  “dispatcher.” Once we activate your ShippingTAP account, you will
                  automatically enjoy the fleet mode functionality within the app and fleet web
                  portal. This will give you the ability to assign loads to your drivers and set
                  their schedule.
                </div>
                <div class="break"></div>
      
                <div class="md-title">
                  How do I know which drivers in my fleet have the ShippingTAP app?
                </div>
                <div class="md-body-1">
                  Tap Drivers in your app menu to see a full list of your drivers. Tap My Loads
                  in the app menu to see all loads booked by all your drivers.
                </div>
                <div class="break"></div>
      
                <div class="md-title">
                  How do I manage dispatchers and/or drivers in my fleet?
                </div>
                <div class="md-body-1">
                  Fleet managers and dispatchers can add or remove members and manage driver
                  booking permissions through the fleet web portal
                  <div class="break"></div>
                  To add a member:
                  <ul>
                    <li>Sign in using the same email and password on your ShippingTAP app.</li>
                    <li>Tap Add a member and enter their information.</li>
                    <li>
                      The new member will receive an email asking them to verify their account.
                    </li>
                  </ul>
                </div>
      
                <div class="md-title">After booking a load, who receives a rate con?</div>
                <div class="md-body-1">
                  Dispatchers and carriers both receive a rate con for loads booked via fleet
                  mode. Drivers who have permission to see load rates will also receive a rate
                  con.
                </div>
                <div class="break"></div>
      
                <div class="md-title">
                  Can dispatchers see the location of their drivers in the Shippingtab Freight
                  app?
                </div>
                <div class="md-body-1">
                  Yes, where available, we show each driver’s current location and calculate the
                  deadhead from that location to each pickup. This helps dispatchers choose the
                  best driver for each load.
                </div>
                <div class="break"></div>
      
                <div class="md-title">How do I send a dispatch to a driver?</div>
                <div class="md-body-1">
                  Once you’ve selected a load and tapped the “Book” button, you will be prompted
                  to assign a driver from a list of “Available” drivers. Drivers will then be
                  notified of the dispatch and have 30 minutes to reject the load.
                </div>
                <div class="break"></div>
      
                <div class="md-title">How do I view driver schedules?</div>
                <div class="md-body-1">
                  Click Drivers in the menu bar to see driver schedules.
                </div>
                <div class="break"></div>
      
                <div class="md-title">
                  When I book a load and assign it to a driver, does the driver automatically
                  have the load?
                </div>
                <div class="md-body-1">
                  Yes, when a dispatcher assigns a load to a driver in their fleet, the driver
                  has 30 minutes to decline the load.
                </div>
                <div class="break"></div>
      
                <div class="md-title">
                  What happens if the driver does not respond in 30 minutes?
                </div>
                <div class="md-body-1">
                  If your driver does not respond within the 30-minute window, the load will be
                  booked.
                </div>
                <div class="break"></div>
      
                <div class="md-title">What if the driver declines the load?</div>
                <div class="md-body-1">
                  If your driver declines the load, the load will no longer be reserved for your
                  carrier. The app will send the dispatcher a notification that the load was
                  declined.
                </div>
                <div class="break"></div>
                <div class="md-title">Can drivers see the full price of the load?</div>
                <div class="md-body-1">
                  Yes, if dispatchers set each driver’s permission to see load prices in the
                  Drivers tab.
                </div>
                <div class="break"></div>
      
                <div class="md-title">Can drivers book loads in their apps?</div>
                <div class="md-body-1">
                  Yes, if dispatchers set each driver’s permission to be able to book loads via
                  the app.
                </div>
                <div class="break"></div>
      
                <div class="md-title">
                  Is the dispatcher notified when their driver books a load via fleet mode?
                </div>
                <div class="md-body-1">
                  Yes, the app will send the dispatcher a notification.
                </div>
                <div class="break"></div>
                <div class="md-title">What is the “Post Truck” feature?</div>
                <div class="md-body-1">
                  For fleet mode dispatchers posting trucks for drivers, you can post a truck by
                  tapping a driver’s name in the Drivers tab.
                </div>
                <div class="break"></div>
                To cancel a truck post that was booked in fleet mode for a driver:
                <ul>
                  <li>Go to the Drivers tab.</li>
                  <li>Tap the specific driver.</li>
                  <li>Select Delete Post.</li>
                </ul>
      
                <div class="md-title">How do I respond to a dispatch request?</div>
                <div class="md-body-1">
                  Once a dispatcher assigns a load, you’ll receive a notification prompting you
                  to confirm the load.
                </div>
                <div class="break"></div>
                <div class="md-title">How much time do I have to respond?</div>
                <div class="md-body-1">
                  You’ll have 30 minutes to reject a dispatch. If you don’t reject the dispatch,
                  it will be booked automatically.
                </div>
                <div class="break"></div>
                <div class="md-title">Am I able to see the full price of the load?</div>
                <div class="md-body-1">
                  Dispatchers can set each driver’s permission to see load prices in the app.
                </div>
                <div class="break"></div>
                <div class="md-title">Can I still book loads in my app?</div>
                <div class="md-body-1">
                  Dispatchers can set each driver’s permission to be able to book loads via the
                  app.
                </div>
                <div class="break"></div>
                <div class="md-title">
                  Is the dispatcher notified when their driver books a load via dispatcher mode?
                </div>
                <div class="md-body-1">
                  Yes, the app will send the dispatcher a notification.
                </div>
                <div class="break"></div>
      
                '
            ],
            [
                'title' => 'Using the ShippingTAP app',
                'body' => '

                <div class="md-title">How does the ShippingTAP app work?</div>
                <div class="md-body-1">
                  The ShippingTAP app is free and available in the App Store and Google Play
                  Store. The ShippingTAP app lists loads that you can book right from your
                  phone. Once you book a load, the load is confirmed for you, so please only
                  book loads that you and your carrier are willing to take.
                </div>
                <div class="break"></div>
      
                <div class="md-title">How do I sign in?</div>
                <div class="md-body-1">
                  On your Android or iPhone, sign in with the email and password you provided
                  when you created your ShippingTAP account.
                </div>
                <div class="break"></div>
      
                <div class="md-title">What if I forgot my password?</div>
                <div class="md-body-1">
                  You can reset your password by following this link or clicking the “I forgot
                  my password” link at the bottom of the login page. You’ll need to enter the
                  email address associated with your ShippingTAP account. The password reset
                  link will be sent to your email address. Once you have created your new
                  password, open your ShippingTAP app where you can sign in with your new
                  password. If you still have problems signing in, please email us at
                  freight-eu@Shippingtab.com.
                </div>
                <div class="break"></div>
      
                <div class="md-title">How do I search for loads?</div>
                <div class="md-body-1">
                  The ShippingTAP app has many features designed to help you filter and search
                  for loads. You can search by trailer type, location, pickup date, and length
                  of haul. You can also sort loads by deadhead, rate per kilometer, price, and
                  weight based on your preferences.
                </div>
                <div class="break"></div>
      
                <div class="md-title">How do I book a load?</div>
                <div class="md-body-1">
                  Tap on the load to view its details. Simply tap “Book load” at the bottom of
                  the screen and the load is yours. The primary contact on your carrier account
                  and dispatcher or driver who booked the load will receive a rate confirmation
                  via email.
                </div>
                <div class="break"></div>
      
                <div class="md-title">Am I allowed to book back-to-back loads?</div>
                <div class="md-body-1">
                  Yes, generally the app will allow you to book another. For back-to-back loads,
                  load availability will depend on several factors, including the previous
                  load’s delivery time, time spent at the facility, and kilometers between the
                  previous load’s delivery location and the next load’s pickup location.
                </div>
                <div class="break"></div>
      
                <div class="md-title">When and how do I receive the rate confirmation?</div>
                <div class="md-body-1">
                  You or your dispatcher should receive a rate confirmation in your email inbox
                  shortly after tapping the “Book load” button. Your rate confirmation email
                  will also include the load number you’ll need to provide if you contact our
                  support team.
                </div>
                <div class="break"></div>
      
                <div class="md-title">
                  How do I cancel a load if I can no longer make the pickup?
                </div>
                <div class="md-body-1">
                  If you must cancel a load, please do so as soon as possible. Tap the headset
                  icon at the top right corner of the screen, select the load, and tap “Request
                  to remove myself from this load.” You can also call the ShippingTAP support
                  team by tapping “Call ShippingTAP support.”
                </div>
                <div class="break"></div>
      
                <div class="md-title">What is the “Post Truck” feature?</div>
                <div class="md-body-1">
                  Posting a truck helps make sure your truck is always utilized by matching you
                  to available loads that meet your specific needs. Tap “My Loads” on the
                  navigation bar and then tap “Post Truck.” Select the day your truck will be
                  available, then provide the place and time your truck will be ready for loads.
                  Once you confirm that you want to post your truck, you’ll receive a push
                  notification each time a load matches your post. <br />
                  To cancel a truck post that hasn’t received a match, tap “My Loads” on the
                  navigation bar and then tap “Remove truck post.” To cancel a truck post that
                  has received matches, tap “view matches,” scroll down, and tap “Remove truck
                  post.” Once you cancel a post, you will no longer receive matches or alerts
                  for that posting.
                </div>
                <div class="break"></div>
      
                <div class="md-title">
                  How does the “Post Truck” feature work in fleet mode?
                </div>
                <div class="md-body-1">
                  For dispatchers posting trucks for drivers, tap a driver’s name in the
                  “Drivers” tab, select a day in the driver’s schedule that is empty, and tap
                  “Post Truck.” <br />
                  To cancel a truck post that was booked in fleet mode for a driver, go to the
                  “Drivers” tab and tap on the specific driver, then “Delete Post.” If you need
                  help, you can contact customer support by tapping the headset icon in the
                  upper right corner.
                </div>
      
                <div class="break"></div>
      
                <div class="md-title">What are reloads?</div>
                <div class="md-body-1">
                  At the bottom of each load details screen, we’ll suggest reloads if we have
                  options available. Reloads keep your trucks moving by minimizing empty
                  kilometers. When you go to book a load through the app, ShippingTAP will
                  preview a list of reloads or backhauls (loads picking up near the delivery
                  location) that you can book next. At the bottom of each load details screen,
                  we’ll suggest reloads if we have options available. Tap on a reload to see all
                  relevant load information and to book the reload.
                </div>
                <div class="break"></div>
      
                <div class="md-title">How do I share a load?</div>
                <div class="md-body-1">
                  Tap on the load that you want to share. Scroll to the bottom of the load
                  details and tap “Share this Load.” If the recipient has been activated on the
                  ShippingTAP app, they will receive a link to the load. If not, they will
                  receive an invitation to sign up with Shippingtab Freight.
                </div>
                <div class="break"></div>
      
                <div class="md-title">Where do I find the loads I booked?</div>
                <div class="md-body-1">
                  You can see all your loads in the “My Loads” tab in the menu. To see the loads
                  you’re currently on and have booked for the future, tap “Booked” at the top of
                  the screen. To see your completed loads, tap “Past.”
                </div>
                <div class="break"></div>
      
                <div class="md-title">
                  What do I do if I am running late for my appointment?
                </div>
                <div class="md-body-1">
                  We know sometimes issues happen that are out of your control. In those cases,
                  reach out to our customer support team by tapping the headset icon at the top
                  right corner of the screen.
                </div>
                <div class="break"></div>
      
                <div class="md-title">
                  What does ShippingTAP pay for accessorials for loads booked on the app?
                </div>
                <div class="md-body-1">
                  We keep our app load accessorial rates posted publicly on our website. For
                  more information on accessorial rates, view the Carrier Payment and
                  Accessorials Guide.
                </div>
                <div class="break"></div>
      
                <div class="md-title">How does in-app support work?</div>
                <div class="md-body-1">
                  You can get support help with assignment changes, tracking updates, detention
                  requests, payment status, and more, all within the app. You can also speak
                  with a representative by tapping the headset icon at the top right corner of
                  the screen, then “Call ShippingTAP support.”
                </div>
                <div class="break"></div>
      
                <div class="md-title">
                  How do I submit a proof of delivery and other documents?
                </div>
                <div class="md-body-1">
                  When your trailer is empty, tap “Complete delivery” and the app will prompt
                  you to use your phone’s camera to take a photo of the signed proof of delivery
                  (POD). Take the photo. Be sure to capture a clear and legible image of your
                  POD to prevent delays in payment; if the image is unclear, please retake the
                  photo. Then, add pages as necessary. A complete, legible, signed, and
                  otherwise acceptable copy of the Proof of Delivery (the “POD”) is required for
                  payment. Please submit the POD within 24 hours after delivery.
                </div>
                <div class="break"></div>
                '
            ],
            [
                'title' => 'Using the ShippingTAP web portal',
                'body' => '
                <div class="md-title">What does a carrier need to sign in?</div>
                <div class="md-body-1">
                  Carriers sign in through the ShippingTAP
                  <router-link to="/login">web portal</router-link> with their email and
                  password that they previously created for ShippingTAP and the app.
                </div>
                <div class="break"></div>
      
                <div class="md-title">How do I search for loads in the web portal?</div>
                <div class="md-body-1">
                  In the Search tab, you can search by pickup location, pickup date, pickup
                  radius, delivery location, delivery radius, and trailer type. The pickup
                  location is the only required field.
                </div>
                <div class="break"></div>
      
                <div class="md-title">How do I save loads in the web portal?</div>
                <div class="md-body-1">
                  In the Saved Lanes tab, you can search by pickup location, pickup radius, pick
                  up availability, delivery location, delivery radius, and trailer type. The
                  pickup location and radius are the only required fields. You can also save
                  searches from the Search tab by clicking “Save this lane” under the Search
                  button. Saved lanes appear on the left side of the Saved Lanes tab.
                </div>
                <div class="break"></div>
      
                <div class="md-title">How do I see the status of a load?</div>
                <div class="md-body-1">
                  In the My Loads tab, you can see the status of each load on the load details
                  page. For dispatchers with the app in fleet mode, push notifications will also
                  be sent via the mobile app with updates on your drivers’ activity.
                </div>
                <div class="break"></div>
      
                <div class="md-title">Can documents be uploaded via the web portal?</div>
                <div class="md-body-1">
                  No. Documents, such as PODs, need to be uploaded via the Shippingtab Freight
                  app. Please make sure drivers have the app downloaded and set up in order to
                  do so.
                </div>
                <div class="break"></div>
      
                <div class="md-title">After a load is booked, how do I assign a driver?</div>
                <div class="md-body-1">
                  You can assign a driver after a load is booked. You have the option to assign
                  a driver after booking and before pick up, or at the time of booking. When a
                  load is booked with an assigned driver, these loads will show up on the app
                  and web portal in as active in “My Loads” and show as assigned.
                </div>
                <div class="break"></div>
      
                <div class="md-title">What happens if I don’t assign a driver?</div>
                <div class="md-body-1">
                  If a load is booked without an assigned driver, these loads will not appear as
                  booked in “My Loads” in the app and will be shown as unassigned. Dispatchers
                  will be notified via email up to three times—24 hours before pickup, 14 hours
                  before pickup, and 4 hours before pickup—to assign a driver. To assign a
                  driver later, go to the “My Loads” tab, click booked loads, then click “Assign
                  Driver” next to the load.
                </div>
                <div class="break"></div>
      
                <div class="md-title">Do my drivers have to use the app?</div>
                <div class="md-body-1">
                  In order to see status updates for active loads on the web portal and app,
                  your drivers will need to use the app during the duration of the load. To
                  qualify for accessorial rates of loads booked on the ShippingTAP app or web
                  portal, the app must be running continuously throughout the load (with GPS
                  location data being provided), all accessorial requests and receipts must be
                  submitted within 24 hours of delivery and supported by a signed BOL with “in”
                  and “out” times, and the POD must be uploaded in the ShippingTAP app.
                </div>
                <div class="break"></div>
      
                <div class="md-title">
                  How long does a driver have to respond to assigned loads?
                </div>
                <div class="md-body-1">
                  If a driver is assigned a load, the driver has 30 minutes to reject the load
                  in the app before it is automatically accepted.
                </div>
                <div class="break"></div>
      
                <div class="md-title">How can I bounce a load?</div>
                <div class="md-body-1">
                  If a driver is not assigned on the load, the dispatcher must call ShippingTAP
                  support to bounce from a load. If a driver is assigned on the load, they can
                  bounce off the load via in-app support on the app by tapping the phone icon in
                  the top right corner.
                </div>
                <div class="break"></div>
      
                <div class="md-title">How do I add drivers from my fleet?</div>
                <div class="md-body-1">
                  In the Fleet Management tab, click “Add Member” and enter the driver’s
                  information. We will email the driver and ask them to verify the account.
                  After the driver’s account is verified via email confirmation, they will have
                  access to ShippingTAP loads. They will have access to loads on the ShippingTAP
                  platform.
                </div>
                <div class="break"></div>
      
                <div class="md-title">How do I remove drivers from my fleet?</div>
                <div class="md-body-1">
                  In the Fleet Management tab, click the 3 dots to the right of the driver’s
                  name, then click “Remove driver.”
                </div>
                <div class="break"></div>
      
                <div class="md-title">
                  How do I change booking or rate visibility permissions for my drivers?
                </div>
                <div class="md-body-1">
                  In the Fleet Management tab, click the 3 dots to the right of the driver’s
                  name, then click “Edit details.” You can then toggle their permissions.
                  Booking permission is only allowed for drivers who also have permission to see
                  rates.
                </div>
                <div class="break"></div>

                '
            ],
            [
                'title' => 'Carrier payment and accessorials guide',
                'body' => '
                <div class="md-title">How does ShippingTAP pay?</div>
                <div class="md-body-1">
                  ShippingTAP pays carriers with direct deposit. You can set your preference
                  before booking your first load with ShippingTAP.
                </div>
                <div class="break"></div>
      
                <div class="md-title">When is payment made?</div>
                <div class="md-body-1">
                  We pay carriers within 7 days after successfully submitting an acceptable
                  proof of delivery and load invoice at freight-invoice-eu@Shippingtab.com.
                </div>
                <div class="break"></div>
      
                <div class="md-title">How do I view the payment status on a load in-app?</div>
                <div class="md-body-1">
                  The “See payment” button will appear in the load details page as soon as you
                  begin a load. Tap the button to view payment details for that load, and if
                  there are any documents needed before payment can be sent. Drivers without
                  permission to view rates will only see document statuses.
                </div>
                <div class="break"></div>
      
                <div class="md-title">
                  What happens after my required documents are submitted?
                </div>
                <div class="md-body-1">
                  Once your documents are received, our team will review them and either approve
                  or deny each document. If a document is rejected (too blurry, missing
                  information, etc.), you may be asked to provide additional information.
                  <div class="break"></div>
                  Once all required documents are approved, we will send the payment the
                  following Monday. Depending on the bank used, it may take 1-4 days to appear
                  on your account.
                </div>
                <div class="break"></div>
      
                <div class="md-title">What does ShippingTAP pay for detention?</div>
                <div class="md-body-1">
                  Below are our accessorial rates for loads in Europe (EUR). All accessorial
                  currencies paid out will match the currency of the linehaul agreement.
      
                  <div class="break"></div>
                  <b>Accessorial - Carrier Payment (1)</b>
                  <ul>
                    <li>Detention for Technology booked Loads (2) - €35 per hour (3)</li>
                    <li>Detention for Broker booked Loads - €30 per hour</li>
                    <li>Layover for Technology booked Loads - €280 per 24 hours</li>
                    <li>Layover for Broker booked Loads - €240 per 24 hours</li>
                  </ul>
                  (1) Rates will be determined by the currency of the linehaul on the rate
                  confirmation. Eligibility is subject to verification. The accessorial rates
                  may be changed for future loads at ShippingTAP’s discretion. Carriers will be
                  notified in the event of changes.
                  <div class="break"></div>
                  (2) For Technology rates to apply, you must meet the following conditions:
                </div>
                <div class="break"></div>
      
                <div class="md-title">Technology booked load</div>
                <div class="md-body-1">
                  Book the load on the ShippingTAP App or ShippingTAP Web Portal
                </div>
                <div class="break"></div>
      
                <div class="md-title">Tracking information provided</div>
                <div class="md-body-1">
                  <ul>
                    <li>
                      Assign a driver to the load at least 2 hours prior to pickup or provide
                      driver full name and license plate info at least 2 hours prior to pickup
                      to tracking-eu@Shippingtab.com
                    </li>
                    <li>
                      The ShippingTAP App, must be running continuously throughout the load with
                      GPS location data being provided starting 2 hours prior to pickup until
                      load is delivered or you must share live tracking updates via your
                      ELD/​telematics provider with our partner supply chain visibility
                      platforms starting 2 hours prior to pickup until load is delivered. If one
                      or more of the above conditions are not met, broker rates apply.
                    </li>
                  </ul>
                  (3) The hours eligible for detention payment start at 2 hours after the
                  scheduled appointment time and end at 10 hours after the scheduled appointment
                  time (for a maximum of 8 hours of paid detention).
                </div>
                <div class="break"></div>
      
                <div class="md-title">
                  What are the requirements for detention compensation?
                </div>
                <div class="md-body-1">
                  1. Arrive on time to the scheduled appointment. <br />
                  2. Ensure the equipment is compliant with all requirements for the load.
                  <br />
                  3. Share location data or notify ShippingTAP at least 30 minutes prior to
                  entering detention. <br />
                  4. Submit in-app requests within 24 hours of delivery and include a signed
                  Proof of delivery with in and out times documented for all completed stops.
                  <br />
                  5. No detention payment applies if the delay is due to the carriers negligence
                  to meet the transport order instruction.
                  <br />
                </div>
                <div class="break"></div>
      
                <div class="md-title">How to request detention?</div>
                <div class="md-body-1">
                  1. Check in when you get onsite and leave location settings to “always on”
                  while ShippingTAP app is open or share live tracking updates via your
                  ELD/telematics provider with our partner supply chain visibility platforms. If
                  you are unable to share location data, you must notify ShippingTAP by phone
                  (+31 20 241 8688) or via email at tracking-eu@Shippingtab.com at least 30
                  minutes prior to entering detention or the request may be denied at our
                  discretion.
                  <br />
                  2. After the load is delivered and within 24 hours, request detention through
                  the ShippingTAP app or at freight-support.Shippingtab.com along with the
                  signed Proof of delivery showing in and out times and a verified signature of
                  stamp from the facility. <br />
                  3. Once your documents are received, our team will review them and either
                  approve or deny each document. If a document is rejected (too blurry, missing
                  information, etc.), you may be asked to provide additional information. <br />
                  4. We will send an updated rate confirmation to the email address that
                  submitted the detention payment request and after you can submit the invoice
                  to freight-invoice-eu@Shippingtab.com.
                  <br />
                </div>
                <div class="break"></div>

                '
            ],
            [
                'title' => 'How to update my expired documents',
                'body' => '
                <div class="md-title">What happens when my documents expire?</div>
                <div class="md-body-1">
                  If the documents expire, they will be deactivated in our system. This means
                  that until we receive the renewed documents, your Shippingtab Freight account
                  will remain inactive.
                </div>
                <div class="break"></div>
      
                <div class="md-title">How can I submit my renewed documents?</div>
                <div class="md-body-1">
                  ShippingTAP keeps track of the expiry dates of your Cargo liability Coverage
                  and Transport Cargo License. We’ll send you an email notification 4 weeks
                  prior to the expiration date of the document in question.
      
                  <div class="break"></div>
                  In order to submit your renewed documents, you should send an email to
                  freight-onboarding-eu@Shippingtab.com with the renewed Cargo liability
                  Coverage or Transport Cargo License attached.
                </div>
                <div class="break"></div>

                '
            ],
            [
                'title' => 'How to contact ShippingTAP',
                'body' => '
                <div class="md-title">Carrier Support</div>
                <div class="md-body-1">
                  <b>Email</b>
                  <ul>
                    <li>For general inquiries: freight-eu@Shippingtab.com</li>
                    <li>For carrier onboarding: freight-onboarding-eu@Shippingtab.com</li>
                    <li>For tracking updates: tracking-eu@Shippingtab.com</li>
                    <li>
                      For invoices and proof of delivery: freight-invoice-eu@Shippingtab.com
                    </li>
                  </ul>
                  <b>Phone</b>
                  <ul>
                    <li>International: +31 20 241 8688</li>
                    The Netherlands
                    <li>Toll free (only for calls within NL): +31 800 420 0027</li>
                    Poland
                    <li>Local: +48 800 088 019</li>
                    Germany
                    <li>Local: +49 800 000 9481</li>
                    France
                    <li>Local: +33 805 080 359</li>
                    Spain
                    <li>Local: +34 900 423 988</li>
                  </ul>
                </div>
                <div class="break"></div>

                '
            ],
            [
                'title' => 'Book your next load',
                'body' => '

                <div class="md-body-1">
                At ShippingTAP, we know that every trucking company runs differently. So, when
                we designed the ShippingTAP app and
                <router-link to="">web portal</router-link> , we listened to what carriers and
                their drivers had to say about the challenges facing them and we continue to
                listen today. The end result was tools that are easy to navigate and designed
                entirely for phone, desktops or laptops, so dispatchers and drivers can
                clearly and conveniently book a load.
                <div class="break"></div>
                Using our products comes at no cost and there are no hidden booking fees. With
                ShippingTAP prices are provided upfront which eliminates haggling and the time
                wasted with back and forth negotiations, allowing drivers to hit the road
                faster.
              </div>
              <div class="break"></div>
    
              <div class="md-title">
                Searching and booking your next load on the web portal
              </div>
              Finding loads on the ShippingTAP web portal couldn’t be simpler. Better still,
              there are 2 ways you can find loads 24/7.
              <div class="break"></div>
              1) To find single loads, click on “Search” in the top menu bar. To find and set
              recurring loads, click on “Saved Lanes” in the top menu bar.
              <div class="break"></div>
              2) Specify your search criteria. Fields that are required are noted with an
              asterisk and click the “Search” button from the “Search” tab or click “Save”
              from the “Saved Lanes” tab and you will be shown a list of available loads that
              meet your specifications.
              <div class="break"></div>
              3) If you see a load you’re interested in, click on it and a new browser tab
              will open with the load details page. You can book the load immediately by
              clicking “Book load”. You will receive a booking confirmation email.
              <div class="break"></div>
              4) When you book a load, you have the option to assign a driver immediately or
              to do so at a later time. Don’t worry, if a load isn’t assigned to a driver,
              you’ll receive multiple notifications 24/12/4 hours before pickup.
              <div class="break"></div>
              <div class="md-title">Click below to watch video tutorials on:</div>
              <div class="md-body-1">
                <router-link to="www.youtube.com"
                  >Searching a load on the ShippingTAP app</router-link
                >
                <router-link to="www.youtube.com"
                  >Booking your next load on the ShippingTAP app</router-link
                >
              </div>
                '
            ],
            [
                'title' => 'Find the right loads',
                'body' => '
                <div class="md-body-1">
                As trucking companies grow, it can become increasingly difficult for
                dispatchers to keep trucks utilized by assigning the right loads to the right
                drivers within their fleets. Deadhead, the industry term for kilometers a
                truck drives with an empty trailer, is one of the most costly problems in
                trucking. Surveys vary on the distance carriers drive without an active load —
                estimates range from a low of 15% to a high of 30%. That translates into tens
                of billions of lost kilometers every year, creating an enormous loss of time
                and fuel.
              </div>
              <div class="break"></div>
    
              <div class="md-title">Searching for the right load</div>
              <div class="md-body-1">
                The ShippingTAP web portal makes it easier for dispatchers to find loads.
                <div class="break"></div>
                1) Click “Search” in the top menu bar.
                <div class="break"></div>
    
                2) Type in your search criteria, which must include the pickup location (city
                comma country) or (country comma zip code) and pick up radius. All other
                fields are optional, including pickup date, pickup radius, delivery location,
                delivery date, delivery radius, trailer type and additional criteria like:
                distance, weight, rate.
                <div class="break"></div>
                3) After you click the “Search” button, you will be shown a list of loads that
                match your specifications. If you don’t find any results from your first
                search, adjust your criteria and try again.
                <div class="brea"></div>
                4) If you see a load you want to learn more about, click it and the load
                details page will open in a new browser tab. You can review key load
                information, including pickup and delivery locations, the carrier rate, trip
                distance, dates and times and weight. You should pay attention to the pick up
                notes for important details about the load as well as facility instruction.
                <div class="break"></div>
                5) If you like what you see, hit “Book load” and it’s yours. It’s important to
                be sure you can make the pick up time specified as these are fixed. After you
                book a load, you will see the “Load booked” display. You then have the option
                to assign a driver or book another load and assign a driver later.
              </div>
              <div class="break"></div>
    
              <div class="md-title">Reload opportunities for current load</div>
              <div class="md-body-1">
                While browsing for a load in the bottom of the desktop/app screen you can see
                available reloads - loads which have a pickup nearby the drop off location of
                the previous load.
              </div>
              <div class="break"></div>
    
              <div class="md-title">
                Reload options for each load directly within the web portal
              </div>
              <div class="md-body-1">
                If you’re an owner-operator, dispatcher, or fleet owner, the Shippingtab
                Freight app and web portal can increase your efficiency and simplify your
                workday.
              </div>
    
              <div class="break"></div>

                '
            ],
            [
                'title' => 'Saved Lanes',
                'body' => '

                <div class="md-body-1">
                Making every hour count can be tough for carriers and their drivers. Finding
                and booking loads that are going in the right direction, at the right time, is
                often time consuming and frustrating. The Saved Lanes tab allows you to save
                your most frequently searched lanes, so that you can save more time when
                booking with ShippingTAP.
              </div>
              <div class="break"></div>
    
              <div class="md-title">Adding a Saved Lane</div>
              <div class="md-body-1">
                1) Login into the web portal.
                <div class="break"></div>
                2) To add a new lane, search for a load as you would on any normal search in
                the “Search tab”.
                <div class="break"></div>
                3) Just below the “Search” button, click on “Save this lane”.
                <div class="break"></div>
                4) A pop up will appear where you can select the days of the week that you
                want to find loads on this lane.
                <div class="break"></div>
                5) Once you click “Done”, this will automatically add it to your saved lanes.
                To create a new lane, click the “+ New” on the top-left side. Enter the pickup
                location and pick up radius and click “Save”.
                <div class="break"></div>
              </div>
    
              <div class="md-title">How Saved Lanes work</div>
              <div class="md-body-1">
                To see all your saved lanes, click “Saved Lanes” on the top menu bar.
                <div class="break"></div>
                Loads are automatically refreshed every two minutes. The number of relevant
                loads will appear in results on the right, with all your preferred lane saved
                searches shown on the left in alphabetical order of source location and
                delivery location.
                <div class="break"></div>
    
                New matches will be indicated with a blue dot. To learn more about a load,
                click on it and a new browser tab will open with all the load details. If you
                want the load, click “Book load.”
                <div class="break"></div>
                We’re always looking for ways to improve our products, and feedback from our
                users is instrumental, so if you have ideas or just want to learn more, get in
                touch today at freight-eu@Shippingtab.com.
                <div class="break"></div>
              </div>
                '
            ],
            [
                'title' => 'Spot the best price',
                'body' => '
                <div class="md-title"></div>
                <div class="md-body-1">
                  Carriers are famous for going their own way, especially when it comes to how
                  they run their businesses. There is one thing, however, all owner-operators or
                  fleets can probably agree on: you won’t make it far in trucking if the rates
                  aren’t right. Here’s how the web portal and app can help carriers make the
                  most out of their load-pricing strategy.
                </div>
                <div class="break"></div>
      
                <div class="md-title">No haggling required</div>
                <div class="md-body-1">
                  Inspired by our carriers, ShippingTAP believes there’s too much time wasted in
                  the traditional booking process of calling a brokerage. The concept of
                  electronically booking freight, if the price is fair, brings a cost effective
                  perspective to booking loads.
                  <div class="break"></div>
                  The web portal and app equips carriers, dispatchers and drivers with the tools
                  they need to easily visualize and accelerate their workflow. For example,
                  dispatchers can view and book loads, assign them to available drivers, and
                  manage them from end-to-end, all via their web browser. Additionally,
                  dispatchers can list their trucks’ availability, and ideal loads will be
                  recommended to them and available to book directly within the web portal.
                </div>
                <div class="break"></div>
      
                <div class="md-title">Plan ahead</div>
                <div class="md-body-1">
                  Downtime can also be a major problem for carriers. Scouring job boards while
                  sitting idle often pressures a carrier to find a load fast, and rushing can
                  mean overlooking better opportunities. This stressful situation can be
                  minimized or avoided entirely by planning ahead.
                  <div class="break"></div>
                  With ShippingTAP, carriers can better plan ahead. For example, whenever a new
                  load is booked available reloads are automatically shown. Additionally,
                  carriers can post their truck on the app to see future loads that match their
                  preferences.
                </div>
      
                <div class="md-title">It’s all in the (load) details</div>
                <div class="md-body-1">
                  Deadhead in comparison to load length is also a major component that carriers
                  look for. Load weight and topography can improve fuel economy, and thereby
                  increase their rate per kilometre, significantly— which are the sort of
                  details carrier are able to find in the ShippingTAP app or web portal.
                  <div class="break"></div>
                  Whether it’s load weight, location, or time of delivery, the powerful search
                  feature helps carriers find the exact load they are looking for to maximize
                  their business.
                </div>
                <div class="break"></div>
      
                <div class="md-title">Load details directly within the web portal</div>
                <div class="md-body-1">
                  Our goal at ShippingTAP is to create a transparent and efficient freight
                  ecosystem, with intuitive tools for carriers of all sizes.
                  <div class="break"></div>
                  Are you an ShippingTAP user? Send us your questions, comments, and suggestions
                  at freight-eu@Shippingtab.com.
                </div>
                <div class="break"></div>
                '
            ],
            [
                'title' => 'Tracking and Location data-sharing',
                'body' => '
                <div class="md-body-1">
                To best partner with ShippingTAP, we expect carriers to provide timely
                tracking status updates throughout the lifecycle of each load via one or more
                automated data sources. There are four ways in which you can integrate with
                ShippingTAP to ensure efficient tracking.
              </div>
              <div class="break"></div>
              <div class="md-title">ShippingTAP App Overview</div>
              <div class="md-body-1">
                There are 3 ways to provide location updates through the Shippingtab Freight
                app:
                <ul>
                  <li>
                    Keep the app open throughout the lifecycle of the load to provide
                    automatic location updates
                  </li>
                  <li>
                    When prompted, tap the in-app confirmations that you have moved to the
                    next stage of the load
                  </li>
                  <li>Submit a live status update through in-app support.</li>
                </ul>
              </div>
              <div class="break"></div>
              <div class="md-title">ShippingTAP App Requirements</div>
              <div class="md-body-1">
                <ul>
                  <li>
                    Download the app, sign in, and set Location Services to “Always Allow”.
                  </li>
                  <li>
                    Keep the app turned on throughout the load so that it can register
                    location updates.
                  </li>
                  <li>
                    Provide the following 5 status updates in a timely manner: Dispatched 3+
                    hours before Pickup, Arrived at Pickup, Departed Pickup, Arrived at Drop
                    Off, Delivered.
                  </li>
                </ul>
              </div>
              <div class="break"></div>
              <div class="md-title">Third-party data aggregator overview</div>
              <div class="md-body-1">
                <ul>
                  <li>
                    Third-party aggregators automatically give load location updates while you
                    are completing a load with ShippingTAP.
                  </li>
                  <li>
                    Currently ShippingTAP is partnered with Project44 to provide load status
                    updates.
                  </li>
                </ul>
              </div>
              <div class="break"></div>
              <div class="md-title">Third-party data aggregator requirements</div>
              <div class="md-body-1">
                <ul>
                  <li>Sign up and onboard with Project44 here.</li>
                  <li>Agree to share data with ShippingTAP through P44.</li>
                  <li>Provide an accurate truck and trailer number on every load.</li>
                </ul>
              </div>
              <div class="md-title">Live Status Update Overview</div>
              <div class="md-body-1">
                <ul>
                  <li>Provide ShippingTAP Status updates through the web portal.</li>
                </ul>
              </div>
              <div class="break"></div>
              <div class="md-title">Live Status Update Requirements</div>
              <div class="md-body-1">
                <ul>
                  <li>Log in to your ShippingTAP web portal.</li>
                  <li>
                    Click on Contact Support, then select the relevant load for a tracking
                    update.
                  </li>
                  <li>Select ‘Provide a Live Status Update’.</li>
                  <li>Provide ShippingTAP with the current status of the load.</li>
                </ul>
              </div>

                '
            ],
            [
                'title' => 'Location data-sharing',
                'body' => '
                <div class="md-title">What data does ShippingTAP collect?</div>
                <div class="md-body-1">ShippingTAP collects GPS location data.</div>
                <div class="break"></div>
      
                <div class="md-title">Why does ShippingTAP collect this data?</div>
                <div class="md-body-1">
                  ShippingTAP uses the GPS location data to improve the services provided to
                  carriers and shippers, including:
                  <ul>
                    <li>
                      Reducing or eliminating location-request calls to dispatchers and/or
                      drivers on loads in progress.
                    </li>
                    <li>Tracking loads booked via the ShippingTAP platform.</li>
                  </ul>
                  These initiatives make carriers more efficient while transporting loads booked
                  via ShippingTAP. In the future, this data may be used for automatic processing
                  of detention and other carrier accessorials.
                </div>
                <div class="break"></div>
                <div class="md-title">Does ShippingTAP share this data with anyone?</div>
                <div class="md-body-1">
                  ShippingTAP may share this location data with the shipper and/or receiver of a
                  load to keep them informed of the location of their freight while in transit.
                  <div class="break"></div>
                  In addition, ShippingTAP may share this data with other third parties who
                  require, request, or use such data in connection with transportation,
                  logistics, delivery, and/or other related services arranged or performed by
                  ShippingTAP. For more information, please see the ShippingTAP Privacy Notice.
                </div>
                <div class="break"></div>
      
                <div class="md-title">How long does ShippingTAP store my data?</div>
                <div class="md-body-1">
                  ShippingTAP stores location data that can be tied to a specific carrier for
                  three years. After three years, ShippingTAP destroys the location data.
                </div>
                <div class="break"></div>
      
                <div class="md-title">
                  What happens if a carrier chooses not to share automatic tracking data?
                </div>
                <div class="md-body-1">
                  The dispatcher and/or driver will receive at least 5 tracking calls or emails
                  per load.
                </div>
                <div class="break"></div>
      
                <div class="md-title">
                  Does ShippingTAP reimburse for data usage, such as a phone plan?
                </div>
                <div class="md-body-1">No, ShippingTAP will not reimburse for data usage.</div>
                <div class="break"></div>
      
                <div class="md-title">
                  We have our own way to track our drivers, so why do you need to track them
                  constantly?
                </div>
                <div class="md-body-1">
                  ShippingTAP’s goal is to help our shippers and carriers become more efficient.
                  When GPS data is shared, ShippingTAP is able to reduce tracking calls and
                  improve efficiency and safety for carriers.
                </div>
                <div class="break"></div>

                '
            ],
            [
                'title' => 'Tracking FAQ',
                'body' => '
                <div class="md-title">
                What are the benefits of using an automated tracking source and sharing my
                data?
              </div>
              <div class="md-body-1">
                Using an automated tracking source should result in fewer tracking calls and
                emails. In the future, other benefits may be added for providing automated
                tracking updates.
              </div>
              <div class="break"></div>
    
              <div class="md-title">
                When should I expect to provide tracking updates to ShippingTAP?
              </div>
              <div class="md-body-1">
                ShippingTAP expects timely and accurate tracking updates so we can provide the
                best information possible to our customers.
                <ul>
                  <li>
                    When booking a load, provide as much detail as possible about the load:
                    truck and trailer number, driver name, driver number.
                  </li>
                  <li>
                    At least 3 hours prior to the PU all driver and truck information must be
                    provided: truck and trailer number, driver name, driver number.
                  </li>
                  <li>
                    At least within 1 hour of arriving to the pickup, please provide a status
                    update.
                  </li>
                  <li>
                    At least within 1 hour of departing the pickup, please provide a status
                    update.
                  </li>
                  <li>
                    At least within 2 hours of arriving to the delivery, please provide a
                    status update with an ETA.
                  </li>
                  <li>
                    At least within 2 hours of departing the the delivery, please provide a
                    status update with a POD.
                  </li>
                </ul>
              </div>
              <div class="break"></div>
    
              <div class="md-title">
                What are the best practices for using the ShippingTAP app?
              </div>
              <div class="md-body-1">
                <ul>
                  <li>Only log in to one device at a time.</li>
                  <li>Do not kill or swipe away from the ShippingTAP app.</li>
                  <li>
                    Dispatch yourself in-app by swiping the “Heading to Pickup” notification
                    that appears 3 hours before the designated pickup time or dispatch
                    yourself through in-app support.
                  </li>
                  <li>
                    Re-open the app at critical points in the load (such as dispatch, pickup,
                    dropoff, after a break and engage with all in-app notifications.
                  </li>
                  <li>
                    Charge your phone continuously during the trip (avoid low battery mode)
                    and keep the ShippingTAP app open in the foreground with the screen on
                    where possible.
                  </li>
                </ul>
              </div>
              <div class="break"></div>
    
              <div class="md-title">How can I limit tracking calls?</div>
              <div class="md-body-1">
                We recommend setting up with one or more automatic tracking options—the
                ShippingTAP app or Project44. While there may still be instances where we will
                need to call or email depending on the load, having location updates can help
                reduce the frequency of calls or emails.
              </div>
              <div class="break"></div>
    
              <div class="md-title">
                Will I still get calls and emails when I’m integrated with an automated
                tracking source?
              </div>
              <div class="md-body-1">
                When automated tracking is working properly, we do not expect to call drivers
                or dispatchers to obtain tracking updates.
                <div class="break"></div>
                However, if real-time location data is not transmitting properly or if there
                are non-tracking reasons that we need to contact you regarding a load,
                ShippingTAP may still call to confirm necessary load details or inquire about
                other matters.
              </div>
              <div class="break"></div>
    
              <div class="md-title">Can I use more than one of the tracking methods?</div>
              <div class="md-body-1">
                Absolutely. Using multiple methods increases the likelihood of real-time
                location updates being received.
              </div>
              <div class="break"></div>
    
              <div class="md-title">
                What is ShippingTAP’s preferred method of location sharing?
              </div>
              <div class="md-body-1">
                Our preference is for you to share your location through the Shippingtab
                Freight app or through Project44. These methods are updated in real time and
                allow you to communicate with us when needed throughout the load (e.g., the
                app allows you to confirm dispatch prior to pickup).
              </div>
              <div class="break"></div>
    
              <div class="md-title">Do I need to provide a truck and trailer number?</div>
              <div class="md-body-1">
                In order for ShippingTAP to match your device to a load and successfully
                receive location updates, we need to verify the truck and trailer number. This
                is mandatory across all EU loads with Shippingtab Freight.
              </div>
              <div class="break"></div>
    
              <div class="md-title">How can I provide truck and trailer information?</div>
              <div class="md-body-1">
                Please send all truck and trailer number information to
                tracking-eu@Shippingtab.com. In the future, you will be able to provide this
                information through the ShippingTAP app or web portal.
              </div>
              <div class="break"></div>
    
              <div class="md-title">
                When does ShippingTAP need to receive truck and trailer information?
              </div>
              <div class="md-body-1">
                Truck and trailer information should be provided to ShippingTAP at least 3
                hours before pick up. If possible, please provide truck and trailer
                information at the time each load is booked.
              </div>
              <div class="break"></div>

                '
            ]
        ];

        CarrierFaq::insert($cities);
    }
}

