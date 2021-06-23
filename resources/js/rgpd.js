
tarteaucitron.init({
    "privacyUrl": "/mentions-legales", /* Privacy policy url */

    "hashtag": "#tarteaucitron", /* Open the panel with this hashtag */
    "cookieName": "tarteaucitronPasrel", /* Cookie name */

    "orientation": "bottom", /* Banner position (top - bottom) */

    "showAlertSmall": true, /* Show the small banner on bottom right */
    "cookieslist": true, /* Show the cookie list */

    "showIcon": true, /* Show cookie icon to manage cookies */
    "iconPosition": "BottomRight", /* Position of the icon between BottomRight, BottomLeft, TopRight and TopLeft */

    "adblocker": true, /* Show a Warning if an adblocker is detected */

    "DenyAllCta": true, /* Show the deny all button */
    "AcceptAllCta": true, /* Show the accept all button when highPrivacy on */
    "highPrivacy": true, /* HIGHLY RECOMMANDED Disable auto consent */

    "handleBrowserDNTRequest": false, /* If Do Not Track == 1, disallow all */

    "removeCredit": false, /* Remove credit link */
    "moreInfoLink": true, /* Show more info link */
    "useExternalCss": false, /* If false, the tarteaucitron.css file will be loaded */

    //"cookieDomain": ".my-multisite-domaine.fr", /* Shared cookie for subdomain website */

    "readmoreLink": "/mentions-legales", /* Change the default readmore link pointing to tarteaucitron.io */

    "mandatory": true /* Show a message about mandatory cookies */
});
// Service personnalisé
tarteaucitron.services.mycustomservice = {
    "key": "mycustomservice",
    "type": "ads|analytic|api|comment|other|social|support|video",
    "name": "MyCustomService",
    "needConsent": true,
    "cookies": ['cookie', 'cookie2'],
    "readmoreLink": "/custom_read_more", // If you want to change readmore link
    "js": function () {
        "use strict";
        // When user allow cookie
    },
    "fallback": function () {
        "use strict";
        // when use deny cookie
    }
};
// google analytics
tarteaucitron.services.analytics = {
    "key": "analytics",
    "type": "analytic",
    "name": "Google Analytics (universal)",
    "uri": "https://policies.google.com/privacy",
    "needConsent": true,
    "cookies": (function () {
        var googleIdentifier = tarteaucitron.user.analyticsUa,
            tagUaCookie = '_gat_gtag_' + googleIdentifier,
            tagGCookie = '_ga_' + googleIdentifier;

        tagUaCookie = tagUaCookie.replace(/-/g, '_');
        tagGCookie = tagGCookie.replace(/G-/g, '');

        return ['_ga', '_gat', '_gid', '__utma', '__utmb', '__utmc', '__utmt', '__utmz', tagUaCookie, tagGCookie];
    })(),
    "js": function () {
        "use strict";
        window.GoogleAnalyticsObject = 'ga';
        window.ga = window.ga || function () {
            window.ga.q = window.ga.q || [];
            window.ga.q.push(arguments);
        };
        window.ga.l = new Date();
        tarteaucitron.addScript('https://www.google-analytics.com/analytics.js', '', function () {
            var uaCreate = {'cookieExpires': 34128000};
            tarteaucitron.extend(uaCreate, tarteaucitron.user.analyticsUaCreate || {});
            ga('create', tarteaucitron.user.analyticsUa, uaCreate);

            if (tarteaucitron.user.analyticsAnonymizeIp) {
                ga('set', 'anonymizeIp', true);
            }

            if (typeof tarteaucitron.user.analyticsPrepare === 'function') {
                tarteaucitron.user.analyticsPrepare();
            }

            if (tarteaucitron.user.analyticsPageView) {
                ga('send', 'pageview', tarteaucitron.user.analyticsPageView);
            } else {
                ga('send', 'pageview');
            }

            if (typeof tarteaucitron.user.analyticsMore === 'function') {
                tarteaucitron.user.analyticsMore();
            }
        });
    }
};


// google analytics
tarteaucitron.services.gtag = {
    "key": "gtag",
    "type": "analytic",
    "name": "Google Analytics (gtag.js)",
    "uri": "https://policies.google.com/privacy",
    "needConsent": true,
    "cookies": (function () {
        var googleIdentifier = tarteaucitron.user.gtagUa,
            tagUaCookie = '_gat_gtag_' + googleIdentifier,
            tagGCookie = '_ga_' + googleIdentifier;

        tagUaCookie = tagUaCookie.replace(/-/g, '_');
        tagGCookie = tagGCookie.replace(/G-/g, '');

        return ['_ga', '_gat', '_gid', '__utma', '__utmb', '__utmc', '__utmt', '__utmz', tagUaCookie, tagGCookie];
    })(),
    "js": function () {
        "use strict";
        window.dataLayer = window.dataLayer || [];
        tarteaucitron.addScript('https://www.googletagmanager.com/gtag/js?id=' + tarteaucitron.user.gtagUa, '', function () {
            window.gtag = function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', tarteaucitron.user.gtagUa);

            if (typeof tarteaucitron.user.gtagMore === 'function') {
                tarteaucitron.user.gtagMore();
            }
        });
    }
};
