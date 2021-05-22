window.Vue = require("vue");
import VueRouter from "vue-router";
import Home from "./components/frontend/Home";
import Register from "./components/frontend/auth/Register";
import Login from "./components/frontend/auth/Login";
import ResetPassword from "./components/frontend/auth/ResetPassword";
import ForgotPassword from "./components/frontend/auth/ForgotPassword";
import Welcome from "./components/frontend/auth/Welcome";

import Card from "./components/frontend/card/Card";

import CarrierDashboard from "./components/frontend/carrier/Dashboard";
import HomeContent from "./components/frontend/pages/HomeContent";
import Help from "./components/frontend/pages/Help";
import CityList from "./components/frontend/pages/Cities";
import AboutUs from "./components/frontend/pages/AboutUs";
import ContactUs from "./components/frontend/pages/ContactUs";
import Privacy from "./components/frontend/pages/Privacy";
import Terms from "./components/frontend/pages/Terms";
import OurCarriers from "./components/frontend/pages/OurCarriers";
import OurShippers from "./components/frontend/pages/OurShippers";
import Rating from "./components/frontend/pages/review/Rating";
import CarrierReviews from "./components/frontend/pages/review/CarrierReviews";

import CarrierProfile from "./components/frontend/carrier/CarrierProfile";
import CarrierDetails from "./components/frontend/carrier/general-details/CarrierDetails";
import CarrierDetailsContainer from "./components/frontend/carrier/general-details/CarrierDetailsContainer";
import EditCarrierDetails from "./components/frontend/carrier/general-details/EditCarrierDetails";
import AddCarrierDetails from "./components/frontend/carrier/general-details/AddCarrierDetails";

import CarrierRates from "./components/frontend/carrier/rate/CarrierRates";
import RateContainer from "./components/frontend/carrier/rate/RateContainer";
import AddRate from "./components/frontend/carrier/rate/AddRate";
import EditRate from "./components/frontend/carrier/rate/EditRate";
import History from "./components/frontend/carrier/history/History";
import Jobs from "./components/frontend/carrier/history/Jobs";
import JobDetails from "./components/frontend/carrier/history/JobDetails";
import CarrierAccountContainer from "./components/frontend/carrier/account-details/CarrierAccountContainer";
import CarrierAccount from "./components/frontend/carrier/account-details/CarrierAccount";
import EditCarrierAccount from "./components/frontend/carrier/account-details/EditCarrierAccount";
import EarningContainer from "./components/frontend/carrier/earnings/EarningContainer";
import Earnings from "./components/frontend/carrier/earnings/Earnings";
import EarningDetails from "./components/frontend/carrier/earnings/EarningDetails";
import CarrierCalendar from "./components/frontend/carrier/calendar/Calendar";
import CarrierPaymentContainer from "./components/frontend/carrier/payments/Container";
import CarrierPayments from "./components/frontend/carrier/payments/Payments";
import CarrierAddPayment from "./components/frontend/carrier/payments/Add";
import CarrierEditPayment from "./components/frontend/carrier/payments/Edit";

import Order from "./components/frontend/order/Order";

import ShipmentDetails from "./components/frontend/order/ShipmentDetails";
//import MovingFrom from './components/frontend/order/MovingFrom'
import VehicleSizes from "./components/frontend/order/VehicleSizes";
import MovingSizes from "./components/frontend/order/MovingSizes";
import OfficeSizes from "./components/frontend/order/OfficeSizes";
import MovingTypes from "./components/frontend/order/MovingTypes";
import Floors from "./components/frontend/order/Floors";
import NumberOfMover from "./components/frontend/order/NumberOfMover";
import MovingSupplies from "./components/frontend/order/MovingSupplies";
//import MovingTo from './components/frontend/order/MovingTo'
import MovingDate from "./components/frontend/order/MovingDate";
import FewItems from "./components/frontend/order/FewItems";
import Movers from "./components/frontend/order/Movers";
import MovingPayment from './components/frontend/order/MovingPayment'
import CardDetails from "./components/frontend/card/Card";
import MovingConfirmation from "./components/frontend/order/MovingConfirmation";
import MovingCompletion from "./components/frontend/order/MovingCompletion";

