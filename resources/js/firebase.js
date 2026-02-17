import { initializeApp } from "firebase/app";
import { getMessaging, getToken, onMessage } from "firebase/messaging";

const firebaseConfig = {
    apiKey: "AIzaSyC1Z4f-D7pUub8S0vt44AE3rTZvAhH0Olc",
    authDomain: "job-loker.firebaseapp.com",
    projectId: "job-loker",
    messagingSenderId: "639905587657",
    appId: "1:639905587657:web:2d1889db1d870bfdfbc818",
};

const app = initializeApp(firebaseConfig);
const messaging = getMessaging(app);
if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('/firebase-messaging-sw.js')
        .then(() => {
            console.log('SW registered');
        })
        .catch(err => console.error('SW error', err));
}

Notification.requestPermission().then(permission => {
    if (permission === 'granted') {
        getToken(messaging, {
            vapidKey: 'BBI9cYlTTS_TH1f1yLbCmkAvdXEBzx-jjcUIiZJh5m3UUOyXNQfEE26HFKrMXxF_qb0giY-8ZVBL-QUL7Xcr3Og'
        }).then(token => {
            console.log('FCM Token:', token);

            fetch('/save-fcm-token', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ token })
            });
        });
    }
});
