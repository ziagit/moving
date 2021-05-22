import axios from "axios";
import localData from "./localData";
export default {
    async checkPayment() {
        let billing = localData.read("bl");
        if (billing.status && billing.id != null) {
            const response = await axios.get("check-payment/" + billing.id);
            return response.data;
        }
        return false;
    }
};
