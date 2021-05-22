<template>
<div class="shipment-details">
    <div class="card-container">

        <md-card mode="ios" color="light">
            <md-card-header>
                <h3 class="md-title">Shipment details</h3>
            </md-card-header>
            <md-card-content v-if="dataLoaded">
                <div>
                    <p>
                        Dear {{shipment.order_detail.shipper.first_name}},
                        <br />your freight
                        <span>{{shipment.jobstatus.title}}</span>
                    </p>
                    <p>You will be collecting your freight at bellow address</p>

                    <p> {{shipment.order_detail.full_address[1].country.name}},
                        {{shipment.order_detail.full_address[1].state}},<br>
                        {{shipment.order_detail.full_address[1].city}},
                        {{shipment.order_detail.full_address[1].zip}},
                        {{shipment.order_detail.full_address[1].address}}
                    </p>

                    <div>
                        <div class="carrier-contacts">
                            <label>Carrier contacts</label>
                            <md-switch class="md-primary" v-model="carrierTogal"></md-switch>
                        </div>
                        <div v-show="carrierTogal">
                            <div v-if="carrier != null">
                                <p>{{carrier.last_name}} <br>
                                    {{carrier.contact.phone}} <br>
                                    {{carrier.contact.email}}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </md-card-content>
        </md-card>
    </div>

    <Footer />
</div>
</template>

<script>
import Footer from '../../shared/Footer';
import axios from "axios";
export default {
    name: "ShipmentDetails",
    data: () => ({
        dataLoaded: false,
        shipment: null,
        carrier: null,
        carrierExist: false,
        carrierTogal: false,
    }),
    watch: {
        carrierTogal(data) {
            if (data) {
                this.getCarrier()
            }
        }
    },
    methods: {
        get() {
            axios
                .get("shipment-details/" + this.$route.params.id)
                .then((res) => {
                    this.shipment = res.data;
                    this.dataLoaded = true;
                    console.log("res: ", this.shipment);
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        getCarrier() {
            if (this.carrier == null) {
                axios
                    .get("carrier-contacts/" + this.shipment.carrier_id)
                    .then((res) => {
                        this.carrierExist = true;
                        this.carrier = res.data;
                        console.log(res.data);
                    })
                    .catch((err) => {
                        console.log(err);
                    });
            }
        },
    },
    created() {
        this.get();
    },
    components: {
        Footer,
    }
};
</script>

<style lang="scss" scoped>
.shipment-details {
    .card-container {
        padding-top: 30px;
        min-height: calc(100vh - 67px);

        .md-card {
            text-align: left;
            background: #fff !important;
            max-width: 600px;
            margin: auto;

            span {
                color: green;
            }

            .carrier-contacts {
                display: flex;
                align-items: center;
            }
        }

        .md-primary {
            color: red;
        }
    }
}

@media only screen and (max-width: 600px) {
    .card-container {
        padding: 30px;
    }
}
</style>
