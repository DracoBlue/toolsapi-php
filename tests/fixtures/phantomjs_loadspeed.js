var page = require('webpage').create(),
    system = require('system'),
    t, address;

if (system.args.length === 1) {
    console.log('Usage: loadspeed.js <some URL>');
    phantom.exit();
}

//page.onResourceRequested = function (q) {
//    console.log('requested: ' + q.url + ' at ' + q.time.getTime());
////    console.log('requested: ' + JSON.stringify(req, undefined, 4));
//};

//page.onResourceReceived = function (q) {
////    console.log('received: ' + JSON.stringify(res, undefined, 4));
//    console.log('received: ' + q.url + ' at ' + q.time.getTime());
//};

t = Date.now();
address = system.args[1];
page.open(address, function (status) {
    if (status !== 'success') {
        console.log(false);
    } else {
        t = Date.now() - t;
        console.log('{"time": ' + t + '}');
    }
    page.render(system.args[2] + '/output.png');
    phantom.exit();
});
