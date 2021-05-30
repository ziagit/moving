import localData from "./localData";
export default {
    async buildOrder() {
        let order = {};
        order["from"] = await localData.read("from");
        order["to"] = await localData.read("to");
        order["moving_size"] = await localData.read("moving-size");
        order["vehicle"] = await localData.read("vehicle");
        order["number_of_movers"] = await localData.read("number-of-movers");
        order["floors"] = await localData.read("floors");
        order["moving_date"] = await localData.read("moving-date");
        order["instructions"] = await localData.read("instructions");
        order["contacts"] = await localData.read("contacts");
        order["items"] = await localData.read("moving-items");
        order["moving_type"] = await localData.read("moving-type");
        order["distance"] = await localData.read("distance");
        order["duration"] = await localData.read("duration");
        order["supplies"] = this.buildSupplies();
        order["carrier"] = await localData.read("carrier");
        order["shipper"] = await localData.read("shipper");

        return order;
    },
    buildDate() {
        let d = localData.read("moving-date");
        return d.date.year + "-" + (d.date.month<10?"0"+d.date.month:d.date.month) + "-" + (d.date.date<10?"0"+d.date.date:d.date.date);
    },
    buildTime() {
        let t = localData.read("moving-date");
        return (t.time.from<10?'0'+t.time.from:t.time.from) + "-" + (t.time.to<10?'0'+t.time.to:t.time.to);
    },
    buildSupplies() {
        let supplies = localData.read("supplies");
        var sups = [];
        if (supplies) {
            for (let i = 0; i < supplies.enabled.length; i++) {
                let obj = {
                    name: "",
                    code: "",
                    number: ""
                };
                if (supplies.enabled[i] != null) {
                    obj.name = supplies.enabled[i];
                    obj.code = supplies.enabled[i]
                        .toLowerCase()
                        .replace(/\s/g, "");
                    obj.number = supplies.number[i];
                    sups.push(obj);
                }
            }
            return sups;
        }
    }
}