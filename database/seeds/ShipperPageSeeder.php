<?php

use App\ShipperPage;
use Illuminate\Database\Seeder;

class ShipperPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ShipperPage::truncate();
        $data = [
            'title'=>'Shipper',
            'body'=>'
            <div>
            <div class="md-display-1">Important info about your quote</div>
            <div class="md-body-1">
              1. All freight rates quoted on ShippingTAP platform are provided according
              to the description of goods and declared by the shipper and may be subject
              to additional charges in the case of misdeclaration.
              <div class="break"></div>
              2. If your load needs special handling, please select it for an accurate
              quote. Carriers charge for special handling if needed, and this will affect
              your final rate and invoice.
              <div class="break"></div>
              3. The pickup date and transit time vary by the carrier and are not
              guaranteed unless otherwise stated. Transit time starts with the first
              business day after pickup and doesn’t include the day of pickup, weekends or
              holidays.
              <div class="break"></div>
              4. Be mindful of the truck waiting time. Rates quoted include up to 30
              minutes loading and offloading and 1 hour loading and 1 hour offloading
              unless otherwise specified. There will be additional charges for delays in
              loading, waiting at facilities for loading or offloading and other
              unforeseen delays.
              <div class="break"></div>
              5. By using this site, you agree to be bound by Terms of Use.
              <router-link to="terms-and-conditions"
                >Please review the terms here</router-link
              >.
            </div>
          </div>
          <br />
          <div>
            <div class="md-display-1">How Does ShippingTAP Works?</div>
            <div class="md-body-1">
              ShippingTAP is like the Expedia of shipping freight. Just type in your
              origin and destination, dates and quantity you’re shipping. Instantly see
              all available trucks and rates. You book the deal you want! <br />
              <ul>
                <li>
                  <router-link to="/order">Get a Free Instant Quote</router-link>
                </li>
                <li>
                  <router-link to="/terms-and-conditions"
                    >Read our Terms and Conditions</router-link
                  >
                </li>
                <li>
                  <router-link to="/privacy-policy">Read Privacy Policy</router-link>
                </li>
                <li>
                  <router-link to="/help">Visit our Help Center</router-link>
                </li>
                <li><router-link to="/register">Signup now</router-link></li>
              </ul>
            </div>
            <router-link to="faq">See Shipper FAQ</router-link>
          </div>
          <br />
          <div>
            <div class="md-title">Start a New Quote</div>
            <div class="break"></div>
            <md-button class="custom-button">Get Quote</md-button>
          </div>
            '
        ];
        ShipperPage::insert($data);
    }
}
