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
        return order;
    },
    editOrder(order) {
        var d = new Date(order.pickup_date);
        localData.save("from", order.addresses[0]);
        localData.save("to", order.addresses[1]);
        localData.save("moving-type", order.movingtype);
        localData.save("moving-size", order.movingsize);
        localData.save("vehicle", order.vehicle);
        localData.save("number-of-movers", order.movernumber);
        localData.save("floors", {
            pickup: order.floor_from,
            destination: order.floor_to
        });
        localData.save("moving-date", {
            date: {
                date: d.getDate(),
                day: this.getDaysName(d.getDay()),
                month: d.getMonth() + 1,
                year: d.getFullYear()
            },
            time: {
                from: parseInt(order.appointment_time.substring(0, 2), 10),
                to: parseInt(order.appointment_time.slice(-2), 10)
            }
        });
        localData.save("instructions", order.instructions);
        this.editSupplies(order.supplies);

        //localData.save("contacts", );
        //localData.read("moving-items");
        return order;
    },
    editSupplies(sups) {
        var enabled = [];
        var number = [];
        axios
            .get("moving-supplies")
            .then(res => {
                var supplies = res.data;
                for (let i = 0; i < supplies.length; i++) {
                    var flag = false;
                    for (let j = 0; j < sups.length; j++) {
                        if (supplies[i].code == sups[j].code) {
                            enabled[i] = sups[j].name;
                            number[i] = sups[j].pivot.number;
                            flag = true;
                        }
                    }
                    if (!flag) {
                        enabled[i] = null;
                        number[i] = null;
                    }
                }

                localData.save("supplies", {
                    enabled: enabled,
                    number: number
                });
            })
            .catch(err => {
                console.log("Error: ", err);
            });
    },
    buildDate() {
        let d = localData.read("moving-date");
        return (
            d.date.year +
            "-" +
            (d.date.month < 10 ? "0" + d.date.month : d.date.month) +
            "-" +
            (d.date.date < 10 ? "0" + d.date.date : d.date.date)
        );
    },
    buildTime() {
        let t = localData.read("moving-date");
        return (
            (t.time.from < 10 ? "0" + t.time.from : t.time.from) +
            "-" +
            (t.time.to < 10 ? "0" + t.time.to : t.time.to)
        );
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
    },

    getDaysName(num) {
        switch (num) {
            case 0:
                return "Sun";
            case 1:
                return "Mon";
            case 2:
                return "Tue";
            case 3:
                return "Wed";
            case 4:
                return "Thu";
            case 5:
                return "Fri";
            case 6:
                return "Sat";
        }
    }
};
