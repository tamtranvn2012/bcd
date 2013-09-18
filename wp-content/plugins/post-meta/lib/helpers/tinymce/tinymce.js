function init() {
	tinyMCEPopup.resizeToInnerSize();
}

function getCheckedValue(radioObj) {
	if(!radioObj)
		return "";
	var radioLength = radioObj.length;
	if(radioLength == undefined)
		if(radioObj.checked)
			return radioObj.value;
		else
			return "";
	for(var i = 0; i < radioLength; i++) {
		if(radioObj[i].checked) {
			return radioObj[i].value;
		}
	}
	return "";
}

function insertPostMetaLink() {
	
	var tagtext;
	var index;
    var type = getCheckedValue(document.getElementsByName('type'));
	var metaKey = document.getElementById('metakey').value;
    if(type=='field'){
        groupIndex=document.getElementsByName('groupIndexCustom')[0].value;
        if(!groupIndex){
            groupIndex=1;
        }
        
        fieldIndex=getCheckedValue(document.getElementsByName('fieldIndex'));
        if(fieldIndex != 'all'){
            cfieldIndex=document.getElementsByName('fieldIndexCustom')[0].value;
            if(cfieldIndex){
                fieldIndex=cfieldIndex;
            }else{
                fieldIndex=1;
            }
        }
        index = "groupindex="+ groupIndex +" fieldindex="+ fieldIndex;
    }else{
        groupIndex=getCheckedValue(document.getElementsByName('groupIndex'));
        if(groupIndex != 'all'){
            cgroupIndex=document.getElementsByName('groupIndexCustom')[0].value;
            if(cgroupIndex){
                groupIndex=cgroupIndex;
            }else{
                groupIndex=1;
            }
        }
        index = "groupindex="+ groupIndex ;
    }
    if(metaKey)
        tagtext = "[post-meta type="+ type + " metakey=" + metaKey +" "+ index+ "]";
    else
        tinyMCEPopup.close();
    
	if(window.tinyMCE) {
        window.tinyMCE.execInstanceCommand(window.tinyMCE.activeEditor.id, 'mceInsertContent', false, tagtext);
		//Peforms a clean up of the current editor HTML. 
		//tinyMCEPopup.editor.execCommand('mceCleanup');
		//Repaints the editor. Sometimes the browser has graphic glitches. 
		tinyMCEPopup.editor.execCommand('mceRepaint');
		tinyMCEPopup.close();
	}
	return;
}
