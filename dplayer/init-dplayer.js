var len = dPlayerOptions.length;
for(var i=0;i<len;i++){
    dPlayers[i] = new DPlayer({
        element: document.getElementById('player' + dPlayerOptions[i]['id']),
            autoplay: dPlayerOptions[i]['autoplay'],
            video: dPlayerOptions[i]['video'],
            theme: dPlayerOptions[i]['theme'],
            danmaku: dPlayerOptions[i]['danmaku'],
    });
}

