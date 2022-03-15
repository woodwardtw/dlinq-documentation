// Add your JS customizations here

//smooth scroll
// handle links with @href started with '#' only
jQuery(document).on('click', 'a[href^="#"]', function(e) {
    // target element id
    console.log('click');
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
	let directLinks = document.querySelectorAll('.direct-link');
	console.log(directLinks);
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
  jQuery('#navbar-documentation').toggleClass('collapsed');
  let button = document.querySelector('#doc-btn-expand-collapse');
  if(button.innerHTML === 'x'){
      button.innerHTML = '+';
  } else {
      button.innerHTML = 'x';
  }
});

if(document.getElementById('player')){
  let player = document.getElementById('player');
  let videoId = player.dataset.videoid;
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
}


 
          //The API will call this function when the iframe is ready
function onPanoptoIframeReady(){
        // The iframe is ready and the video is not yet loaded (on the splash screen)
        // Load video will begin playback
        embedApi.loadVideo();
    }

function onPanoptoVideoReady(){
  //alert('alert');
  embedApi.unmuteVideo();
}
  

function jumpTime(seconds){
  embedApi.seekTo(seconds);
  embedApi.playVideo();
  embedApi.unmuteVideo();
}



let jumpButtons = document.querySelectorAll('.jump-button');

jumpButtons.forEach((button) => {
  button.addEventListener('click', () => {
    let time = button.dataset.jump;
    let row = button.dataset.row;
    jumpTime(time);   
    changeResources(row);
    appendTimeToUrl(time);
  });
});

function appendTimeToUrl(time){
 window.history.replaceState(null, null, "?time="+time);
}

function changeResources(row){
    let chosen = document.getElementById('video-content-'+row);
    let allContent = document.querySelectorAll('.video-content');
      allContent.forEach((contentBlock) => {
      contentBlock.classList.remove('show');
      contentBlock.classList.add('hide');
  });

    chosen.classList.add('show');
    chosen.classList.remove('hide');
  }


