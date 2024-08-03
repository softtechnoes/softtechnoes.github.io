import { DateTime } from 'luxon';
import store from '../store';
export default {
    /**
     * Translate the given key.
     */
     Lang_get(key, replace) {
        let translation, translationNotFound = true

        try {
            translation = key.split('.').reduce((t, i) => t[i] || null, window._translations[window._locale].php)

            if (translation) {
                translationNotFound = false
            }
        } catch (e) {
            translation = key
        }

        if (translationNotFound) {
            translation = window._translations[window._locale]['json'][key]
                ? window._translations[window._locale]['json'][key]
                : key
        }

        _forEach(replace, (value, key) => {
            translation = translation.replace(':' + key, value)
        })
        return translation
    },

    // to get authenticated user data
    authUser() {
        return axios.get('/api/auth/user').then(response => response.data).then(response => {
            return response;
        }).catch(error => {
            
        });
    },

    // to check for authenticated user
    check() {
        return axios.post('/api/auth/check').then(response => {
            console.log('response inside helper', response)
            store.dispatch('currentUser/setConfig', response.data.config);
            if (response.data.authenticated) {
                if(response.data.user.is_activated) {
                    store.dispatch('currentUser/setAuthStatus', response.data.authenticated);
                    store.dispatch('currentUser/setAuthUserDetail', response.data.user);
                    // store.dispatch('setPermission', response.permissions);
                    // store.dispatch('setDefaultRole', response.default_role);
                }else{
                    store.dispatch('currentUser/resetAuthUserDetail');
                }
                // this.setLastActivity(); // TODO Last activity management
            } else {
                store.dispatch('currentUser/resetAuthUserDetail');
            }

            return response.data.authenticated;
        }).catch(error => {
            console.log(error)
            store.dispatch('currentUser/resetAuthUserDetail');
            // store.dispatch('currentUser/resetConfig');
        });
    },

    setLastActivity() {
        if (!this.isScreenLocked())
            store.dispatch('setLastActivity')
    },

    // to check for last activity time and lock/unlock screen
    isScreenLocked() {
        let last_activity = this.getLastActivity();
        let lock_screen_timeout = this.getConfig('lock_screen_timeout');
        let last_activity_after_timeout = prototype(last_activity).add(lock_screen_timeout, 'minutes').format('LLL');
        return (prototype().format('LLL') > last_activity_after_timeout);
    },

    // to append filter variables in the URL
    getFilterURL(data) {
        let url = '';
        $.each(data, function(key, value) {
            url += (value) ? '&' + key + '=' + encodeURI(value) : '';
        });
        return url;
    },

    // getLastActivity() {
    //     return store.getters.getLastActivity;
    // },

    // // to get Auth Status
    isAuth() {
        return store.getters['currentUser/getAuthStatus'];
    },

    // to get Auth user detail // TODO Update
    getAuthUser(name) {
        if (name === 'full_name')
            return store.getters.getAuthUser('first_name') + ' ' + store.getters.getAuthUser('last_name');
        else if (name === 'avatar') {
            if (store.getters.getAuthUser('avatar'))
                return '/' + store.getters.getAuthUser('avatar');
            else
                return '/images/avatar.png';
        } else
            return store.getters.getAuthUser(name);
    },

    // to get User avatar // TODO Update
    getAvatar(user) {
        if (user && user.profile.avatar)
            return '/' + user.profile.avatar;
        else
            return '/images/avatar.png';
    },

    // to get config
    getConfig(config) {
        return store.getters.getConfig(config);
    },

    // to get default role name of system
    getDefaultRole(role) {
        return store.getters.getDefaultRole(role);
    },

    // to check role of authenticated user
    hasRole(role) {
        return store.getters.hasRole(this.getDefaultRole(role));
    },

    // to check permission for authenticated user
    hasPermission(permission) {
        return store.getters.hasPermission(permission);
    },

    // to check feature is available or not
    featureAvailable(feature) {
        return this.getConfig(feature);
    },

    // returns not accessible message if permission is denied
    notAccessibleMsg() {
        toastr.error(i18n.permission.permission_denied);
    },

    // returns feature not available message if permission is denied
    featureNotAvailableMsg() {
        toastr.error(i18n.general.feature_not_available);
    },

    // returns user status
    getUserStatus(user) {
        let status = [];

        if (user.status === 'activated')
            status.push({ 'color': 'success', 'label': i18n.user.status_activated });
        else if (user.status === 'pending_activation')
            status.push({ 'color': 'warning', 'label': i18n.user.status_pending_activation });
        else if (user.status === 'pending_approval')
            status.push({ 'color': 'warning', 'label': i18n.user.status_pending_approval });
        else if (user.status === 'banned')
            status.push({ 'color': 'danger', 'label': i18n.user.status_banned });
        else if (user.status === 'disapproved')
            status.push({ 'color': 'danger', 'label': i18n.user.status_disapproved });

        return status;
    },

    // to mass assign one object in another object
    formAssign(form, data) {
        for (let key of Object.keys(form)) {
            if (key !== "originalData" && key !== "errors" && key !== "autoReset" && key !== "providers") {
                form[key] = data[key] || '';
            }
        }
        return form;
    },

    // to get date in desired format
    formatDate(date) {
        if (!date)
            return;

        return prototype(date).format(this.getConfig('date_format'));
    },

    // to get date time in desired format
    formatDateTime(date) {
        if (!date)
            return;

        var date_format = this.getConfig('date_format');
        var time_format = this.getConfig('time_format');

        return moment(date).format(date_format + ' ' + time_format);
    },

    // to change first character of every word to upper case
    ucword(value) {
        if (!value)
            return;

        return value.toLowerCase().replace(/\b[a-z]/g, function(value) {
            return value.toUpperCase();
        });
    },

    // to change string into human readable format
    toWord(value) {
        if (!value)
            return;

        value = value.replace(/-/g, ' ');
        value = value.replace(/_/g, ' ');

        return value.toLowerCase().replace(/\b[a-z]/g, function(value) {
            return value.toUpperCase();
        });
    },

    // returns error message for axios request
    fetchDataErrorMsg(error) {
        return error.response.data.errors.message[0];
    },

    // returns error message for axios form request
    fetchErrorMsg(error) {
        return error.errors.message[0];
    },

    // round numbers as given precision
    roundNumber(number, precision) {
        precision = Math.abs(parseInt(precision)) || 0;
        var multiplier = Math.pow(10, precision);
        return (Math.round(number * multiplier) / multiplier);
    },

    // round numbers as given precision
    formatNumber(number, decimal_place) {
        if (decimal_place === undefined)
            decimal_place = 2;
        return this.roundNumber(number, decimal_place);
    },

    // fill number with padding
    formatWithPadding(n, width, z) {
        z = z || '0';
        n = n + '';
        return n.length >= width ? n : new Array(width - n.length + 1).join(z) + n;
    },

    // generates random string of certain length
    randomString(length) {
        if (length === undefined)
            length = 40;
        var chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        var result = '';
        for (var i = length; i > 0; --i) result += chars[Math.floor(Math.random() * chars.length)];
        return result;
    },
}