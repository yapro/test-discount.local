var dateFormatter = {
    getDateByTimestamp: function (timestamp) {
        var d = new Date;
        d.setTime(timestamp);
        var month = d.getMonth() + 1;
        if (month < 10) {
            month = "0" + month;
        }
        var day = d.getDate();
        if (day < 10) {
            day = "0" + day;
        }
        return d.getFullYear() + "-" + month + "-" + day;
    }
};
module.exports = dateFormatter;