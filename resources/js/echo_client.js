// Setting up Echo client and io
import Echo from 'laravel-echo';
window.io = require('socket.io-client'); 
let app_env = process.env.MIX_APP_ENV;
let app_url = window.location.hostname; // Use in production
if(app_env == 'local'){
    app_url = window.location.hostname + ':6001'
}
window.Echo = new Echo({
    broadcaster: 'socket.io',
    host: app_url, // This will work on localhost or production
    // host: window.location.hostname + ':6001', // Use + ':6001' on local
    //host: window.location.hostname, // Use in production
    reconnectionAttempts: 60,
    auth: {
        headers: {
            Accept: 'application/json'
            /** I'm using access tokens to access  **/
            // Authorization: "Bearer " + Cookies.get('access_token')
        }
    },
});
// This code is for checking connection and deconnection of Socket
window.Echo.connector.socket.on('connect_error', (error) => {
    // Forcing disconnect when not able to connect
    window.Echo.connector.socket.disconnect();
});
// When socket connected
window.Echo.connector.socket.on('connect', function () {
    console.log('Socket is connected with the following id: ' + window.Echo.socketId());
});
// When socket disconnected
window.Echo.connector.socket.on('disconnect', function () {
    console.log('Socket is now disconnected');
});
