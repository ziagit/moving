<?php

use App\About;
use Illuminate\Database\Seeder;

class AboutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        About::truncate();
        $data =  [
                'title' => 'About Us',
                'body' => '
                <div>
                <div class="md-display-1">Shipping TAP Mission</div>
                <div class="md-body-1">
                  Shipping TAB was founded to create a better way for people and businesses to
                  ship freight as well as moving their household. There were countless
                  carriers to choose from, but there was no way to compare them side by side.
                  That meant you had to either spend hours online or on the phone, comparing
                  rates and carriers, or just book with one carrier and hope you chose the
                  best possible option.
                  <div class="break"></div>
                  We were the first to solve this dilemma by developing our own patented
                  technology. It disrupted the freight industry and forever changed how people
                  and businesses ship freight.
                  <div class="break"></div>
                  Today, we’ve quoted thousands of shipments, delivering to virtually every
                  corner of Canada.
                  <div class="break"></div>
                  We can serve multitudes of customers and still maintain the highest
                  standards of service because we’ve committed, from the start, to integrating
                  technology and powerful data analytics into everything we do. From the
                  backend that gathers and organizes quotes to the self-service online tools
                  that give you all the information you need to manage freight like a pro, our
                  business is designed to serve yours.
                </div>
              </div>
              <br />
              <div>
                <div class="md-display-1">Services that we Provide</div>
                <div class="md-body-1">
                  <div class="md-title">Freight Transport</div>
                  Are you a business shipping goods within Canada ?
                  <div class="break"></div>
                  Don’t fret! Using our shipping service, you can ship your freight to various
                  locations around the country and provide a cost-effective, flexible shipping
                  option to your clients.
                  <div class="break"></div>
                  Whether you are a conglomerate or a mom and pop store, our service may be
                  the best option for you. With this shipping your freight can be secured and
                  safely transported using pallets or skids. Pallet shipping increases the
                  efficiency and safety of handling and moving your cargo.
                  <div class="break"></div>
                  Benefits:
                  <ul>
                    <li>Quick and regular daily service</li>
                    <li>Cost-effective transportation option</li>
                    <li>Negotiations based on National Motor Freight Classification</li>
                    <li>Negotiated pricing based on total volume</li>
                    <li>Customized online tools for you to manage your freight</li>
                  </ul>
                </div>
                <div class="md-body-1">
                  <div class="md-title">Household Moving</div>
                  Do you need help moving your things to your new home?
                  <div class="break"></div>
                  With the Shipping TAP, we even load, unload and take care of the transport
                  and permits.
                  <div class="break"></div>
                  <b>Why you should choose a moving company?</b><br />
                  <ul>
                    <li>
                      Professionals offer packaging materials and packing services, which
                      ensures that all your belongings are safely loaded to a truck, shipped,
                      and offloaded from the truck.
                    </li>
                    <li>
                      Hiring a professional will also save you time. Since the moving company
                      is going to do everything for you from packing to loading to shipping to
                      offloading, you will have time to do other things and settle in your new
                      home.
                    </li>
                    <li>
                      Hiring professionals may also help you save money, this may sound
                      unlikely, but the truth is that your lack of experience in the job can
                      lead to damages that can cost you a lot if you choose DIY. Professionals
                      have the necessary skills to ensure that damages that are associated
                      with moving are minimized.
                    </li>
                  </ul>
                  <b>Why choose us over other Household movers?</b><br />
                  Moving can be a stressful task, full of its fair share of unwelcomed
                  surprises, but what should not come as a surprise to you is the total amount
                  you see on your moving invoice once your move is completed. Before you
                  choose us as your moving company, one of our highly skilled Shipping TAP
                  Personal Relocation Consultants will provide you with an affordable moving
                  quote via our Shipping TAP Advantage service. Based on your moving needs,
                  the quote given will cover the cost of your household relocation, as well as
                  the services we will supply to complete your move.
                  <div class="break"></div>
                  At Shipping TAP, we want to provide you with as many moving resources as we
                  can. We want to take the stress out of the moving process, and replace it
                  with quality service you can count on. Our Packing Options give you the
                  opportunity and flexibility to decide how much you would like to participate
                  with your move, and we offer a comprehensive list of packing options and
                  services that will help you plan and prepare with ease.
                  <div class="break"></div>
                  <b>Packing Options</b><br />
                  <ul>
                    <li>
                      <b>Full Service Packing</b> - Using the latest industry packing methods
                      and moving materials, our experts will pack your entire home in detail.
                      At Shipping TAP, we treat your belongings as our own, and you can relax
                      knowing your move is in the hands of qualified interstate moving
                      specialists.
                    </li>
                    <li>
                      <b>Fragile Packing</b> - For items that are delicate, breakable or
                      irreplaceable in value, we encourage you to let us know so that we can
                      pack them with the utmost care. At Shipping TAP, we treat your
                      belongings as our own, and you can relax knowing your move is in the
                      hands of qualified moving specialists.
                    </li>
                    <li>
                      <b>Do It Yourself Packing</b> - If you prefer to pack all of your
                      belongings yourself, we can assist with supplying all of the moving
                      boxes and packaging material you will need to help make your move
                      convenient and easy.
                    </li>
                  </ul>
                  <b>Basic Household Moving Services</b><br />
                  <b>Loading</b> - Prior to loading your furniture and belongings, Shipping
                  TAP takes the time to make sure that each item is properly packed, listed
                  for inventory and labeled for moving. For upholstered furniture, we use a
                  durable, plastic Stretchwrap to guard against potential damage from dirt and
                  scratches. For other items, we use special packing to protect against
                  shifting. Once prepped, your personal contents are systematically loaded
                  onto our moving trucks where they will be transported to their new location.
                  <br />
                  <b>Transportation</b> - Safety is a top-priority for Shipping TAP and each
                  of our moving trailers contains suspension systems with airride protection.
                  Our drivers are all licensed and certified with quality training, and are
                  committed to making sure your belongings are transported in a professional
                  way. Whether it is a local, state to state or long distance move, we have
                  you covered.
                  <br />
                  <b>Unloading</b> - After delivery, we take inventory during the unloading
                  process to ensure that each item is accounted for. With your guidance and
                  instruction, our trained movers will carefully place all of your boxes and
                  furniture into each room, and we will provide re-assembly services as
                  requested.
                </div>
              </div>
              <br />
              <div>
                <div class="md-display-1">Our Team</div>
                <div class="md-body-1">
                  Technology alone can’t solve every problem. That’s why we also have highly
                  trained shipping experts who are ready to answer any question, at any time –
                  this experienced team is the primary reason we are able to maintain our A+
                  rating year after year.
                  <div class="break"></div>
                  So whether you’re an experienced or novice shipper, we have the tools and
                  experts to help you plan and execute complex or simple shipping solutions.
                  The service our technology and people make possible gained the attentions
                  globally.
                  <br />
                </div>
              </div>

            '
        ];

        About::insert($data);

    }
}
