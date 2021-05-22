<?php

use App\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Faq::truncate();
        $data =  [
                'title' => 'Shipper FAQ',
                'body' => '
                <div class="md-display-1">3 Steps to Place Your Order</div>
                <div class="md-body-1">
                  1. Specify your source, destination and list your items.
                  <div class="break"></div>
                  2. Select a carrier from the available list
                  <div class="break"></div>
                  3. Track your order wherevery goes.
                  <br /><br />
                  Modernizing logistics systems offers the promise of greater efficiency and
                  profitability for shippers and carriers, but how does that translate to an
                  individual load?
                  <div class="break"></div>
                  From tendering to pickup, delivery to documentation, ShippingTAP is streamlining
                  shipping operations every step of the way.
                  <div class="break"></div>
                  In ShippingTAP platform, shippers have more control and capacity at their
                  fingertips to maximize results across their supply chains. And with increased
                  visibility, they can see upfront pricing on rates up to 2 weeks in advance and
                  monitor loads in real-time.
                  <div class="break"></div>
                  Carriers benefit as well. The easy-to-use ShippingTAP app features loads available
                  across the country—24 hours a day, 7 days a week. Additionally, using ShippingTAP
                  creates a smoother work experience by reducing tracking calls and simplifying the
                  documentation process.
                  <div class="break"></div>
                  No matter which side of the marketplace you work on, ShippingTAP can help carriers
                  and shippers see better results. To see how we can help, sign up here.
                </div>
                '
        ];

        Faq::insert($data);
    }
}
