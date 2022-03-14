// Add your JS customizations here

//smooth scroll
// handle links with @href started with '#' only
jQuery(document).on('click', 'a[href^="#"]', function(e) {
    // target element id
    console.log('click')
    var id = jQuery(this).attr('href');

    // target element
    var $id = jQuery(id);
    if ($id.length === 0) {
        return;
    }

    // prevent standard hash navigation (avoid blinking in IE)
    //e.preventDefault();

    // top position relative to the document
    var pos = ($id.offset().top)-50;

    // animated top scrolling
    jQuery('body, html').animate({scrollTop: pos});
});

if (document.querySelectorAll('.direct-link')){
	let directLinks = document.querySelectorAll('.direct-link')
	console.log(directLinks)
	directLinks.forEach((button) => {
	  button.addEventListener('click', () => {
	    console.log(button.dataset.url);
	    copyTextToClipboard(button.dataset.url);
      button.classList.add('confirm');
       setTimeout(function(){
        button.classList.remove("confirm");
      }, 500);      
	  });
	});
}


//from https://stackoverflow.com/questions/400212/how-do-i-copy-to-the-clipboard-in-javascript
function copyTextToClipboard(text) {
  if (!navigator.clipboard) {
    fallbackCopyTextToClipboard(text);
    return;
  }
  navigator.clipboard.writeText(text).then(function() {
    console.log('Async: Copying to clipboard was successful!');
  }, function(err) {
    console.error('Async: Could not copy text: ', err);
  });
}

function fallbackCopyTextToClipboard(text) {
  var textArea = document.createElement("textarea");
  textArea.value = text;
  
  // Avoid scrolling to bottom
  textArea.style.top = "0";
  textArea.style.left = "0";
  textArea.style.position = "fixed";

  document.body.appendChild(textArea);
  textArea.focus();
  textArea.select();

  try {
    var successful = document.execCommand('copy');
    var msg = successful ? 'successful' : 'unsuccessful';
    console.log('Fallback: Copying text command was ' + msg);
  } catch (err) {
    console.error('Fallback: Oops, unable to copy', err);
  }

  document.body.removeChild(textArea);
}

jQuery('#doc-btn-expand-collapse').click(function(e) {
  console.log('clack')
  jQuery('#navbar-documentation').toggleClass('collapsed');
  let button = document.querySelector('#doc-btn-expand-collapse');
  if(button.innerHTML === 'x'){
      button.innerHTML = '+'
  } else {
      button.innerHTML = 'x'
  }
});

if(document.getElementById('player')){
  const player = document.getElementById('player');
  const videoId = player.dataset.videoid;
   var embedApi;
        function onPanoptoEmbedApiReady()
        {
            embedApi = new EmbedApi("player", {
                width: "750",
                height: "422",
                //This is the URL of your Panopto site
                serverName: "midd.hosted.panopto.com",
                sessionId: videoId,
                videoParams: { 
                    interactivity: "true",
                    showtitle: "false",
                    offerviewer: "false",
                    showbrand: "false",
                    hideoverlay: "false",
                    autoplay: "false",
                    start: 0,
                  
                },
                events: {
                    "onIframeReady": onPanoptoIframeReady,
                    "onReady": onPanoptoVideoReady,
                    //"onStateChange": onPanoptoStateUpdate
                }
            });
        }

          //The API will call this function when the iframe is ready
        function onPanoptoIframeReady()
        {
            // The iframe is ready and the video is not yet loaded (on the splash screen)
            // Load video will begin playback
            embedApi.loadVideo();
        }

function onPanoptoVideoReady(){
  //alert('alert');
  console.log(embedApi.unmuteVideo());
}
  

function jumpTime(seconds){
  embedApi.seekTo(seconds);
  console.log(embedApi.playVideo());
  console.log(embedApi.unmuteVideo());
  console.log('mute? ' + embedApi.isMuted())
  console.log('v? ' + embedApi.getVolume())
}

let jumpButtons = document.querySelectorAll('.jump-button');

jumpButtons.forEach((button) => {
  button.addEventListener('click', () => {
    let time = button.dataset.jump;
    let topic = button.dataset.topic;
    jumpTime(time);   
    //changeResources(topic, chapterData);
    appendTimeToUrl(time)
  });
});

function appendTimeToUrl(time){
 window.history.replaceState(null, null, "?time="+time);
}

function changeResources(topic, chapterData){
  let box = document.getElementById('resources');
  let data = chapterData.find(o => o.slug === topic);
  let title = data.title
  let content = data.content;
  console.log(title)
  box.innerHTML = `<h2>${title}</h2> <p>${content}</p>`;
  box.removeAttribute("class")
  box.classList.add(topic);
  
}

const chapterData = [
  {
  "slug" : "something-else",
  "content" : "Here are words that go with something else and a <a href='https://middcreate.net'>link</a>",
  "title" : "Something Else"
},
  {
  "slug" : "communal-notes",
  "content" : "Here are words that go with communal notes.",
  "title" : "Communal Notes"
}
                    
                    ];
}