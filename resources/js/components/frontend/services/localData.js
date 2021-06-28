export default {
    save(name, data){
        return sessionStorage.setItem(name, JSON.stringify(data));
    },
    read(name){
        return JSON.parse(sessionStorage.getItem(name));
    },
    remove(name){
        return sessionStorage.removeItem(name);
    },
    removeAll(){
        sessionStorage.removeItem('vehicle');
        sessionStorage.removeItem('office-size');
        sessionStorage.removeItem('from-state');
        sessionStorage.removeItem('to-state');
        sessionStorage.removeItem('to');
        sessionStorage.removeItem('supplies');
        sessionStorage.removeItem('moving-items');
        sessionStorage.removeItem('floors');
        sessionStorage.removeItem('moving-contacts');
        sessionStorage.removeItem('number-of-movers');
        sessionStorage.removeItem('moving-date');
        sessionStorage.removeItem('cr');
        sessionStorage.removeItem('from');
        sessionStorage.removeItem('moving-size');
        sessionStorage.removeItem('moving-type');
        sessionStorage.removeItem('id');
        sessionStorage.removeItem('shipper');
        sessionStorage.removeItem('carrier');
        sessionStorage.removeItem('distance');
        sessionStorage.removeItem('duration');
        sessionStorage.removeItem('contacts');
        sessionStorage.removeItem('phone');
        sessionStorage.removeItem('me');
        sessionStorage.removeItem('editable_id');
        sessionStorage.removeItem('carrier_id');
      return ;
    }
}