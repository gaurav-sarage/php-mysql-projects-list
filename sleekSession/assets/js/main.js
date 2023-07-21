'use strict';


// buttons
let callBtn = $('#callBtn');

let peerConnection;
let sendTo = callBtn.data('user');
let localStream;

// variables for video elements 

const localVideo = document.querySelector("#localVideo");
const remoteVideo = document.querySelector("#remoteVideo");


function getConnection() {
    if(!peerConnection) {
        peerConnection = new RTCPeerConnection();
    }
}