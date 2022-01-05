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