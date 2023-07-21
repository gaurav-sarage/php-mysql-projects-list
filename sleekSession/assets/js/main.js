'use strict';


// buttons
let callBtn = $('#callBtn');

let pc;
let sendTo = callBtn.data('user');
let localStream;

// variables for video elements 

const localVideo = document.querySelector("#localVideo");
const remoteVideo = document.querySelector("#remoteVideo");

const mediaConst = {
    video:true
};

// function to receive info from other client

const options = {
    offerToReceiveVideo: 1,
}

function getConnection() {
    if(!pc) {
        pc = new RTCPeerConnection();
    }
}

// function to ask for media input from user

async function getCam() {
    let mediaStream;

    try {
        if(!pc) {
            await getConnection();
        }

        mediaStream = await navigator.mediaDevices.getUserMedia(mediaConst);

        localVideo.srcObject = mediaStream;

        localStream = mediaStream;

        localStream.getTracks().forEach(track => pc.addTrack(track, localStream));

    } catch(error) {
        console.log(error);
    }
}

async function createOffer(sendTo) {
    await sendIceCandidate(sendTo);
    await pc.createOffer(options);
    await pc.setLocalDescription(pc.localDescription);
    send('client-offer', pc.localDescription, sendTo);
}

function sendIceCandidate(sendTo) {
    pc.onicecandidate = e => {
        if (e.candidate !== null) {
            // send ice candidate to other client
            send('client-candidate', e.candidate, sendTo);
        }
    }
}



$('#callBtn').on('click', () => {
    getCam();
    send('is-client-ready', null, sendTo);
});

conn.onopen = e => {
    console.log('connected to websocket');
}

conn.onmessage = async e => {
    let message = JSON.parse(e.data);
    let by = message.by;
    let data = message.data;
    let type = message.type;
    let profileImage = message.profileImage;
    let username = message.username;

    switch(type) {
        case 'is-client-ready':
            if(!pc) {
                await getConnection();
            }
            if (pc.iceConnectionState === "connected") {
                send('client-already-oncall');
            }
            else {
                // display call
                alert('user is calling!');
            }
        break;

        case 'client-already-oncall':
            // display popup

            setTimeout('window.location.reload(true)', 2000);
        break;
    }


}

function send(type, data, sendTo) {
    conn.send(JSON.stringify({
        sendTo:sendTo,
        type:type,
        data:data
    }));
}