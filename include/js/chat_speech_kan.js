var SpeechRecognition			= SpeechRecognition || webkitSpeechRecognition
var SpeechGrammarList			= SpeechGrammarList || webkitSpeechGrammarList
var SpeechRecognitionEvent	= SpeechRecognitionEvent || webkitSpeechRecognitionEvent

var colors = [ 'aqua' , 'azure' , 'beige', 'bisque', 'black', 'blue', 'brown', 'chocolate', 'coral', 'crimson', 'cyan', 'fuchsia', 'ghostwhite', 'gold', 'goldenrod', 'gray', 'green', 'indigo', 'ivory', 'khaki', 'lavender', 'lime', 'linen', 'magenta', 'maroon', 'moccasin', 'navy', 'olive', 'orange', 'orchid', 'peru', 'pink', 'plum', 'purple', 'red', 'salmon', 'sienna', 'silver', 'snow', 'tan', 'teal', 'thistle', 'tomato', 'turquoise', 'violet', 'white', 'yellow'];
var grammar = '#JSGF V1.0; grammar colors; public <color> = ' + colors.join(' | ') + ' ;'

var recognitionA					= new SpeechRecognition();
var speechRecognitionList		= new SpeechGrammarList();

speechRecognitionList.addFromString(grammar, 1);
recognitionA.grammars			= speechRecognitionList;

recognitionA.continuous			= false;
//recognitionA.lang				= 'en-US';
recognitionA.lang					= 'ko-KR';
recognitionA.interimResults		= false;
recognitionA.maxAlternatives	= 1;

var diagnostic = document.querySelector('.output');

/*
//var diagnosticA = document.querySelector('.input');	// add kan
//var diagnostic = document.querySelector('.output');
//var bg			= document.querySelector('html');
//var hints			= document.querySelector('.hints');

var colorHTML= '';
colors.forEach(function(v, i, a){
  console.log(v, i);
  colorHTML += '<span style="background-color:' + v + ';"> ' + v + ' </span>';
});
hints.innerHTML = 'Tap/click then say a color to change the background color of the app. Try <br>' + colorHTML + '.';
*/

document.body.onclick = function() {
//	var result = confirm( " Start OK? Y/N ");
//	if(result){
//	} else {
//		return false;
//	}

  //recognitionA.start();
	//alert('start --- run end  ----  ');
  //console.log('Ready to receive a color command.');
}

function spk_func(){
	
	var result = confirm( " 마이크가 준비되었으면 말을하세요! Start OK? Y/N ");
	if(result){
	} else {
		return false;
	}
	

  recognitionA.start();
	//alert('start --- run end  ----  ');
  //console.log('Ready to receive a color command.');
}

recognitionA.onresult = function(event) {
  // The SpeechRecognitionEvent results property returns a SpeechRecognitionResultList object
  // The SpeechRecognitionResultList object contains SpeechRecognitionResult objects.
  // It has a getter so it can be accessed like an array
  // The first [0] returns the SpeechRecognitionResult at the last position.
  // Each SpeechRecognitionResult object contains SpeechRecognitionAlternative objects that contain individual results.
  // These also have getters so they can be accessed like arrays.
  // The second [0] returns the SpeechRecognitionAlternative at position 0.
  // We then return the transcript property of the SpeechRecognitionAlternative object
  
  var SpeechKr = event.results[0][0].transcript;

		eval( "document.kakao_form.msg.value= SpeechKr ;" );

  //diagnostic.textContent = 'Result received SpeechKr: ' + SpeechKr + ', color: ' + color + '.';
  //bg.style.backgroundColor = color;
  console.log('Confidence: ' + event.results[0][0].confidence);
}

recognitionA.onspeechend = function() {
  recognitionA.stop();
}

recognitionA.onnomatch = function(event) {
  //diagnostic.textContent = "I didn't recognise that color.";
}

recognitionA.onerror = function(event) {
  diagnostic.textContent = 'Error occurred in recognitionA: ' + event.error;
}