import ShipperProfile from "./components/frontend/shipper/ShipperProfile";
import ShipperDetailsContainer from "./components/frontend/shipper/general-details/ShipperDetailsContainer";
import ShipperDetails from "./components/frontend/shipper/general-details/ShipperDetails";
import AddShipperDetails from "./components/frontend/shipper/general-details/AddShipperDetails";
import EditShipperDetails from "./components/frontend/shipper/general-details/EditShipperDetails";
import ShipperAccountContainer from "./components/frontend/shipper/account-details/ShipperAccountContainer";
import ShipperAccount from "./components/frontend/shipper/account-details/ShipperAccount";
import EditShipperAccount from "./components/frontend/shipper/account-details/EditShipperAccount";
import ShipperOrderContainer from "./components/frontend/shipper/orders/ShipperOrderContainer";
import ShipperOrders from "./components/frontend/shipper/orders/ShipperOrders";
import ShipperOrderDetails from "./components/frontend/shipper/orders/ShipperOrderDetails";
import ShipperCard from "./components/frontend/shipper/card-details/ShipperCard";
import Expences from "./components/frontend/shipper/expences/Expences";

//backend
import Admin from "./components/backend/Admin";
import Dashboard from "./components/backend/Dashboard";
import Comapany from "./components/backend/company/Company";
import Countries from "./components/backend/lookups/countries/Countries";
import Cities from "./components/backend/lookups/cities/Cities";
import States from "./components/backend/lookups/states/States";

import Locationtype from "./components/backend/lookups/location-type/Locationtype";
import Movernumber from "./components/backend/lookups/mover-number/Movernumber";
import Movingsize from "./components/backend/lookups/moving-size/Movingsize";
import MovingFewItems from "./components/backend/lookups/moving-few-items/MovingFewItems";
import Movingtype from "./components/backend/lookups/moving-type/Movingtype";
import Officesize from "./components/backend/lookups/office-size/Officesize";
import Supply from "./components/backend/lookups/supply/Supply";
import Vehicle from "./components/backend/lookups/vehicle/Vehicle";
import Constans from "./components/backend/lookups/constans/Constans";

import CarrierList from "./components/backend/carrier/CarrierList";
import CarrierDetailsAdmin from "./components/backend/carrier/Edit";
import CarriersAccount from "./components/backend/carrier/accounts/Accounts";
import CustomerAddresses from "./components/backend/addresses/Addresses";
import CustomerContacts from "./components/backend/contacts/Contacts";
import Rates from "./components/backend/carrier/rates/Rates";
import AdminJobs from "./components/backend/carrier/jobs/Jobs";
import AdminJobDetails from "./components/backend/carrier/jobs/Details";
import Orders from "./components/backend/shippers/orders/Orders";
import AdminOrderDetails from "./components/backend/shippers/orders/Details";
import Shippers from "./components/backend/shippers/Shippers";
import ShippersAccount from "./components/backend/shippers/accounts/Accounts";
import Users from "./components/backend/users/Users";

import AdminEarnings from "./components/backend/finances/Earnings";
import AdminEarningDetails from "./components/backend/finances/EarningDetails";
import AdminInvoices from "./components/backend/finances/Invoices";

import About from "./components/backend/company/about/About";
import Contact from "./components/backend/company/contact/Contact";
import TermsAdmin from "./components/backend/company/terms/Terms";
import PrivacyAdmin from "./components/backend/company/privacy/Privacy";
import HelpCenterAdmin from "./components/backend/company/help/Help";
import CarrierInfoAdmin from "./components/backend/company/carrier/Carrier";
import ShipperInfoAdmin from "./components/backend/company/shipper/Shipper";
import CarrierFaqAdmin from "./components/backend/company/carrier-faq/FAQ";
import ShipperFaqAdmin from "./components/backend/company/shipper-faq/FAQ";

import store from "./store";

