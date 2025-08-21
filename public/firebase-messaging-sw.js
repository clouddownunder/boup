importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js');
firebase.initializeApp({
    apiKey: "AIzaSyBFvgULlBbACKRhOcPxTSHDbyQDL_MLPjQ",
    projectId: "reading-km-s",
    messagingSenderId: "790948095546",
    appId: "1:790948095546:web:e03c70412c7719c7493703",
});

const messaging = firebase.messaging();
self.addEventListener('install', function (event) {
    // Ensure the service worker is activated immediately after installation
    self.skipWaiting();
});

self.addEventListener('activate', function (event) {
    // Ensure the service worker takes control of all open clients
    self.clients.claim();
});

messaging.setBackgroundMessageHandler(function ({ data: { title, body, icon, url } }) {
    return self.registration.showNotification(title, { body, icon, data: { url: url } });
});
self.addEventListener('notificationclick', function(event) {
    event.notification.close();
    event.waitUntil(
      clients.openWindow(event.notification.data.url)
    );
});