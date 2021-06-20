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
        $data = [
            'title'=>'Movers Contract Agreement',
            'body'=>'
            <div>
            <div class="md-display-1">Access thousands of shipments a day.</div>
            <div class="md-body-1">
              We understand service to our customers is only as good as our network of
              contract carriers. We value our carriers and have invested in technology to
              best support their needs. Our proprietary technology, developed and managed,
              matches your equipment with our available customer loads. You tell us where
              your trucks are, and we’ll match you with our opportunities. Whether you’re
              looking for a load to get home or consistent freight to fill daily and
              weekly runs, our network has access to thousands of available loads to keep
              you busy and profitable.
              <br /><br />
              <div class="md-title">
                There are benefits when you’re a contract carrier for Shipping TAP
              </div>
              <ul>
                <li>Get access to our loads</li>
                <li>
                  Receive fast payments or choose QuickPay to get your money even sooner
                </li>
                <li>Find freight with a free mobile app</li>
                <li>Strengthen your efficiencies with a Carrier AdvantageTM Program</li>
                <li>Build a relationship with your single point of contact</li>
                <li>Keep your business moving with technology created for carriers</li>
              </ul>
              <md-button class="custom-button">Create Account</md-button>
            </div>
          </div>
            '
        ];
        Legal::insert($data);
    }
}
