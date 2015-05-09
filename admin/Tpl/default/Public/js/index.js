function $(id) {return document.getElementById(id);}

function iframeResize(frameId, frameName) {
	var dyniframe   = null;
	var indexwin    = null;
	if ($){
		if(!frameId) {
			frameId = "contentFrame";
			frameName = "contentFrame";
		}
		dyniframe       = $(frameId);
		indexwin        = window;
		if (dyniframe){
			dyniframe.height = document.documentElement.clientHeight-112;
		}
	}
}