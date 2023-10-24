importScripts('https://www.gstatic.com/firebasejs/9.22.0/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/9.22.0/firebase-messaging-compat.js');

self.onnotificationclick = (event) => {
    console.log("On notification click: ", event.notification.tag);
    event.notification.close();

    // This looks to see if the current is already open and
    // focuses if it is
    event.waitUntil(
        clients
            .matchAll({
                type: "window",
            })
            .then((clientList) => {
                for (const client of clientList) {
                    if (client.url === "/" && "focus" in client) return client.focus();
                }
                if (clients.openWindow) return clients.openWindow("/notifications");
            })
    );
};

firebase.initializeApp({
    apiKey: '{{ env("VITE_FIREBASE_API_KEY") }}',
    authDomain: '{{ env("VITE_FIREBASE_AUTH_DOMAIN") }}',
    databaseURL: '{{ env("VITE_FIREBASE_DATABASE_URL") }}',
    projectId: '{{ env("VITE_FIREBASE_PROJECT_ID") }}',
    storageBucket: '{{ env("VITE_FIREBASE_STORAGE_BUCKET") }}',
    messagingSenderId: '{{ env("VITE_FIREBASE_MESSAGING_SENDER_ID") }}',
    appId: '{{ env("VITE_FIREBASE_APP_ID") }}'
});

const messaging = firebase.messaging();
