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

$('#callBtn').on('click', () => {
    getCam();
})