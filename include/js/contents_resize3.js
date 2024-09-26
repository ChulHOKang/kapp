function reSize()
{
	try{
		if(navigator.appName.indexOf("Microsoft Internet Explorer") != 0)
		{
			var objBody	=	parent.document.all["ifrm3"].contentWindow.document.body;
			var objFrame	=	parent.document.all["ifrm3"];

		    objFrame.style.height = objBody.scrollHeight;
		    //objFrame.style.width = '100%';
		    objFrame.style.width = '780'

		}
		else
		{

			var objBody	    =	ifrm3.document.body;
			var objFrame	=	document.all["ifrm3"];
			objFrame.style.height = objBody.scrollHeight + (objBody.offsetHeight - objBody.clientHeight);
			//objFrame.style.width = '100%';
			objFrame.style.width = '780'
		}
	}
	//An error is raised if the IFrame domain != its container's domain
	catch(e)
	{
	    //err_handle(e);
	}
}

// iframe initialize Function
function frame_init3()
{
	if(navigator.appName.indexOf("Netscape") != 0){
		parent.reSize();
	}else{
		reSize();
	}
}