import Test from "./components/Test";

function webGuard(to, from, next) {
    if (!store.getters["auth/authenticated"]) {
        next("/login");
    } else {
        next();
    }
}

Vue.use(VueRouter);
export default new VueRouter({
    mode: "history",
    hash: false,
    routes: [
        {
            path: "/",
            component: Home,
            children: [
                { path: "", redirect: "home" },
                { name: "home", path: "home", component: HomeContent },
                { name: "about", path: "about", component: AboutUs },
                { name: "contact", path: "contact", component: ContactUs },
                { name: "help", path: "help", component: Help },
                { name: "cities", path: "cities", component: CityList },
                { name: "login", path: "login", component: Login },
                { name: "register", path: "register", component: Register },
                {
                    path: "/reset-password/:token",
                    component: ResetPassword
                },
                {
                    name: "forget-password",
                    path: "/forgot-password",
                    component: ForgotPassword
                },
                { name: "welcome", path: "welcome", component: Welcome },
                { name: "checkout", path: "checkout", component: Card },
                {
                    name: "shipment-details",
                    path: "shipment-details/:id",
                    component: ShipmentDetails
                },
                {
                    name: "privacy",
                    path: "/privacy-policies",
                    component: Privacy
                },
                {
                    name: "terms",
                    path: "/terms-and-conditions",
                    component: Terms
                },
                { name: "carriers", path: "/carriers", component: OurCarriers },
                { name: "shippers", path: "/shippers", component: OurShippers },
                { name: "rating", path: "/rating", component: Rating },
                {
                    name: "order",
                    path: "order",
                    component: Order,
                    children: [
                        { path: "", redirect: "moving-types" },

                        {
                            name: "moving-types",
                            path: "moving-types",
                            component: MovingTypes
                        },
                        {
                            name: "moving-sizes",
                            path: "moving-sizes",
                            component: MovingSizes
                        },
                        {
                            name: "office-sizes",
                            path: "office-sizes",
                            component: OfficeSizes
                        },
                        { name: "floors", path: "floors", component: Floors },
                        {
                            name: "vehicle-sizes",
                            path: "vehicle-sizes",
                            component: VehicleSizes
                        },
                        {
                            name: "number-of-movers",
                            path: "number-of-movers",
                            component: NumberOfMover
                        },
                        {
                            name: "moving-supplies",
                            path: "moving-supplies",
                            component: MovingSupplies
                        },
                        {
                            name: "moving-date",
                            path: "moving-date",
                            component: MovingDate
                        },
                        {
                            name: "few-items",
                            path: "few-items",
                            component: FewItems
                        },
                        { name: "movers", path: "movers", component: Movers },
                        {
                            name: "moving-payment",
                            path: "moving-payment",
                            component: MovingPayment
                        },
                        {
                            name: "card-details",
                            path: "card-details",
                            component: CardDetails
                        }
                    ]
                },
                {
                    name: "confirmation",
                    path: "confirmation",
                    component: MovingConfirmation
                },
                {
                    name: "completion",
                    path: "completion/:id",
                    component: MovingCompletion
                },
                {
                    name: "reviews",
                    path: "reviews/:id",
                    component: CarrierReviews
                },  
                {
                    name: "carrier",
                    path: "carrier",
                    component: CarrierProfile,
                    children: [
                        { path: "", redirect: "dashboard" },
                        {
                            name: "dashboard",
                            path: "dashboard",
                            component: CarrierDashboard
                        },
                        {
                            name: "account",
                            path: "account",
                            component: CarrierAccountContainer,
                            children: [
                                { path: "", redirect: "details" },
                                {
                                    name: "account-details",
                                    path: "details",
                                    component: CarrierAccount
                                },
                                {
                                    name: "edit-account",
                                    path: "edit/:id",
                                    component: EditCarrierAccount
                                }
                            ]
                        },
                        {
                            name: "profile",
                            path: "profile",
                            component: CarrierDetailsContainer,
                            children: [
                                { path: "", redirect: "details" },
                                {
                                    name: "carrier-details",
                                    path: "details",
                                    component: CarrierDetails
                                },
                                {
                                    name: "add-carrier",
                                    path: "add",
                                    component: AddCarrierDetails
                                },
                                {
                                    name: "edit-carrier",
                                    path: "edit/:id",
                                    component: EditCarrierDetails
                                }
                            ]
                        },
                        {
                            name: "rates",
                            path: "rates",
                            component: RateContainer,
                            children: [
                                { path: "", redirect: "list" },
                                {
                                    name: "rate-list",
                                    path: "list",
                                    component: CarrierRates
                                },
                                {
                                    name: "add-rate",
                                    path: "add",
                                    component: AddRate
                                },
                                {
                                    name: "edit-rate",
                                    path: "edit/:id",
                                    component: EditRate
                                }
                            ]
                        },

                        {
                            name: "history",
                            path: "history",
                            component: History,
                            children: [
                                { path: "", redirect: "jobs" },
                                { name: "jobs", path: "jobs", component: Jobs },
                                {
                                    name: "job-details",
                                    path: "details/:id",
                                    component: JobDetails
                                }
                            ]
                        },
                        {
                            name: "earnings",
                            path: "earnings",
                            component: EarningContainer,
                            children: [
                                { path: "", redirect: "list" },
                                {
                                    name: "earning-list",
                                    path: "list",
                                    component: Earnings
                                },
                                {
                                    name: "earning-details",
                                    path: "details/:id",
                                    component: EarningDetails
                                }
                            ]
                        },
                        {
                            name: "payments",
                            path: "payments",
                            component: CarrierPaymentContainer,
                            children: [
                                { path: "", redirect: "details" },
                                {
                                    name: "details",
                                    path: "details",
                                    component: CarrierPayments
                                },
                                {
                                    name: "edit",
                                    path: "edit/:id",
                                    component: CarrierEditPayment
                                },
                                {
                                    name: "add",
                                    path: "add",
                                    component: CarrierAddPayment
                                }
                            ]
                        },
                        {
                            name: "calendar",
                            path: "calendar",
                            component: CarrierCalendar
                        },
                        {
                            name:"payments",
                            path:"payments",
                            component: CarrierPayments
                        }
                    ],
                    beforeEnter: webGuard
                },
                {
                    name: "shipper",
                    path: "shipper",
                    component: ShipperProfile,
                    children: [
                        { path: "", redirect: "account" },
                        {
                            name: "account",
                            path: "account",
                            component: ShipperAccountContainer,
                            children: [
                                { path: "", redirect: "details" },
                                {
                                    name: "account-details",
                                    path: "details",
                                    component: ShipperAccount
                                },
                                {
                                    name: "edit-account",
                                    path: "edit/:id",
                                    component: EditShipperAccount
                                }
                            ]
                        },
                        {
                            name: "profile",
                            path: "profile",
                            component: ShipperDetailsContainer,
                            children: [
                                { path: "", redirect: "details" },
                                {
                                    name: "shipper-details",
                                    path: "details",
                                    component: ShipperDetails
                                },
                                {
                                    name: "add-shipper",
                                    path: "add",
                                    component: AddShipperDetails
                                },
                                {
                                    name: "edit-shipper",
                                    path: "edit/:id",
                                    component: EditShipperDetails
                                }
                            ]
                        },
                        {
                            name: "orders",
                            path: "orders",
                            component: ShipperOrderContainer,
                            children: [
                                { path: "", redirect: "list" },
                                {
                                    name: "order-list",
                                    path: "list",
                                    component: ShipperOrders
                                },
                                {
                                    name: "order-details",
                                    path: "details/:id",
                                    component: ShipperOrderDetails
                                }
                            ]
                        },
                        {
                            name: "card",
                            path: "card",
                            component: ShipperCard
                        },
                        {
                            name: "expences",
                            path: "expences",
                            component: Expences
                        }
                    ],
                    beforeEnter: webGuard
                },
                {
                    name: "admin",
                    path: "admin",
                    component: Admin,
                    children: [
                        { path: "", redirect: "dashboard" },
                        {
                            name: "dashboard",
                            path: "dashboard",
                            component: Dashboard
                        },
                        {
                            name: "company",
                            path: "company",
                            component: Comapany
                        },
                        {
                            name: "counteries",
                            path: "countries",
                            component: Countries
                        },
                        { name: "cities", path: "cities", component: Cities },
                        { name: "states", path: "states", component: States },
                        {
                            name: "location-types",
                            path: "location-types",
                            component: Locationtype
                        },
                        {
                            name: "number-of-movers",
                            path: "number-of-movers",
                            component: Movernumber
                        },
                        {
                            name: "moving-sizes",
                            path: "moving-sizes",
                            component: Movingsize
                        },
                        {
                            name: "moving-few-items",
                            path: "moving-few-items",
                            component: MovingFewItems
                        },
                        {
                            name: "office-sizes",
                            path: "office-sizes",
                            component: Officesize
                        },
                        {
                            name: "moving-types",
                            path: "moving-types",
                            component: Movingtype
                        },
                        { name: "supplies", path: "supplies", component: Supply },
                        {
                            name: "vehicles",
                            path: "vehicles",
                            component: Vehicle
                        },
                        {
                            name: "constans",
                            path: "constans",
                            component: Constans
                        },
                        {
                            name: "carriers-account",
                            path: "carriers-account",
                            component: CarriersAccount
                        },
                        {
                            name: "carriers",
                            path: "carriers",
                            component: CarrierList
                        },
                        {
                            name: "carrier-details",
                            path: "carrier-details/:id",
                            component: CarrierDetailsAdmin
                        },
                       
                        { name: "rates", path: "rates", component: Rates },
                        { name: "jobs", path: "jobs", component: AdminJobs },
                        {
                            name: "job-details",
                            path: "job-details/:id",
                            component: AdminJobDetails
                        },
                        {
                            name: "shippers-account",
                            path: "shippers-account",
                            component: ShippersAccount
                        },
                        {
                            name: "shippers",
                            path: "shippers",
                            component: Shippers
                        },
                        { name: "orders", path: "orders", component: Orders },
                        {
                            name: "order-details",
                            path: "order-details/:id",
                            component: AdminOrderDetails
                        },
                        {
                            name: "addresses",
                            path: "addresses",
                            component: CustomerAddresses
                        },
                        {
                            name: "contacts",
                            path: "contacts",
                            component: CustomerContacts
                        },
                        { name: "users", path: "users", component: Users },
                        { name: "about", path: "about", component: About },
                        {
                            name: "contact",
                            path: "contact",
                            component: Contact
                        },
                        { name: "terms", path: "terms", component: TermsAdmin },
                        {
                            name: "privacy",
                            path: "privacy",
                            component: PrivacyAdmin
                        },
                        {
                            name: "carrier-help",
                            path: "carrier-help",
                            component: CarrierInfoAdmin
                        },
                        {
                            name: "shipper-help",
                            path: "shipper-help",
                            component: ShipperInfoAdmin
                        },
                        {
                            name: "carrier-faq",
                            path: "carrier-faq",
                            component: CarrierFaqAdmin
                        },
                        {
                            name: "shipper-faq",
                            path: "shipper-faq",
                            component: ShipperFaqAdmin
                        },
                        {
                            name: "help",
                            path: "help",
                            component: HelpCenterAdmin
                        },
                        {
                            name: "finances",
                            path: "finances",
                            component: AdminEarnings
                        },
                        {
                            name: "finance-details",
                            path: "finance-details/:id",
                            component: AdminEarningDetails
                        },
                        {
                            name: "invoices",
                            path: "invoices",
                            component: AdminInvoices
                        }
                    ],

                    beforeEnter: webGuard
                }
            ]
        },
        { name: "terms", path: "/terms-and-conditions", component: Terms },
        { path: "*", redirect: "/" }
    ],
    scrollBehavior() {
        window.scrollTo(0, 0);
    }
});
